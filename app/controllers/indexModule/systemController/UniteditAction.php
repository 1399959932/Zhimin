<?php

class UniteditAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return NULL;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'edit':
		default:
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;
		}
	}

	protected function edit()
	{
		$unit_m = new UnitModel();
		$bh = Zhimin::param('bh', 'get');
		$my_unit = $unit_m->get_by_sn($bh);

		if (empty($my_unit)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '单位不存在');
			return NULL;
		}

		$p_unit = $unit_m->get_by_ids($my_unit['parentid']);
		$this->_data['data'] = $my_unit;
		$this->_data['p_unit'] = $p_unit;
		$unit_select = $unit_m->get_down();
		$pid = $unit_select['id'];
		$units = array();
		$unit_m->get_units_stair($units, $pid);
		$this->_data['unit_array'] = $units;
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'post');
		$gname = Zhimin::param('zuming', 'post');
		$note = Zhimin::param('beizhu', 'post');
		$orderby = Zhimin::param('orderby', 'post');
		$result_array = array();
		$log_string = '';
		$unit = $unit_m->read($id);

		if (empty($unit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($gname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位名称不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，单位名称：' . $gname;
		}

		$parent_unit = $unit_m->get_by_ids($unit['parentid']);
		$log_string .= '，上级单位：' . $parent_unit['dname'];

		if ($orderby != '') {
			$log_string .= '，排序：' . $orderby;
		}

		if ($note != '') {
			$log_string .= '，备注：' . $note;
		}

		$edit_flg = $unit_m->updateRow('id=' . $id, array('dname' => $gname, 'note' => $note, 'moder' => $_SESSION['username'], 'modtime' => time(), 'orderby' => $orderby));

		if ($edit_flg) {
			$log_type = '082';
			$log_message = '编辑单位成功，单位编号：' . $unit['bh'] . $log_string;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '编辑成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '编辑失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}
}


?>

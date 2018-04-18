<?php

class UnitAction extends Action
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
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有访问权限', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'add':
			$this->saveAdd();
			break;

		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;

		case 'del':
			$this->del();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$unit_m = new UnitModel();
		$unit = $unit_m->get_down();
		$pid = $unit['id'];
		$units = array();
		$unit_m->get_units_stair($units, $pid);
		$this->_data['datas'] = $units;
	}

	protected function saveAdd()
	{
		$unit_m = new UnitModel();
		$log = new LogModel();
		$result_array = array();
		$post_bh = trim(Zhimin::param('bh', 'post'));
		$gname = trim(Zhimin::param('zuming', 'post'));
		$xsbh = Zhimin::param('xsbh', 'post');
		$note = trim(Zhimin::param('beizhu', 'post'));
		$orderby = Zhimin::param('orderby', 'post');

		if ($post_bh == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位编号不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($gname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($xsbh == '') {
			$xsbh = 0;
		}

		$grow = $unit_m->get_by_sn($post_bh);

		if (!empty($grow)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位编号已经存在';
			echo json_encode($result_array);
			exit();
		}

		$syscode = '';

		if (empty($xsbh)) {
			$top = $unit_m->get_down();

			if (!empty($top)) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '不允许存在多个顶级单位';
				echo json_encode($result_array);
				exit();
			}
			else {
				$syscode = '100';
			}
		}
		else {
			$parent = $unit_m->fetchOne('', 'select dname, unitsyscode from ' . $unit_m->table() . ' where id = ' . $xsbh);

			if (empty($parent)) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '上级单位:' . $parent['dname'] . '不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$sibmax = $unit_m->fetchOne('', 'select max(unitsyscode) as maxdb from ' . $unit_m->table() . ' where parentid = ' . $xsbh);

				if (empty($sibmax['maxdb'])) {
					$syscode = $parent['unitsyscode'] . '100';
				}
				else {
					$tempcode = substr($sibmax['maxdb'], -3, 3) + 1;

					if (999 < $tempcode) {
						$result_array['state'] = 'fail';
						$result_array['msg'] = '操作失败,单位:' . $parent['dname'] . '的子单位数超过了900!';
						echo json_encode($result_array);
						exit();
					}

					$syscode = $parent['unitsyscode'] . str_pad($tempcode, 3, '0', STR_PAD_LEFT);
				}
			}
		}

		$insert_flg = $unit_m->insertRow(array('bh' => $post_bh, 'dname' => $gname, 'note' => $note, 'unitsyscode' => $syscode, 'creater' => $_SESSION['username'], 'createtime' => time(), 'parentid' => $xsbh, 'orderby' => $orderby));

		if ($insert_flg) {
			$log_type = '081';
			$parent_unit = $unit_m->get_by_ids($xsbh);

			if ($xsbh == 0) {
				$parent_unit['dname'] = '顶级单位';
			}

			$log_message = '添加单位成功，单位名：' . $gname . '，单位编号：' . $post_bh . '，上级单位：' . $parent_unit['dname'] . '，排序：' . $orderby;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加单位成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function del()
	{
		$unit_m = new UnitModel();
		$log = new LogModel();
		$result_array = array();
		$bh = trim(Zhimin::param('bh', 'post'));
		$unit = $unit_m->get_by_sn($bh);

		if (empty($unit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您要删除的记录不存在，请稍后重试';
			echo json_encode($result_array);
			exit();
		}

		$gname = $unit['dname'];
		$sunit = $unit_m->get_down($unit['id']);

		if (!empty($sunit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请先删除该单位的下级单位';
			echo json_encode($result_array);
			exit();
		}

		$del_flg = $unit_m->deleteRow('bh=\'' . $bh . '\'');

		if ($del_flg) {
			$log_type = '083';
			$log_message = '删除单位成功，单位名：' . $gname . '，单位编号：' . $bh;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除单位成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除单位失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function edit()
	{
		$result_array = array();
		$unit_m = new UnitModel();
		$bh = Zhimin::param('bh', 'post');
		$my_unit = $unit_m->get_by_sn($bh);

		if (empty($my_unit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位不存在';
			echo json_encode($result_array);
			exit();
		}

		$p_unit = $unit_m->get_by_ids($my_unit['parentid']);
		$result_array['state'] = 'success';
		$result_array['id'] = $my_unit['id'];
		$result_array['bh'] = $my_unit['bh'];
		$result_array['dname'] = $my_unit['dname'];
		$result_array['sort'] = $my_unit['orderby'];
		$result_array['note'] = $my_unit['note'];

		if ($my_unit['parentid'] == 0) {
			$result_array['p_name'] = '作为顶级单位';
		}
		else {
			$result_array['p_name'] = $p_unit['dname'];
		}

		echo json_encode($result_array);
		exit();
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

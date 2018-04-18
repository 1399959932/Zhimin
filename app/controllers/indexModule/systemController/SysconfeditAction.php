<?php

class SysconfeditAction extends Action
{
	protected $units = array();
	protected $module_sn = '10081';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$sysconf_m = new SysconfModel();
		$type = Zhimin::request('type');
		$id = Zhimin::param('id', 'get');
		$sysconf = $sysconf_m->data_by_id($id);
		$this->_data['data'] = $sysconf;
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$config_types = $sysconf_m->config_type;
		$this->_data['config_types'] = $config_types;

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
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return NULL;
		}

		$sysconf_m = new SysconfModel();
		$id = Zhimin::param('id', 'get');
		$type = Zhimin::request('type');
		$sysconf = $sysconf_m->data_by_id($id);

		if (empty($sysconf)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '访问的数据不存在');
			return NULL;
		}
	}

	protected function saveEdit()
	{
		$sysconf_m = new SysconfModel();
		$log = new LogModel();
		$type = Zhimin::request('type');
		$id = Zhimin::param('id', 'post');
		$confname = Zhimin::param('confname', 'post');
		$confvalue = Zhimin::param('confvalue', 'post');
		$note = Zhimin::param('note', 'post');
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$sysconf = $sysconf_m->data_by_id($id);

		if (empty($sysconf)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '访问的数据不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($type == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择类别';
			echo json_encode($result_array);
			exit();
		}

		if ($confname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '配置名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($confvalue == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '配置值不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($note == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '备注不能为空';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $sysconf_m->updateRow('id=' . $id, array('confname' => $confname, 'type' => $type, 'confvalue' => $confvalue, 'note' => $note, 'createtime' => time()));

		if ($edit_flg) {
			$log_type = '122';
			$log_message = '编辑系统配置项成功类别：' . $type . '，配置名称：' . $confname . '，配置值：' . $confvalue . '，备注：' . $note . '';
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

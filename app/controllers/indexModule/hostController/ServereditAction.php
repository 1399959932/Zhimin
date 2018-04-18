<?php

class ServereditAction extends Action
{
	protected $module_sn = '1007';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '';
		return $this;
	}

	protected function _main()
	{
		$server_m = new ServerModel();
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
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return;
		}

		$server_m = new ServerModel();
		$id = Zhimin::param('id', 'get');
		$server = $server_m->data_by_id($id);

		if (empty($server)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '服务器不存在');
			return;
		}

		$this->_data['data'] = $server;
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$server_m = new ServerModel();
		$id = Zhimin::param('id', 'post');
		$servername = Zhimin::param('servername', 'post');
		$serverip = Zhimin::param('serverip', 'post');
		$ftpusername = Zhimin::param('ftpusername', 'post');
		$pwd = Zhimin::param('pwd', 'post');
		$port = Zhimin::param('port', 'post');
		$path = Zhimin::param('path', 'post');
		$flag = Zhimin::param('flag', 'post');
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		if ($servername == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '服务器名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($serverip == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '服务IP地址不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($ftpusername == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '登录用户名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($pwd == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '登录密码不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($port == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '端口不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($path == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '路径url不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($flag == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择是否使用';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $server_m->updateRow('id=' . $id, array('servername' => $servername, 'serverip' => $serverip, 'ftpusername' => $ftpusername, 'pwd' => $pwd, 'path' => $path, 'port' => $port, 'flag' => $flag, 'creater' => 'admin', 'creatertime' => time()));

		if ($edit_flg) {
			$log_type = '072';
			$log_message = '编辑服务器成功，服务器成功，添加服务器名称：' . $servername . '，服务IP地址：' . $serverip . '，登录用户名：' . $ftpusername . '，端口：' . $port . '，路径url：' . $path;
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

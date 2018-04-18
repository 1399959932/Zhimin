<?php

class ServerAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$server_m = new ServerModel();
		$user_m = new UserModel();

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有访问权限', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('add' => 0, 'edit' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;

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

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$server_m = new ServerModel();
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$sql = 'SELECT COUNT(*) as count FROM `' . $server_m->table() . '` ';
		$rs = $server_m->fetchOne('', $sql);
		$count = $rs['count'];

		if ($count == 0) {
		}
		else {
			if (!is_numeric($lines)) {
				$lines = 15;
			}

			(!is_numeric($page) || ($page < 1)) && ($page = 1);
			$pageNums = ceil($count / $lines);
			if ($pageNums && ($pageNums < $page)) {
				$page = $pageNums;
			}

			$start = ($page - 1) * $lines;
			$limit = 'LIMIT ' . $start . ',' . $lines;
			$sql = 'SELECT * FROM `' . $server_m->table() . '` ';
			$sql .= ' order by creatertime desc,modtime desc ' . $limit;
			$servers = $server_m->fetchAll('', $sql);
			$this->_data['servers'] = $servers;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function saveAdd()
	{
		$server_m = new ServerModel();
		$log = new LogModel();
		$result_array = array();
		$servername = Zhimin::param('servername', 'post');
		$serverip = Zhimin::param('serverip', 'post');
		$ftpusername = Zhimin::param('ftpusername', 'post');
		$pwd = Zhimin::param('pwd', 'post');
		$port = Zhimin::param('port', 'post');
		$path = Zhimin::param('path', 'post');
		$flag = Zhimin::param('flag', 'post');

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

		$insert_flg = $server_m->insertRow(array('servername' => $servername, 'serverip' => $serverip, 'ftpusername' => $ftpusername, 'pwd' => $pwd, 'path' => $path, 'port' => $port, 'flag' => $flag, 'creater' => 'admin', 'creatertime' => time()));

		if ($insert_flg) {
			$log_type = '071';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加服务器成功，添加服务器名称：' . $servername . '，服务IP地址：' . $serverip . '，登录用户名：' . $ftpusername . '，端口：' . $port . '，路径url：' . $path;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加服务器成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加服务器失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function edit()
	{
		$result_array = array();
		$server_m = new ServerModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$server = $server_m->data_by_id($id);

		if (empty($server)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($server['flag'] == 1) {
			$server['flag'] = '<label for="radio_yes">' . "\r\n" . '								是' . "\r\n" . '								<input type="radio" name="flag" id="radio_yes" value="1" checked="checked">' . "\r\n" . '							</label>' . "\r\n" . '    						<label for="radio_no">' . "\r\n" . '								否' . "\r\n" . '								<input type="radio" name="flag" id="radio_no" value="0">' . "\r\n" . '							</label>' . "\r\n" . '    				';
		}
		else if ($server['flag'] == 0) {
			$server['flag'] = '<label for="radio_yes">' . "\r\n" . '								是' . "\r\n" . '								<input type="radio" name="flag" id="radio_yes" value="1">' . "\r\n" . '							</label>' . "\r\n" . '    						<label for="radio_no">' . "\r\n" . '								否' . "\r\n" . '								<input type="radio" name="flag" id="radio_no" value="0" checked="checked">' . "\r\n" . '							</label>' . "\r\n" . '    				';
		}
		else {
			$server['flag'] = '<label for="radio_yes">' . "\r\n" . '								是' . "\r\n" . '								<input type="radio" name="flag" id="radio_yes" value="1">' . "\r\n" . '							</label>' . "\r\n" . '    						<label for="radio_no">' . "\r\n" . '								否' . "\r\n" . '								<input type="radio" name="flag" id="radio_no" value="0">' . "\r\n" . '							</label>' . "\r\n" . '    				';
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['servername'] = $server['servername'];
		$result_array['serverip'] = $server['serverip'];
		$result_array['ftpusername'] = $server['ftpusername'];
		$result_array['pwd'] = $server['pwd'];
		$result_array['port'] = $server['port'];
		$result_array['path'] = $server['path'];
		$result_array['flag'] = $server['flag'];
		echo json_encode($result_array);
		exit();
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

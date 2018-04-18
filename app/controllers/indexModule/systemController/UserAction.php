<?php

class UserAction extends Action
{
	protected $units = array();
	protected $module_sn = '10081';
	protected $url_base = '';
	protected $units_array = array();

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$units_array = get_units_by_json('bh', 'dname');
		$this->_data['units_array'] = $units_array;
		$this->units_array = $units_array;
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('view' => 0, 'add' => 0, 'edit' => 0, 'del' => 0, 'ok' => 0, 'admin' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['view'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitEdit($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['del'] = 1;
		}

		if ($auth->checkPermitOk($this->module_sn)) {
			$user_auth['ok'] = 1;
		}

		if ($auth->isSuperAdmin()) {
			$user_auth['admin'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$user_groups = array();
		getusergroups($user_groups, '');
		$this->_data['user_groups'] = $user_groups;

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

		case 'manager':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveManager();
			}
			else {
				$this->manager();
			}

			break;

		case 'deluser':
			$this->savedel();
			break;

		case 'pass':
			$this->passsave();
			break;

		case 'unpass':
			$this->unpasssave();
			break;

		case 'changepass':
			$this->changepass();
			break;

		case 'excel_demo':
			$this->downloadexcel();
			break;

		case 'excel':
			$this->inputexcel();
			break;

		case 'user_exist':
			$this->user_exist();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$group_m = new GroupModel();
		$hostname = Zhimin::request('hostname');
		$hostcode = Zhimin::request('hostcode');
		$danwei = Zhimin::request('danwei');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['hostname'] = $hostname;
		$url['hostcode'] = $hostcode;
		$url['danwei'] = $danwei;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = ' 1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$where .= ' AND pu.ifadmin=0';
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pu.dbh in (' . $dlist . ')';
		}

		$where .= ' AND pu.username != \'manager\'';

		if (!empty($hostname)) {
			$where .= ' AND (pu.realname like \'%' . $hostname . '%\' or pu.username like \'%' . $hostname . '%\')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pu.dbh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (!empty($hostcode)) {
			$where .= ' AND pu.hostcode like \'%' . $hostcode . '%\'';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $user_m->table() . '` pu WHERE ' . $where;
		$rs = $user_m->fetchOne('', $sql);
		$count = $rs['count'];

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
		$sql = 'SELECT pu.*, pd.dname as unitname, pg.gname as groupname FROM `' . $user_m->table() . '` pu';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pu.dbh';
		$sql .= ' LEFT JOIN `' . $group_m->table() . '` pg ON pg.bh=pu.gid';
		$sql .= ' WHERE ' . $where . ' order by pu.dbh asc,sort asc,id desc ' . $limit;
		$users = $user_m->fetchAll('', $sql);
		$this->_data['datas'] = $users;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function saveAdd()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$username = trim(Zhimin::param('username', 'post'));
		$password1 = trim(Zhimin::param('password1', 'post'));
		$password2 = trim(Zhimin::param('password2', 'post'));
		$realname = trim(Zhimin::param('realname', 'post'));
		$hostcode = trim(Zhimin::param('hostcode', 'post'));
		$group = Zhimin::param('group', 'post');
		$danwei = Zhimin::param('danwei_add', 'post');
		$sort = Zhimin::param('sort', 'post');
		$pwd_len = strlen($password1);

		if ($username == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '用户名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (($password1 != $password2) || ($password1 == '')) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '两次密码输入不一致';
			echo json_encode($result_array);
			exit();
		}

		if ($pwd_len < 6) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '密码长度不能少于6位';
			echo json_encode($result_array);
			exit();
		}

		if (12 < $pwd_len) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '密码长度不能多于12位';
			echo json_encode($result_array);
			exit();
		}

		if ($realname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($group == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择角色';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		$user = $user_m->get_by_name($username);

		if (!empty($user)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '用户名已经被注册';
			echo json_encode($result_array);
			exit();
		}

		$password = md5($password1);
		$insert_flg = $user_m->insertRow(array('username' => $username, 'pdw' => $password, 'ifadmin' => 0, 'ispass' => 1, 'gid' => $group, 'dbh' => $danwei, 'hostcode' => $hostcode, 'regtime' => time(), 'creater' => $_SESSION['username'], 'createtime' => time(), 'realname' => $realname, 'sort' => $sort, 'email' => ''));

		if ($insert_flg) {
			$log_type = '091';
			$group_m = new GroupModel();
			$unit_m = new UnitModel();
			$log_group = $group_m->get_by_sn($group);
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加用户成功，用户名：' . $username . '，角色：' . $log_group['gname'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加用户成功';
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

	protected function edit()
	{
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$user_m = new UserModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$user = $user_m->read($id);

		if (empty($user)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '用户不存在';
			echo json_encode($result_array);
			exit();
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['username'] = $user['username'];
		$result_array['gid'] = $user['gid'];
		$result_array['dbh'] = $user['dbh'];
		$result_array['hostcode'] = $user['hostcode'];
		$result_array['realname'] = $user['realname'];
		$result_array['sort'] = $user['sort'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'post');
		$realname = trim(Zhimin::param('realname', 'post'));
		$hostcode = trim(Zhimin::param('hostcode', 'post'));
		$group = Zhimin::param('group', 'post');
		$danwei = Zhimin::param('danwei_edit', 'post');
		$sort = Zhimin::param('sort', 'post');
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';
		$user = $user_m->read($id);

		if (empty($user)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '用户不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($realname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，' . $_SESSION['zfz_type'] . '姓名：' . $realname;
		}

		if ($group == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择角色';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_group = $group_m->get_by_sn($group);
			$log_string .= '，角色：' . $log_group['gname'];
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_string .= '，单位：' . $log_unit['dname'];
		}

		if ($hostcode != '') {
			$log_string .= '，' . $_SESSION['zfz_type'] . '编号：' . $hostcode;
		}

		if ($sort != '') {
			$log_string .= '，排序：' . $sort;
		}

		$edit_flg = $user_m->updateRow('id=' . $id, array('realname' => $realname, 'hostcode' => $hostcode, 'dbh' => $danwei, 'gid' => $group, 'sort' => $sort, 'moder' => $_SESSION['username'], 'modtime' => time()));

		if ($edit_flg) {
			$log_type = '092';
			$log_message = '编辑用户成功，用户名：' . $user['username'] . $log_string;
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

	protected function saveDel()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有删除的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$user_res = $user_m->get_by_id($id);

		if (!$user_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $user_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法删除自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$del_flg = $user_m->deleteRow('`id`=\'' . $id . '\'');

		if ($del_flg) {
			$log_type = '097';
			$group_m = new GroupModel();
			$unit_m = new UnitModel();
			$log_group = $group_m->get_by_sn($user_res['gid']);
			$log_unit = $unit_m->get_by_sn($user_res['dbh']);
			$log_message = '删除用户成功，用户名：' . $user_res['username'] . '，角色：' . $log_group['gname'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除用户成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除用户失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function unpasssave()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有停用的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$user_res = $user_m->get_by_id($id);

		if (!$user_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $user_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法停用自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$user_m->updateRow('`id`=\'' . $id . '\'', array('ispass' => 0));
		$log_type = '095';
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$log_group = $group_m->get_by_sn($user_res['gid']);
		$log_unit = $unit_m->get_by_sn($user_res['dbh']);
		$log_message = '停用账号成功，用户名：' . $user_res['username'] . '，角色：' . $log_group['gname'] . '，单位：' . $log_unit['dname'];
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '停用账号成功';
		echo json_encode($result_array);
		exit();
	}

	protected function passsave()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有启用的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$user_res = $user_m->get_by_id($id);

		if (!$user_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $user_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法启用自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$user_m->updateRow('`id`=\'' . $id . '\'', array('ispass' => 1));
		$log_type = '096';
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$log_group = $group_m->get_by_sn($user_res['gid']);
		$log_unit = $unit_m->get_by_sn($user_res['dbh']);
		$log_message = '启用账号成功，用户名：' . $user_res['username'] . '，角色：' . $log_group['gname'] . '，单位：' . $log_unit['dname'];
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '启用账号成功';
		echo json_encode($result_array);
		exit();
	}

	protected function changepass()
	{
		$log = new LogModel();
		$user_m = new UserModel();
		$id = Zhimin::param('id', 'post');
		$new_pwd = 123456;
		$result_array = array();
		$password = md5($new_pwd);
		$flg = $user_m->updateRow('id=' . $id, array('pdw' => $password));

		if ($flg) {
			$user_res = $user_m->get_by_id($id);
			$log_type = '093';
			$group_m = new GroupModel();
			$unit_m = new UnitModel();
			$log_group = $group_m->get_by_sn($user_res['gid']);
			$log_unit = $unit_m->get_by_sn($user_res['dbh']);
			$log_message = '重置用户密码成功，用户名：' . $user_res['username'] . '，角色：' . $log_group['gname'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '重置用户密码成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '重置用户密码失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function downloadexcel()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$file_name = getrooturl();
		$file_name .= 'images/demo/user_demo.xls';
		$log_type = '018';
		$log_message = '下载导入用户的Excel模板';
		$log_filename = 'user_demo.xls';
		$log->writeLog($log_type, $log_message, $log_filename);
		echo '<script language=\'javascript\'>location.href=\'' . $file_name . '\';</script>';
		exit();
	}

	protected function user_exist()
	{
		$this->_hasView = false;
		$username = Zhimin::param('username', 'get');
		$user_m = new UserModel();
		$user = $user_m->get_by_name($username);

		if (!empty($user)) {
			echo 1;
		}
		else {
			echo 0;
		}
	}

	protected function saveManager()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'post');
		$manager_string = '';
		$manager_temp = array();
		$manager_unit = Zhimin::param('manager_unit', 'post');
		$result_array = array();
		$user = $user_m->read($id);

		if (empty($user)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '用户不存在';
			echo json_encode($result_array);
			exit();
		}

		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitOk($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有管理范围的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';

		if (!empty($manager_unit)) {
			foreach ($manager_unit as $k => $v ) {
				if ($v == '1') {
					$k1 = substr($k, 1, -1);
					array_push($manager_temp, $k1);
					$unit_name = $unit_m->get_by_sn($k1);
					$log_string .= $unit_name['dname'] . '，';
				}
			}
		}

		if (empty($manager_temp)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有选择管理范围';
			echo json_encode($result_array);
			exit();
		}

		$deep_flg = $unit_m->judge_deep_equiry($manager_temp);

		if (!$deep_flg) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择同一等级的单位';
			echo json_encode($result_array);
			exit();
		}

		$units_child = user_unit_stair($manager_temp);
		$dlist = unit_string_sql($units_child);
		$my_bh = '\'' . $user['dbh'] . '\'';

		if (strpos($dlist, $my_bh) === false) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您选择的单位必须有一个是用户本单位或本单位的上级';
			echo json_encode($result_array);
			exit();
		}

		$manager_string = implode(',', $manager_temp);
		$edit_flg = $user_m->updateRow('id=' . $id, array('manager_unit' => $manager_string, 'moder' => $_SESSION['username'], 'modtime' => time()));

		if ($edit_flg) {
			$log_type = '094';
			$log_message = '编辑用户管理范围成功，用户名：' . $user['username'] . '。修改此用户的管理范围为：【' . $log_string . '】';
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

	protected function manager()
	{
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$user = $user_m->read($id);
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitOk($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		if (empty($user)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if (empty($user['manager_unit'])) {
			$manager_string = '';
		}
		else {
			$manager_string = $user['manager_unit'];
		}

		$result_array['state'] = 'success';
		$result_array['msg'] = $manager_string;
		$result_array['id'] = $id;
		echo json_encode($result_array);
		exit();
	}

	protected function inputexcel()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有导入的权限', 'url' => Zhimin::buildUrl());
			return NULL;
		}

		$file = $_FILES['inputExcel']['name'];
		$filetempname = $_FILES['inputExcel']['tmp_name'];
		$filePath = 'upload/excel/';
		$str = '';
		require_once ('./PHPExcel/PHPExcel.php');
		require_once ('./PHPExcel/PHPExcel/IOFactory.php');
		require_once ('./PHPExcel/PHPExcel/Reader/Excel5.php');
		$time = date('y-m-d-H-i-s');
		$extend = strrchr($file, '.');
		$name = $time . $extend;
		$uploadfile = $filePath . $name;
		$result = move_uploaded_file($filetempname, $uploadfile);

		if ($result) {
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load($uploadfile);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$headtitle = array();
			$error_no = array('username_empty' => 0, 'password_empty' => 0, 'pwd_short' => 0, 'pwd_long' => 0, 'realname_empty' => 0, 'group_empty' => 0, 'danwei_empty' => 0, 'username_exist' => 0, 'insert_error' => 0);
			$log_string = '';

			for ($row = 2; $row <= $highestRow; $row++) {
				$strs = array();

				for ($col = 0; $col < $highestColumnIndex; $col++) {
					$strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				}

				$username = trim($strs[0]);
				$password = trim($strs[1]);
				$realname = trim($strs[2]);
				$hostcode = trim($strs[3]);
				$danwei = trim($strs[4]);
				$group = trim($strs[5]);
				$sort = trim($strs[6]);
				$pwd_len = strlen($password);
				$password1 = md5($password);

				if ($username == '') {
					$error_no['username_empty']++;
					$log_string .= '用户名为空；';
					continue;
				}

				if ($password == '') {
					$error_no['password_empty']++;
					$log_string .= '用户名' . $username . '，密码为空；';
					continue;
				}

				if ($pwd_len < 6) {
					$error_no['pwd_short']++;
					$log_string .= '用户名' . $username . '，密码长度少于6位；';
					continue;
				}

				if (12 < $pwd_len) {
					$error_no['pwd_long']++;
					$log_string .= '用户名' . $username . '，密码长度多于12位；';
					continue;
				}

				if ($realname == '') {
					$error_no['realname_empty']++;
					$log_string .= '用户名' . $username . '，' . $_SESSION['zfz_type'] . '姓名为空；';
					continue;
				}

				if ($group == '') {
					$error_no['group_empty']++;
					$log_string .= '用户名' . $username . '，角色为空；';
					continue;
				}

				if ($danwei == '') {
					$error_no['danwei_empty']++;
					$log_string .= '用户名' . $username . '，单位为空；';
					continue;
				}

				$user = $user_m->get_by_name($username);

				if (!empty($user)) {
					$error_no['username_exist']++;
					$log_string .= '用户名' . $username . '，用户名已经被注册；';
					continue;
				}

				$insert_flg = $user_m->insertRow(array('username' => $username, 'pdw' => $password1, 'ifadmin' => 0, 'ispass' => 1, 'gid' => $group, 'dbh' => $danwei, 'hostcode' => $hostcode, 'regtime' => time(), 'creater' => $_SESSION['username'], 'createtime' => time(), 'realname' => $realname, 'sort' => $sort, 'email' => ''));

				if (!$insert_flg) {
					$error_no['insert_error']++;
					$log_string .= '用户名' . $username . '，插入到数据库失败；';
					continue;
				}
			}

			$total_count = $highestRow - 1;
			$error_count = 0;

			foreach ($error_no as $k => $v ) {
				$error_count += $v;
			}

			$output_string = '此次共导入' . $total_count . '条用户记录，其中失败' . $error_count . '条，详情请查看【系统日志】';

			if ($error_count != 0) {
				$message_string = '此次共导入' . $total_count . '条用户记录，其中失败' . $error_count . '条，详情如下：' . $log_string;
			}
			else {
				$message_string = '此次共导入' . $total_count . '条用户记录，其中失败' . $error_count . '条。';
			}

			$log_type = '098';
			$log_message = '导入用户Excel成功，' . $message_string;
			$log->writeLog($log_type, $log_message);
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => $output_string, 'url' => Zhimin::buildUrl());
			return NULL;
		}
		else {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '请选择Excel文件', 'url' => Zhimin::buildUrl());
			return NULL;
		}
	}
}


?>

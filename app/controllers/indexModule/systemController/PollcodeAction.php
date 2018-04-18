<?php

class PollcodeAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$sysconf_m = new SysconfModel();
		if (!$auth->isSuperAdmin() && ($_SESSION['username'] == 'manager')) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有访问权限', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('edit' => 0, 'add' => 0, 'del' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['del'] = 1;
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

		case 'del':
			$this->savedel();
			break;

		case 'create_code':
			$this->create_code();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');
		$sysconf_m = new PollcodeModel();
		$config_types = $sysconf_m->config_type;
		$this->_data['config_types'] = $config_types;
		$type = Zhimin::request('type');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['type'] = $type;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';

		if (!empty($type)) {
			$where .= ' AND `psc`.`type` = \'' . $type . '\' ';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $sysconf_m->table() . '` as `psc` where ' . $where;
		$rs = $sysconf_m->fetchOne('', $sql);
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
			$sql = 'SELECT psc.* FROM `' . $sysconf_m->table() . '` psc';
			$sql .= ' WHERE ' . $where . ' order by psc.type desc ' . $limit;
			$sysconfs = $sysconf_m->fetchAll('', $sql);
			$this->_data['sysconfs'] = $sysconfs;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function saveAdd()
	{
		$sysconf_m = new PollcodeModel();
		$log = new LogModel();
		$result_array = array();
		$type = Zhimin::param('type', 'post');
		$code = Zhimin::param('code', 'post');
		$expira_time = Zhimin::param('expira_time', 'post');
		$remark = Zhimin::param('remark', 'post');

		if ($type == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择类别';
			echo json_encode($result_array);
			exit();
		}

		if ($code == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '注册码不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($expira_time == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择过期时间';
			echo json_encode($result_array);
			exit();
		}

		if ($expira_time < date('Y-m-d H:i:s', time())) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '过期日期有误，该时间已过期';
			echo json_encode($result_array);
			exit();
		}

		$expira_time = strtotime($expira_time);
		$insert_flg = $sysconf_m->insertRow(array('type' => $type, 'code' => $code, 'expira_time' => $expira_time, 'remark' => $remark, 'create_user' => $_SESSION['username'], 'create_date' => time()));

		if ($insert_flg) {
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加注册码成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加注册码失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function saveDel()
	{
		$sysconf_m = new PollcodeModel();
		$result_array = array();
		$id = Zhimin::param('id', 'post');
		$sysconf_res = $sysconf_m->get_by_id($id);

		if (!$sysconf_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $sysconf_m->deleteRow('`id`=\'' . $id . '\'');

		if ($edit_flg) {
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function edit()
	{
		$result_array = array();
		$sysconf_m = new PollcodeModel();
		$id = trim(Zhimin::param('id', 'post'));
		$sysconf = $sysconf_m->data_by_id($id);

		if (empty($sysconf)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['type'] = $sysconf['type'];
		$result_array['code'] = $sysconf['code'];
		$result_array['expira_time'] = date('Y-m-d', $sysconf['expira_time']);
		$result_array['remark'] = $sysconf['remark'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$sysconf_m = new PollcodeModel();
		$id = Zhimin::param('id', 'post');
		$type = Zhimin::param('type', 'post');
		$code = Zhimin::param('code', 'post');
		$expira_time = Zhimin::param('expira_time', 'post');
		$remark = Zhimin::param('remark', 'post');
		$result_array = array();
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

		if ($expira_time == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择过期时间';
			echo json_encode($result_array);
			exit();
		}

		if ($expira_time < date('Y-m-d H:i:s', time())) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '过期日期有误，该时间已过期';
			echo json_encode($result_array);
			exit();
		}

		$expira_time = strtotime($expira_time);
		$edit_flg = $sysconf_m->updateRow('id=' . $id, array('type' => $type, 'expira_time' => $expira_time, 'remark' => $remark, 'update_user' => $_SESSION['username'], 'update_date' => time()));

		if ($edit_flg) {
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

	protected function create_guid($namespace = NULL)
	{
		static $guid = '';
		$uid = uniqid('', true);
		$data = $namespace;
		$data .= $_SERVER['REQUEST_TIME'];
		$data .= $_SERVER['HTTP_USER_AGENT'];
		$data .= $_SERVER['SERVER_ADDR'];
		$data .= $_SERVER['SERVER_PORT'];
		$data .= $_SERVER['REMOTE_ADDR'];
		$data .= $_SERVER['REMOTE_PORT'];
		$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
		$guid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);
		return $guid;
	}

	protected function create_code()
	{
		$result_array = array();
		$result_array['state'] = 'success';
		$result_array['msg'] = $this->create_guid('zhimin');
		echo json_encode($result_array);
		exit();
	}
}


?>

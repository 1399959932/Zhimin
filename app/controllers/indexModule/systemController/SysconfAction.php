<?php

class SysconfAction extends Action
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

		if (!$auth->isSuperAdmin()) {
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

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');
		$user_m = new UserModel();
		$sysconf_m = new SysconfModel();
		$config_types = $sysconf_m->config_type;
		$this->_data['config_types'] = $config_types;
		$type = Zhimin::request('type');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['type'] = $type;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pa.receive_unit in (' . $dlist . ')';
		}

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
			$sql .= ' LEFT JOIN `' . $user_m->table() . '` pu ON pu.username=psc.creater';
			$sql .= ' WHERE ' . $where . ' order by psc.createtime desc ' . $limit;
			$sysconfs = $sysconf_m->fetchAll('', $sql);
			$this->_data['sysconfs'] = $sysconfs;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function saveAdd()
	{
		$sysconf_m = new SysconfModel();
		$log = new LogModel();
		$user_m = new UserModel();
		$result_array = array();
		$type = Zhimin::param('type', 'post');
		$confname = Zhimin::param('confname', 'post');
		$confvalue = Zhimin::param('confvalue', 'post');
		$note = Zhimin::param('note', 'post');

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

		$confcode = $sysconf_m->get_next_sn();
		$user_a = $user_m->read($_SESSION['userid']);

		if ($type == '1') {
			$v['type'] = '文件类型';
		}
		else if ($type == '2') {
			$v['type'] = '案件类型';
		}
		else if ($type == '3') {
			$v['type'] = '标注类型';
		}
		else if ($type == '4') {
			$v['type'] = '故障类型';
		}
		//modify
		else if ($type == '5') {
			$v['type'] = '号码类型';
		}
		else if ($type == '6') {
			$v['type'] = '警情来源';
		}
		else if ($type == '7') {
			$v['type'] = '采集设备来源';
		}

		$insert_flg = $sysconf_m->insertRow(array('type' => $type, 'confcode' => $confcode, 'confname' => $confname, 'confvalue' => $confvalue, 'note' => $note, 'creater' => $user_a['username'], 'createtime' => time()));

		if ($insert_flg) {
			$log_type = '121';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加系统配置项成功，类别：' . $v['type'] . '，配置名称：' . $confname . '，配置值：' . $confvalue . '，备注：' . $note . '';
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加系统配置项成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加系统配置项失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function saveDel()
	{
		$sysconf_m = new SysconfModel();
		$log = new LogModel();
		$result_array = array();
		$id = Zhimin::param('id', 'post');
		$sysconf_res = $sysconf_m->get_by_id($id);

		if (!$sysconf_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$sysconf_m->deleteRow('`id`=\'' . $id . '\'');

		if ($sysconf_res['type'] == '1') {
			$v['type'] = '文件类型';
		}
		else if ($sysconf_res['type'] == '2') {
			$v['type'] = '案件类型';
		}
		else if ($sysconf_res['type'] == '3') {
			$v['type'] = '标注类型';
		}
		else if ($sysconf_res['type'] == '4') {
			$v['type'] = '故障类型';
		}
		//modify
		else if ($sysconf_res['type'] == '5') {
			$v['type'] = '号码类型';
		}
		else if ($sysconf_res['type'] == '6') {
			$v['type'] = '警情来源';
		}
		else if ($sysconf_res['type'] == '7') {
			$v['type'] = '采集设备来源';
		}

		$log_type = '123';
		$unit_m = new UnitModel();
		$log_unit = $unit_m->get_by_sn($user_res['dbh']);
		$log_message = '删除系统配置项成功，类别：' . $v['type'] . '，配置名称：' . $sysconf_res['confname'] . '，配置值：' . $sysconf_res['confvalue'] . '，备注：' . $sysconf_res['note'] . '';
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '删除系统配置项成功';
		echo json_encode($result_array);
		exit();
	}

	protected function edit()
	{
		$result_array = array();
		$sysconf_m = new SysconfModel();
		$unit_m = new UnitModel();
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
		$result_array['confname'] = $sysconf['confname'];
		$result_array['confvalue'] = $sysconf['confvalue'];
		$result_array['note'] = $sysconf['note'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$sysconf_m = new SysconfModel();
		$log = new LogModel();
		$type = Zhimin::param('type', 'post');
		$id = Zhimin::param('id', 'post');
		$confname = Zhimin::param('confname', 'post');
		$confvalue = Zhimin::param('confvalue', 'post');
		$note = Zhimin::param('note', 'post');
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

		if ($confname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '配置名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $sysconf_m->updateRow('id=' . $id, array('confname' => $confname, 'type' => $type, 'confvalue' => $confvalue, 'note' => $note, 'createtime' => time()));

		if ($sysconf['type'] == '1') {
			$v['type'] = '文件类型';
		}
		else if ($sysconf['type'] == '2') {
			$v['type'] = '案件类型';
		}
		else if ($sysconf['type'] == '3') {
			$v['type'] = '标注类型';
		}
		else if ($sysconf['type'] == '4') {
			$v['type'] = '故障类型';
		}
		//modify
		else if ($sysconf['type'] == '5') {
			$v['type'] = '号码类型';
		}
		else if ($sysconf['type'] == '6') {
			$v['type'] = '警情来源';
		}
		else if ($sysconf['type'] == '7') {
			$v['type'] = '采集设备来源';
		}

		if ($edit_flg) {
			$log_type = '122';
			$log_message = '编辑系统配置项成功,类别：' . $v['type'] . '，配置名称：' . $confname . '，配置值：' . $confvalue . '，备注：' . $note . '';
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

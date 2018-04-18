<?php

class DeviceAction extends Action
{
	protected $module_sn = '10061';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '记录仪管理-' . Zhimin::$name;
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$device_m = new DeviceModel();
		$sysconf_m = new SysconfModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$this->_data['device_state'] = $device_m->_state;
		$device_repair_array = array();
		$device_repair_array = $sysconf_m->get_by_type(4);
		$this->_data['device_repair_array'] = $device_repair_array;
		$device_auth = array('view' => 0, 'add' => 0, 'edit' => 0, 'del' => 0, 'admin' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$device_auth['view'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$device_auth['add'] = 1;
		}

		if ($auth->checkPermitEdit($this->module_sn)) {
			$device_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$device_auth['del'] = 1;
		}

		if ($auth->isSuperAdmin()) {
			$device_auth['admin'] = 1;
		}

		$this->_data['device_auth'] = $device_auth;

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

		case 'update':
			$this->deviceupdate();
			break;

		case 'del':
			$this->savedel();
			break;

		case 'scrap':
			$this->scrap();
		case 'warning_device':
			$this->warning();
		case 'up':
			$this->up();
		case 'merge_device':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->mergesave();
			}
			else {
				$this->merge();
			}

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
			return;
		}

		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$device_m = new DeviceModel();
		$media_m = new MediaModel();
		$hostname = trim(Zhimin::request('hostname'));
		$hostcode = trim(Zhimin::request('hostcode'));
		$hostbody = trim(Zhimin::request('hostbody'));
		$danwei = trim(Zhimin::request('danwei'));
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['hostname'] = $hostname;
		$url['hostcode'] = $hostcode;
		$url['danwei'] = $danwei;
		$url['hostbody'] = $hostbody;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = ' 1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pd.danwei in (' . $dlist . ')';
		}

		if (!empty($hostname)) {
			$where .= ' AND  pd.hostname like \'%' . $hostname . '%\'';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pd.danwei in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (!empty($hostcode)) {
			$where .= ' AND pd.hostcode like \'%' . $hostcode . '%\'';
		}

		if (!empty($hostbody)) {
			$where .= ' AND pd.hostbody like \'%' . $hostbody . '%\'';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $device_m->table() . '` pd WHERE ' . $where;
		$rs = $device_m->fetchOne('', $sql);
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
		$sql = 'SELECT pd.*, pu.dname as unitname FROM `' . $device_m->table() . '` pd';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pu ON pd.danwei=pu.bh';
		$sql .= ' WHERE ' . $where . ' order by pu.orderby asc,pd.id desc ' . $limit;
		$devices = $device_m->fetchAll('', $sql);

		foreach ($devices as $k => $v ) {
			$createdate_sql = 'SELECT `createdate` FROM `' . $media_m->table() . '` where `hostbody`=\'' . $v['hostbody'] . '\' order by `id` desc limit 1';
			$createdate = $media_m->fetchOne('', $createdate_sql);
			$devices_array[$k] = $v;
			$devices_array[$k]['last_date'] = $createdate['createdate'];
		}

		$this->_data['datas'] = $devices_array;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function saveAdd()
	{
		$user_m = new UserModel();
		$device_m = new DeviceModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$hostcode = trim(Zhimin::param('hostcode', 'post'));
		$hostname = trim(Zhimin::param('hostname', 'post'));
		$danwei = Zhimin::param('danwei', 'post');
		$hostbody = trim(Zhimin::param('hostbody', 'post'));
		$product_name = trim(Zhimin::param('product_name', 'post'));
		$product_firm = trim(Zhimin::param('product_firm', 'post'));
		$capacity = Zhimin::param('capacity', 'post');

		if ($hostcode == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($hostname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if ($hostbody == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪编号不能为空';
			echo json_encode($result_array);
			exit();
		}

		$hostbody_res = $device_m->data_by_hostbody($hostbody);

		if (!empty($hostbody_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪编号已经存在';
			echo json_encode($result_array);
			exit();
		}

		$insert_flg = $device_m->insertRow(array('hostname' => $hostname, 'hostcode' => $hostcode, 'hostbody' => $hostbody, 'danwei' => $danwei, 'product_name' => $product_name, 'product_firm' => $product_firm, 'capacity' => $capacity, 'state' => '0', 'creater' => $_SESSION['username'], 'creatertime' => time()));

		if ($insert_flg) {
			$log_type = '051';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加记录仪成功，配发' . $_SESSION['zfz_type'] . '：' . $hostname . '，' . $_SESSION['zfz_type'] . '编号：' . $hostcode . '，记录仪编号：' . $hostbody . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加记录仪成功';
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

	protected function saveDel()
	{
		$device_m = new DeviceModel();
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
		$device_res = $device_m->data_by_id($id);

		if (!$device_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$del_flg = $device_m->deleteRow('`id`=\'' . $id . '\'');

		if ($del_flg) {
			$log_type = '056';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($device_res['danwei']);
			$log_message = '删除记录仪成功，配发' . $_SESSION['zfz_type'] . '：' . $device_res['hostname'] . '，' . $_SESSION['zfz_type'] . '编号：' . $device_res['hostcode'] . '，记录仪编号：' . $device_res['hostbody'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除记录仪成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除记录仪失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function scrap()
	{
		$device_m = new DeviceModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有报废的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$device_res = $device_m->data_by_id($id);

		if (!$device_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$state = '2';
		$scrap_flg = $device_m->data_state_update($state, $id);

		if ($scrap_flg) {
			$log_type = '055';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($device_res['danwei']);
			$log_message = '报废记录仪成功，配发' . $_SESSION['zfz_type'] . '：' . $device_res['hostname'] . '，' . $_SESSION['zfz_type'] . '编号：' . $device_res['hostcode'] . '，记录仪编号：' . $device_res['hostbody'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '报废记录仪成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '报废记录仪失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function merge()
	{
		$device_m = new DeviceModel();
		$result_array = array();
		$id = Zhimin::param('id', 'post');
		$device_res = $device_m->data_by_id($id);
		$result_array['hostbody'] = $device_res['hostbody'];
		$result_array['hostname'] = $device_res['hostname'];
		echo json_encode($result_array);
		exit();
	}

	protected function mergesave()
	{
		$device_m = new DeviceModel();
		$media_m = new MediaModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有合并记录仪的权限';
			echo json_encode($result_array);
			exit();
		}

		$hostbody_old = trim(Zhimin::param('hostbody_old', 'post'));
		$hostbody = trim(Zhimin::param('hostbody', 'post'));

		if ($hostbody_old == $hostbody) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '替换的新记录仪编号与旧设备编号相同';
			echo json_encode($result_array);
			exit();
		}

		$device_old_res = $device_m->data_by_hostbody($hostbody_old);
		$device_res = $device_m->data_by_hostbody($hostbody);

		if (!$device_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '替换的新记录仪编号不存在';
			echo json_encode($result_array);
			exit();
		}

		if (!$device_old_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $media_m->updateRow('`hostbody`=\'' . $hostbody_old . '\'', array('hostname' => $device_res['hostname'], 'hostcode' => $device_res['hostcode'], 'hostbody' => $device_res['hostbody'], 'danwei' => $device_res['danwei']));

		if ($edit_flg) {
			$log_type = '053';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($device_res['danwei']);
			$log_message = '合并记录仪成功，旧记录仪编号：' . $hostbody_old . '，新记录仪编号：' . $hostbody . '，旧记录仪编辑上传的视频文件的（记录仪属性更正为：' . $device_res['hostbody'] . '，配备' . $_SESSION['zfz_type'] . '更正为：' . $device_res['hostname'] . '，单位更正为：' . $log_unit['dname'] . ')';
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '合并记录仪成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '合并记录仪失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function deviceupdate()
	{
		$device_m = new DeviceModel();
		$media_m = new MediaModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有更新记录仪的权限';
			echo json_encode($result_array);
			exit();
		}

		$userarray = array();
		//modify
		//$sql = 'SELECT DISTINCT t.hostcode from zm_device t;';
		$sql = 'SELECT DISTINCT t.hostbody from zm_device t;';
		$result = mysql_query($sql);

		while ($row_c = mysql_fetch_array($result)) {
			//modify
			//$userarray[] = $row_c['hostcode'];
			$userarray[] = $row_c['hostbody'];
		}

		$yesterday = date('Y-m-d', strtotime('-1 day'));
		// 更新设备
		// $sql = 'SELECT DISTINCT t.hostbody, t.hostcode, t.hostname, t.danwei from zm_video_list t ';
		$sql = "SELECT DISTINCT t.hostbody, t.hostcode, t.hostname, t.danwei from zm_video_list t 
WHERE t.hostbody!='' GROUP BY t.hostcode ORDER BY t.createdate desc ";
		$result = mysql_query($sql);
		$log_string = '';

		while ($row_c = mysql_fetch_array($result)) {
			$tempbody = $row_c['hostbody'];
			$tempcode = $row_c['hostcode'];
			$tempname = $row_c['hostname'];
			$tempdanwei = $row_c['danwei'];

			//modify：一个执法者可能有多台执法仪设备
			//if (in_array($row_c['hostcode'], $userarray)) {
			if (in_array($row_c['hostbody'], $userarray)) {
				//$sql_deal = 'UPDATE zm_device set hostbody=\'' . $tempbody . '\', hostname=\'' . $tempname . '\', danwei=\'' . $tempdanwei . '\' where hostcode=\'' . $tempcode . '\'';
				$sql_deal = 'UPDATE zm_device set hostbody=\'' . $tempbody . '\', hostname=\'' . $tempname . '\', danwei=\'' . $tempdanwei . '\' where hostbody=\'' . $tempbody . '\'';
				$log_string .= '；修改记录仪信息：记录仪编号' . $tempbody . '，' . $_SESSION['zfz_type'] . '姓名：' . $tempname . '，单位：' . $tempdanwei . '，' . $_SESSION['zfz_type'] . '编号：' . $tempcode;
			}
			else {
				$sql_deal = 'INSERT INTO zm_device(hostbody, hostname, danwei, hostcode) VALUES(\'' . $tempbody . '\', \'' . $tempname . '\', \'' . $tempdanwei . '\', \'' . $tempcode . '\')';
				$log_string .= '；新增记录仪信息：记录仪编号' . $tempbody . '，' . $_SESSION['zfz_type'] . '姓名：' . $tempname . '，单位：' . $tempdanwei . '，' . $_SESSION['zfz_type'] . '编号：' . $tempcode;
			}

			$result_1 = mysql_query($sql_deal);
		}

		$log_type = '057';
		$log_message = '更新记录仪成功 ';

		if ($log_string == '') {
			$log_message = '更新记录仪成功 ,记录仪列表无需更新。';
		}
		else {
			$log_message .= $log_string;
		}

		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '更新设备成功';
		echo json_encode($result_array);
		exit();
	}

	protected function warning()
	{
		$device_m = new DeviceModel();
		$device_repair_m = new DevicerepairModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有报障的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'get');
		$report_user = trim(Zhimin::param('report_user', 'post'));
		$type = trim(Zhimin::param('type', 'post'));
		$report_date = trim(Zhimin::param('report_date', 'post'));
		$e_startup_time = trim(Zhimin::param('e_startup_time', 'post'));
		$reason = trim(Zhimin::param('reason', 'post'));
		$remark = trim(Zhimin::param('remark', 'post'));
		$state = '1';
		$report_date = strtotime($report_date);
		$e_startup_time = strtotime($e_startup_time);

		if ($e_startup_time < $report_date) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '预计启用时间不能在故障时间之前';
			echo json_encode($result_array);
			exit();
		}

		$device_res = $device_m->data_by_id($id);

		if (!$device_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($report_user == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请输入报障人';
			echo json_encode($result_array);
			exit();
		}

		if ($type == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请输入故障类型';
			echo json_encode($result_array);
			exit();
		}

		if ($report_date == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请输入故障时间';
			echo json_encode($result_array);
			exit();
		}

		if ($device_res['state'] == '1') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪已经是报障状态';
			echo json_encode($result_array);
			exit();
		}

		if ($device_res['state'] == '2') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪已经是报废状态';
			echo json_encode($result_array);
			exit();
		}

		$insert_flg = $device_repair_m->insertRow(array('type' => $type, 'report_user' => $report_user, 'hostbody' => $device_res['hostbody'], 'unit_no' => $device_res['danwei'], 'hostcode' => $device_res['hostcode'], 'hostname' => $device_res['hostname'], 'report_date' => $report_date, 'reason' => $reason, 'remark' => $remark, 'e_startup_time' => $e_startup_time, 'creater' => $_SESSION['username'], 'createtime' => time()));

		if ($insert_flg) {
			$scrap_flg = $device_m->data_state_update($state, $id);
			$log_type = '054';
			$unit_m = new UnitModel();
			$sysconf_m = new SysconfModel();
			$type_name = $sysconf_m->get_by_no($type);
			$log_unit = $unit_m->get_by_sn($device_res['danwei']);
			$log_message = '记录仪报障成功，记录仪编号：' . $device_res['hostbody'] . '，配发' . $_SESSION['zfz_type'] . '：' . $device_res['hostname'] . '，单位：' . $log_unit['dname'] . '，故障类型：' . $type_name['confname'] . '，故障时间：' . date('Y-m-d', $report_date);
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '记录仪报障成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪报障失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function up()
	{
		$device_m = new DeviceModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有启用记录仪的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$device_res = $device_m->data_by_id($id);

		if (!$device_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($device_res['state'] == '0') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '此记录仪的状态为正常';
			echo json_encode($result_array);
			exit();
		}

		if ($device_res['state'] == '2') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '此记录仪已报废';
			echo json_encode($result_array);
			exit();
		}

		$state = '0';
		$scrap_flg = $device_m->data_state_update($state, $id);

		if ($scrap_flg) {
			$device_repair_m = new DevicerepairModel();
			$get_last_sql = 'select `id` from `zm_device_repair` where `hostbody`=\'' . $device_res['hostbody'] . '\' order by `createtime` desc limit 1';
			$get_last = $device_repair_m->fetchOne('', $get_last_sql);
			$device_repair_m->updateRow('id=\'' . $get_last['id'] . '\'', array('startup_time' => time(), 'moder' => $_SESSION['username'], 'modtime' => time()));
			$log_type = '058';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($device_res['danwei']);
			$log_message = '启用记录仪成功，配发' . $_SESSION['zfz_type'] . '：' . $device_res['hostname'] . '，' . $_SESSION['zfz_type'] . '编号：' . $device_res['hostcode'] . '，记录仪编号：' . $device_res['hostbody'] . '，单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '启用记录仪成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '启用记录仪失败，请稍后再试';
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

		$device_m = new DeviceModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$device = $device_m->read($id);

		if (empty($device)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['hostname'] = $device['hostname'];
		$result_array['hostcode'] = $device['hostcode'];
		$result_array['hostbody'] = $device['hostbody'];
		$result_array['danwei'] = $device['danwei'];
		$result_array['product_name'] = $device['product_name'];
		$result_array['product_firm'] = $device['product_firm'];
		$result_array['capacity'] = $device['capacity'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$unit_m = new UnitModel();
		$device_m = new DeviceModel();
		$id = Zhimin::param('id', 'post');
		$hostname = trim(Zhimin::param('hostname', 'post'));
		$hostcode = trim(Zhimin::param('hostcode', 'post'));
		$danwei = Zhimin::param('danwei', 'post');
		$product_name = trim(Zhimin::param('product_name', 'post'));
		$product_firm = trim(Zhimin::param('product_firm', 'post'));
		$capacity = trim(Zhimin::param('capacity', 'post'));
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';
		$device_res = $device_m->read($id);

		if (empty($device_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($hostname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，配发' . $_SESSION['zfz_type'] . '：' . $hostname;
		}

		if ($hostcode == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，' . $_SESSION['zfz_type'] . '编号：' . $hostcode;
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

		if ($product_name != '') {
			$log_string .= '，产品名称：' . $product_name;
		}

		if ($product_firm != '') {
			$log_string .= '，厂商：' . $product_firm;
		}

		if ($capacity != '') {
			$log_string .= '，容量(MB)：' . $capacity;
		}

		$edit_flg = $device_m->updateRow('id=' . $id, array('hostname' => $hostname, 'hostcode' => $hostcode, 'danwei' => $danwei, 'product_name' => $product_name, 'product_firm' => $product_firm, 'capacity' => $capacity, 'moder' => $_SESSION['username'], 'modtime' => time()));

		if ($edit_flg) {
			$log_type = '092';
			$log_message = '编辑记录仪成功，记录仪编号：' . $device_res['hostbody'] . $log_string;
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

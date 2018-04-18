<?php

class WorkforceAction extends Action
{
	protected $module_sn = '10022';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$workforce_m = new WorkforceModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('edit' => 0, 'delete' => 0, 'add' => 0, 'import' => 0, 'down_modul' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['delete'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['import'] = 1;
		}

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['down_modul'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$user_groups = array();
		getusergroups($user_groups, '');
		$this->_data['user_groups'] = $user_groups;

		switch ($action) {
		case 'add':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveAdd();
				break;
			}
			else {
				$this->add();
				break;
			}

		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;

		case 'delete':
			$this->saveDel();
			break;

		case 'import':
			$this->import();
			break;

		case 'down_modul':
			$this->downloadexcel();
			break;

		case 'excel':
			$this->excel();
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
		$workforce_m = new WorkforceModel();
		$unit_m = new UnitModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$classids = $workforce_m->classid;
		$this->_data['classids'] = $classids;
		$usename = Zhimin::request('usename');
		$classid = Zhimin::request('classid');
		$danwei = Zhimin::request('danwei');
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['usename'] = $usename;
		$url['classid'] = $classid;
		$url['danwei'] = $danwei;
		$url['date_time'] = $date_time;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pw.unitcode in (' . $dlist . ')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pw.unitcode in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (!empty($usename)) {
			$where .= ' AND pw.usename like \'%' . $usename . '%\' ';
		}

		if (!empty($classid)) {
			$where .= ' AND pw.classid = \'' . $classid . '\' ';
		}

		if ($date_time == '1') {
			$sdate1 = get_week_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本周';
		}
		else if ($date_time == '2') {
			$sdate1 = get_month_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本月';
		}
		else if ($date_time == '3') {
			if (($sdate != '') && ($edate != '')) {
				$sdate1 = $sdate . ' 00:00:00';
				$edate1 = $edate . ' 23:59:59';
			}

			$date_time_name = '一段时间';
		}
		else {
			$sdate1 = '1970-00-00 00:00:00';
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '不限';
		}

		$this->_data['date_time_name'] = $date_time_name;
		$where .= ' AND (\'' . strtotime($sdate1) . '\' <= \'' . strtotime($edate1) . '\')';
		$where .= ' and `pw`.`statdate` between \'' . date('Y-m-d', strtotime($sdate1)) . '\' and  \'' . date('Y-m-d', strtotime($edate1)) . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $workforce_m->table() . '` as `pw` left join `zm_danwei` as `pd` on `pw`.`unitcode`=`pd`.`bh`  where ' . $where;
		$rs = $workforce_m->fetchOne('', $sql);
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
			$sql = 'SELECT pw.*, pd.dname as unitname FROM `' . $workforce_m->table() . '` pw';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pw.usecode';
			$sql .= ' LEFT JOIN `' . $user_m->table() . '` pu ON pu.username=pw.creater';
			$sql .= ' WHERE ' . $where . ' order by pw.statdate desc,pw.creatime desc ' . $limit;
			$workforces = $workforce_m->fetchAll('', $sql);
			$this->_data['workforces'] = $workforces;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function add()
	{
		$workforce_m = new WorkforceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$classids = $workforce_m->classid;
		$this->_data['classids'] = $classids;
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$usecode = Zhimin::param('usecode', 'post');
		$usename = Zhimin::param('usename', 'post');
		$user_a = $user_m->get_by_realname($usename);

		if (!$user_a) {
			$user_a = $user_m->get_by_name($usename);
		}

		$user_b = $user_m->get_by_hostcode($usecode);
		$unit = ($user_a['dbh'] == '' ? $user_b['dbh'] : $user_a['dbh']);
		$unit_a = $unit_m->get_by_sn($unit);

		if ($usename) {
			if (!$user_a) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '姓名不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usecode = $user_a['hostcode'];
				$danwei = $user_a['dbh'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usecode . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}
		else if ($usecode) {
			if (!$user_b) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usename = ($user_b['realname'] == '' ? $user_b['username'] : $user_b['realname']);
				$danwei = $user_b['dbh'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usename . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}
	}

	protected function saveAdd()
	{
		$workforce_m = new WorkforceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$classids = $workforce_m->classid;
		$this->_data['classids'] = $classids;
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$usecode = Zhimin::param('usecode', 'post');
		$usename = Zhimin::param('usename', 'post');
		$danwei = trim(Zhimin::param('danwei', 'post'));
		$classid = Zhimin::param('classid', 'post');
		$stattime = Zhimin::param('stattime', 'post');
		$endtime = Zhimin::param('endtime', 'post');
		$statdate = Zhimin::param('statdate', 'post');
		$user_a = $user_m->get_by_realname($usename);
		$user_b = $user_m->get_by_hostcode($usecode);
		$unit = ($user_a['dbh'] == '' ? $user_b['dbh'] : $user_a['dbh']);
		$unit_a = $unit_m->get_by_sn($unit);

		if ($user_a) {
			$usename = $user_a['realname'];
		}
		else if (!$user_a) {
			$user_a = $user_m->get_by_name($usename);
			$usename = $user_a['username'];
		}

		if ($usecode == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (!$user_b) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '不存在此' . $_SESSION['zfz_type'] . '编号';
			echo json_encode($result_array);
			exit();
		}

		if ($usename == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (!$user_a) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '不存在此姓名';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if (!$unit_a || ($danwei !== $unit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '此姓名（' . $_SESSION['zfz_type'] . '编号）对应单位有误，请重新选择';
			echo json_encode($result_array);
			exit();
		}

		if ($classid == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择状态';
			echo json_encode($result_array);
			exit();
		}

		if ($statdate == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择考勤日期';
			echo json_encode($result_array);
			exit();
		}

		if (date('Y-m-d', time()) < $statdate) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '考勤日期超出';
			echo json_encode($result_array);
			exit();
		}

		if ($stattime == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择开始时间';
			echo json_encode($result_array);
			exit();
		}

		if (substr($stattime, 0, 10) != $statdate) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '开始时间必须是考勤日期当天的时间';
			echo json_encode($result_array);
			exit();
		}

		if ($endtime == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择结束时间';
			echo json_encode($result_array);
			exit();
		}

		if (substr($endtime, 0, 10) != $statdate) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '结束时间必须是考勤日期当天的时间';
			echo json_encode($result_array);
			exit();
		}

		if ($endtime < $stattime) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '开始时间不能大于结束时间，请重新选择';
			echo json_encode($result_array);
			exit();
		}

		$usename = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$insert_flg = $workforce_m->insertRow(array('creater' => $_SESSION['username'], 'usename' => $usename, 'usecode' => $usecode, 'unitcode' => $danwei, 'classid' => $classid, 'statdate' => $statdate, 'stattime' => $stattime, 'endtime' => $endtime, 'creatime' => time()));

		if ($insert_flg) {
			$log_type = '021';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加考勤成功，添加人员：' . $usename . '，考勤日期：' . $statdate . '，考勤开始时间：' . $stattime . '，考勤结束时间：' . $endtime;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加考勤成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加考勤失败，考勤日期已存在，请稍后重试';
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

		$workforce_m = new WorkforceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$workforce = $workforce_m->data_by_id($id);
		$usecode = Zhimin::param('usecode', 'post');
		$usename = Zhimin::param('usename', 'post');
		$user_a = $user_m->get_by_realname($usename);

		if (!$user_a) {
			$user_a = $user_m->get_by_name($usename);
		}

		$user_b = $user_m->get_by_hostcode($usecode);
		$unit = ($user_a['dbh'] == '' ? $user_b['dbh'] : $user_a['dbh']);
		$unit_a = $unit_m->get_by_sn($unit);

		if ($usename) {
			if (!$user_a) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '姓名不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usecode = $user_a['hostcode'];
				$danwei = $user_a['dbh'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usecode . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}
		else if ($usecode) {
			if (!$user_b) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usename = ($user_b['realname'] == '' ? $user_b['username'] : $user_b['realname']);
				$danwei = $user_b['dbh'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usename . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['usename'] = $workforce['usename'];
		$result_array['usecode'] = $workforce['usecode'];
		$result_array['danwei'] = $workforce['unitcode'];
		$result_array['classid'] = $workforce['classid'];
		$result_array['statdate'] = $workforce['statdate'];
		$result_array['stattime'] = $workforce['stattime'];
		$result_array['endtime'] = $workforce['endtime'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$workforce_m = new WorkforceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$usename = Zhimin::param('usename', 'post');
		$usecode = Zhimin::param('usecode', 'post');
		$danwei = trim(Zhimin::param('danwei', 'post'));
		$classid = Zhimin::param('classid', 'post');
		$statdate = Zhimin::param('statdate', 'post');
		$stattime = Zhimin::param('stattime', 'post');
		$endtime = Zhimin::param('endtime', 'post');
		$user_a = $user_m->get_by_realname($usename);
		$user_b = $user_m->get_by_hostcode($usecode);
		$unit = ($user_a['dbh'] == '' ? $user_b['dbh'] : $user_a['dbh']);
		$unit_a = $unit_m->get_by_sn($unit);

		if ($user_a) {
			$usename = $user_a['realname'];
		}
		else if (!$user_a) {
			$user_a = $user_m->get_by_name($usename);
			$usename = $user_a['username'];
		}

		if ($usecode == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (!$user_b) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '不存在此' . $_SESSION['zfz_type'] . '编号';
			echo json_encode($result_array);
			exit();
		}

		if ($usename == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (!$user_a) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '不存在此姓名';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if (!$unit_a || ($danwei !== $unit)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '此姓名（' . $_SESSION['zfz_type'] . '编号）对应单位有误，请重新选择';
			echo json_encode($result_array);
			exit();
		}

		if ($classid == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择状态';
			echo json_encode($result_array);
			exit();
		}

		if ($statdate == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择考勤日期';
			echo json_encode($result_array);
			exit();
		}

		if (date('Y-m-d', time()) < $statdate) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '考勤日期超出';
			echo json_encode($result_array);
			exit();
		}

		if ($stattime == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择开始时间';
			echo json_encode($result_array);
			exit();
		}

		if (10 < strlen($stattime)) {
			if (substr($stattime, 0, 10) != $statdate) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '开始时间必须是考勤日期当天的时间';
				echo json_encode($result_array);
				exit();
			}
		}

		if ($endtime == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择结束时间';
			echo json_encode($result_array);
			exit();
		}

		if (10 < strlen($stattime)) {
			if (substr($endtime, 0, 10) != $statdate) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '结束时间必须是考勤日期当天的时间';
				echo json_encode($result_array);
				exit();
			}
		}

		if ($endtime < $stattime) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '开始时间不能大于结束时间，请重新选择';
			echo json_encode($result_array);
			exit();
		}

		$usename = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$workforce = $workforce_m->data_by_id($id);
		$edit_flg = $workforce_m->updateRow('id=' . $id, array('usecode' => $usecode, 'creater' => $_SESSION['username'], 'usename' => $usename, 'unitcode' => $danwei, 'classid' => $classid, 'statdate' => $statdate, 'stattime' => $stattime, 'endtime' => $endtime, 'creatime' => time()));

		if ($edit_flg) {
			$log_type = '022';
			$log_message = '编辑考勤成功，考勤人员：' . $workforce['usename'] . '，考勤日期：' . $statdate . '，考勤开始时间：' . $stattime . '，考勤结束时间：' . $endtime;
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
		$workforce_m = new WorkforceModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有删除的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::request('id');
		$danwei = Zhimin::request('danwei');
		$danwei = Zhimin::request('usename');
		$danwei = Zhimin::request('usecode');
		$danwei = Zhimin::request('classid');
		$danwei = Zhimin::request('classid');
		$danwei = Zhimin::request('stattime');
		$danwei = Zhimin::request('endtime');
		$danwei = Zhimin::request('statdate');
		$workforce_res = $workforce_m->get_by_id($id);

		if (!$workforce_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $workforce_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法删除自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$workforce_m->deleteRow('`id`=\'' . $id . '\'');
		$log_type = '023';
		$unit_m = new UnitModel();
		$log_message = '删除考勤成功，删除人员：' . $workforce_res['usename'] . '，考勤日期：' . $workforce_res['statdate'] . '，考勤开始时间：' . $workforce_res['stattime'] . '，考勤结束时间：' . $workforce_res['endtime'];
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '删除考勤成功';
		echo json_encode($result_array);
		exit();
	}

	protected function downloadexcel()
	{
		$user_m = new UserModel();
		$log = new LogModel();
		$file_name = getrooturl();
		$file_name .= 'images/demo/workforce_demo.xls';
		$log_type = '018';
		$log_message = '下载导入用户的Excel模板';
		$log_filename = 'workforce_demo.xls';
		$log->writeLog($log_type, $log_message, $log_filename);
		echo '<script language=\'javascript\'>location.href=\'' . $file_name . '\';</script>';
		exit();
	}

	protected function import()
	{
		$user_m = new UserModel();
		$workforce_m = new WorkforceModel();
		$log = new LogModel();
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
		$time = date('ymd-His');
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
			$error_no = array('usename_noexist' => 0, 'usename_empty' => 0, 'usecode_noexist' => 0, 'usecode_empty' => 0, 'statdate_empty' => 0, 'statdate_wrong' => 0, 'stattime_empty' => 0, 'endtime_empty' => 0, 'endtime_wrong' => 0, 'classid_empty' => 0, 'insert_error' => 0);
			$log_string = '';

			for ($row = 2; $row <= $highestRow; $row++) {
				$strs = array();

				for ($col = 0; $col < $highestColumnIndex; $col++) {
					$strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				}

				$usename = trim($strs[0]);
				$usecode = trim($strs[1]);
				$statdate = trim($strs[2]);
				$stattime = trim($strs[3]);
				$endtime = trim($strs[4]);
				$classid = trim($strs[5]);
				$user_a = $user_m->get_by_realname($usename);

				if (!$user_a) {
					$user_a = $user_m->get_by_name($usename);
				}

				$user_b = $user_m->get_by_hostcode($usecode);
				$unit = ($user_a['dbh'] == '' ? $user_b['dbh'] : $user_a['dbh']);
				$unit_a = $unit_m->get_by_sn($unit);

				if ($usename) {
					if (!$user_a) {
						if ($usecode) {
							if (!$user_b) {
								$error_no['usename_noexist']++;
								$error_no['usecode_noexist']++;
								$log_string .= ' ' . $_SESSION['zfz_type'] . $usename . '不存在，' . $_SESSION['zfz_type'] . '编号' . $usecode . '不存在；';
								continue;
							}
							else {
								$usename = ($user_b['realname'] == '' ? $user_b['username'] : $user_b['realname']);
								$danwei = $user_b['dbh'];
							}
						}
						else {
							$error_no['usename_noexist']++;
							$error_no['usecode_empty']++;
							$log_string .= ' ' . $_SESSION['zfz_type'] . $usename . '不存在，' . $_SESSION['zfz_type'] . '编号为空；';
							continue;
						}
					}
					else {
						$usename = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
						$usecode = $user_a['hostcode'];
						$danwei = $user_a['dbh'];
					}
				}
				else if ($usecode) {
					if (!$user_b) {
						$error_no['usename_empty']++;
						$error_no['usecode_noexist']++;
						$log_string .= ' ' . $_SESSION['zfz_type'] . '为空，' . $_SESSION['zfz_type'] . '编号' . $usecode . '不存在；';
						continue;
					}
					else {
						$usename = ($user_b['realname'] == '' ? $user_b['username'] : $user_b['realname']);
						$danwei = $user_b['dbh'];
					}
				}
				else {
					$error_no['usename_empty']++;
					$error_no['usecode_empty']++;
					$log_string .= ' ' . $_SESSION['zfz_type'] . '为空，' . $_SESSION['zfz_type'] . '编号为空；';
					continue;
				}

				if ($statdate == '') {
					$error_no['statdate_empty']++;
					$log_string .= ' 考勤日期为空；';
					continue;
				}

				if ($stattime == '') {
					$error_no['stattime_empty']++;
					$log_string .= ' 开始时间为空；';
					continue;
				}

				if ($endtime == '') {
					$error_no['endtime_empty']++;
					$log_string .= ' 结束时间为空；';
					continue;
				}

				if (date('Y-m-d', time()) < $statdate) {
					$error_no['statdate_wrong']++;
					$log_string .= ' 考勤日期' . $statdate . '超出今天' . date('Y-m-d', time());
					continue;
				}

				if ($endtime < $stattime) {
					$error_no['endtime_wrong']++;
					$log_string .= ' 开始时间' . $stattime . '不能大于结束时间' . $endtime;
					continue;
				}

				if ($classid == '') {
					$error_no['classid_empty']++;
					$log_string .= ' 状态为空；';
					continue;
				}

				$insert_flg = $workforce_m->insertRow(array('creater' => $_SESSION['username'], 'usename' => $usename, 'usecode' => $usecode, 'unitcode' => $danwei, 'classid' => $classid, 'statdate' => $statdate, 'stattime' => $stattime, 'endtime' => $endtime, 'creatime' => time()));

				if (!$insert_flg) {
					$error_no['insert_error']++;
					$log_string .= '用户名' . $usename . '，插入到数据库失败；';
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

			$log_type = '024';
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

	protected function excel()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$user_m = new UserModel();
		$workforce_m = new WorkforceModel();
		$unit_m = new UnitModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$classids = $workforce_m->classid;
		$this->_data['classids'] = $classids;
		$usename = Zhimin::request('usename');
		$classid = Zhimin::request('classid');
		$danwei = Zhimin::request('danwei');
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['usename'] = $usename;
		$url['classid'] = $classid;
		$url['danwei'] = $danwei;
		$url['date_time'] = $date_time;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pw.unitcode in (' . $dlist . ')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pw.unitcode in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (!empty($usename)) {
			$where .= ' AND pw.usename like \'%' . $usename . '%\' ';
		}

		if (!empty($classid)) {
			$where .= ' AND pw.classid = \'' . $classid . '\' ';
		}

		if ($date_time == '1') {
			$sdate1 = get_week_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本周';
		}
		else if ($date_time == '2') {
			$sdate1 = get_month_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本月';
		}
		else if ($date_time == '3') {
			if (($sdate != '') && ($edate != '')) {
				$sdate1 = $sdate . ' 00:00:00';
				$edate1 = $edate . ' 23:59:59';
			}

			$date_time_name = '一段时间';
		}
		else {
			$sdate1 = '1970-00-00 00:00:00';
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '不限';
		}

		$this->_data['date_time_name'] = $date_time_name;
		$where .= ' AND (\'' . strtotime($sdate1) . '\' <= \'' . strtotime($edate1) . '\')';
		$where .= ' and `pw`.`statdate` between \'' . date('Y-m-d', strtotime($sdate1)) . '\' and  \'' . date('Y-m-d', strtotime($edate1)) . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $workforce_m->table() . '` as `pw` left join `zm_danwei` as `pd` on `pw`.`unitcode`=`pd`.`bh`  where ' . $where;
		$rs = $workforce_m->fetchOne('', $sql);
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
			$sql = 'SELECT pw.*, pd.dname as unitname FROM `' . $workforce_m->table() . '` pw';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pw.usecode';
			$sql .= ' LEFT JOIN `' . $user_m->table() . '` pu ON pu.username=pw.creater';
			$sql .= ' WHERE ' . $where . ' order by pw.statdate desc,pw.creatime desc ';
			$workforces = $workforce_m->fetchAll('', $sql);
			$this->_data['workforces'] = $workforces;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}

		$unit_cc = $unit_m->get_by_sn($danwei);
		include ('PHPExcel/PHPExcel.php');
		$excel = new PHPExcel();
		$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
		$excel->getActiveSheet()->mergeCells('A1:H1');
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$A1_title = '执法监督 - 考勤管理';
		$excel->getActiveSheet()->mergeCells('A2:H2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(11);
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false);
		$A2_title = '【统计单位：' . ($danwei = ($danwei == '' || '0' ? 'xx公安分局' : $unit_cc['dname'])) . '】 统计时段：' . ($sdate = ($sdate == '' ? '不限' : $sdate)) . '至' . ($edate = ($edate == '' ? '不限' : $edate));
		$excel->getActiveSheet()->mergeCells('A3:H3');
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(11);
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);
		$A3_title = '【生成单位：' . $danwei . '】【制表人：张三】【生成日期：' . date('Y-m-d', time()) . '】';
		$excel->getActiveSheet()->setCellValue('A1', $A1_title);
		$excel->getActiveSheet()->setCellValue('A2', $A2_title);
		$excel->getActiveSheet()->setCellValue('A3', $A3_title);
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$tableheader = array('序号', '发布' . $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type'] . '编号）', '单位', '考勤日期', '开始时间', '结束时间', '时长', '状态');

		for ($i = 0; $i < count($tableheader); $i++) {
			$excel->getActiveSheet()->setCellValue($letter[$i] . '4', $tableheader[$i]);
		}

		foreach ($workforces as $key => $value ) {
			$workforce_m = new WorkforceModel();
			$user_m = new UserModel();
			$unit_m = new UnitModel();
			$workforce = $workforce_m->data_by_id($value['id']);
			$user_a = $user_m->get_by_name($workforce['creater']);
			$unit_a = $unit_m->get_by_sn($user_a['dbh']);
			$unit_c = $unit_m->get_by_sn($workforce['unitcode']);
			$workforce['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
			$workforce['unit_receive'] = ($workforce['unitcode'] == '' ? '所有单位' : $unit_c['dname']);
			$hour = floor(((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400) / 3600);

			if (0 < $hour) {
				$hour = ($hour < 10 ? '0' . $hour : $hour);
			}
			else {
				$hour = '00';
			}

			$minute = floor((((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400) / 60) % 60);

			if (0 < $minute) {
				$minute = ($minute < 10 ? '0' . $minute : $minute);
			}
			else {
				$minute = '00';
			}

			$second = floor((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400 % 60);

			if (0 < $second) {
				$second = ($second < 10 ? '0' . $second : $second);
			}
			else {
				$second = '00';
			}

			$workforce['time'] = $hour . ':' . $minute . ':' . $second;

			if ($value['classid'] == 1) {
				$value['classid'] = '休班/假';
			}
			else if ($value['classid'] == 2) {
				$value['classid'] = '上班';
			}
			else if ($value['classid'] == 3) {
				$value['classid'] = '会议';
			}
			else if ($value['classid'] == 4) {
				$value['classid'] = '公出';
			}

			$excel->getActiveSheet()->setCellValue('A' . ($key + 5), $key + 1);
			$excel->getActiveSheet()->setCellValue('B' . ($key + 5), $value['usename'] . '(' . $value['usecode'] . ')');
			$excel->getActiveSheet()->setCellValue('C' . ($key + 5), $workforce['unit_receive']);
			$excel->getActiveSheet()->setCellValue('D' . ($key + 5), $value['statdate']);
			$excel->getActiveSheet()->setCellValue('E' . ($key + 5), $value['stattime']);
			$excel->getActiveSheet()->setCellValue('F' . ($key + 5), $value['endtime']);
			$excel->getActiveSheet()->setCellValue('G' . ($key + 5), $workforce['time']);
			$excel->getActiveSheet()->setCellValue('H' . ($key + 5), $value['classid']);
		}

		$write = new PHPExcel_Writer_Excel5($excel);
		$filename = $runit['dname'] . date('YmdHis', time());
		ob_end_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
		header('Content-Type:application/force-download');
		header('Content-Type:application/vnd.ms-execl');
		header('Content-Type:application/octet-stream');
		header('Content-Type:application/download');
		header('Content-Disposition:attachment;filename="' . $filename . '.xls"');
		header('Content-Transfer-Encoding:binary');
		$write->save('php://output');
		$user_m = new UserModel();
		$log = new LogModel();
		$log_type = '017';
		$log_message = 'Excel表格导出';
		$log_filename = '';
		$log->writeLog($log_type, $log_message, $log_filename);
		exit();
	}
}


?>

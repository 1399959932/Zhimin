<?php

class WorkforceditAction extends Action
{
	protected $module_sn = '10022';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '';
		return $this;
	}

	protected function _main()
	{
		$workforce_m = new WorkforceModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_groups = array();
		getusergroups($user_groups, '');
		$this->_data['user_groups'] = $user_groups;
		$classids = $workforce_m->classid;
		$this->_data['classids'] = $classids;

		switch ($action) {
		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
				break;
			}
			else {
				$this->edit();
				break;
			}

		default:
			$this->check();
			break;
		}
	}

	protected function check()
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
		$this->_data['danwei'] = $danwei;

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

	protected function edit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return NULL;
		}

		$workforce_m = new WorkforceModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'get');
		$workforce = $workforce_m->data_by_id($id);
		$unit_m = new UnitModel();
		$danwei = $workforce['unitcode'];
		$this->_data['danwei'] = $danwei;

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (empty($workforce)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '考勤不存在');
			return NULL;
		}

		$user_unit = $unit_m->get_by_sn($workforce['unitcode']);
		$workforce['unit_name'] = $user_unit['dname'];
		$this->_data['data'] = $workforce;
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
}


?>

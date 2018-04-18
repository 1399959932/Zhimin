<?php

class UsereditAction extends Action
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
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$user = $user_m->get_by_name($_SESSION['username']);
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_groups = array();
		getusergroups($user_groups, '');
		$this->_data['user_groups'] = $user_groups;

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

		$user_m = new UserModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'get');
		$user = $user_m->read($id);

		if (empty($user)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '用户不存在');
			return NULL;
		}

		$user_group = $group_m->get_by_sn($user['gid']);
		$user['gid_name'] = $user_group['gname'];
		$user_unit = $unit_m->get_by_sn($user['dbh']);
		$user['unit_name'] = $user_unit['dname'];
		$this->_data['data'] = $user;
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
		$danwei = Zhimin::param('danwei', 'post');
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
}


?>

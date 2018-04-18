<?php

class AccessfromAction extends Action
{
	protected $module_sn = '10041';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAll($this->module_sn)) {
			echo '<script language=\'javascript\'>alert(\'无权限,禁止操作!\');history.back(-1);</script>';
			exit();
		}

		$user_auth = array('add' => 0);

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$station_m = new AccessModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$unit_num = $_SESSION['unitcode'];
		$unit = $unit_m->get_by_sn($unit_num);
		$unit_id = $unit['id'];
		$brother_record = $unit_m->getBrotherUnit($unit_id);
		$own_unit = $unit_m->get_by_ids($unit_id);
		$father_unit_sql = 'select * from `' . $unit_m->table() . '` where `id`=\'' . $own_unit['parentid'] . '\'';
		$father_unit = $unit_m->dquery($father_unit_sql);
		$users_records = $user_m->get_group_users($father_unit[0]['bh']);
		$group_m = new GroupModel();
		$sql = 'select * from ' . $group_m->table();
		$groups = $group_m->dquery($sql);
		$i = 0;

		foreach ($groups as $v ) {
			if ($v['qx_accessto'] & 32) {
				$d_rows[$i] = $v;
				$i++;
			}
		}

		$j = 0;

		foreach ($users_records as $v ) {
			foreach ($d_rows as $k_d => $v_d ) {
				if ($v['gid'] == $d_rows[$k_d]['bh']) {
					$users_record[$j] = $v;
					$j++;
				}
			}
		}

		$this->_data['brothers'] = $brother_record;
		$this->_data['b_users'] = $users_record;
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'add':
			$this->saveAdd();
			break;

		case 'view':
			$this->view();
			break;

		case 'del':
			$this->savedel();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function savedel()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$access_m = new AccessModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$result_array = array();
		$id = Zhimin::request('id');
		$data = $access_m->data_by_id($id);
		$app_user = $data['applicant'];
		$app_unit = $data['app_unit'];
		$sql = 'SELECT * FROM `' . $user_m->table() . '` WHERE username=\'' . $app_user . '\'';
		$puser = $user_m->fetchOne('', $sql);
		$manager_unit = $puser['manager_unit'];
		$manager_unit_arr = explode(',', $manager_unit);

		if (in_array($app_unit, $manager_unit_arr)) {
			$key = array_search($app_unit, $manager_unit_arr);

			if ($key !== false) {
				array_splice($manager_unit_arr, $key, 1);
			}
		}

		if ($id) {
			$manager = implode(',', $manager_unit_arr);
			$user_m->updateRow('id=' . $puser['id'], array('manager_unit' => $manager));
			$access_m->deleteRow('id=\'' . $id . '\'');
			$loginuser = $_SESSION['username'];
			$log_type = '042';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '成功删除案件!';
			$log_m->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除成功！';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除失败！';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function view()
	{
		$access_m = new AccessModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$result_array = array();
		$_status = array('等待审批', '审批通过', '拒绝申请');
		$id = Zhimin::param('id', 'post');
		$data = $access_m->data_by_id($id);
		$user = $user_m->get_by_id($data['approver']);
		$unit = $unit_m->get_by_sn($data['app_unit']);
		$result_array['username'] = $user['username'];
		$result_array['unit'] = $unit['dname'];
		$result_array['createtime'] = date('Y-m-d', $data['create_date']);
		$result_array['status'] = $_status[$data['app_status']];

		if ($data['app_date'] == '') {
			$result_array['apptime'] = '';
		}
		else {
			$result_array['apptime'] = date('Y-m-d', $data['app_date']);
		}

		echo json_encode($result_array);
		exit();
	}

	protected function saveAdd()
	{
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$access_m = new AccessModel();
		$app_unit = Zhimin::param('app_unit', 'post');
		$approver = Zhimin::param('approver', 'post');
		$appname = $_SESSION['username'];
		$user_m = new UserModel();
		$sql = 'SELECT * FROM `' . $user_m->table() . '` WHERE username=\'' . $appname . '\'';
		$puser = $user_m->fetchOne('', $sql);
		$manager_unit = $puser['manager_unit'];
		$manager_unit_arr = explode(',', $manager_unit);

		if (in_array($app_unit, $manager_unit_arr)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '调阅单位已存在，不用再重新申请！';
			echo json_encode($result_array);
			exit();
		}

		if ($app_unit == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '申请调阅单位不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($approver == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '审批负责人不能为空';
			echo json_encode($result_array);
			exit();
		}

		$flag = $access_m->insertRow(array('applicant' => $_SESSION['username'], 'app_unit' => $app_unit, 'approver' => $approver, 'app_status' => '0', 'create_date' => time()));

		if (0 < intval($flag)) {
			$result_array['state'] = 'success';
			$result_array['msg'] = '申请同级调阅成功';
			$message_m = new MessageModel();
			$use_m = new UserModel();
			$danwei_m = new UnitModel();
			$sql1 = 'SELECT * FROM `' . $danwei_m->table() . '` WHERE bh=' . $app_unit;
			$pdanwei = $use_m->fetchOne('', $sql1);
			$pdw = $pdanwei['dname'];
			$sql = 'SELECT * FROM `' . $use_m->table() . '` WHERE id=' . $approver;
			$puser = $use_m->fetchOne('', $sql);
			$touserid = $puser['id'];
			$tousername = $puser['username'];
			$uusersn = $_SESSION['userid'];
			$loginuser = $_SESSION['username'];
			$posttitle = '申请调阅';
			$postcontent = $loginuser . '申请调阅' . $pdw . '的资料，请审批！';
			$message_m->insertRow(array('userid' => $uusersn, 'username' => $loginuser, 'touserid' => $touserid, 'tousername' => $tousername, 'title' => $posttitle, 'content' => $postcontent, 'is_new' => 1, 'in_time' => time()));
			$log_type = '041';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '向' . $tousername . '发送同级调阅申请!';
			$log_m->writeLog($log_type, $log_message);
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '申请同级调阅失败';
			echo json_encode($result_array);
			exit();
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

		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$access_m = new AccessModel();
		$_status = array('等待审批', '审批通过', '拒绝申请');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$this->url_base = suffix_url($this->url_base, $url);
		$where = ' 1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$user_name = $loginuser['username'];

		if (!$auth->isSuperAdmin()) {
			$where .= ' AND pac.applicant=\'' . $user_name . '\'';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $access_m->table() . '` pac LEFT JOIN `' . $unit_m->table() . '` pdw ON pdw.bh=pac.app_unit WHERE ' . $where;
		$rs = $access_m->fetchOne('', $sql);
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
		$sql = 'SELECT pac.*,pdw.dname FROM `' . $access_m->table() . '`pac LEFT JOIN `' . $unit_m->table() . '` pdw ON pdw.bh=pac.app_unit';
		$sql .= ' WHERE ' . $where . ' order by pac.app_status asc,pac.create_date desc ' . $limit;
		$accs = $access_m->fetchAll('', $sql);
		$this->_data['datas'] = $accs;
		$this->_data['status'] = $_status;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}
}


?>

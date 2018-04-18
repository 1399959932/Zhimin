<?php

class AccesstoAction extends Action
{
	protected $module_sn = '10042';

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

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$station_m = new AccessModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();

		switch ($action) {
		case 'view':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->appsave();
			}
			else {
				$this->view();
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

	protected function appsave()
	{
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有审批的权限';
			echo json_encode($result_array);
			exit();
		}

		$access_m = new AccessModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$id = Zhimin::param('id', 'post');
		$noapp = Zhimin::param('noapp', 'post');
		$status = Zhimin::param('approver', 'post');
		$sql = 'SELECT * FROM `' . $access_m->table() . '` WHERE id=\'' . $id . '\'';
		$access = $access_m->fetchOne('', $sql);
		$appname = $access['applicant'];
		$app_unit = $access['app_unit'];
		$sql = 'SELECT * FROM `' . $user_m->table() . '` WHERE username=\'' . $appname . '\'';
		$puser = $user_m->fetchOne('', $sql);
		$manager_unit = $puser['manager_unit'];
		$manager_unit = $puser['manager_unit'];
		$manager_unit_arr = explode(',', $manager_unit);

		if (in_array($app_unit, $manager_unit_arr)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '调阅单位已存在，不用再重新审批！';
			echo json_encode($result_array);
			exit();
		}

		$sql1 = 'SELECT * FROM `' . $unit_m->table() . '` WHERE bh=\'' . $app_unit . '\'';
		$pdanwei = $unit_m->fetchOne('', $sql1);
		$dname = $pdanwei['dname'];

		if ($noapp == 1) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '已审批，无法继续审批';
			echo json_encode($result_array);
			exit();
		}

		if (($status == '') || !is_numeric($status)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '未做处理';
			echo json_encode($result_array);
			exit();
		}
		else {
			if ($status == 1) {
				if (empty($manager_unit)) {
					$manager_unit = $puser['dbh'];
				}

				$manager_unit .= ',' . $pdanwei['bh'];
				$user_m->updateRow('id=' . $puser['id'], array('manager_unit' => trim($manager_unit, ',')));
			}

			$flag = $access_m->updateRow('id=' . $id, array('app_status' => $status, 'app_date' => time()));

			if (0 < intval($flag)) {
				$result_array['state'] = 'success';
				$result_array['msg'] = '审批成功';
				$message_m = new MessageModel();
				$touserid = $puser['id'];
				$tousername = $appname;
				$uusersn = $_SESSION['userid'];
				$loginuser = $_SESSION['username'];
				$posttitle = '审批';
				$postcontent = $loginuser . '审批了对' . $dname . '的同级调阅申请！';
				$message_m->insertRow(array('userid' => $uusersn, 'username' => $loginuser, 'touserid' => $touserid, 'tousername' => $tousername, 'title' => $posttitle, 'content' => $postcontent, 'is_new' => 1, 'in_time' => time()));
				$log_type = '043';
				$log_m = new LogModel();
				$log_message = '用户：' . $loginuser . '审批' . $tousername . '发送的同级调阅申请!';
				$log_m->writeLog($log_type, $log_message);
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '审批失败';
				echo json_encode($result_array);
				exit();
			}
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
		$result_array['id'] = $id;
		$data = $access_m->data_by_id($id);
		$sql = 'SELECT pac.*, pdw.dname FROM zm_access pac LEFT JOIN zm_user pu ON pu.username=pac.applicant' . "\r\n" . '                LEFT JOIN zm_danwei pdw ON pdw.bh=pu.dbh WHERE pac.id=' . $id;
		$appunit = $access_m->fetchOne('', $sql);
		$unit = $unit_m->get_by_sn($data['app_unit']);
		$result_array['appunit'] = $appunit['dname'];
		$result_array['username'] = $data['applicant'];
		$result_array['unit'] = $unit['dname'];
		$result_array['createtime'] = date('Y-m-d', $data['create_date']);
		$result_array['status'] = $_status[$data['app_status']];
		if (($data['app_status'] == 1) || ($data['app_status'] == 2)) {
			$result_array['noapp'] = 1;
		}

		if ($data['app_date'] == '') {
			$result_array['apptime'] = '';
		}
		else {
			$result_array['apptime'] = date('Y-m-d', $data['app_date']);
		}

		echo json_encode($result_array);
		exit();
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
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
		$user_id = $loginuser['id'];

		if (!$auth->isSuperAdmin()) {
			$where .= ' AND pac.approver=\'' . $user_id . '\'';
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
		$sql = 'SELECT pac.*,pdw.dname,pdws.dname as danwei_name FROM `' . $access_m->table() . '`pac LEFT JOIN `' . $unit_m->table() . '` pdw ON pdw.bh=pac.app_unit LEFT JOIN `' . $user_m->table() . '` us ON us.username=pac.applicant LEFT JOIN `' . $unit_m->table() . '` pdws ON pdws.bh=us.dbh';
		$sql .= ' WHERE ' . $where . ' order by pac.app_status asc,pac.create_date desc ' . $limit;
		$accs = $access_m->fetchAll('', $sql);
		$this->_data['datas'] = $accs;
		$this->_data['status'] = $_status;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}
}


?>

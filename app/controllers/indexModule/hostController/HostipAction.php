<?php

class HostipAction extends Action
{
	protected $module_sn = '10071';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$unit_m = new UnitModel();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$hostip_auth = array('view' => 0, 'add' => 0, 'edit' => 0, 'del' => 0, 'admin' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$hostip_auth['view'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$hostip_auth['add'] = 1;
		}

		if ($auth->checkPermitEdit($this->module_sn)) {
			$hostip_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$hostip_auth['del'] = 1;
		}

		if ($auth->isSuperAdmin()) {
			$hostip_auth['admin'] = 1;
		}

		$this->_data['device_auth'] = $hostip_auth;

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

		case 'scrap':
			$this->scrap();
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
		$station_m = new StationModel();
		$danwei = trim(Zhimin::request('danwei'));
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['danwei'] = $danwei;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = ' 1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND ph.unitcode in (' . $dlist . ')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND ph.unitcode in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $station_m->table() . '` ph WHERE ' . $where;
		$rs = $station_m->fetchOne('', $sql);
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
		$sql = 'SELECT ph.*, pd.dname as unitname FROM `' . $station_m->table() . '` ph';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON ph.unitcode=pd.bh';
		$sql .= ' WHERE ' . $where . ' order by ph.modtime desc,ph.unitcode asc,ph.id desc ' . $limit;
		$hostips = $station_m->fetchAll('', $sql);
		$online_array = array();

		foreach ($hostips as $k => $v ) {
			$online_array[$k] = $v;

			if ($v['online'] == 0) {
				$online_array[$k]['online'] = 0;
				$online_array[$k]['activetime'] = '----';
			}
			else {
				$time_limit = 10 * 60;
				$time_temp = strtotime($v['modtime']);
				$time_true = time() - $time_temp;
				if (empty($v['startime']) || ($v['startime'] == '0000-00-00 00:00:00')) {
					$station_m->updateRow('id = \'' . $v['id'] . '\'', array('startime' => $v['modtime']));
					$time_start = strtotime($v['modtime']);
				}
				else {
					$time_start = strtotime($v['startime']);
				}

				if ($time_limit < $time_true) {
					$online_array[$k]['online'] = 0;
					$online_array[$k]['activetime'] = '----';
				}
				else {
					$online_array[$k]['online'] = 1;
					$time_temp01 = timediff($time_start, time());
					$online_array[$k]['activetime'] = $time_temp01['day'] . '天' . $time_temp01['hour'] . '小时' . $time_temp01['min'] . '分' . $time_temp01['sec'] . '秒';
				}
			}
		}

		$this->_data['datas'] = $online_array;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function saveAdd()
	{
		$station_m = new StationModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$hostname = trim(Zhimin::param('hostname', 'post'));
		$danwei = Zhimin::param('danwei', 'post');
		$hostip = trim(Zhimin::param('hostip', 'post'));
		$contact = trim(Zhimin::param('contact', 'post'));
		$telephone = trim(Zhimin::param('telephone', 'post'));
		$address = Zhimin::param('address', 'post');
		$memo = trim(Zhimin::param('memo', 'post'));
		$online = 1;

		if ($hostname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if ($hostip == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站IP地址不能为空';
			echo json_encode($result_array);
			exit();
		}

		$hostip_exist = $station_m->get_by_name($hostname);

		if (!empty($hostip_exist)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '该工作站名称已经被存在';
			echo json_encode($result_array);
			exit();
		}

		$hostip_exist1 = $station_m->get_by_ip($hostip);

		if (!empty($hostip_exist1)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '该工作站IP已经被存在';
			echo json_encode($result_array);
			exit();
		}

		$contact = trim(Zhimin::param('contact', 'post'));
		$telephone = trim(Zhimin::param('telephone', 'post'));
		$address = Zhimin::param('address', 'post');
		$memo = trim(Zhimin::param('memo', 'post'));
		$log_string = '';

		if ($contact != '') {
			$log_string .= '，负责人：' . $contact;
		}

		if ($telephone != '') {
			$log_string .= '，联系电话：' . $telephone;
		}

		if ($address != '') {
			$log_string .= '，工作站地址：' . $address;
		}

		if ($memo != '') {
			$log_string .= '，备注：' . $memo;
		}

		$insert_flg = $station_m->insertRow(array('hostname' => $hostname, 'hostip' => $hostip, 'online' => $online, 'contact' => $contact, 'address' => $address, 'telephone' => $telephone, 'memo' => $memo, 'unitcode' => $danwei, 'enable' => 1, 'startime' => date('Y-m-d H:i:s', time()), 'modtime' => date('Y-m-d H:i:s', time())));

		if ($insert_flg) {
			$log_type = '061';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加工作站成功，工作站名称：' . $hostname . '，工作站IP：' . $hostip . '，所属单位：' . $log_unit['dname'] . $log_string;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加工作站成功';
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

	protected function savedel()
	{
		$unit_m = new UnitModel();
		$station_m = new StationModel();
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
		$station_res = $station_m->get_by_id($id);

		if (empty($station_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您要删除的记录不存在，请稍后重试';
			echo json_encode($result_array);
			exit();
		}

		$del_flg = $station_m->deleteRow('`id`=\'' . $id . '\'');

		if ($del_flg) {
			$log_type = '065';
			$log_unit = $unit_m->get_by_sn($station_res['unitcode']);
			$log_message = '删除工作站成功，工作站名称：' . $station_res['hostname'] . '，工作站IP：' . $station_res['hostip'] . '，所属单位：' . $log_unit['dname'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除工作站成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除工作站失败，请稍后再试';
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

		$station_m = new StationModel();
		$unit_m = new UnitModel();
		$id = trim(Zhimin::param('id', 'post'));
		$hostip = $station_m->read($id);

		if (empty($hostip)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站不存在';
			echo json_encode($result_array);
			exit();
		}

		$result_array['state'] = 'success';
		$result_array['id'] = $id;
		$result_array['hostname'] = $hostip['hostname'];
		$result_array['unitcode'] = $hostip['unitcode'];
		$result_array['hostip'] = $hostip['hostip'];
		$result_array['contact'] = $hostip['contact'];
		$result_array['telephone'] = $hostip['telephone'];
		$result_array['address'] = $hostip['address'];
		$result_array['memo'] = $hostip['memo'];
		echo json_encode($result_array);
		exit();
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$unit_m = new UnitModel();
		$station_m = new StationModel();
		$id = Zhimin::param('id', 'post');
		$danwei = Zhimin::param('danwei_edit', 'post');
		$hostip = trim(Zhimin::param('hostip', 'post'));
		$contact = trim(Zhimin::param('contact', 'post'));
		$telephone = trim(Zhimin::param('telephone', 'post'));
		$address = Zhimin::param('address', 'post');
		$memo = trim(Zhimin::param('memo', 'post'));
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';
		$hostip_res = $station_m->read($id);

		if (empty($hostip_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_string .= '，所属单位：' . $log_unit['dname'];
		}

		if ($hostip == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = 'IP地址不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，IP地址：' . $hostip;
		}

		if ($contact != '') {
			$log_string .= '，负责人：' . $contact;
		}

		if ($telephone != '') {
			$log_string .= '，联系电话：' . $telephone;
		}

		if ($address != '') {
			$log_string .= '，工作站地址：' . $address;
		}

		if ($memo != '') {
			$log_string .= '，备注：' . $memo;
		}

		$edit_flg = $station_m->updateRow('id=' . $id, array('hostip' => $hostip, 'contact' => $contact, 'address' => $address, 'telephone' => $telephone, 'memo' => $memo, 'unitcode' => $danwei));

		if ($edit_flg) {
			$log_type = '062';
			$log_message = '编辑工作站成功，工作站名称：' . $hostip_res['hostname'] . $log_string;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '编辑工作站成功';
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

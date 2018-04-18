<?php

class GroupAction extends Action
{
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
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有访问权限', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'add':
			$this->saveAdd();
			break;

		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}

			break;

		case 'del':
			$this->del();
			break;

		case 'popedom':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->savePopedom();
			}

			break;

		case 'search':
		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$id = Zhimin::request('id');
		$group_m = new GroupModel();

		if (empty($id)) {
			$group_this = $group_m->get_first_group();
		}
		else {
			$group_this = $group_m->read($id);
		}

		$this->_data['data'] = $group_this;
		$group_array = $group_m->get_all_group();
		$this->_data['groups'] = $group_array;
		$modules = array();
		$module_m = new ModuleModel();
		$module_m->get_stair($modules, 'SELF');
		$this->_data['modules'] = $modules;
	}

	protected function saveAdd()
	{
		$group_m = new GroupModel();
		$log = new LogModel();
		$result_array = array();
		$gname = trim(Zhimin::param('gname', 'post'));
		$sort = Zhimin::param('sort', 'post');
		$bh = $group_m->get_next_sn();

		if (empty($gname)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '角色名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		$grow = $group_m->get_by_name($gname);

		if (!empty($grow)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '角色名称已经存在';
			echo json_encode($result_array);
			exit();
		}

		$insert_flg = $group_m->insertRow(array('bh' => $bh, 'gname' => $gname, 'sort' => $sort, 'creater' => $_SESSION['username'], 'createtime' => time()));

		if ($insert_flg) {
			$log_type = '101';
			$log_message = '添加角色成功，角色名称：' . $gname . '，角色编号：' . $bh;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加角色成功';
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

	protected function saveEdit()
	{
		$group_m = new GroupModel();
		$log = new LogModel();
		$result_array = array();
		$gname = trim(Zhimin::param('gname', 'post'));
		$sort = Zhimin::param('sort', 'post');
		$id = Zhimin::param('id', 'post');

		if (empty($gname)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '角色名称不能为空';
			echo json_encode($result_array);
			exit();
		}

		$group_this = $group_m->read($id);

		if (empty($group_this)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '角色不存在';
			echo json_encode($result_array);
			exit();
		}

		$grow = $group_m->fetchOne('', 'select bh from `' . $group_m->table() . '` where `id`<>\'' . $id . '\' and gname=\'' . $gname . '\'');

		if (!empty($grow)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '角色名称已经存在';
			echo json_encode($result_array);
			exit();
		}

		$edit_flg = $group_m->updateRow('id=\'' . $id . '\'', array('gname' => $gname, 'sort' => $sort, 'moder' => $_SESSION['username'], 'modtime' => time()));

		if ($edit_flg) {
			$log_type = '102';
			$log_message = '编辑角色成功，角色名称：' . $gname . '，角色编号：' . $group_this['bh'];
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

	protected function del()
	{
		$log = new LogModel();
		$group_m = new GroupModel();
		$result_array = array();
		$id = Zhimin::param('id', 'post');
		$group = $group_m->read($id);

		if (!$group) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$del_flg = $group_m->deleteRow('id=\'' . $id . '\'');

		if ($del_flg) {
			$log_type = '103';
			$log_message = '删除角色成功，角色名称：' . $group['gname'] . '，角色编号：' . $group['bh'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除角色成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除角色失败，请稍后再试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function savePopedom()
	{
		$group_m = new GroupModel();
		$log = new LogModel();
		$id = Zhimin::param('id', 'post');
		$group = $group_m->read($id);

		if (!$group) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		$qx_data = array('qx_only' => 0, 'qx_video' => 0, 'qx_sup' => 0, 'qx_case' => 0, 'qx_acc' => 0, 'qx_report' => 0, 'qx_dev' => 0, 'qx_host' => 0, 'qx_sys' => 0, 'qx_video_list' => 0, 'qx_supervise' => 0, 'qx_workforce' => 0, 'qx_casetopic' => 0, 'qx_accessfrom' => 0, 'qx_accessto' => 0, 'qx_check' => 0, 'qx_assets' => 0, 'qx_chart' => 0, 'qx_chartcom' => 0, 'qx_device' => 0, 'qx_device_fault' => 0, 'qx_hostip' => 0, 'qx_user' => 0, 'qx_announce' => 0, 'qx_stnotify' => 0);
		$qx_only = Zhimin::param('qx_only', 'post');
		$qx_video = Zhimin::param('qx_video', 'post');
		$qx_sup = Zhimin::param('qx_sup', 'post');
		$qx_case = Zhimin::param('qx_case', 'post');
		$qx_acc = Zhimin::param('qx_acc', 'post');
		$qx_report = Zhimin::param('qx_report', 'post');
		$qx_dev = Zhimin::param('qx_dev', 'post');
		$qx_host = Zhimin::param('qx_host', 'post');
		$qx_sys = Zhimin::param('qx_sys', 'post');
		$qx_video_list = Zhimin::param('qx_video_list', 'post');
		$qx_supervise = Zhimin::param('qx_supervise', 'post');
		$qx_workforce = Zhimin::param('qx_workforce', 'post');
		$qx_casetopic = Zhimin::param('qx_casetopic', 'post');
		$qx_accessfrom = Zhimin::param('qx_accessfrom', 'post');
		$qx_accessto = Zhimin::param('qx_accessto', 'post');
		$qx_check = Zhimin::param('qx_check', 'post');
		$qx_assets = Zhimin::param('qx_assets', 'post');
		$qx_chart = Zhimin::param('qx_chart', 'post');
		$qx_chartcom = Zhimin::param('qx_chartcom', 'post');
		$qx_device = Zhimin::param('qx_device', 'post');
		$qx_device_fault = Zhimin::param('qx_device_fault', 'post');
		$qx_hostip = Zhimin::param('qx_hostip', 'post');
		$qx_user = Zhimin::param('qx_user', 'post');
		$qx_announce = Zhimin::param('qx_announce', 'post');
		$qx_stnotify = Zhimin::param('qx_stnotify', 'post');

		if (!empty($qx_only)) {
			$qx_data['qx_only'] = array_sum($qx_only);
		}

		if (!empty($qx_video)) {
			$qx_data['qx_video'] = array_sum($qx_video);
		}

		if (!empty($qx_sup)) {
			$qx_data['qx_sup'] = array_sum($qx_sup);
		}

		if (!empty($qx_case)) {
			$qx_data['qx_case'] = array_sum($qx_case);
		}

		if (!empty($qx_acc)) {
			$qx_data['qx_acc'] = array_sum($qx_acc);
		}

		if (!empty($qx_report)) {
			$qx_data['qx_report'] = array_sum($qx_report);
		}

		if (!empty($qx_dev)) {
			$qx_data['qx_dev'] = array_sum($qx_dev);
		}

		if (!empty($qx_host)) {
			$qx_data['qx_host'] = array_sum($qx_host);
		}

		if (!empty($qx_sys)) {
			$qx_data['qx_sys'] = array_sum($qx_sys);
		}

		if (!empty($qx_video_list)) {
			$qx_data['qx_video_list'] = array_sum($qx_video_list);
		}

		if (!empty($qx_supervise)) {
			$qx_data['qx_supervise'] = array_sum($qx_supervise);
		}

		if (!empty($qx_workforce)) {
			$qx_data['qx_workforce'] = array_sum($qx_workforce);
		}

		if (!empty($qx_casetopic)) {
			$qx_data['qx_casetopic'] = array_sum($qx_casetopic);
		}

		if (!empty($qx_accessfrom)) {
			$qx_data['qx_accessfrom'] = array_sum($qx_accessfrom);
		}

		if (!empty($qx_accessto)) {
			$qx_data['qx_accessto'] = array_sum($qx_accessto);
		}

		if (!empty($qx_check)) {
			$qx_data['qx_check'] = array_sum($qx_check);
		}

		if (!empty($qx_assets)) {
			$qx_data['qx_assets'] = array_sum($qx_assets);
		}

		if (!empty($qx_chart)) {
			$qx_data['qx_chart'] = array_sum($qx_chart);
		}

		if (!empty($qx_chartcom)) {
			$qx_data['qx_chartcom'] = array_sum($qx_chartcom);
		}

		if (!empty($qx_device)) {
			$qx_data['qx_device'] = array_sum($qx_device);
		}

		if (!empty($qx_device_fault)) {
			$qx_data['qx_device_fault'] = array_sum($qx_device_fault);
		}

		if (!empty($qx_hostip)) {
			$qx_data['qx_hostip'] = array_sum($qx_hostip);
		}

		if (!empty($qx_user)) {
			$qx_data['qx_user'] = array_sum($qx_user);
		}

		if (!empty($qx_announce)) {
			$qx_data['qx_announce'] = array_sum($qx_announce);
		}

		if (!empty($qx_stnotify)) {
			$qx_data['qx_stnotify'] = array_sum($qx_stnotify);
		}

		$edit_flg = $group_m->updateRow('`id`=\'' . $id . '\'', $qx_data);

		if ($edit_flg) {
			$log_type = '102';
			$log_message = '编辑角色权限组成功，角色名称：' . $group['gname'] . '，角色编号：' . $group['bh'];
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '编辑角色权限组成功';
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

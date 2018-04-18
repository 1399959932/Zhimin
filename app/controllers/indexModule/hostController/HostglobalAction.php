<?php

class HostglobalAction extends Action
{
	protected $module_sn = '10071';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '工作站配置-' . Zhimin::$name;
		return $this;
	}

	protected function _main()
	{
		$StorageMode = Zhimin::request('StorageMode');
		$Upload = Zhimin::request('Upload');
		$hostcnf_m = new HostcnfModel();
		$upload_model_array = $hostcnf_m->upload_model_array;
		$this->_data['upload_model_array'] = $upload_model_array;
		$store_model_array = $hostcnf_m->store_model_array;
		$this->_data['store_model_array'] = $store_model_array;
		$action = Zhimin::param('action', 'get');
		$exglobal = Zhimin::request('exglobal');
		$this->_data['exglobal'] = $exglobal;
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'oglobal':
			if (!is_null(Zhimin::request('flag'))) {
				$this->oneGlobal();
				break;
			}
			else {
				$this->oView();
				break;
			}

		case 'aglobal':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->allGlobal();
				break;
			}
			else {
				$this->aView();
				break;
			}

		default:
			break;
		}
	}

	protected function oView()
	{
		$station_m = new StationModel();
		$hostcnf_m = new HostcnfModel();
		$id = Zhimin::param('id', 'get');
		$station = $station_m->get_by_id($id);
		$this->_data['station'] = $station;
		$hostcnfhname = $hostcnf_m->get_cnf_hostip($station['hostname']);
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return;
		}

		$hostcnf_m = new HostcnfModel();
		$hostcnf = $hostcnf_m->get_cnf_basic();
		$HotTel = $hostcnf_m->get_cnf_one('HotTel', $station['hostname']);
		$Title = $hostcnf_m->get_cnf_one('Title', $station['hostname']);
		$ReserveSpace = $hostcnf_m->get_cnf_one('ReserveSpace', $station['hostname']);
		$CopyParalls = $hostcnf_m->get_cnf_one('CopyParalls', $station['hostname']);
		$Overlay = $hostcnf_m->get_cnf_one('Overlay', $station['hostname']);
		$HuntPort = $hostcnf_m->get_cnf_one('HuntPort', $station['hostname']);
		$DevLog = $hostcnf_m->get_cnf_one('DevLog', $station['hostname']);
		$StorageMode = $hostcnf_m->get_cnf_one('StorageMode', $station['hostname']);
		$Upload = $hostcnf_m->get_cnf_one('Upload', $station['hostname']);
		$SyncTime = $hostcnf_m->get_cnf_one('SyncTime', $station['hostname']);
		$SyncSpace = $hostcnf_m->get_cnf_one('SyncSpace', $station['hostname']);
		$MonitorSoft = $hostcnf_m->get_cnf_one('MonitorSoft', $station['hostname']);
		$MonitorHardware = $hostcnf_m->get_cnf_one('MonitorHardware', $station['hostname']);
		$Desktop = $hostcnf_m->get_cnf_one('Desktop', $station['hostname']);
		$Bandwidth = $hostcnf_m->get_cnf_one('Bandwidth', $station['hostname']);
		$Equipmentcontrol = $hostcnf_m->get_cnf_one('Equipmentcontrol', $station['hostname']);
		$Usbswitch = $hostcnf_m->get_cnf_one('Usbswitch', $station['hostname']);
		$keyboard = $hostcnf_m->get_cnf_one('keyboard', $station['hostname']);
		$Netswitch = $hostcnf_m->get_cnf_one('Netswitch', $station['hostname']);
		$Process = $hostcnf_m->get_cnf_one('Process', $station['hostname']);
		$hostcnfs = array('HotTel' => $HotTel['cnf_value'], 'Title' => $Title['cnf_value'], 'ReserveSpace' => $ReserveSpace['cnf_value'], 'CopyParalls' => $CopyParalls['cnf_value'], 'Overlay' => $Overlay['cnf_value'], 'HuntPort' => $HuntPort['cnf_value'], 'DevLog' => $DevLog['cnf_value'], 'StorageMode' => $StorageMode['cnf_value'], 'Upload' => $Upload['cnf_value'], 'SyncTime' => $SyncTime['cnf_value'], 'SyncSpace' => $SyncSpace['cnf_value'], 'MonitorSoft' => $MonitorSoft['cnf_value'], 'MonitorHardware' => $MonitorHardware['cnf_value'], 'Desktop' => $Desktop['cnf_value'], 'Bandwidth' => $Bandwidth['cnf_value'], 'Equipmentcontrol' => $Equipmentcontrol['cnf_value'], 'Usbswitch' => $Usbswitch['cnf_value'], 'keyboard' => $keyboard['cnf_value'], 'Netswitch' => $Netswitch['cnf_value'], 'Process' => $Process['cnf_value']);
		$this->_data['hostcnfs'] = $hostcnfs;
	}

	protected function oneGlobal()
	{
		$log = new LogModel();
		$hostcnf_m = new HostcnfModel();
		$basic = Zhimin::param('basic', 'get');
		$collect = Zhimin::param('collect', 'get');
		$uploadfile = Zhimin::param('uploadfile', 'get');
		$safe = Zhimin::param('safe', 'get');
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		if ($basic) {
			$Title = Zhimin::param('Title', 'post');
			$HotTel = Zhimin::param('HotTel', 'post');
			$hostname = Zhimin::param('hostname', 'post');
			$myhostTitle = $hostcnf_m->get_cnf_one('Title', $hostname);

			if (!$myhostTitle) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Title, 'cnf_name' => 'Title', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostHotTel = $hostcnf_m->get_cnf_one('HotTel', $hostname);

			if (!$myhostHotTel) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $HotTel, 'cnf_name' => 'HotTel', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($Title == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '标题不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($HotTel == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '服务热线不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($hostname == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '不存在此工作站';
				echo json_encode($result_array);
				exit();
			}

			$basic_Title = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Title\'', array('cnf_value' => $Title));
			$basic_HotTel = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'HotTel\'', array('cnf_value' => $HotTel));
			if ($basic_Title && $basic_HotTel) {
				$log_type = '063';
				$log_message = '远程配置基本信息配置成功，工作站名称：' . $hostname . '，标题：' . $Title . '，服务热线:' . $HotTel;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '远程配置基本信息配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '远程配置基本信息配置失败，数据库不存在此工作站记录';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($collect) {
			$ReserveSpace = Zhimin::param('ReserveSpace', 'post');
			$Bandwidth = Zhimin::param('Bandwidth', 'post');
			$CopyParalls = Zhimin::param('CopyParalls', 'post');
			$Overlay = Zhimin::param('Overlay', 'post');
			$DevLog = Zhimin::param('DevLog', 'post');
			$HuntPort = Zhimin::param('HuntPort', 'post');
			$hostname = Zhimin::param('hostname', 'post');

			if ($Overlay == '') {
				$Overlay = 0;
			}

			if ($DevLog == '') {
				$DevLog = 0;
			}

			if ($HuntPort == '') {
				$HuntPort = 0;
			}

			$myhostReserveSpace = $hostcnf_m->get_cnf_one('ReserveSpace', $hostname);

			if (!$myhostReserveSpace) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $ReserveSpace, 'cnf_name' => 'ReserveSpace', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostBandwidth = $hostcnf_m->get_cnf_one('Bandwidth', $hostname);

			if (!$myhostBandwidth) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Bandwidth, 'cnf_name' => 'Bandwidth', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostCopyParalls = $hostcnf_m->get_cnf_one('CopyParalls', $hostname);

			if (!$myhostCopyParalls) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $CopyParalls, 'cnf_name' => 'CopyParalls', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostOverlay = $hostcnf_m->get_cnf_one('Overlay', $hostname);

			if (!$myhostOverlay) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Overlay, 'cnf_name' => 'Overlay', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostDevLog = $hostcnf_m->get_cnf_one('DevLog', $hostname);

			if (!$myhostDevLog) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $DevLog, 'cnf_name' => 'DevLog', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostHuntPort = $hostcnf_m->get_cnf_one('HuntPort', $hostname);

			if (!$myhostHuntPort) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $HuntPort, 'cnf_name' => 'HuntPort', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($ReserveSpace == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '预警容量不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($Bandwidth == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '网络带宽不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($CopyParalls == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '并发数不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($hostname == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '不存在此工作站';
				echo json_encode($result_array);
				exit();
			}

			$collect_ReserveSpace = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'ReserveSpace\'', array('cnf_value' => $ReserveSpace));
			$collect_Bandwidth = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Bandwidth\'', array('cnf_value' => $Bandwidth));
			$collect_CopyParalls = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'CopyParalls\'', array('cnf_value' => $CopyParalls));
			$collect_Overlay = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Overlay\'', array('cnf_value' => $Overlay));
			$collect_DevLog = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'DevLog\'', array('cnf_value' => $DevLog));
			$collect_HuntPort = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'HuntPort\'', array('cnf_value' => $HuntPort));
			if ($collect_ReserveSpace && $collect_Bandwidth && $collect_CopyParalls) {
				$log_type = '063';
				$log_message = '远程配置采集相关配置成功，工作站名称：' . $hostname . '，预警容量：' . $ReserveSpace . '，网络带宽:' . $Bandwidth . '，并发数:' . $CopyParalls;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '远程配置采集相关配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '远程配置采集相关配置失败，数据库不存在此工作站记录';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($uploadfile) {
			$StorageMode = Zhimin::param('StorageMode', 'post');
			$Upload = Zhimin::param('Upload', 'post');
			$SyncTime = Zhimin::param('SyncTime', 'post');
			$SyncSpace = Zhimin::param('SyncSpace', 'post');
			$Desktop = Zhimin::param('Desktop', 'post');
			$MonitorSoft = Zhimin::param('MonitorSoft', 'post');
			$MonitorHardware = Zhimin::param('MonitorHardware', 'post');
			$hostname = Zhimin::param('hostname', 'post');

			if ($SyncTime == '') {
				$SyncTime = 0;
			}

			if ($SyncSpace == '') {
				$SyncSpace = 0;
			}

			if ($Desktop == '') {
				$Desktop = 0;
			}

			if ($MonitorSoft == '') {
				$MonitorSoft = 0;
			}

			if ($MonitorHardware == '') {
				$MonitorHardware = 0;
			}

			$myhostStorageMode = $hostcnf_m->get_cnf_one('StorageMode', $hostname);

			if (!$myhostStorageMode) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $StorageMode, 'cnf_name' => 'StorageMode', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostUpload = $hostcnf_m->get_cnf_one('Upload', $hostname);

			if (!$myhostUpload) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Upload, 'cnf_name' => 'Upload', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostSyncTime = $hostcnf_m->get_cnf_one('SyncTime', $hostname);

			if (!$myhostSyncTime) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $SyncTime, 'cnf_name' => 'SyncTime', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostSyncSpace = $hostcnf_m->get_cnf_one('SyncSpace', $hostname);

			if (!$myhostSyncSpace) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $SyncSpace, 'cnf_name' => 'SyncSpace', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostDesktop = $hostcnf_m->get_cnf_one('Desktop', $hostname);

			if (!$myhostDesktop) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Desktop, 'cnf_name' => 'Desktop', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostMonitorSoft = $hostcnf_m->get_cnf_one('MonitorSoft', $hostname);

			if (!$myhostMonitorSoft) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $MonitorSoft, 'cnf_name' => 'MonitorSoft', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostMonitorHardware = $hostcnf_m->get_cnf_one('MonitorHardware', $hostname);

			if (!$myhostMonitorHardware) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $MonitorHardware, 'cnf_name' => 'MonitorHardware', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($StorageMode == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '请选择存储模式';
				echo json_encode($result_array);
				exit();
			}

			if ($Upload == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '请选择上传方式';
				echo json_encode($result_array);
				exit();
			}

			if ($hostname == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '不存在此工作站';
				echo json_encode($result_array);
				exit();
			}

			$uploadfile_StorageMode = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'StorageMode\'', array('cnf_value' => $StorageMode));
			$uploadfile_Upload = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Upload\'', array('cnf_value' => $Upload));
			$uploadfile_SyncTime = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'SyncTime\'', array('cnf_value' => $SyncTime));
			$uploadfile_SyncSpace = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'SyncSpace\'', array('cnf_value' => $SyncSpace));
			$uploadfile_Desktop = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Desktop\'', array('cnf_value' => $Desktop));
			$uploadfile_MonitorSoft = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'MonitorSoft\'', array('cnf_value' => $MonitorSoft));
			$uploadfile_MonitorHardware = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'MonitorHardware\'', array('cnf_value' => $MonitorHardware));
			if ($uploadfile_StorageMode && $uploadfile_Upload) {
				$log_type = '063';
				$log_message = '远程配置上传相关配置成功，工作站名称：' . $hostname . '，存储模式：' . $StorageMode . '，上传方式:' . $Upload;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '远程配置上传相关配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '远程配置上传相关配置失败，数据库不存在此工作站记录';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($safe) {
			$Equipmentcontrol = Zhimin::param('Equipmentcontrol', 'post');
			$Usbswitch = Zhimin::param('Usbswitch', 'post');
			$keyboard = Zhimin::param('keyboard', 'post');
			$Netswitch = Zhimin::param('Netswitch', 'post');
			$Process = Zhimin::param('Process', 'post');
			$hostname = Zhimin::param('hostname', 'post');

			if ($Equipmentcontrol == '') {
				$Equipmentcontrol = 0;
			}

			if ($Usbswitch == '') {
				$Usbswitch = 0;
			}

			if ($keyboard == '') {
				$keyboard = 0;
			}

			$myhostEquipmentcontrol = $hostcnf_m->get_cnf_one('Equipmentcontrol', $hostname);

			if (!$myhostEquipmentcontrol) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Equipmentcontrol, 'cnf_name' => 'Equipmentcontrol', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostNetswitch = $hostcnf_m->get_cnf_one('Netswitch', $hostname);

			if (!$myhostNetswitch) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Netswitch, 'cnf_name' => 'Netswitch', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostProcess = $hostcnf_m->get_cnf_one('Process', $hostname);

			if (!$myhostProcess) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Process, 'cnf_name' => 'Process', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($Equipmentcontrol == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '设备控制策略不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($Netswitch == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '网络控制策略不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($Process == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '进程管控策略（白名单）不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($hostname == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '不存在此工作站';
				echo json_encode($result_array);
				exit();
			}

			$safe_Equipmentcontrol = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Equipmentcontrol\'', array('cnf_value' => $Equipmentcontrol));
			$safe_Usbswitch = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Usbswitch\'', array('cnf_value' => $Usbswitch));
			$safe_keyboard = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'keyboard\'', array('cnf_value' => $keyboard));
			$safe_Netswitch = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Netswitch\'', array('cnf_value' => $Netswitch));
			$safe_Process = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Process\'', array('cnf_value' => $Process));
			if ($safe_Equipmentcontrol && $safe_Netswitch && $safe_Process) {
				$log_type = '063';
				$log_message = '远程配置安全配置成功，工作站名称：' . $hostname . '，标题：' . $Title . '，服务热线:' . $HotTel;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '远程配置安全配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '远程配置安全配置失败，数据库不存在此工作站记录';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
	}

	protected function aView()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return;
		}

		$hostcnf_m = new HostcnfModel();
		$hostcnf = $hostcnf_m->get_cnf_basic();
		$HotTel = $hostcnf_m->get_cnf_one('HotTel');
		$Title = $hostcnf_m->get_cnf_one('Title');
		$ReserveSpace = $hostcnf_m->get_cnf_one('ReserveSpace');
		$CopyParalls = $hostcnf_m->get_cnf_one('CopyParalls');
		$Overlay = $hostcnf_m->get_cnf_one('Overlay');
		$HuntPort = $hostcnf_m->get_cnf_one('HuntPort');
		$DevLog = $hostcnf_m->get_cnf_one('DevLog');
		$StorageMode = $hostcnf_m->get_cnf_one('StorageMode');
		$Upload = $hostcnf_m->get_cnf_one('Upload');
		$SyncTime = $hostcnf_m->get_cnf_one('SyncTime');
		$SyncSpace = $hostcnf_m->get_cnf_one('SyncSpace');
		$MonitorSoft = $hostcnf_m->get_cnf_one('MonitorSoft');
		$MonitorHardware = $hostcnf_m->get_cnf_one('MonitorHardware');
		$Desktop = $hostcnf_m->get_cnf_one('Desktop');
		$Bandwidth = $hostcnf_m->get_cnf_one('Bandwidth');
		$Equipmentcontrol = $hostcnf_m->get_cnf_one('Equipmentcontrol');
		$Usbswitch = $hostcnf_m->get_cnf_one('Usbswitch');
		$keyboard = $hostcnf_m->get_cnf_one('keyboard');
		$Netswitch = $hostcnf_m->get_cnf_one('Netswitch');
		$Process = $hostcnf_m->get_cnf_one('Process');
		$hostcnfs = array('HotTel' => $HotTel['cnf_value'], 'Title' => $Title['cnf_value'], 'ReserveSpace' => $ReserveSpace['cnf_value'], 'CopyParalls' => $CopyParalls['cnf_value'], 'Overlay' => $Overlay['cnf_value'], 'HuntPort' => $HuntPort['cnf_value'], 'DevLog' => $DevLog['cnf_value'], 'StorageMode' => $StorageMode['cnf_value'], 'Upload' => $Upload['cnf_value'], 'SyncTime' => $SyncTime['cnf_value'], 'SyncSpace' => $SyncSpace['cnf_value'], 'MonitorSoft' => $MonitorSoft['cnf_value'], 'MonitorHardware' => $MonitorHardware['cnf_value'], 'Desktop' => $Desktop['cnf_value'], 'Bandwidth' => $Bandwidth['cnf_value'], 'Equipmentcontrol' => $Equipmentcontrol['cnf_value'], 'Usbswitch' => $Usbswitch['cnf_value'], 'keyboard' => $keyboard['cnf_value'], 'Netswitch' => $Netswitch['cnf_value'], 'Process' => $Process['cnf_value']);
		$this->_data['hostcnfs'] = $hostcnfs;
	}

	protected function allGlobal()
	{
		$log = new LogModel();
		$hostcnf_m = new HostcnfModel();
		$basic = Zhimin::param('basic', 'get');
		$collect = Zhimin::param('collect', 'get');
		$uploadfile = Zhimin::param('uploadfile', 'get');
		$safe = Zhimin::param('safe', 'get');
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		if ($basic) {
			$Title = Zhimin::param('Title', 'post');
			$HotTel = Zhimin::param('HotTel', 'post');
			$hostname = '';
			$myhostTitle = $hostcnf_m->get_cnf_one('Title', $hostname);

			if (!$myhostTitle) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Title, 'cnf_name' => 'Title', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostHotTel = $hostcnf_m->get_cnf_one('HotTel', $hostname);

			if (!$myhostHotTel) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $HotTel, 'cnf_name' => 'HotTel', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($Title == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '标题不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($HotTel == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '服务热线不能为空';
				echo json_encode($result_array);
				exit();
			}

			$basic_Title = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Title\'', array('cnf_value' => $Title));
			$basic_HotTel = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'HotTel\'', array('cnf_value' => $HotTel));
			if ($basic_Title && $basic_HotTel) {
				$log_type = '064';
				$log_message = '全局配置基本信息配置成功，标题：' . $Title . '，服务热线:' . $HotTel;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '全局配置基本信息配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '全局配置基本信息配置失败，请稍后重试';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($collect) {
			$ReserveSpace = Zhimin::param('ReserveSpace', 'post');
			$Bandwidth = Zhimin::param('Bandwidth', 'post');
			$CopyParalls = Zhimin::param('CopyParalls', 'post');
			$Overlay = Zhimin::param('Overlay', 'post');
			$DevLog = Zhimin::param('DevLog', 'post');
			$HuntPort = Zhimin::param('HuntPort', 'post');
			$hostname = '';

			if ($Overlay == '') {
				$Overlay = 0;
			}

			if ($DevLog == '') {
				$DevLog = 0;
			}

			if ($HuntPort == '') {
				$HuntPort = 0;
			}

			$myhostReserveSpace = $hostcnf_m->get_cnf_one('ReserveSpace', $hostname);

			if (!$myhostReserveSpace) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $ReserveSpace, 'cnf_name' => 'ReserveSpace', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostBandwidth = $hostcnf_m->get_cnf_one('Bandwidth', $hostname);

			if (!$myhostBandwidth) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Bandwidth, 'cnf_name' => 'Bandwidth', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostCopyParalls = $hostcnf_m->get_cnf_one('CopyParalls', $hostname);

			if (!$myhostCopyParalls) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $CopyParalls, 'cnf_name' => 'CopyParalls', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostOverlay = $hostcnf_m->get_cnf_one('Overlay', $hostname);

			if (!$myhostOverlay) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Overlay, 'cnf_name' => 'Overlay', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostDevLog = $hostcnf_m->get_cnf_one('DevLog', $hostname);

			if (!$myhostDevLog) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $DevLog, 'cnf_name' => 'DevLog', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostHuntPort = $hostcnf_m->get_cnf_one('HuntPort', $hostname);

			if (!$myhostHuntPort) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $HuntPort, 'cnf_name' => 'HuntPort', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($ReserveSpace == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '预警容量不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($Bandwidth == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '网络带宽不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($CopyParalls == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '并发数不能为空';
				echo json_encode($result_array);
				exit();
			}

			$collect_ReserveSpace = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'ReserveSpace\'', array('cnf_value' => $ReserveSpace));
			$collect_Bandwidth = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Bandwidth\'', array('cnf_value' => $Bandwidth));
			$collect_CopyParalls = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'CopyParalls\'', array('cnf_value' => $CopyParalls));
			$collect_Overlay = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Overlay\'', array('cnf_value' => $Overlay));
			$collect_DevLog = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'DevLog\'', array('cnf_value' => $DevLog));
			$collect_HuntPort = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'HuntPort\'', array('cnf_value' => $HuntPort));
			if ($collect_ReserveSpace && $collect_Bandwidth && $collect_CopyParalls) {
				$log_type = '064';
				$log_message = '全局配置采集相关配置成功，预警容量：' . $ReserveSpace . '，网络带宽:' . $Bandwidth . '，并发数:' . $CopyParalls;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '全局配置采集相关配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '全局配置采集相关配置失败，请稍后重试';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($uploadfile) {
			$StorageMode = Zhimin::param('StorageMode', 'post');
			$Upload = Zhimin::param('Upload', 'post');
			$SyncTime = Zhimin::param('SyncTime', 'post');
			$SyncSpace = Zhimin::param('SyncSpace', 'post');
			$Desktop = Zhimin::param('Desktop', 'post');
			$MonitorSoft = Zhimin::param('MonitorSoft', 'post');
			$MonitorHardware = Zhimin::param('MonitorHardware', 'post');
			$hostname = '';

			if ($SyncTime == '') {
				$SyncTime = 0;
			}

			if ($SyncSpace == '') {
				$SyncSpace = 0;
			}

			if ($Desktop == '') {
				$Desktop = 0;
			}

			if ($MonitorSoft == '') {
				$MonitorSoft = 0;
			}

			if ($MonitorHardware == '') {
				$MonitorHardware = 0;
			}

			$myhostStorageMode = $hostcnf_m->get_cnf_one('StorageMode', $hostname);

			if (!$myhostStorageMode) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $StorageMode, 'cnf_name' => 'StorageMode', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostUpload = $hostcnf_m->get_cnf_one('Upload', $hostname);

			if (!$myhostUpload) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Upload, 'cnf_name' => 'Upload', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostSyncTime = $hostcnf_m->get_cnf_one('SyncTime', $hostname);

			if (!$myhostSyncTime) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $SyncTime, 'cnf_name' => 'SyncTime', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostSyncSpace = $hostcnf_m->get_cnf_one('SyncSpace', $hostname);

			if (!$myhostSyncSpace) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $SyncSpace, 'cnf_name' => 'SyncSpace', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostDesktop = $hostcnf_m->get_cnf_one('Desktop', $hostname);

			if (!$myhostDesktop) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Desktop, 'cnf_name' => 'Desktop', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostMonitorSoft = $hostcnf_m->get_cnf_one('MonitorSoft', $hostname);

			if (!$myhostMonitorSoft) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $MonitorSoft, 'cnf_name' => 'MonitorSoft', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostMonitorHardware = $hostcnf_m->get_cnf_one('MonitorHardware', $hostname);

			if (!$myhostMonitorHardware) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $MonitorHardware, 'cnf_name' => 'MonitorHardware', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			if ($StorageMode == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '请选择存储模式';
				echo json_encode($result_array);
				exit();
			}

			if ($Upload == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '请选择上传方式';
				echo json_encode($result_array);
				exit();
			}

			$uploadfile_StorageMode = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'StorageMode\'', array('cnf_value' => $StorageMode));
			$uploadfile_Upload = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Upload\'', array('cnf_value' => $Upload));
			$uploadfile_SyncTime = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'SyncTime\'', array('cnf_value' => $SyncTime));
			$uploadfile_SyncSpace = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'SyncSpace\'', array('cnf_value' => $SyncSpace));
			$uploadfile_Desktop = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Desktop\'', array('cnf_value' => $Desktop));
			$uploadfile_MonitorSoft = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'MonitorSoft\'', array('cnf_value' => $MonitorSoft));
			$uploadfile_MonitorHardware = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'MonitorHardware\'', array('cnf_value' => $MonitorHardware));
			if ($uploadfile_StorageMode && $uploadfile_Upload) {
				$log_type = '064';
				$log_message = '全局配置上传相关配置成功，存储模式：' . $StorageMode . '，上传方式:' . $Upload;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '全局配置上传相关配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '全局配置上传相关配置失败，请稍后重试';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
		else if ($safe) {
			$Equipmentcontrol = Zhimin::param('Equipmentcontrol', 'post');
			$Usbswitch = Zhimin::param('Usbswitch', 'post');
			$keyboard = Zhimin::param('keyboard', 'post');
			$Netswitch = Zhimin::param('Netswitch', 'post');
			$Process = Zhimin::param('Process', 'post');
			$hostname = '';

			if ($Equipmentcontrol == '') {
				$Equipmentcontrol = 0;
			}

			if ($Usbswitch == '') {
				$Usbswitch = 0;
			}

			if ($keyboard == '') {
				$keyboard = 0;
			}

			$myhostEquipmentcontrol = $hostcnf_m->get_cnf_one('Equipmentcontrol', $hostname);

			if (!$myhostEquipmentcontrol) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Equipmentcontrol, 'cnf_name' => 'Equipmentcontrol', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostNetswitch = $hostcnf_m->get_cnf_one('Netswitch', $hostname);

			if (!$myhostNetswitch) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Netswitch, 'cnf_name' => 'Netswitch', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$myhostProcess = $hostcnf_m->get_cnf_one('Process', $hostname);

			if (!$myhostProcess) {
				$insert_flg = $hostcnf_m->insertRow(array('cnf_value' => $Process, 'cnf_name' => 'Process', 'hostname' => $hostname, 'creater' => $_SESSION['username'], 'createtime' => time()));
			}

			$safe_Equipmentcontrol = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Equipmentcontrol\'', array('cnf_value' => $Equipmentcontrol));
			$safe_Usbswitch = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Usbswitch\'', array('cnf_value' => $Usbswitch));
			$safe_keyboard = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'keyboard\'', array('cnf_value' => $keyboard));
			$safe_Netswitch = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Netswitch\'', array('cnf_value' => $Netswitch));
			$safe_Process = $hostcnf_m->updateRow('hostname=\'' . $hostname . '\' AND cnf_name=\'Process\'', array('cnf_value' => $Process));
			if ($safe_Equipmentcontrol && $safe_Netswitch && $safe_Process) {
				$log_type = '064';
				$log_message = '全局配置安全配置成功，标题：' . $Title . '，服务热线:' . $HotTel;
				$log->writeLog($log_type, $log_message);
				$result_array['state'] = 'success';
				$result_array['msg'] = '全局配置安全配置成功';
				echo json_encode($result_array);
				exit();
			}
			else {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '全局配置安全配置失败，请稍后重试';
				echo json_encode($result_array);
				exit();
			}

			exit();
		}
	}
}


?>

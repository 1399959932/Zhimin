<?php

class HostcnfModel extends BaseModel
{
	protected $_tbname = 'zm_hostcnf';
	protected $_p_k = 'id';
	public $upload_model_array = array('不上传源文件，转换FLV', '上传源文件，不转换FLV', '不上传源文件，上传FLV', '不上传源文件，不转换FLV', '上传源文件，转换FLV', '上传源文件，上传FLV');
	public $store_model_array = array('混合模式', '其他模式');
	protected $cnf_array = array('HotTel' => '热线', 'Title' => '标题', 'ReserveSpace' => '预警容量', 'CopyParalls' => '采集并发数', 'Overlay' => '是否自动覆盖', 'HuntPort' => '是否兼容', 'DevLog' => '是否采集日志', 'StorageMode' => '存储模式', 'Upload' => '上传模式', 'SyncTime' => '是否同步时间', 'SyncSpace' => '是否同步容量', 'MonitorSoft' => '是否监控应用程序', 'MonitorHardware' => '是否监控硬件信息', 'Desktop' => '远程桌面', 'Bandwidth' => '网络带宽', 'Equipmentcontrol' => '设备控制策略', 'Usbswitch' => 'USB存储设备', 'keyboard' => 'USB键盘', 'Netswitch' => '网络控制策略', 'Process' => '进程白名单');

	public function get_cnf_basic()
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostname`=\'\'';
		$user_record = $this->dquery($statement);
		return $user_record;
	}

	public function get_cnf_hostip($hostname)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostname`=\'' . $hostname . '\'';
		$user_record = $this->dquery($statement);
		return $user_record;
	}

	public function get_cnf_one($val, $hostname)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostname`=\'' . $hostname . '\' AND `cnf_name`=\'' . $val . '\'';
		$user_record = $this->fetchOne('', $statement);
		return $user_record;
	}
}


?>

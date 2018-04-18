<?php

class DevicelogModel extends BaseModel
{
	protected $_tbname = 'zm_device_log';
	protected $_p_k = 'id';
	public $log_type = array(1 => '关机', 2 => '开机', 3 => '拍照', 4 => '摄影', 5 => '录音', 6 => '无动作', 7 => '录影结束', 8 => '低电报警');

	public function readType($a)
	{
		return $this->log_type[$a];
	}
}


?>

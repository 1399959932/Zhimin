<?php

class StationlogModel extends BaseModel
{
	protected $_tbname = 'zm_station_log';
	protected $_p_k = 'id';
	public $log_type = array(1 => '开机', 2 => '关机', 3 => '记录仪接入', 4 => '记录仪拔出', 5 => '文件采集');

	public function readType($a)
	{
		return $this->log_type[$a];
	}
}


?>

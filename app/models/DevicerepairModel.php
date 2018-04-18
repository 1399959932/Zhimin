<?php

class DevicerepairModel extends BaseModel
{
	protected $_tbname = 'zm_device_repair';
	protected $_p_k = 'id';

	public function data_by_id($id)
	{
		return $this->read($id);
	}
}


?>

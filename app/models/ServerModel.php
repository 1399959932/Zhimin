<?php

class ServerModel extends BaseModel
{
	protected $_tbname = 'zm_serverinfo';
	protected $_p_k = 'id';

	public function data_by_id($id)
	{
		return $this->read($id);
	}
}


?>

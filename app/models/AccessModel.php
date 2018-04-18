<?php

class AccessModel extends BaseModel
{
	protected $_tbname = 'zm_access';
	protected $_p_k = 'id';
	public $_state = array('等待审批', '审批通过', '拒绝申请');

	public function data_by_id($id)
	{
		return $this->read($id);
	}
}


?>

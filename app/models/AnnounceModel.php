<?php

class AnnounceModel extends BaseModel
{
	protected $_tbname = 'zm_announce';
	protected $_p_k = 'id';

	public function get_user_announce($unit_no)
	{
		$sql = 'select * from `' . $this->_tbname . '` WHERE `enddate`>\'' . time() . '\' and (`receive_unit`=\'' . $unit_no . '\' or `receive_unit`=\'\' or `receive_unit` is NULL) order by `vieworder` asc,`createtime` desc';
		$res = $this->fetchAll('', $sql);
		return $res;
	}

	public function data_by_id($id)
	{
		return $this->read($id);
	}

	public function get_by_id($id, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `id`=\'' . $id . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}
}


?>

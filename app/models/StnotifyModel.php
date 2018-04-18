<?php

class StnotifyModel extends BaseModel
{
	protected $_tbname = 'zm_stnotify';
	protected $_p_k = 'id';

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

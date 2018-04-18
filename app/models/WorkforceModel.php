<?php

class WorkforceModel extends BaseModel
{
	protected $_tbname = 'zm_workforce';
	protected $_p_k = 'id';
	public $classid = array(1 => '休班/假', 2 => '上班', 3 => '会议', 4 => '公出');

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

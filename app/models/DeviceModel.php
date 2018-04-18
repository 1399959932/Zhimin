<?php

class DeviceModel extends BaseModel
{
	protected $_tbname = 'zm_device';
	protected $_p_k = 'id';
	public $_state = array('正常', '报障', '报废');

	public function data_by_id($id)
	{
		return $this->read($id);
	}

	public function data_insert($data)
	{
		return $this->insertRow($data);
	}

	public function data_update($condition, $data)
	{
		return $this->updateRow($condition, $data);
	}

	public function data_del($condition)
	{
		return $this->deleteRow($condition);
	}

	public function data_by_hostbody($hostbody, $fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '` WHERE `hostbody`=\'' . $hostbody . '\'';
		return $this->fetchOne('', $statement, $fetchStyle);
	}

	public function data_by_hostcode($hostbody, $fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '` WHERE `hostcode`=\'' . $hostbody . '\'';
		return $this->fetchOne('', $statement, $fetchStyle);
	}

	public function data_state_update($state, $id)
	{
		$condition = '`id`=\'' . $id . '\'';
		$data = array('state' => $state, 'moder' => $_SESSION['user']['username'], 'modtime' => time());
		return $this->updateRow($condition, $data);
	}

	public function data_count($condition, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT COUNT(*) AS count FROM `' . $this->_tbname . '` WHERE ' . $condition;
		return $this->fetchOne('', $statement, $fetchStyle);
	}
}


?>

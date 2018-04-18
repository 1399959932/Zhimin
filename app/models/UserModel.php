<?php

class UserModel extends BaseModel
{
	protected $_tbname = 'zm_user';
	protected $_p_k = 'id';

	public function get_by_name($username, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT *,FROM_UNIXTIME(logintime) as lasttime FROM `' . $this->_tbname . '` WHERE `username`=\'' . $username . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_realname($realname, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `realname`=\'' . $realname . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_sn($sn, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `userid`=\'' . $sn . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_id($id, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `id`=\'' . $id . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_hostcode($hostcode, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostcode`=\'' . $hostcode . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_group_users($dbh)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `dbh`=\'' . $dbh . '\' and `ispass`=\'1\'';
		$user_record = $this->dquery($statement);
		return $user_record;
	}

	public function get_manager_unit($id)
	{
		$unit_array = array();
		$user = $this->get_by_id($id);

		if (empty($user['manager_unit'])) {
			array_push($unit_array, $user['dbh']);
		}
		else {
			$unit_array = explode(',', $user['manager_unit']);
		}

		return $unit_array;
	}

	public function get_next_sn()
	{
		$min_sn = '10000';
		$user = $this->fetchOne('', 'select userid as min_sn from `' . $this->table() . '` order by userid desc limit 1;');
		if (empty($user) || ($user['min_sn'] < $min_sn)) {
			return $min_sn;
		}

		return $user['min_sn'] + 1;
	}
}


?>

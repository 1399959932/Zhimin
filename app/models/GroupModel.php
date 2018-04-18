<?php

class GroupModel extends BaseModel
{
	protected $_tbname = 'zm_group';
	protected $_p_k = 'id';

	public function get_by_sn($sn, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `bh`=\'' . $sn . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_name($name, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `gname`=\'' . $name . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_all_group()
	{
		$sql = 'SELECT * FROM `' . $this->_tbname . '` order by `sort` asc';
		$ret = $this->fetchAll('', $sql);
		$this->free_result('');
		return $ret;
	}

	public function get_first_group()
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` order by `sort` asc limit 1';
		$ret = $this->fetchOne('', $statement);
		$this->free_result('');
		return $ret;
	}

	public function get_next_sn()
	{
		$min_sn = '100';
		$group = $this->fetchOne('', 'select max(bh) as min_sn from `' . $this->table() . '`');
		if (empty($group) || ($group['min_sn'] < $min_sn)) {
			return $min_sn;
		}

		return $group['min_sn'] + 1;
	}
}


?>

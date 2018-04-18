<?php

class PollcodeModel extends BaseModel
{
	protected $_tbname = 'zm_poll_code';
	protected $_p_k = 'id';
	public $config_type = array(1 => '第三方工作站注册码');

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

	public function get_by_no($no, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `code`=\'' . $no . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_type($type, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `type`=\'' . $type . '\';';
		$ret = $this->fetchAll('', $statement);
		$this->free_result('');
		return $ret;
	}

	public function get_next_sn()
	{
		$min_sn = '100';
		$group = $this->fetchOne('', 'select max(confcode) as min_sn from `' . $this->table() . '`');
		if (empty($group) || ($group['min_sn'] < $min_sn)) {
			return $min_sn;
		}

		return $group['min_sn'] + 1;
	}

	public function get_classdatas($typeid)
	{
		$group = $this->fetchAll('', 'select confcode, CONCAT(confname,\'(\',confvalue,\')\') as name from `' . $this->table() . '` where type=' . $typeid);
		return $group;
	}
}


?>

<?php

class SysconfModel extends BaseModel
{
	protected $_tbname = 'zm_system_config';
	protected $_p_k = 'id';
	//public $config_type = array(1 => '文件类型', 2 => '案件类型', 3 => '标注类型', 4 => '故障类型');
	//modify
	public $config_type = array(1 => '文件类型', 2 => '案件类型', 3 => '标注类型', 4 => '故障类型', 5 => '号码类型', 6 => '警情来源', 7 => '采集设备来源');
	//	

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
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `confcode`=\'' . $no . '\';';
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

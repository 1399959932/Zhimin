<?php

class BaseModel
{
	protected $_stmt = array();
	protected $_db;
	protected $_config;
	protected $_tbname = '';
	protected $_p_k = 'id';
	protected $_rowCount = 0;

	public function __construct()
	{
		$main_cfg = Zhimin::config('main');
		$this->_config = $main_cfg['db'];
		$this->_db = new Model($this->_config);
		$this->charset();
	}

	public function table()
	{
		return $this->_tbname;
	}

	public function fetchOne($name, $statement, $fetchStyle = Model::FETCH_ASSOC)
	{
		$this->query($name, $statement);
		$ret = $this->fetch($name, $fetchStyle);
		$this->free_result($name);
		// echo '<pre>';print_r($ret);exit;
		return $ret;
	}

	public function fetchAll($name, $statement, $fetchStyle = Model::FETCH_ASSOC)
	{
		$this->query($name, $statement);
		$ret = array();

		while ($row = $this->fetch($name, $fetchStyle)) {
			$ret[] = $row;
		}

		$this->free_result($name);
		$this->_rowCount = count($ret);
		return $ret;
	}

	public function query($name, $statement)
	{
		return $this->_db->query($statement);
	}

	public function fetch($name = '', $fetchStyle = Model::FETCH_ASSOC)
	{
		$ret = $this->_db->fetch($fetchStyle);
		return $ret;
	}

	public function free_result($name = '')
	{
		$this->_db->delResult();
	}

	public function charset($charset = '')
	{
		if (!empty($this->_config['charset']) && empty($charset)) {
			$charset = $this->_config['charset'];
		}

		$charset = ($charset == '' ? 'GB2312' : $charset);
		$this->query('', 'SET NAMES \'' . $charset . '\';');
		$this->free_result('');
	}

	public function read($v, $fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '` WHERE `' . $this->_p_k . '`=\'' . $v . '\'';
		return $this->fetchOne('', $statement, $fetchStyle);
	}

	public function readAll($fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '`;';
		return $this->fetchAll('', $statement, $fetchStyle);
	}

	public function updateRow($condition, $fields)
	{
		if (empty($condition) || empty($fields)) {
			return false;
		}

		$fields_arr = array();

		foreach ($fields as $key => $val ) {
			if ($val === NULL) {
				$fields_arr[] = '`' . $key . '`=NULL';
			}
			else {
				$fields_arr[] = '`' . $key . '`=\'' . $val . '\'';
			}
		}

		$fields_str = join(',', $fields_arr);
		unset($fields_arr);
		$statement = 'UPDATE `' . $this->_tbname . '` SET ' . $fields_str . ' WHERE ' . $condition;
		$flg = $this->query('', $statement);
		$this->free_result('');
		return $flg;
	}

	public function insertRow($fields)
	{
		if (empty($fields)) {
			return false;
		}

		$fields_arr = array();

		foreach ($fields as $key => $val ) {
			if (NULL === $val) {
				$fields_arr[] = '`' . $key . '`=NULL';
			}
			else {
				$fields_arr[] = '`' . $key . '`=\'' . $val . '\'';
			}
		}

		$fields_str = join(',', $fields_arr);
		unset($fields_arr);
		$statement = 'INSERT INTO `' . $this->_tbname . '` SET ' . $fields_str;
		$this->query('', $statement);
		$this->free_result('');
		return $this->_db->lastInsertId('');
	}

	public function deleteRow($condition)
	{
		if (empty($condition)) {
			return false;
		}

		$statement = 'DELETE FROM `' . $this->_tbname . '` WHERE ' . $condition;
		$flg = $this->query('', $statement);
		$this->free_result('');
		return $flg;
	}

	public function dquery($statement, $fetchStyle = Model::FETCH_ASSOC)
	{
		$ret = array();
		$hstr = strtolower(substr($statement, 0, 6));
		$this->query('', $statement);
		if (($hstr == 'select') || (substr($hstr, 0, 4) == 'show')) {
			while ($row = $this->fetch('', $fetchStyle)) {
				$ret[] = $row;
			}

			$this->_rowCount = count($ret);
		}

		$this->free_result('');
		return $ret;
	}

	public function rowCount()
	{
		return $this->_rowCount;
	}

	public function error_no()
	{
		return $this->_db->errorCode();
	}

	public function error_text()
	{
		return $this->_db->errorInfo();
	}

	public function lastInsertId($name = '')
	{
		return $this->_db->lastInsertId($name);
	}
}


?>

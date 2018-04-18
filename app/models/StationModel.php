<?php

class StationModel extends BaseModel
{
	protected $_tbname = 'zm_hostip';
	protected $_p_k = 'id';

	public function get_by_id($id, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `id`=\'' . $id . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_name($username, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostname`=\'' . $username . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_ip($ip, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `hostip`=\'' . $ip . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function GetAllStationServerUrl()
	{
		$arr_temp = array();
		$sql = 'SELECT hostname, hostip from zm_hostip;';
		$rows = $this->dquery($sql);

		if (is_array($rows)) {
			foreach ($rows as $row ) {
				$arr_temp[$row['hostname']] = 'http://' . $row['hostip'] . '/';
			}
		}

		$sql = 'SELECT servername, path from zm_serverinfo;';
		$rows = $this->dquery($sql);

		if (is_array($rows)) {
			foreach ($rows as $row ) {
				$arr_temp[$row['servername']] = $row['path'];
			}
		}

		return $arr_temp;
	}
}


?>

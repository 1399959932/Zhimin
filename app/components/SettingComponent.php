<?php

class SettingComponent
{
	protected $_data = array();
	protected $_model;

	public function __construct($params)
	{
		$this->_model = new ConfigModel();
		$this->init();
	}

	private function init()
	{
		$this->_data = array();
		$configs = $this->_model->readAll();

		if (!empty($configs)) {
			foreach ($configs as $config ) {
				$this->_data[$config['db_config']] = $config['db_value'];
			}
		}

		$this->_data['db_size'] = $this->_dbSize();
		$this->_data['systemtime'] = gmdate('Y-m-d H:i:s', time());
		$this->_data['altertime'] = gmdate('Y-m-d H:i', time() + (Zhimin::g('db_timedf') * 3600));
		$this->_data['sysversion'] = PHP_VERSION;
		$this->_data['dbversion'] = mysql_get_server_info();
		$this->_data['sysos'] = $_SERVER['SERVER_SOFTWARE'];
		$this->_data['max_upload'] = (ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'Disabled');
		$this->_data['max_ex_time'] = ini_get('max_execution_time') . ' seconds';
		$this->_data['sys_mail'] = (ini_get('sendmail_path') ? 'Unix Sendmail ( Path: ' . ini_get('sendmail_path') . ')' : (ini_get('SMTP') ? 'SMTP ( Server: ' . ini_get('SMTP') . ')' : 'Disabled'));
		return $this->_data;
	}

	private function _dbSize()
	{
		$tbs = $this->_model->dquery('SHOW TABLE STATUS');
		$dbsize = 0;

		foreach ($tbs as $tb ) {
			$dbsize += $tb['Data_length'] + $tb['Index_length'];
		}

		return number_format($dbsize / (1024 * 1024), 2);
	}

	public function get($key)
	{
		if (is_string($key) && isset($this->_data[$key])) {
			return $this->_data[$key];
		}

		return '';
	}

	public function getAll()
	{
		return $this->_data;
	}
}


?>

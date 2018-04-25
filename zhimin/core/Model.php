<?php

class Model
{
	const PARAM_BOOL = 5;
	const PARAM_NULL = 0;
	const PARAM_INT = 1;
	const PARAM_STR = 2;
	const PARAM_LOB = 3;
	const PARAM_STMT = 4;
	const PARAM_INPUT_OUTPUT = -2147483648;
	const PARAM_EVT_ALLOC = 0;
	const PARAM_EVT_FREE = 1;
	const PARAM_EVT_EXEC_PRE = 2;
	const PARAM_EVT_EXEC_POST = 3;
	const PARAM_EVT_FETCH_PRE = 4;
	const PARAM_EVT_FETCH_POST = 5;
	const PARAM_EVT_NORMALIZE = 6;
	const FETCH_LAZY = 1;
	const FETCH_ASSOC = 2;
	const FETCH_NUM = 3;
	const FETCH_BOTH = 4;
	const FETCH_OBJ = 5;
	const FETCH_BOUND = 6;
	const FETCH_COLUMN = 7;
	const FETCH_CLASS = 8;
	const FETCH_INTO = 9;
	const FETCH_FUNC = 10;
	const FETCH_GROUP = 65536;
	const FETCH_UNIQUE = 196608;
	const FETCH_KEY_PAIR = 12;
	const FETCH_CLASSTYPE = 262144;
	const FETCH_SERIALIZE = 524288;
	const FETCH_PROPS_LATE = 1048576;
	const FETCH_NAMED = 11;
	const ATTR_AUTOCOMMIT = 0;
	const ATTR_PREFETCH = 1;
	const ATTR_TIMEOUT = 2;
	const ATTR_ERRMODE = 3;
	const ATTR_SERVER_VERSION = 4;
	const ATTR_CLIENT_VERSION = 5;
	const ATTR_SERVER_INFO = 6;
	const ATTR_CONNECTION_STATUS = 7;
	const ATTR_CASE = 8;
	const ATTR_CURSOR_NAME = 9;
	const ATTR_CURSOR = 10;
	const ATTR_ORACLE_NULLS = 11;
	const ATTR_PERSISTENT = 12;
	const ATTR_STATEMENT_CLASS = 13;
	const ATTR_FETCH_TABLE_NAMES = 14;
	const ATTR_FETCH_CATALOG_NAMES = 15;
	const ATTR_DRIVER_NAME = 16;
	const ATTR_STRINGIFY_FETCHES = 17;
	const ATTR_MAX_COLUMN_LEN = 18;
	const ATTR_EMULATE_PREPARES = 20;
	const ATTR_DEFAULT_FETCH_MODE = 19;
	const ERRMODE_SILENT = 0;
	const ERRMODE_WARNING = 1;
	const ERRMODE_EXCEPTION = 2;
	const CASE_NATURAL = 0;
	const CASE_LOWER = 2;
	const CASE_UPPER = 1;
	const NULL_NATURAL = 0;
	const NULL_EMPTY_STRING = 1;
	const NULL_TO_STRING = 2;
	const ERR_NONE = 0;
	const FETCH_ORI_NEXT = 0;
	const FETCH_ORI_PRIOR = 1;
	const FETCH_ORI_FIRST = 2;
	const FETCH_ORI_LAST = 3;
	const FETCH_ORI_ABS = 4;
	const FETCH_ORI_REL = 5;
	const CURSOR_FWDONLY = 0;
	const CURSOR_SCROLL = 1;
	const MYSQL_ATTR_USE_BUFFERED_QUERY = 1000;
	const MYSQL_ATTR_LOCAL_INFILE = 1001;
	const MYSQL_ATTR_INIT_COMMAND = 1002;
	const MYSQL_ATTR_COMPRESS = 1003;
	const MYSQL_ATTR_DIRECT_QUERY = 1004;
	const MYSQL_ATTR_FOUND_ROWS = 1005;
	const MYSQL_ATTR_IGNORE_SPACE = 1006;
	const MYSQL_ATTR_SSL_KEY = 1007;
	const MYSQL_ATTR_SSL_CERT = 1008;
	const MYSQL_ATTR_SSL_CA = 1009;
	const MYSQL_ATTR_SSL_CAPATH = 1010;
	const MYSQL_ATTR_SSL_CIPHER = 1011;
	const ODBC_ATTR_USE_CURSOR_LIBRARY = 1000;
	const ODBC_ATTR_ASSUME_UTF8 = 1001;
	const ODBC_SQL_USE_IF_NEEDED = 0;
	const ODBC_SQL_USE_DRIVER = 2;
	const ODBC_SQL_USE_ODBC = 1;
	const PGSQL_ATTR_DISABLE_NATIVE_PREPARED_STATEMENT = 1000;
	const PGSQL_TRANSACTION_IDLE = 0;
	const PGSQL_TRANSACTION_ACTIVE = 1;
	const PGSQL_TRANSACTION_INTRANS = 2;
	const PGSQL_TRANSACTION_INERROR = 3;
	const PGSQL_TRANSACTION_UNKNOWN = 4;

	/**
     * @var null
     */
	protected $_db;
	/**
     * @var array
     */
	protected $_baseConfig = array('persistent' => false, 'host' => 'localhost', 'login' => 'root', 'password' => '', 'dbname' => 'zmdbm', 'port' => '3306');
	/**
     * @param array
     */
	protected $_Config = array();
	protected $_result;
	protected $_records;
	protected $_affected;
	protected $lastQuery = '';
	protected $lastCode = '';
	protected $lastError = '';

	public function __construct($params)
	{
		$this->_Config = $this->_baseConfig;
		$this->_Config['host'] = $params['host'];
		$this->_Config['login'] = $params['login'];
		$this->_Config['password'] = $params['password'];
		$this->_Config['dbname'] = $params['dbname'];
		$this->_Config['port'] = (empty($params['port']) ? $this->_baseConfig['port'] : $params['port']);
		$this->_Config['persistent'] = (empty($params['persistent']) ? $this->_baseConfig['persistent'] : $params['persistent']);
		$this->Connect();
	}

	private function Connect()
	{
		$persistant = $this->_Config['persistent'];

		if ($persistant) {
			$this->_db = @mysql_pconnect($this->_Config['host'], $this->_Config['login'], $this->_Config['password']);
		}
		else {
			$this->_db = @mysql_connect($this->_Config['host'], $this->_Config['login'], $this->_Config['password']);
		}

		if (!$this->_db) {
			$this->lastCode = @mysql_errno($this->_db);
			$this->lastError = 'Could not connect to server: ' . @mysql_error($this->_db);
			return false;
		}

		if (!$this->SelectDB()) {
			$this->lastCode = @mysql_errno($this->_db);
			$this->lastError = 'Could not connect to database: ' . @mysql_error($this->_db);
			return false;
		}

		return true;
	}

	private function SelectDB()
	{
		if (!@mysql_select_db($this->_Config['dbname'], $this->_db)) {
			$this->lastCode = @mysql_errno($this->_db);
			$this->lastError = 'Cannot select database: ' . @mysql_error($this->_db);
			return false;
		}
		else {
			return true;
		}
	}

	public function CloseConnection()
	{
		if ($this->_db) {
			@mysql_close($this->_db);
		}
	}

	public function errorCode()
	{
		return $this->lastCode;
	}

	public function errorInfo()
	{
		return $this->lastError;
	}

	public function lastInsertId($name = NULL)
	{
		return mysql_insert_id($this->_db);
	}

	private function SecureData($data)
	{
		if (is_array($data)) {
			foreach ($data as $key => $val ) {
				if (!is_array($data[$key])) {
					$data[$key] = @mysql_real_escape_string($data[$key], $this->_db);
				}
			}
		}
		else {
			$data = @mysql_real_escape_string($data, $this->_db);
		}

		return $data;
	}

	public function ExecuteSQL($query, $fetchStyle = self::FETCH_ASSOC)
	{
		$this->lastQuery = $query;

		if ($this->_result = @mysql_query($query, $this->_db)) {
			if (!is_resource($this->_result)) {
				return true;
			}

			$this->_records = @mysql_num_rows($this->_result);
			$this->_affected = @mysql_affected_rows($this->_db);

			if (0 < $this->_records) {
				return $this->fetchAll($fetchStyle);
			}
			else {
				return true;
			}
		}
		else {
			$this->lastCode = @mysql_errno($this->_db);
			$this->lastError = mysql_error($this->_db);
			return false;
		}
	}

	public function query($query)
	{
		$this->lastQuery = $query;

		if ($this->_result = @mysql_query($query, $this->_db)) {
			if (!is_resource($this->_result)) {
				return true;
			}

			$this->_records = @mysql_num_rows($this->_result);
			$this->_affected = @mysql_affected_rows($this->_db);
			return true;
		}
		else {
			return false;
		}
	}

	public function fetch($fetchStyle = self::FETCH_ASSOC)
	{
		$data = @mysql_fetch_assoc($this->_result);

		if ($data === false) {
			$this->lastCode = @mysql_errno($this->_db);
			$this->lastError = @mysql_error($this->_db);
		}

		return $data;
	}

	public function fetchAll($fetchStyle = self::FETCH_ASSOC)
	{
		if ($this->_records == 1) {
			return $this->fetch($fetchStyle);
		}

		$datas = array();

		while ($data = @mysql_fetch_assoc($this->_result)) {
			$datas[] = $data;
		}

		return $datas;
	}

	public function delResult()
	{
		if ($this->_result) {
		}

		$this->_result = NULL;
	}
}


?>

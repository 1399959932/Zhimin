<?php

class Log
{
	protected $_logDir = '';

	public function __construct($params)
	{
		$this->_logDir = Zhimin::path($params['dir']) . '/';
	}

	public function error($e)
	{
		return $this->record(implode("\t", array_slice($e, 0, -1)), 'error', 'common');
	}

	public function record($msg, $type = 'normal', $category = 'common.info')
	{
		$file = $this->_logDir . str_replace('.', '/', $category) . '/' . $type . '/' . date('Y/m/d') . '.log';
		$dir = dirname($file);
		if (!file_exists($dir) && !@mkdir(dirname($file), 511, true)) {
			return false;
		}

		return file_put_contents($file, $msg . PHP_EOL . PHP_EOL, LOCK_EX | FILE_APPEND);
	}
}


?>

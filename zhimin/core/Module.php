<?php

class Module
{
	protected $_global = array();

	public function __construct()
	{
		foreach ($this->_global as $k => $v ) {
			Zhimin::g($k, $v);
		}
	}

	protected function _before()
	{
	}

	protected function _after()
	{
	}

	public function execute()
	{
		$this->_before();
		Zhimin::c($this)->execute();
		$this->_after();
	}
}


?>

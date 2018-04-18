<?php

class Controller
{
	protected $_m;
	protected $_global = array();

	public function __construct()
	{
		if (func_num_args() == 1) {
			$this->_m = func_get_arg(0);
		}

		foreach ($this->_global as $k => $v ) {
			Zhimin::g($k, $v);
		}
	}

	public function execute()
	{
		$this->_before();

		if ($this->_m) {
			Zhimin::a($this->_m, $this)->init()->execute();
		}
		else {
			Zhimin::a($this->_m)->init()->execute();
		}

		$this->_after();
	}

	protected function _before()
	{
	}

	protected function _after()
	{
	}
}


?>

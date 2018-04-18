<?php

class LeftAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
	}
}


?>

<?php

class IndexAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->title = '首页-' . Zhimin::$name;
		$this->layout('');
		return $this;
	}

	public function _main()
	{
	}
}


?>

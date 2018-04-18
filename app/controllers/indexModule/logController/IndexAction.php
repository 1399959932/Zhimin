<?php

class IndexAction extends Action
{
	public function init()
	{
		return $this;
	}

	public function _main()
	{
		Zhimin::forward('log');
	}
}


?>

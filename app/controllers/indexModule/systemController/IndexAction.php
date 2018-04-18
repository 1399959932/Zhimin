<?php

class IndexAction extends Action
{
	public function init()
	{
		return $this;
	}

	public function _main()
	{
		$bh = Zhimin::param('bh', 'get');
		$child_mud = mudule_first($bh);

		if (!$child_mud) {
			Zhimin::forward('main', 'index');
		}
		else {
			Zhimin::forward($child_mud);
		}
	}
}


?>

<?php

class EditAction extends Action
{
	public function init()
	{
		return $this;
	}

	public function _main()
	{
		Zhimin::forward('media', 'media');
	}
}


?>

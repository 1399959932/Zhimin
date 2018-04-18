<?php

class CaptchaAction extends Action
{
	public function __construct()
	{
		$this->_hasView = 0;
	}

	protected function _main()
	{
		$captcha = Zhimin::getComponent('captcha');
		$captcha->setLength(4);
		$_SESSION['vcode'] = $captcha->paint();
	}
}


?>

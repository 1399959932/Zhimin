<?php

class LanguageComponent
{
	protected $_data = array(
		'首页'       => array('cn' => '首页', 'en' => 'home'),
		'产品列表' => array('cn' => '产品列表', 'en' => 'goods'),
		'联系我们' => array('cn' => '联系我们', 'en' => 'concat'),
		'关于我们' => array('cn' => '关于我们', 'en' => 'about')
		);
	protected $_type = 'en';

	public function __construct($params)
	{
		$this->_type = $params['type'];
	}

	public function l($key)
	{
		return $this->_data[$key][$this->_type];
	}
}


?>

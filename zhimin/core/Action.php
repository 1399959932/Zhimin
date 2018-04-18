<?php

class Action
{
	/**
     * @var Module|null
     */
	protected $_m;
	/**
     * @var Controller|null
     */
	protected $_c;
	/**
     * 传给view的数据
     * @var array
     */
	protected $_data = array();
	/**
     * 是否使用视图
     * @var bool
     */
	protected $_hasView = true;
	/**
     * 是否发生错误
     * @var bool
     */
	protected $_hasError = false;
	/**
     * 视图layout
     * @var string
     */
	protected $_layout = 'main';
	/**
     * 传给layout的数据
     * @var array
     */
	protected $_section = array();
	/**
     * 页面title
     * @var string
     */
	public $title = '';
	/**
     * 页面关键字
     * @var string
     */
	public $keyword = '';
	/**
     * 页面描述
     * @var string
     */
	public $descript = '';
	/**
     * action状态（是否已经输出视图)
     * @var string
     */
	public $state = '';
	/**
     * @var array
     *     array (
     *          '错误类型',array('msg'=>'各种错误参数，回显的时候用的着',....)
     *     );
     */
	protected $_error = array();
	/**
     * 全局信息，初始的时候覆盖增加到全局信息去
     * @var array
     */
	protected $_global = array();
	/**
     * 外部参数校验
     * @var array
     * @see Zhimin::validate
     */
	//证实
	protected $_validate = array();

	public function __construct()
	{
		$funcArgsNum = func_num_args();

		if ($funcArgsNum == 2) {
			$this->_m = func_get_arg(0);
			$this->_c = func_get_arg(1);
		}
		else if ($funcArgsNum == 1) {
			$this->_c = func_get_arg(0);
		}
	}

	public function init()
	{
		return $this;
	}

	public function execute()
	{
		foreach ($this->_global as $k => $v ) {
			Zhimin::g($k, $v);
		}

		Zhimin::validate($this->_validate);
		$this->_before();
		$this->_main();

		if ($this->_hasError) {
			$this->_showError();
		}
		else if ($this->_hasView) {
			$this->_display();
		}

		if (PHP_SAPI == 'cgi_fast') {
			fastcgi_finish_request();
		}
		else if (ob_get_status()) {
			ob_end_flush();
			flush();
		}

		$this->state = 'finished';
		$this->_after();
	}

	protected function _showError()
	{
		Zhimin::show('app.view.' . $this->_error[0], $this->_error[1]);
	}

	protected function _display($file = NULL)
	{
		if ($file) {
			$file = 'app.view.' . $file;
		}
		else {
			$file = 'app.view.' . implode('.', array_filter(Zhimin::getRouteInfo()));
		}

		if (!$this->_layout) {
			Zhimin::show($file, $this->_data);
		}
		else {
			$this->_section['main'] = Zhimin::show($file, $this->_data, true);
			Zhimin::show('app.view.layout.' . $this->_layout, $this->_section);
		}
	}

	protected function _main()
	{
	}

	protected function _before()
	{
	}

	protected function _after()
	{
	}

	public function exception($e)
	{
		if (method_exists($this->_c, 'exception')) {
			$this->_c->exception($e);
		}
		else if (method_exists($this->_m, 'exception')) {
			$this->_m->exception($e);
		}

		if ($this->state != 'finished') {
			Zhimin::show('zhimin.view.error', $e);
		}
	}

	public function layout($layout)
	{
		$this->_layout = $layout;
	}

	public function setData($key, $val)
	{
		if (is_string($key)) {
			$this->_data[$key] = $val;
		}
	}

	public function getData($key)
	{
		if (is_string($key) && isset($this->_data[$key])) {
			return $this->_data[$key];
		}


	}

	public function setSection($key, $val)
	{
		if (is_string($key)) {
			$this->_section[$key] = $val;
		}
	}
}


?>

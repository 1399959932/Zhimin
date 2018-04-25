<?php
ignore_user_abort(1);
set_time_limit(0);

if (!function_exists('error_get_last')) {
	function error_get_last()
	{
		global $__error_get_last_retval__;

		if (!isset($__error_get_last_retval__)) {
			return;
		}

		return $__error_get_last_retval__;
	}
}
//异常处理
class AppNotHasComponentError extends Exception
{}

class AppComponentInitError extends Exception
{}

class HookNotExistsError extends Exception
{}

class LoadInitError extends Exception
{}

class LoadClassNotExistsError extends Exception
{}

class GlobalKeyNotExistsError extends Exception
{}

class GPCError extends Exception
{}



class Zhimin
{
	//const 定义常量, 不能被修改
	const HOOK_BREAK = 1;
	const HOOK_OK = 2;
	const HOOK_FAIL = 4;
	const PARAM_MODE_NORMAL = 0;
	const PARAM_MODE_PATH = 1;
	const PARAM_MODE_HTML = 2;
	const PARAM_MODE_SQL = 4;
	const PARAM_MODE_INT = 8;
	const PARAM_MODE_IMPORT = 16;
	const PARAM_MODE_TRIM = 1048576;
	const PARAM_MODE_FUNC = 2097152;

	/**
     * log实例
     * @var Log
     */
	static 	public $log;
	/**
     * 异常报告实例
     * @var Report
     */
	static 	public $report;
	/**
     * 系统名称
     * @var
     */
	static 	public $name;
	/**
     * 是否有访问权限
     * @var bool
     */
	static 	public $_hasPermission = true;
	/**
     * 存放Zhimin目录 ，app目录
     * @var array
     */
	static 	protected $_path = array();
	/**
     * 钩子
     * @var array
     * @see Zhimin::bindHook
     * @see Zhimin::hook
     */
	static 	protected $_hooks = array(
		'error'             => array(),
		'shutdown'          => array(),
		'route'             => array(),
		'config'            => array(),
		'load'              => array(),
		'permission'        => array(),
		'withoutPermission' => array()
		);
	/**
     * 记录m,c,a对应的名称
     * @var array
     * @see Zhimin::route
     */
	//这是不是写串行了
	static 	protected $_routeInfo = array();
	/**
     * 存储get
     * @var array
     */
	static 	protected $_gpcGet = array();
	/**
     * 存储post
     * @var array
     */
	static 	protected $_gpcPost = array();
	/**
     * 存储cookie
     * @var array
     */
	static 	protected $_gpcCookie = array();
	/**
     * 存储gpc经过validate的键名
     * @var array
     * @see Zhimin::validate
     * @see Zhimin::param
     */
	static 	protected $_whiteList = array(
		'cookie' => array(),
		'post'   => array(),
		'get'    => array()
		);
	/**
     * 组件类，推荐使用 Zhimin::getComponent
     * @var
     */
	static 	public $component;
	/**
     * @var array 组件的配置
     */
	static 	protected $_componentConf = array();
	/**
     * load已经实例化过的类集合
     * @var array
     */
	static 	protected $_instance = array();
	/**
     * @var string $loading 目前加载中的类名、参数，可以在hook中改变
     */
	static 	public $_loading = array('class' => '', 'params' => '', 'className' => '');
	/**
     * @var array 存储配置
     */
	static 	protected $_conf = array();
	/**
     * @var string 加载中的config的路径，可在hook中改变
     */
	static 	public $_loadingConf = '';
	static 	protected $_g = array();

	static public function run($appDir)
	{
		self::$_gpcCookie = $_COOKIE;
		self::$_gpcGet = $_GET;
		self::$_gpcPost = $_POST;
		unset($_COOKIE);
		unset($_GET);
		unset($_POST);
		unset($_REQUEST);
		self::$_path['zhimin'] = realpath(dirname(dirname(__FILE__)));
		self::$_path['app'] = $appDir;
		$config = self::config('main');
		self::$name = $config['app_name'];
		self::$_g = $config['global'];

		if (file_exists(self::$_path['app'] . '/core/Common.php')) {
			require_once (self::$_path['app'] . '/core/Common.php');
		}

		if (file_exists(self::$_path['zhimin'] . '/core/Common.php')) {
			require_once (self::$_path['zhimin'] . '/core/Common.php');
		}

		set_include_path(self::$_path['app'] . '/core' . PATH_SEPARATOR . self::$_path['zhimin'] . '/core' . PATH_SEPARATOR . self::$_path['app'] . '/model' . PATH_SEPARATOR . self::$_path['app'] . '/extensions' . PATH_SEPARATOR . self::$_path['zhimin'] . '/extensions' . PATH_SEPARATOR . self::$_path['app'] . '/hook' . PATH_SEPARATOR . self::$_path['zhimin'] . '/hook' . PATH_SEPARATOR . self::$_path['app'] . '/controllers' . PATH_SEPARATOR . self::$_path['app'] . '/models' . PATH_SEPARATOR . self::$_path['app'] . '/components' . PATH_SEPARATOR . get_include_path());
		spl_autoload_register(array('Zhimin', '_autoLoad'));
		set_error_handler(array('Zhimin', 'errorHandler'));
		register_shutdown_function(array('Zhimin', 'shutdownHandler'));
		isset($config['log']['class']) || ($config['log']['class'] = 'Log');
		self::$log = self::load($config['log']['class'], array($config['log']['params']));
		self::bindHook('error', array(self::$log, 'error'));
		self::bindHookByConfig($config['hooks']);
		self::_route();
		self::$component = new stdClass();
		self::$_componentConf = $config['components'];
		self::_execute();
	}

	//检查许可
	static protected function _checkPermission()
	{
		Zhimin::hook('permission');

		if (!Zhimin::$_hasPermission) {
			Zhimin::hook('withoutPermission');
		}
	}

	//处决, 执行
	static public function _execute()
	{
		self::_addMVCSuffix();
		self::_checkPermission();

		if (!Zhimin::$_hasPermission) {
			return;
		}

		if (self::$_routeInfo['m']) {
			self::m()->execute();
		}
		else if (self::$_routeInfo['c']) {
			self::c()->execute();
		}
		else {
			self::a()->init()->execute();
		}
	}

	static public function to($a, $c = NULL, $m = NULL)
	{
		self::$_routeInfo = array('m' => $m, 'c' => $c, 'a' => $a);
		self::_execute();
	}

	static public function _autoLoad($name)
	{
		$file = $name . '.php';
		return @(include $file);
	}

	static public function path($path)
	{
		if (!is_array($path)) {
			$pathInfo = explode('.', $path);
		}
		else {
			$pathInfo = $path;
		}

		if (count($pathInfo) == 1) {
			return $pathInfo[0];
		}
		else if (($pathInfo[0] == 'app') || ($pathInfo[0] == 'zhimin')) {
			$pathInfo[0] = self::$_path[$pathInfo[0]];
		}
		else {
			array_unshift($pathInfo, self::$_path['app']);
		}

		return implode(DIRECTORY_SEPARATOR, $pathInfo);
	}

	//错误处理者
	static public function errorHandler($errNo, $errStr, $errFile, $errLine, $errBacktrace)
	{
		global $__error_get_last_retval__;
		$e['type'] = $errNo;
		$e['message'] = $errStr;
		$e['file'] = $errFile;
		$e['line'] = $errLine;
		$__error_get_last_retval__ = $e;
		$e['backtrace'] = $errBacktrace;
	}
	//关机
	static public function shutdownHandler()
	{
		self::hook('shutdown', array());
		$e = error_get_last();

		if (!is_null($e)) {
			self::hook('error', array($e));

			if (self::$_routeInfo) {
				try {
					$a = self::a();

					try {
						$a->exception($e);
					}
					catch (Exception $_e) {
						if ($a->state != 'finished') {
							throw $_e;
						}
					}
				}
				catch (Exception $_e) {
					self::show('zhimin.view.error', $e);
				}
			}
			else {
				self::show('zhimin.view.error', $e);
			}
		}
	}

	static public function show($_file, $_params, $_return = false)
	{
		if (isset($_params['_file']) || isset($_params['_return']) || isset($_params['_params'])) {
			exit('传给模版的数据数组不能含有_file,_params或_return键名');
		}

		foreach ($_params as $key => $value ) {
			//删了一个$
			$$key = $value;
		}

		if ($_return) {
			ob_get_clean();
			ob_start();
		}

		$viewFile = self::path($_file) . '.php';
		//echo("<hr />template：".$viewFile);  //显示每个模块所调用的模板文件路径
		require ($viewFile);

		if ($_return) {
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}

		
	}

	static public function bindHook($hookName, $callBack)
	{
		self::$_hooks[$hookName][] = $callBack;
	}

	static public function bindHookByConfig($confHooks)
	{
		foreach ($confHooks as $hookName => $callBacks ) {
			foreach ($callBacks as $callBack ) {
				if (is_array($callBack) && $callBack) {
					$callBack[0] = ucfirst($callBack[0]) . 'Hook';
				}
				else if (is_null($callBack)) {
					self::$_hooks[$hookName] = array();
				}

				self::bindHook($hookName, $callBack);
			}
		}
	}

	static public function hook($name, $params = array())
	{
		if (!isset(self::$_hooks[$name])) {
			throw new HookNotExistsError('hook:' . $name . '不存在');
		}

		foreach (self::$_hooks[$name] as $listener ) {
			try {
				$rs = call_user_func_array($listener, $params);

				if ($rs == Zhimin::HOOK_BREAK) {
					break;
				}
			}
			catch (Exception $e) {
				$paramsStr = json_encode($params);

				if (is_array($listener)) {
					$listenerStr = json_encode($listener);
				}
				else {
					$listenerStr = $listener;
				}

				syslog(LOG_ALERT, 'hook(' . $name . ',' . $paramsStr . ')::' . $listenerStr . '::' . $e->getMessage());
			}
		}
	}

	static public function m()
	{
		static $_;

		if (is_null($_)) {
			$mName = ucfirst(self::$_routeInfo['m']);
			$mClass = 'app.controllers.' . self::$_routeInfo['m'] . '.' . $mName;
			$_ = self::load($mClass);
		}

		return $_;
	}

	static public function c()
	{
		static $_;

		if (is_null($_)) {
			$cName = ucfirst(self::$_routeInfo['c']);

			if (self::$_routeInfo['m']) {
				$mName = self::$_routeInfo['m'];
				$cClass = 'app.controllers.' . $mName . '.' . self::$_routeInfo['c'] . '.' . $cName;
			}
			else {
				$cClass = 'app.controllers.' . self::$_routeInfo['c'] . '.' . $cName;
			}

			$args = func_get_args();
			$_ = self::load($cClass, $args);
		}

		return $_;
	}

	static public function a()
	{
		static $_;

		if (is_null($_)) {
			$aName = ucfirst(self::$_routeInfo['a']);

			if (self::$_routeInfo['m']) {
				$mName = self::$_routeInfo['m'];
				$cName = self::$_routeInfo['c'];
				$aClass = 'app.controllers.' . $mName . '.' . $cName . '.' . $aName;
			}
			else if (self::$_routeInfo['c']) {
				$cName = self::$_routeInfo['c'];
				$aClass = 'app.controllers.' . $cName . '.' . $aName;
			}
			else {
				$aClass = 'app.controllers.' . $aName;
			}

			$args = func_get_args();
			$_ = self::load($aClass, $args);
		}

		return $_;
	}

	static public function getRouteInfo()
	{
		if (0 < func_num_args()) {
			$key = func_get_arg(0);

			if (isset(self::$_routeInfo[$key])) {
				return self::$_routeInfo[$key];
			}
			else {
				return;
			}
		}

		return self::$_routeInfo;
	}

	static protected function _route()
	{
		self::validate(array(
	array('name' => '_m', 'type' => 'get', 'request' => false),
	array('name' => '_c', 'type' => 'get', 'request' => false),
	array('name' => '_a', 'type' => 'get', 'request' => false)
	));

		if (self::param('_a', 'get')) {
			self::$_routeInfo['m'] = strtolower(self::param('_m', 'get', self::PARAM_MODE_IMPORT));
			self::$_routeInfo['c'] = strtolower(self::param('_c', 'get', self::PARAM_MODE_IMPORT));
			self::$_routeInfo['a'] = strtolower(self::param('_a', 'get', self::PARAM_MODE_IMPORT));
		}
		else {
			$config = self::config('main');
			self::$_routeInfo = $config['default_route'];
		}

		self::hook('route');
	}

	static protected function _addMVCSuffix()
	{
		if (!isset(self::$_routeInfo['a'])) {
			throw new GPCError('类型:get,名称:_a的gpc不存在。');
		}
		else {
			self::$_routeInfo['a'] .= 'Action';
		}

		if (isset(self::$_routeInfo['m']) && self::$_routeInfo['m']) {
			self::$_routeInfo['m'] .= 'Module';
		}
		else {
			self::$_routeInfo['m'] = NULL;
		}

		if (isset(self::$_routeInfo['c']) && self::$_routeInfo['c']) {
			self::$_routeInfo['c'] .= 'Controller';
		}
		else {
			self::$_routeInfo['c'] = NULL;
		}
	}

	//证实
	static public function validate($rule)
	{
		$params = array();

		foreach ($rule as $paramRule ) {
			if (!isset($params[$paramRule['type']])) {
				$params[$paramRule['type']] = self::${'_gpc' . ucfirst($paramRule['type'])};
			}

			if (isset($params[$paramRule['type']][$paramRule['name']])) {
				$value = $params[$paramRule['type']][$paramRule['name']];
				if (!isset($paramRule['validator']) || !$paramRule['validator']) {
					self::${'_gpc' . ucfirst($paramRule['type'])}[$paramRule['name']] = $value;
				}
				else if (is_callable($paramRule['validator'])) {
					if (!isset($paramRule['params'])) {
						$vRs = call_user_func($paramRule['validator'], $value);
					}
					else {
						$vRs = call_user_func_array($paramRule['validator'], array(0 => $value, 'params' => $paramRule['params']));
					}

					if (!$vRs) {
						throw new GPCError('类型:' . $paramRule['type'] . ',名称:' . $paramRule['name'] . '不能通过校验函数');
					}
				}
				else if (!preg_match($paramRule['validator'], $value)) {
					throw new GPCError('类型:' . $paramRule['type'] . ',名称:' . $paramRule['name'] . '不能通过校验正则');
				}
			}
			else if ($paramRule['request']) {
				throw new GPCError('类型:' . $paramRule['type'] . ',名称:' . $paramRule['name'] . '的gpc不存在。');
			}
			else {
				self::${'_gpc' . ucfirst($paramRule['type'])}[$paramRule['name']] = NULL;
			}

			self::$_whiteList[$paramRule['type']][] = $paramRule['name'];
		}
	}

	static public function param($name, $type, $mode = 0, $callback = '', $params = array())
	{
		if (!isset(self::$_whiteList[$type])) {
			throw new GPCError('类型:' . $type . ',名称:' . $name . '的gpc未通过校验。');
		}

		$v_ = self::${'_gpc' . ucfirst($type)};

		if (!isset($v_[$name])) {
			return NULL;
		}

		$v = $v_[$name];

		if ($mode & self::PARAM_MODE_TRIM) {
			$v = trim($v);
		}

		if ($mode & self::PARAM_MODE_FUNC) {
			if ($params) {
				$v = call_user_func_array($callback, array(0 => $v, 'params' => $params));
			}
			else {
				$v = call_user_func($callback, $v);
			}
		}

		if ($mode & self::PARAM_MODE_PATH) {
			$v = str_replace(array('/', '\\'), '', $v);
		}
		else if ($mode & self::PARAM_MODE_IMPORT) {
			$v = preg_replace('/\\{2,}/', '.', $v);
		}
		else if ($mode & self::PARAM_MODE_SQL) {
			$v = addslashes($v);
		}
		else if ($mode & self::PARAM_MODE_HTML) {
			$v = htmlentities($v, ENT_QUOTES);
		}
		else if ($mode & self::PARAM_MODE_INT) {
			$v = intval($v);
		}

		return $v;
	}

	static public function request($name, $mode = 0, $callback = '', $params = array())
	{
		$v = self::param($name, 'get', $mode, $callback, $params);

		if (!is_null($v)) {
			return $v;
		}

		$v = self::param($name, 'post', $mode, $callback, $params);

		if (!is_null($v)) {
			return $v;
		}
	}

	static public function paramArr($type, $mode = 0, $callback = '', $params = array())
	{
		if (!isset(self::$_whiteList[$type])) {
			throw new GPCError('类型:' . $type . ',名称:' . $name . '的gpc未通过校验。');
		}

		$vArr = self::${'_gpc' . ucfirst($type)};

		foreach ($vArr as &$v ) {
			if ($mode & self::PARAM_MODE_TRIM) {
				$v = trim($v);
			}

			if ($mode & self::PARAM_MODE_FUNC) {
				if ($params) {
					$v = call_user_func_array($callback, array(0 => $v, 'params' => $params));
				}
				else {
					$v = call_user_func($callback, $v);
				}
			}

			if ($mode & self::PARAM_MODE_PATH) {
				$v = str_replace(array('/', '\\'), '', $v);
			}
			else if ($mode & self::PARAM_MODE_IMPORT) {
				$v = preg_replace('/\\{2,}/', '.', $v);
			}
			else if ($mode & self::PARAM_MODE_SQL) {
				$v = addslashes($v);
			}
			else if ($mode & self::PARAM_MODE_HTML) {
				$v = htmlentities($v, ENT_QUOTES);
			}
			else if ($mode & self::PARAM_MODE_INT) {
				$v = intval($v);
			}
		}

		return $vArr;
	}

	static public function getComponent($name)
	{
		if (property_exists(self::$component, $name)) {
			return self::$component->{$name};
		}
		else if (isset(self::$_componentConf[$name])) {
			if (isset(self::$_componentConf[$name]['params'])) {
				$param = array(self::$_componentConf[$name]['params']);
			}
			else {
				$param = array();
			}

			if (isset(self::$_componentConf[$name]['class'])) {
				$class = self::$_componentConf[$name]['class'];
				self::$component->{$name} = self::load($class, $param, false);
			}
			else {
				try {
					$class = 'app.components.' . ucfirst($name);
					$obj = self::load($class, $param, false);
				}
				catch (LoadClassNotExistsError $e) {
					try {
						$class = 'zhimin.components.' . ucfirst($name);
						$obj = self::load($class, $param, false);
					}
					catch (LoadClassNotExistsError $e) {
						throw new AppNotHasComponentError('组件' . $name . '不存在');
					}
				}

				self::$component->{$name} = $obj;
			}

			unset(self::$_componentConf[$name]);
			return self::$component->{$name};
		}
		else {
			try {
				$class = 'app.components.' . ucfirst($name);
				$obj = self::load($class, NULL, false);
			}
			catch (LoadClassNotExistsError $e) {
				try {
					$class = 'zhimin.components.' . ucfirst($name);
					$obj = self::load($class, NULL, false);
				}
				catch (LoadClassNotExistsError $e) {
					throw new AppNotHasComponentError('组件' . $name . '不存在');
				}
			}

			self::$component->{$name} = $obj;
			return self::$component->{$name};
		}
	}

	static public function load($class, $params = NULL, $single = true)
	{
		if ($single && isset(self::$_instance[$class])) {
			return self::$_instance[$class];
		}

		self::$_loading['class'] = $class;
		self::$_loading['params'] = $params;
		$_tempClassName = strrchr($class, '.');
		self::$_loading['className'] = ($_tempClassName ? substr($_tempClassName, 1) : $class);
		self::hook('load', array());
		$obj = self::_load();

		if ($single) {
			self::$_instance[$class] = $obj;
		}

		self::$_loading = array(
			'class'  => '',
			'params' => array()
			);
		return $obj;
	}

	static protected function _load()
	{
		$class = self::$_loading['className'];
		$file = self::path(self::$_loading['class']) . '.php';

		if (file_exists($file)) {
			require ($file);
		}

		if (!class_exists($class)) {
			throw new LoadClassNotExistsError('指定的类 ' . $class . '不存在。');
		}

		if (self::$_loading['params']) {
			$classReflection = new ReflectionClass($class);
			$obj = $classReflection->newInstanceArgs(self::$_loading['params']);
		}
		else {
			$obj = new $class();
		}

		return $obj;
	}

	static public function config($config)
	{
		if (isset(self::$_conf[$config])) {
			return self::$_conf[$config];
		}

		self::$_loadingConf = $config;
		self::hook('config', array());

		if (strpos(self::$_loadingConf, '.') === false) {
			self::$_loadingConf = 'app.config.' . self::$_loadingConf;
		}

		$file = self::path(self::$_loadingConf) . '.php';
		self::$_conf[$config] = @(include $file);
		self::$_loadingConf = '';
		return self::$_conf[$config];
	}

	static public function g()
	{
		if (func_num_args() == 2) {
			$key = func_get_arg(0);
			$value = func_get_arg(1);
			self::$_g[$key] = $value;
		}
		else {
			$key = func_get_arg(0);

			if (isset(self::$_g[$key])) {
				return self::$_g[$key];
			}
			else {
				throw new GlobalKeyNotExistsError($key . '不存在');
			}
		}

		
	}

	static public function hasGlobal($key)
	{
		return isset(self::$_g[$key]);
	}

	static public function buildUrl($a = NULL, $c = NULL, $m = NULL, $q = '')
	{
		$url = self::g('assets_uri');
		$a = ($a ? $a : substr(self::$_routeInfo['a'], 0, -6));
		$c = ($c ? $c : substr(self::$_routeInfo['c'], 0, -10));
		$m = ($m ? $m : substr(self::$_routeInfo['m'], 0, -6));
		$q = ($q ? '&' . $q : '');
		$url .= '?_a=' . $a . '&_c=' . $c . '&_m=' . $m . $q;
		return $url;
	}

	static public function forward($a = NULL, $c = NULL, $m = NULL, $q = '')
	{
		header('location: ' . self::buildUrl($a, $c, $m, $q));
		exit();
	}

	static public function forward_url($url)
	{
		header('location: ' . $url);
		exit();
	}
}

?>

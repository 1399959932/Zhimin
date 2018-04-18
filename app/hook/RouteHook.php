<?php

class RouteHook
{
	public function __construct()
	{
	}

	static public function error()
	{
		$catchError = false;

		if (0 < func_num_args()) {
			$e = func_get_arg(0);
		}

		$routeInfo = Zhimin::getRouteInfo();

		if ($routeInfo) {
			try {
				$aName = ucfirst($routeInfo['a']) . 'Action';

				if ($routeInfo['m']) {
					$mName = $routeInfo['m'] . 'Module';
					$cName = $routeInfo['c'] . 'Controller';
					$aClass = 'app.controllers.' . $mName . '.' . $cName . '.' . $aName;
				}
				else if ($routeInfo['c']) {
					$cName = $routeInfo['c'] . 'Controller';
					$aClass = 'app.controllers.' . $cName . '.' . $aName;
				}
				else {
					$aClass = 'app.controllers.' . $aName;
				}

				Zhimin::load($aClass);
			}
			catch (Exception $_e) {
				$catchError = true;
				Zhimin::show('app.view.error.404', $e);
			}
		}
		else {
			$catchError = true;
			self::show('app.view.error.404', $e);
		}

		if ($catchError) {
			exit();
		}
	}
}


?>

<?php

class IndexModule extends Module
{
	protected function _before()
	{
		$auth = Zhimin::getComponent('auth');

		if (!in_array(Zhimin::getRouteInfo('a'), array('loginAction', 'logoutAction'))) {
			if (isset($_SERVER['HTTP_REFERER'])) {
				$_SESSION['http_referer'] = $_SERVER['HTTP_REFERER'];
			}

			if ($auth->checkLogin() == 0) {

				Zhimin::forward('login', 'index');
				exit();
			}
		}
		else {
			if ((Zhimin::getRouteInfo('a') == 'loginAction') && $auth->isLogin()) {
			}
			else {
				if ((Zhimin::getRouteInfo('a') == 'logoutAction') && !$auth->isLogin()) {
					Zhimin::forward('login');
				}
			}
		}

		$setting = Zhimin::getComponent('setting');
		Zhimin::a()->setData('settings', $setting->getAll());
		Zhimin::a()->title = $setting->get('site');
	}
}


?>

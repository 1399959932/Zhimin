<?php

class PermissionHook
{
	static 	private $data = array('xxxxx');
	static 	private $permissions = array(
		'indexModule' => array(
			'mediaController' => array(
				'mediaAction' => array(
					'video_edit' => array('module' => '10021', 'method' => 'checkPermitEdit', 'message' => '无编辑视频权限!'),
					'audio_edit' => array('module' => '10031', 'method' => 'checkPermitEdit', 'message' => '无编辑图片权限!'),
					'photo_edit' => array('module' => '10041', 'method' => 'checkPermitEdit', 'message' => '无编辑图片权限!'),
					'video_down' => array('module' => '10021', 'method' => 'checkPermitDown', 'message' => '无下载视频权限!'),
					'audio_down' => array('module' => '10031', 'method' => 'checkPermitDown', 'message' => '无下载图片权限!'),
					'photo_down' => array('module' => '10041', 'method' => 'checkPermitDown', 'message' => '无下载图片权限!')
					),
				'videoAction' => array(
					'' => array('module' => '10021', 'method' => 'checkPermitView', 'message' => '无查看视频权限!')
					),
				'audioAction' => array(
					'' => array('module' => '10031', 'method' => 'checkPermitView', 'message' => '无查看录音权限!')
					),
				'photoAction' => array(
					'' => array('module' => '10041', 'method' => 'checkPermitView', 'message' => '无查看图片权限!')
					)
				)
			),
		'adminModule' => array()
		);

	public function __construct()
	{
	}

	static public function checkPermission()
	{
		$routeInfo = Zhimin::getRouteInfo();
		$action = Zhimin::request('action');
		$data = self::$permissions;

		if (!isset($data[$routeInfo['m']])) {
			return NULL;
		}

		$data = $data[$routeInfo['m']];

		if (!isset($data[$routeInfo['c']])) {
			return NULL;
		}

		$data = $data[$routeInfo['c']];

		if (!isset($data[$routeInfo['a']])) {
			return NULL;
		}

		$data = $data[$routeInfo['a']];

		if (!isset($data[$action])) {
			return NULL;
		}

		$data = $data[$action];

		if (!empty($data)) {
			$auth = Zhimin::getComponent('auth');

			if (!$auth->$data['method']($data['module'])) {
				Zhimin::show('app.view.error.withoutpermission', $data);
				exit();
			}
			else {
				unset($data);
			}
		}
	}

	static public function withoutPermission()
	{
	}
}


?>

<?php

class MediaUtils
{
	static 	private $servers = array();
	static 	private $stations = array();
	static 	private $_current_path = '';
	static 	private $_current_onFtp = false;
	static 	private $_current_onWeb = false;

	static private function pre_proccess($path, $storage = 'FTPServer', $serverName = '')
	{
		self::$_current_path = '';
		self::$_current_onFtp = true;
		self::$_current_onWeb = false;

		if (!isset(self::$servers[$storage])) {
			$server_m = new ServerModel();
			$sql = 'select * from `' . $server_m->table() . '` where servername=\'' . $storage . '\' limit 1';
			$serverinfo = $server_m->fetchOne('', $sql);

			if (!empty($serverinfo)) {
				self::$servers[$storage] = array('name' => $serverinfo['servername'], 'ip' => $serverinfo['serverip'], 'path' => $serverinfo['path']);
				self::$_current_onFtp = true;
			}
			else if (!isset(self::$stations[$storage])) {
				$station_m = new StationModel();
				$sql = 'select * from `' . $station_m->table() . '` where hostname=\'' . $storage . '\' limit 1';
				$stationinfo = $station_m->fetchOne('', $sql);

				if (!empty($stationinfo)) {
					self::$stations[$storage] = array('name' => $stationinfo['hostname'], 'ip' => $stationinfo['hostip'], 'path' => 'http://' . $stationinfo['hostip'] . '/');
					self::$_current_onFtp = false;
				}
				else {
					return false;
				}
			}
		}

		if (self::$_current_onFtp && (self::$servers[$storage]['ip'] == $_SERVER['SERVER_ADDR'])) {
			self::$_current_onWeb = true;
		}

		$path = str_replace('media', '', $path);
		$path = ltrim($path, '/');
		self::$_current_path = $path;
		return true;
	}

	static private function pre_proccess_20150601($path, $storage = 'FTPServer', $serverName = '')
	{
		self::$_current_path = '';

		if ($storage == 'FTPServer') {
			self::$_current_onFtp = true;
		}
		else {
			self::$_current_onFtp = false;
		}

		self::$_current_onWeb = false;
		if (self::$_current_onFtp && !isset(self::$servers[$serverName])) {
			$server_m = new ServerModel();

			if (empty($serverName)) {
				$sql = 'select * from `' . $server_m->table() . '` where flag=1 limit 1';
			}
			else {
				$sql = 'select * from `' . $server_m->table() . '` where servername=\'' . $serverName . '\' limit 1';
			}

			$serverinfo = $server_m->fetchOne('', $sql);

			if (!empty($serverinfo)) {
				self::$servers[$serverName] = array('name' => $serverinfo['servername'], 'ip' => $serverinfo['serverip'], 'path' => $serverinfo['path']);
			}
			else {
				return false;
			}
		}
		else {
			if (!self::$_current_onFtp && !isset(self::$stations[$storage])) {
				$station_m = new StationModel();
				$sql = 'select * from `' . $station_m->table() . '` where hostname=\'' . $storage . '\' limit 1';
				$stationinfo = $station_m->fetchOne('', $sql);

				if (!empty($stationinfo)) {
					self::$stations[$storage] = array('name' => $stationinfo['hostname'], 'ip' => $stationinfo['hostip'], 'path' => 'http://' . $stationinfo['hostip'] . '/');
				}
				else {
					return false;
				}
			}
		}

		if (self::$_current_onFtp && (self::$servers[$serverName]['ip'] == $_SERVER['SERVER_ADDR'])) {
			self::$_current_onWeb = true;
		}

		$path = str_replace('media', '', $path);
		$path = ltrim($path, '/');
		self::$_current_path = $path;
		return true;
	}

	static private function pre_media_path($path, $storage, $serverName)
	{
		if (!self::pre_proccess($path, $storage, $serverName)) {
			return false;
		}

		if (self::$_current_onWeb) {
			self::$_current_path = getrootpath() . 'media/' . self::$_current_path;
		}
		else if (self::$_current_onFtp) {
			self::$_current_path = self::$servers[$storage]['path'] . self::$_current_path;
		}
		else {
			self::$_current_path = self::$stations[$storage]['path'] . self::$_current_path;
		}

		return true;
	}

	static private function pre_media_url($path, $storage, $serverName)
	{
		if (!self::pre_proccess($path, $storage, $serverName)) {
			return false;
		}

		if (self::$_current_onFtp) {
			self::$_current_path = self::$servers[$storage]['path'] . self::$_current_path;
		}
		else {
			self::$_current_path = self::$stations[$storage]['path'] . self::$_current_path;
		}

		return true;
	}

	static public function media_thumb_path($path, $serverName = '')
	{
		if (!self::pre_media_path($path, 'FTPServer', $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_thumb_url($path, $serverName = '')
	{
		if (!self::pre_media_url($path, $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_play_path($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_path($path, $storage, $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_play_url($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_url($path, $storage, $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_path($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_path($path, $storage, $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_url($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_url($path, $storage, $serverName)) {
			return false;
		}

		return self::$_current_path;
	}

	static public function media_thumb_exists($path, $serverName = '')
	{
		if (!self::pre_media_path($path, 'FTPServer', $serverName)) {
			return false;
		}

		return NetUtils::file_exists(self::$_current_path, self::$_current_onWeb);
	}

	static public function media_play_exists($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_path($path, $storage, $serverName)) {
			return false;
		}

		return NetUtils::file_exists(self::$_current_path, self::$_current_onWeb);
	}

	static public function media_exists($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_path($path, $storage, $serverName)) {
			return false;
		}

		return NetUtils::file_exists(self::$_current_path, self::$_current_onWeb);
	}

	static public function down_file($path, $storage = 'FTPServer', $serverName = '')
	{
		if (!self::pre_media_url($path, $storage, $serverName)) {
			return false;
		}

		echo '<script language=\'javascript\'>location.href=\'' . self::$_current_path . '\';</script>';
	}
}


?>

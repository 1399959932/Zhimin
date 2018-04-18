<?php

class NetUtils
{
	static public function get_client_ip()
	{
		if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		}
		else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		}
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}

		$onlineip = preg_replace('/^([d.]+).*/', '1', $onlineip);
		return $onlineip;
	}

	static public function get_client_ip_long()
	{
		return vsprintf('%u', ip2long(self::get_client_ip()));
	}

	static public function send_file($file_name, $byte_rate = 0)
	{
		if (!is_file($file_name)) {
			throw new Exception('文件不存在！', 1001);
		}

		if (!is_readable($file_name)) {
			throw new Exception('文件权限错误！', 1002);
		}

		if (headers_sent()) {
			throw new Exception('Header 已发送！', 1003);
		}

		$fp = fopen($file_name, 'rb');

		if (!$fp) {
			throw new Exception('文件获取失败！', 1004);
		}

		header('Expires: 0');
		header('Pragma: no-cache');
		header('Content-Type: application/x-octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file_name));
		header('Content-Length: ' . filesize($file_name));
		$sleep_time = ($byte_rate <= 0 ? 0 : intval(1000000 / $byte_rate));

		while (!feof($fp)) {
			echo fread($fp, 1024);
			usleep($sleep_time);
		}

		fclose($fp);
		return true;
	}

	static public function file_exists($path, $isLocal = false)
	{
		if (!$isLocal) {
			$curl = curl_init($path);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			$result = curl_exec($curl);
			$found = false;

			if ($result !== false) {
				$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

				if ($statusCode == 200) {
					$found = true;
				}
			}

			curl_close($curl);
		}
		else {
			$found = file_exists($path);
		}

		return $found;
	}
}


?>

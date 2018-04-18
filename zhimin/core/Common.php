<?php
function Cookie($ck_Var, $ck_Value, $ck_Time = 'F')
{
	global $timestamp;
	$ck_Time = ($ck_Time == 'F' ? $timestamp + 31536000 : (($ck_Value == '') && ($ck_Time == 0) ? $timestamp - 31536000 : $ck_Time));
	setcookie($ck_Var, $ck_Value, $ck_Time);
}

function GetCookie($Var)
{
	return $_COOKIE[$Var];
}

function getFiletime($timediff)
{
	$timediff = intval($timediff);

	if ($timediff <= 0) {
		return '0h:0m:0s';
	}
	else {
		$timediff = round($timediff / 1000, 2);
		$secs_ex = (($timediff * 100) % 100) * 0.01;
		$tmp_time = $timediff - $secs_ex;
		$secs = $tmp_time % 60;
		$tmp_time = ($tmp_time - $secs) / 60;
		$mins = $tmp_time % 60;
		$tmp_time = ($tmp_time - $mins) / 60;
		$hours = $tmp_time;
		$res = array('hour' => $hours, 'min' => $mins, 'sec' => $secs);
		return number_format($res['hour'], 0) . 'h:' . number_format($res['min'], 0) . 'm:' . number_format($res['sec'], 0) . 's';
	}
}

if (!function_exists('num_rand')) {
	function num_rand($lenth)
	{
		$randval = '';
		mt_srand((double) microtime() * 1000000);

		for ($i = 0; $i < $lenth; $i++) {
			$randval .= mt_rand(0, 9);
		}

		return $randval;
	}
}

if (!function_exists('is_really_writable')) {
	function is_really_writable($file)
	{
		if ((DIRECTORY_SEPARATOR == '/') && (@ini_get('safe_mode') == false)) {
			return is_writable($file);
		}

		if (is_dir($file)) {
			$file = rtrim($file, '/') . '/' . md5(mt_rand(1, 100) . mt_rand(1, 100));

			if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === false) {
				return false;
			}

			fclose($fp);
			@(chmod($file, DIR_WRITE_MODE));
			@(unlink($file));
			return true;
		}
		else if (!is_file($file) || ($fp = @(fopen($file, FOPEN_WRITE_CREATE)) === false)) {
			return false;
		}

		fclose($fp);
		return true;
	}
}

if (!function_exists('array_change_value_case')) {
	function array_change_value_case(array $input, $case = CASE_LOWER)
	{
		switch ($case) {
		case CASE_LOWER:
			return array_map('strtolower', $input);
			break;

		case CASE_UPPER:
			return array_map('strtoupper', $input);
			break;

		default:
			trigger_error('Case is not valid, CASE_LOWER or CASE_UPPER only', 256);
			return false;
		}
	}
}

if (!function_exists('cut_str')) {
	function cut_str($sourcestr, $cutlength)
	{
		$returnstr = '';
		$i = 0;
		$n = 0;
		$str_length = strlen($sourcestr);
		$mb_str_length = mb_strlen($sourcestr, 'utf-8');
		while (($n < $cutlength) && ($i <= $str_length)) {
			$temp_str = substr($sourcestr, $i, 1);
			$ascnum = ord($temp_str);

			if (224 <= $ascnum) {
				$returnstr = $returnstr . substr($sourcestr, $i, 3);
				$i = $i + 3;
				$n++;
			}
			else if (192 <= $ascnum) {
				$returnstr = $returnstr . substr($sourcestr, $i, 2);
				$i = $i + 2;
				$n++;
			}
			else if ((65 <= $ascnum) && ($ascnum <= 90)) {
				$returnstr = $returnstr . substr($sourcestr, $i, 1);
				$i = $i + 1;
				$n++;
			}
			else {
				$returnstr = $returnstr . substr($sourcestr, $i, 1);
				$i = $i + 1;
				$n = $n + 0.5;
			}
		}

		if ($cutlength < $mb_str_length) {
			$returnstr = $returnstr . '...';
		}

		return $returnstr;
	}
}

if (!function_exists('splitchar')) {
	function splitchar($str,$len)
	{
		if (strlen($str)>$len)
		{
			$string = "";
			for($i=0; $i<$len; $i++)
			{
				$tmp_str = substr($str,$i,1);
				if (ord($tmp_str) < 127)
				{
					$string = substr($str,0,$i+1);
				}
				else
				{
					$string = substr($str,0,$i+2);
					$i++;
				}
			}
			$string .= "...";
		}
		else
		{
			$string = $str;
		}
		return $string;
	}
}

if (!function_exists('getRealSize')) {
	function getRealSize($size)
	{
		$mb = 1024;
		$gb = 1024 * $mb;
		$tb = 1024 * $gb;

		if ($size < $mb) {
			return round($size, 2) . ' MB';
		}
		else if ($size < $gb) {
			return round($size / $mb, 2) . ' GB';
		}
		else {
			return round($size / $gb, 2) . ' TB';
		}
	}
}

if (!function_exists('remote_file_exists')) {
	function remote_file_exists($url)
	{
		$curl = curl_init($url);
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
		return $found;
	}
}

?>

<?php

require_once ('../common/generalfunc.php');
$lines = 50;
$gzz_xh = trim(@$_REQUEST['gzz_xh']);
$rzlx = trim(@$_REQUEST['rzlx']);
$dxbh = trim(@$_REQUEST['dxbh']);
$rzrq = trim(@$_REQUEST['rzrq']);
$authKey = trim(@$_REQUEST['authKey']);
$chuanval = '';

if ($gzz_xh) {
	$chuanval .= '执法数据采集设备产品编码（' . $gzz_xh . '），';
}

if ($rzlx) {
	$chuanval .= '日志类型（' . $rzlx . '），';
}

if ($dxbh) {
	$chuanval .= '对象编号（' . $dxbh . '），';
}

if ($rzrq) {
	$chuanval .= '日志时间（' . $rzrq . '），';
}

$chuanval = rtrim($chuanval, '，');

if ($chuanval != '') {
	write_log('用户传入：' . $chuanval, $flg = '1', 'upload/stationlog/');
}
else {
	write_log('用户没传入任何值', $flg = '0', 'upload/stationlog/');
}

$message = '';

if (!$gzz_xh) {
	$message .= '执法数据采集设备产品编码不能为空，';
	write_log('执法数据采集设备产品编码为空', $flg = '0', 'upload/stationlog/');
}

if (!$rzlx) {
	$message .= '日志类型不能为空，';
	write_log('日志类型为空', $flg = '0', 'upload/stationlog/');
}

if (!$rzrq) {
	$message .= '日志时间不能为空，';
	write_log('日志时间为空', $flg = '0', 'upload/stationlog/');
}

if ($gzz_xh) {
	$station = getstationval($gzz_xh);

	if (!$station) {
		$message .= '工作站不存在，';
		write_log('工作站不存在', $flg = '0', 'upload/stationlog/');
	}
}

if (!$authKey) {
	$message .= '认证密钥不能为空！';
	insert_xml('WRITESTATIONLOG', $message, '0');
	write_log('认证密钥为空，上传失败！', $flg = '0', 'upload/stationlog/');
}
else if (verify_authkey($authKey)) {
	if ($message == '') {
		$insert_sql = 'insert into `zm_station_log` set `hostname`=\'' . $gzz_xh . '\',`logtype`=\'' . $rzlx . '\',`obj`=\'' . $dxbh . '\',`logtime`=\'' . $rzrq . '\',`source_type`=\'1\'';
		write_log($insert_sql, $flg = '1', 'upload/stationlog/');
		$insert_flg = runquery($insert_sql);
	}

	if (isset($insert_flg) && !empty($insert_flg)) {
		$message .= '上传成功';
		insert_xml('WRITESTATIONLOG', $message, '1');
		write_log('上传成功', $flg = '1', 'upload/stationlog/');
	}
	else {
		$message .= '上传失败';
		insert_xml('WRITESTATIONLOG', $message, '0');
		write_log('上传失败', $flg = '0', 'upload/stationlog/');
	}
}
else {
	$message .= '输入的认证密钥有误或过期，请重新输入正确的认证密钥！';
	insert_xml('WRITESTATIONLOG', $message, '0');
	write_log('输入的认证密钥有误或过期，上传失败！', $flg = '0', 'upload/stationlog/');
}

?>

<?php

require_once ('../common/generalfunc.php');
$lines = 50;
$gzz_xh = trim(@$_REQUEST['gzz_xh']);
$gzz_ipdz = trim(@$_REQUEST['gzz_ipdz']);
$zxzt = trim(@$_REQUEST['zxzt']);
$qyzt = trim(@$_REQUEST['qyzt']);
$authKey = trim(@$_REQUEST['authKey']);
$chuanval = '';

if ($gzz_xh) {
	$chuanval .= '执法数据采集设备产品编码（' . $gzz_xh . '），';
}

if ($gzz_ipdz) {
	$chuanval .= '执法数据采集设备IP（' . $gzz_ipdz . '），';
}

if ($zxzt) {
	$chuanval .= '在线状态（' . $zxzt . '），';
}

if ($qyzt) {
	$chuanval .= '启用状态（' . $qyzt . '），';
}

$chuanval = rtrim($chuanval, '，');

if ($chuanval != '') {
	write_log('用户传入：' . $chuanval, $flg = '1', 'upload/stationinfo/');
}
else {
	write_log('用户没传入任何值', $flg = '0', 'upload/stationinfo/');
}

$message = '';
$hostname_sql = 'SELECT * FROM `zm_hostip` WHERE `hostname`=\'' . $gzz_xh . '\'';
$hostname_count_query = runquery($hostname_sql);
$hostname_num = mysql_num_rows($hostname_count_query);
mysql_free_result($hostname_count_query);

if (!$gzz_xh) {
	$message .= '执法数据采集设备产品编码不能为空，';
	write_log('执法数据采集设备产品编码为空', $flg = '0', 'upload/stationinfo/');
}

if (!$authKey) {
	$message .= '认证密钥不能为空！';
	insert_xml('WRITESTATIONINFO', $message, '0');
	write_log('认证密钥为空，上传失败！', $flg = '0', 'upload/stationinfo/');
}
else if (verify_authkey($authKey)) {
	if ($message == '') {
		if (0 < $hostname_num) {
			$insert_sql = 'update `zm_hostip` set `hostname`=\'' . $gzz_xh . '\',`hostip`=\'' . $gzz_ipdz . '\',`online`=\'' . $zxzt . '\',`enable`=\'' . $qyzt . '\',`source_type`=\'1\',`modtime`=\'' . date('Y-m-d H:i:s', time()) . '\' where `hostname`=\'' . $gzz_xh . '\'';
		}
		else {
			$insert_sql = 'insert into `zm_hostip` set `hostname`=\'' . $gzz_xh . '\',`hostip`=\'' . $gzz_ipdz . '\',`online`=\'' . $zxzt . '\',`enable`=\'' . $qyzt . '\',`source_type`=\'1\',`modtime`=\'' . date('Y-m-d H:i:s', time()) . '\'';
		}

		write_log($insert_sql, $flg = '1', 'upload/stationinfo/');
		$insert_flg = runquery($insert_sql);
	}

	if (isset($insert_flg) && !empty($insert_flg)) {
		$message .= '上传成功';
		insert_xml('WRITESTATIONINFO', $message, '1');
		write_log('上传成功', $flg = '1', 'upload/stationinfo/');
	}
	else {
		$message .= '上传失败';
		insert_xml('WRITESTATIONINFO', $message, '0');
		write_log('上传失败', $flg = '0', 'upload/stationinfo/');
	}
}
else {
	$message .= '输入的认证密钥有误或过期，请重新输入正确的认证密钥！';
	insert_xml('WRITESTATIONINFO', $message, '0');
	write_log('输入的认证密钥有误或过期，上传失败！', $flg = '0', 'upload/stationinfo/');
}

?>

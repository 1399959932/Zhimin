<?php

require_once ('../common/generalfunc.php');
$lines = 50;
$wjbh = trim(@$_REQUEST['wjbh']);
$wjbm = trim(@$_REQUEST['wjbm']);
$pssj = trim(@$_REQUEST['pssj']);
$wjdx = trim(@$_REQUEST['wjdx']);
$wjlx = trim(@$_REQUEST['wjlx']);
$jy_xm = trim(@$_REQUEST['jy_xm']);
//$jybh = trim(@$_REQUEST['jybh']);
$cpxh = trim(@$_REQUEST['cpxh']);
$jgdm = trim(@$_REQUEST['jgdm']);
$dwmc = trim(@$_REQUEST['dwmc']);
$ccfwq = trim(@$_REQUEST['ccfwq']);
$ccwz = trim(@$_REQUEST['ccwz']);
$bfwz = trim(@$_REQUEST['bfwz']);
$wlwz = trim(@$_REQUEST['wlwz']);
$gzz_xh = trim(@$_REQUEST['gzz_xh']);
$scsj = trim(@$_REQUEST['scsj']);
$bzlx = trim(@$_REQUEST['bzlx']);
$authKey = trim(@$_REQUEST['authKey']);
$chuanval = '';

if ($wjbh) {
	$chuanval .= '文件编号（' . $wjbh . '），';
}

if ($wjbm) {
	$chuanval .= '文件别名（' . $wjbm . '），';
}

if ($pssj) {
	$chuanval .= '拍摄时间（' . $pssj . '），';
}

if ($wjdx) {
	$chuanval .= '文件大小（' . $wjdx . '），';
}

if ($wjlx) {
	$chuanval .= '文件类型（' . $wjlx . '），';
}

if ($jy_xm) {
	$chuanval .= '使用者姓名（' . $jy_xm . '），';
}

/*
if ($jybh) {
	$chuanval .= $_SESSION['zfz_type'] . '编号（' . $jybh . '），';
}
*/

if ($cpxh) {
	$chuanval .= '产品序号（' . $cpxh . '），';
}

if ($jgdm) {
	$chuanval .= '单位编码（' . $jgdm . '），';
}

if ($dwmc) {
	$chuanval .= '单位名称（' . $dwmc . '），';
}

if ($ccfwq) {
	$chuanval .= '存储服务器（' . $ccfwq . '），';
}

if ($ccwz) {
	$chuanval .= '存储位置（' . $ccwz . '），';
}

if ($bfwz) {
	$chuanval .= '播放位置（' . $bfwz . '），';
}

if ($wlwz) {
	$chuanval .= '物理位置（' . $wlwz . '），';
}

if ($gzz_xh) {
	$chuanval .= '执法数据采集设备产品编码（' . $gzz_xh . '），';
}

if ($scsj) {
	$chuanval .= '上传时间（' . $scsj . '），';
}

if ($bzlx) {
	$chuanval .= '标注类型（' . $bzlx . '），';
}

$chuanval = rtrim($chuanval, '，');

if ($chuanval != '') {
	write_log('用户传入：' . $chuanval, $flg = '1', 'upload/deviceinfo/');
}
else {
	write_log('用户没传入任何值', $flg = '0', 'upload/deviceinfo/');
}

$message = '';

if (!$wjbh) {
	$message .= '文件编号不能为空，';
	write_log('文件编号为空', $flg = '0', 'upload/deviceinfo/');
}

/*
if (!$jybh) {
	$message .= $_SESSION['zfz_type'] . '编号不能为空，';
	write_log($_SESSION['zfz_type'] . '编号为空', $flg = '0', 'upload/deviceinfo/');
}
*/

if (!$cpxh) {
	$message .= '产品序号不能为空，';
	write_log('产品序号为空', $flg = '0', 'upload/deviceinfo/');
}

if ($jgdm) {
	$unit = getunitval($jgdm);

	if (!$unit) {
		$message .= '单位编号不存在，';
		write_log('单位编号不存在', $flg = '0', 'upload/deviceinfo/');
	}
}

if ($gzz_xh) {
	$station = getstationval($gzz_xh);

	if (!$station) {
		$message .= '工作站不存在，';
		write_log('工作站不存在', $flg = '0', 'upload/deviceinfo/');
	}
}

if ($cpxh) {
	$device = getdeviceval($cpxh);

	if (!$device) {
		$message .= '记录仪编号不存在，';
		write_log('记录仪编号不存在', $flg = '0', 'upload/deviceinfo/');
	}
}

$filename_sql = 'SELECT * FROM `zm_video_list` WHERE `filename`=\'' . $wjbh . '\'';
$filename_count_query = runquery($filename_sql);
$filename_num = mysql_num_rows($filename_count_query);
mysql_free_result($filename_count_query);

if (!$authKey) {
	$message .= '认证密钥不能为空！';
	insert_xml('WRITEDSJINFO', $message, '0');
	write_log('认证密钥为空，上传失败！', $flg = '0', 'upload/deviceinfo/');
}
else if (verify_authkey($authKey)) {
	if ($message == '') {
		$wjdx = round($wjdx / 1048576, 2);

		if (0 < $filename_num) {
			$insert_sql = 'update `zm_video_list` set `filename`=\'' . $wjbh . '\',`bfilename`=\'' . $wjbm . '\',`createdate`=\'' . $pssj . '\',`filelen`=\'' . $wjdx . '\',`filetype`=\'' . $wjlx . '\',`hostname`=\'' . $jy_xm . '\',`hostcode`=\'' . $jybh . '\',`hostbody`=\'' . $cpxh . '\',`danwei`=\'' . $jgdm . '\',`serverurl`=\'' . $ccfwq . '\',`saveposition`=\'' . $ccwz . '\',`media_play_url`=\'' . $bfwz . '\',`macposition`=\'' . $wlwz . '\',`creater`=\'' . $gzz_xh . '\',`uploaddate`=\'' . $scsj . '\',`caserank`=\'' . $bzlx . '\',`source_type`=\'1\' where `filename`=\'' . $wjbh . '\'';
		}
		else {
			$insert_sql = 'insert into `zm_video_list` set `filename`=\'' . $wjbh . '\',`bfilename`=\'' . $wjbm . '\',`createdate`=\'' . $pssj . '\',`filelen`=\'' . $wjdx . '\',`filetype`=\'' . $wjlx . '\',`hostname`=\'' . $jy_xm . '\',`hostcode`=\'' . $jybh . '\',`hostbody`=\'' . $cpxh . '\',`danwei`=\'' . $jgdm . '\',`serverurl`=\'' . $ccfwq . '\',`saveposition`=\'' . $ccwz . '\',`media_play_url`=\'' . $bfwz . '\',`macposition`=\'' . $wlwz . '\',`creater`=\'' . $gzz_xh . '\',`uploaddate`=\'' . $scsj . '\',`caserank`=\'' . $bzlx . '\',`source_type`=\'1\'';
		}
		//echo $insert_sql;
		write_log($insert_sql, $flg = '1', 'upload/deviceinfo/');
		$insert_flg = runquery($insert_sql);
	}

	if (isset($insert_flg) && !empty($insert_flg)) {
		$message .= '上传成功';
		insert_xml('WRITEDSJINFO', $message, '1');
		write_log('上传成功', $flg = '1', 'upload/deviceinfo/');
	}
	else {
		$message .= '上传失败';
		insert_xml('WRITEDSJINFO', $message, '0');
		write_log('上传失败', $flg = '0', 'upload/deviceinfo/');
	}
}
else {
	$message .= '输入的认证密钥有误或过期，请重新输入正确的认证密钥！';
	insert_xml('WRITEDSJINFO', $message, '0');
	write_log('输入的认证密钥有误或过期，上传失败！', $flg = '0', 'upload/deviceinfo/');
}

?>

<?php

require_once ('../common/generalfunc.php');
$lines = 50;
$wjbh = trim(@$_REQUEST['wjbh']);
$jy_xm = trim(@$_REQUEST['jy_xm']);
$jybh = trim(@$_REQUEST['jybh']);
$jgdm = trim(@$_REQUEST['jgdm']);
$dwmc = trim(@$_REQUEST['dwmc']);
$psrq = trim(@$_REQUEST['psrq']);
$authKey = trim(@$_REQUEST['authKey']);
$record = '';
$message = '';
$chaval = '';

if ($wjbh) {
	$chaval .= '文件编号（' . $wjbh . '），';
}

if ($jy_xm) {
	$chaval .= '使用者姓名（' . $jy_xm . '），';
}

if ($jybh) {
	$chaval .= @$_SESSION['zfz_type'] . '编号（' . $jybh . '），';
}

if ($jgdm) {
	$chaval .= '单位编号（' . $jgdm . '），';
}

if ($dwmc) {
	$chaval .= '单位名称（' . $dwmc . '），';
}

if ($psrq) {
	$chaval .= '拍摄日期（' . $psrq . '），';
}

$chaval = rtrim($chaval, '，');

if ($chaval != '') {
	write_log('用户查询：' . $chaval, $flg = '1', 'query/deviceinfo/');
}
else {
	write_log('用户没查询任何值', $flg = '0', 'query/deviceinfo/');
}

if ($wjbh || $jy_xm || $jybh || $jgdm || $dwmc || $psrq) {
	$where = '1';
}
else {
	$where = '0';
}

if ($wjbh) {
	$where .= ' AND `hostbody`=\'' . $wjbh . '\'';
}

if ($jy_xm) {
	$where .= ' AND `pvl`.`hostname`=\'' . $jy_xm . '\'';
}

if ($jybh) {
	$where .= ' AND `hostcode`=\'' . $jybh . '\'';
}
else {
	$where .= ' AND \'1\'=\'0\'';
	$message .= @$_SESSION['zfz_type'] . '编号不能为空，';
	write_log(@$_SESSION['zfz_type'] . '编号为空', $flg = '0', 'query/deviceinfo/');
}

if ($jgdm) {
	$where .= ' AND `danwei`=\'' . $jgdm . '\'';
}

if ($psrq) {
	$where .= ' AND `createdate`=\'' . $psrq . '\'';
}

if (!$authKey) {
	$message .= '认证密钥不能为空！';
	$record .= '<record />';
	select_xml($record, 'QUERYDSJINFO', $message, '0');
	write_log('认证密钥为空，查询失败！', $flg = '0', 'query/deviceinfo/');
}
else if (verify_authkey($authKey)) {
	$sql = 'SELECT pvl.*,pd.dname,ph.hostip as stationip from `zm_video_list` as `pvl` left join `zm_danwei` as `pd` on `pvl`.`danwei`=`pd`.`bh` left join `zm_hostip` as `ph` on `pvl`.`creater`=`ph`.`hostname` where ' . $where;
	write_log($sql, $flg = '1', 'query/deviceinfo/');
	$all_count_query = runquery($sql);//echo $sql;
	$num = @mysql_num_rows($all_count_query);

	if (0 < $num) {
		while ($data = mysql_fetch_assoc($all_count_query)) {
			$path = str_replace('media', '', $data['playposition']);
			$path = ltrim($path, '/');
			$httpurl = getallstationserverurl($data['serverurl']);

			if ($data['source_type'] != '') {
				$bfwz = $data['media_play_url'];
			}
			else {
				$bfwz = $httpurl[$data['serverurl']] . $path;
			}

			$filelen = round($data['filelen'] * 1048576, 2);
			$record .= '<record wjbh="' . $data['filename'] . '" wjbm="' . $data['bfilename'] . '" pssj="' . $data['createdate'] . '" wjdx="' . $filelen . '" wjlx="' . $data['filetype'] . '" jy_xm="' . $data['hostname'] . '" jybh="' . $data['hostcode'] . '" jgdm="' . $data['danwei'] . '" dwmc="' . $data['dname'] . '" cpxh="' . $data['hostbody'] . '" ccwz="' . $data['saveposition'] . '" bfwz="' . $bfwz . '" wlwz="' . $data['macposition'] . '" scsj="' . $data['uploaddate'] . '" bzlx="' . $data['caserank'] . '" gzz_xh="' . $data['creater'] . '" gzz_ipdz="' . $data['stationip'] . '" />';
		}

		$message .= '查询成功！';
		select_xml($record, 'QUERYDSJINFO', $message, '1');
		write_log('查询成功！', $flg = '1', 'query/deviceinfo/');
	}
	else {
		$message .= '查询失败！输入的内容有误查询不到结果！';
		$record .= '<record />';
		select_xml($record, 'QUERYDSJINFO', $message, '0');
		write_log('查询失败！输入的内容有误查询不到结果！', $flg = '0', 'query/deviceinfo/');
	}

	@mysql_free_result($all_count_query);
}
else {
	$message .= '输入的认证密钥有误或过期，请重新输入正确的认证密钥！';
	$record .= '<record />';
	select_xml($record, 'QUERYDSJINFO', $message, '0');
	write_log('输入的认证密钥有误或过期，查询失败！', $flg = '0', 'query/deviceinfo/');
}

?>

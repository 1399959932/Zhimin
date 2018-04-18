<?php

require_once ('../common/generalfunc.php');
$lines = 50;
$cpxh = trim(@$_REQUEST['cpxh']);
$rzrq = trim(@$_REQUEST['rzrq']);
$authKey = trim(@$_REQUEST['authKey']);
$record = '';
$message = '';
$chaval = '';

if ($cpxh) {
	$chaval .= '产品序号（' . $cpxh . '），';
}

if ($rzrq) {
	$chaval .= '日志时间（' . $rzrq . '），';
}

$chaval = rtrim($chaval, '，');

if ($chaval != '') {
	write_log('用户查询：' . $chaval, $flg = '1', 'query/devicelog/');
}
else {
	write_log('用户没查询任何值', $flg = '0', 'query/devicelog/');
}

if ($cpxh || $rzrq) {
	$where = '1';
}
else {
	$where = '0';
}

if ($cpxh) {
	$where .= ' AND `deviceid`=\'' . $cpxh . '\'';
}
else {
	$where .= ' AND \'1\'=\'0\'';
	$message .= '产品序号不能为空，';
	write_log('产品序号为空', $flg = '0', 'query/devicelog/');
}

if ($rzrq) {
	$where .= ' AND `logtime` like \'' . $rzrq . '%\'';
}

if (!$authKey) {
	$message .= '认证密钥不能为空！';
	$record .= '<record />';
	select_xml($record, 'CXDSJLOG', $message, '0');
	write_log('认证密钥为空，查询失败！', $flg = '0', 'query/devicelog/');
}
else if (verify_authkey($authKey)) {
	$sql = 'SELECT * from `zm_device_log` where ' . $where;
	write_log($sql, $flg = '1', 'query/devicelog/');
	$all_count_query = runquery($sql);
	$num = mysql_num_rows($all_count_query);

	if (0 < $num) {
		while ($data = mysql_fetch_assoc($all_count_query)) {
			$record .= '<record cpxh="' . $data['deviceid'] . '" rzlx="' . $data['logtype'] . '" wjmc="' . $data['filename'] . '" rzrq="' . $data['logtime'] . '" />' . "\n";
		}

		$message .= '查询成功！';
		select_xml($record, 'CXDSJLOG', $message, '1');
		write_log('查询成功！', $flg = '1', 'query/devicelog/');
	}
	else {
		$message .= '查询失败！输入的内容有误查询不到结果！';
		$record .= '<record />';
		select_xml($record, 'CXDSJLOG', $message, '0');
		write_log('查询失败！输入的内容有误查询不到结果！', $flg = '0', 'query/devicelog/');
	}
}
else {
	$message .= '输入的认证密钥有误或过期，请重新输入正确的认证密钥！';
	$record .= '<record />';
	select_xml($record, 'CXDSJLOG', $message, '0');
	write_log('输入的认证密钥有误或过期，查询失败！', $flg = '0', 'query/devicelog/');
}

?>

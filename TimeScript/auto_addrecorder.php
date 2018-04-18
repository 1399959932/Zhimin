<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
$conf = array();
$conf = @include ('../app/config/main.php');
$db_host = $conf['db']['host'];
$db_dbname = $conf['db']['dbname'];
$con = mysql_connect($db_host, $conf['db']['login'], $conf['db']['password']);

if (!$con) {
	echo date('Y-m-d H:i:s') . ' [ERROR] host=[' . $db_host . '], use=[' . $conf['db']['login'] . ']lianjie shibai.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	echo date('Y-m-d H:i:s') . ' [INFO] host=[' . $db_host . '], use=[' . $conf['db']['login'] . ']lianjie chenggong.' . "\n" . '';
}

mysql_select_db($db_dbname, $con);
mysql_query('set names utf8');
$userarray = array();
$sql = 'SELECT DISTINCT t.hostcode from zm_device t;';
$result = mysql_query($sql);

while ($row_c = mysql_fetch_array($result)) {
	$userarray[] = $row_c['hostcode'];
}

if ($argc == 2) {
	$yesterday = $argv[1];
}
else {
	$yesterday = date('Y-m-d', strtotime('-1 day'));
}

$sql = 'SELECT DISTINCT t.hostbody, t.hostcode, t.hostname, t.danwei from zm_video_list t where t.uploaddate like \'' . $yesterday . '%\'';
echo date('Y-m-d H:i:s') . ' [INFO] media_del=[' . $sql . '].' . "\n" . '';
$result = mysql_query($sql);

while ($row_c = mysql_fetch_array($result)) {
	$tempbody = $row_c['hostbody'];
	$tempcode = $row_c['hostcode'];
	$tempname = $row_c['hostname'];
	$tempdanwei = $row_c['danwei'];

	if (in_array($row_c['hostcode'], $userarray)) {
		$sql_deal = 'UPDATE zm_device set hostbody=\'' . $tempbody . '\', hostname=\'' . $tempname . '\', danwei=\'' . $tempdanwei . '\' where hostcode=\'' . $tempcode . '\'';
	}
	else {
		$sql_deal = 'INSERT INTO zm_device(hostbody, hostname, danwei, hostcode) VALUES(\'' . $tempbody . '\', \'' . $tempname . '\', \'' . $tempdanwei . '\', \'' . $tempcode . '\')';
	}

	echo 'sql_deal=[' . $sql_deal . ']<br>';
	$result_1 = mysql_query($sql_deal);
}

?>

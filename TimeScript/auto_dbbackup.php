<?php

echo '﻿';
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
$dump_str = 'mysqldump -u' . $conf['db']['login'] . ' -p' . $conf['db']['password'] . ' ' . $db_dbname . ' > ./dbback/backup' . date('Ymd') . '.sql';

if (!system($dump_str)) {
	echo date('Y-m-d H:i:s') . '[info] database backup successful.';
	$delfilename = './dbback/backup' . date('Ymd', strtotime('-7 day')) . '.sql';
	@unlink($delfilename);
}
else {
	echo date('Y-m-d H:i:s') . '[info] database backup error.';
}

?>

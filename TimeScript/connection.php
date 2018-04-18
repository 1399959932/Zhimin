<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
date_default_timezone_set('PRC');
$conf = array();
$conf = @include ('../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);

if (!$con) {
	echo date('Y-m-d H:i:s') . ' [ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']connect failed.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	echo date('Y-m-d H:i:s') . ' [INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']connect success.' . "\n" . '';
}

$DATABASE = $db_dbname[1];
$CONNECTION = $con;
$_BULLETIN = false;
$_SHOW_ERROR = true;
$_BEFOR_DAY = 4;
$VIDEO_TYPE = array('avi', 'mpg', 'flv', 'wmv', 'mp4', 'mov', 'asf', 'AVI', 'MPG', 'FLV', 'WMV', 'MP4', 'MOV', 'ASF');
$_MIN_TIME = 29 * 60;
$_DEV_TIME = 5 * 60;
$wsdl = 'http://127.0.0.1/cqjxjwsservice/services/ZhptOutAccess?wsdl';
$xtlb = '83';
$jkxlh = '7C1E1D080314E1F38E99E485879A8CD5E7E5EF908CE5EE848099A2C7A49D636E';
$jkid = '83Z82';
$yhbz = '';
$dwmc = '';
$dwjgdm = '';
$yhxm = '';
$zdbs = '127.0.0.2';

?>

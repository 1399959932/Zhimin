<?php

header('content-Type: text/html; charset=utf-8');
include ('../../app/config/main.php');
date_default_timezone_set('PRC');
$conf = array();
$conf = @include ('../../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);
$_MEDIA_TYPE = $conf['global']['media_type'];
$document_root = $conf['global']['document_root'];

if (!$con) {
	$log_string = date('Y-m-d H:i:s') . ' [ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']connect failed.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	$log_string = date('Y-m-d H:i:s') . ' [INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']connect success.' . "\n" . '';
}

$DATABASE = $db_dbname[1];
$CONNECTION = $con;
$DOCUMENT_ROOT = $document_root;
$_BULLETIN = false;
$_SHOW_ERROR = false;

?>

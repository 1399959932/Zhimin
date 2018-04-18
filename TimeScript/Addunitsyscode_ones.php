<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
$statdate = '';

if ($argc == 2) {
	$statdate = $argv[1];
}
else {
	$statdate = date('Y-m-d', strtotime('-1 day'));
}

$conf = array();
$conf = @include ('../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);

if (!$con) {
	echo '[ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie shibai.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	echo '[INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie chenggong.' . "\n" . '';
}

mysql_select_db($db_dbname[1], $con);
mysql_query('set names utf8');
$sql_sel = 'SELECT * from zm_danwei where parentid = 0';
$res_sel = mysql_query($sql_sel);

while ($row_sel = mysql_fetch_array($res_sel)) {
	modifyunitcode($row_sel['id'], '100', $row_sel['id']);
}


function modifyunitcode($parentcode_tmp, $syscode_tmp, $unitid_tmp)
{
	$sql_update = 'UPDATE zm_danwei set unitsyscode = \'' . $syscode_tmp . '\' where id = ' . $unitid_tmp;
	mysql_query($sql_update);
	echo $sql_update;
	echo '<br>';
	$sql = 'SELECT * from zm_danwei where parentid = ' . $parentcode_tmp . ' ';
	$result = mysql_query($sql);
	$i = 1;

	while ($row = mysql_fetch_array($result)) {
		$parentcode_1 = $row['id'];
		$syscode_1 = $syscode_tmp . str_pad($i, 3, '0', STR_PAD_LEFT);
		$unitid_1 = $row['id'];
		modifyunitcode($parentcode_1, $syscode_1, $unitid_1);
		$i = $i + 1;
	}
}
?>

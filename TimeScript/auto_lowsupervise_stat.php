<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
date_default_timezone_set('PRC');
$statdate = '';
$nowdatetime = date('Y-m-d H:i:s');

global $argc;
if ($argc == 2) {
	$statdate = $argv[1];
}
else {
	$statdate = date('Y-m-d', strtotime('-1 day'));//'2017-03-13';//
}

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
$sql = 'select t.hostcode, t.danwei, date(t.createdate) as date, t.hostbody, ' . "\r\n" . '		count(*) as num, round(sum(t.playtime/1000)) as fitime, ' . "\r\n" . '        sum(UNIX_TIMESTAMP(t.uploaddate)-UNIX_TIMESTAMP(t.createdate)>24*3600) as wannum ' . "\r\n" . '        from zm_video_list t where t.uploaddate like \'' . $statdate . '%\' group by t.hostcode, t.danwei, date(t.createdate), t.hostbody';
echo date('Y-m-d H:i:s') . '[INFO] sql=[' . $sql . '].' . "\n" . '';
$result = mysql_query($sql);
$resarray = array();

while ($row = mysql_fetch_array($result)) {
	$resarray[$row['date']][$row['hostcode']][$row['danwei']][$row['hostbody']]['vedionum'] = $row['num'];
	$resarray[$row['date']][$row['hostcode']][$row['danwei']][$row['hostbody']]['vediotime'] = $row['fitime'];
	$resarray[$row['date']][$row['hostcode']][$row['danwei']][$row['hostbody']]['wannum'] = $row['wannum'];
}

echo '<br><hr /><br>';

foreach ($resarray as $key1 => $val1 ) {
	foreach ($val1 as $key2 => $val2 ) {
		foreach ($val2 as $key3 => $val3 ) {
			foreach ($val3 as $key4 => $val4 ) {
				$sql_ins = sprintf('insert into zm_lowsupervise_stat(statdate,hostcode,unitcode,hostbody,' . "\r\n" . '									videototalnum, wanvideonum, videotimelength,creatime) ' . "\r\n" . '					           values(\'%s\',\'%s\',\'%s\',\'%s\',%d,%d,%f,now())' . "\r\n" . '					           on duplicate key update videototalnum=videototalnum + %d, ' . "\r\n" . '					           wanvideonum=wanvideonum + %d, videotimelength=videotimelength + %f,creatime=now()', $key1, $key2, $key3, $key4, $val4['vedionum'], $val4['wannum'], $val4['vediotime'], $val4['vedionum'], $val4['wannum'], $val4['vediotime']);
				echo date('Y-m-d H:i:s') . '[INFO] sql_ins=[' . $sql_ins . '].<br>';
				//mysql_query($sql_ins);
			}
		}
	}
}

?>

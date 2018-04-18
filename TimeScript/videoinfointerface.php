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

if ($argc == 2) {
	$sql_del = 'delete from zm_prewarn_stat where statdate like \'' . $statdate . '%\'';
	$result = mysql_query($sql_del);
}

$sql = 'select t.hostcode, t.hostbody, t.danwei, date(t.createdate) as date, floor(sum(t.playtime/1000)) as filelen,' . "\r\n" . '        sum(IF(querys=0 and downloads=0 and opens=0, 1, 0)) as noopervedionum,' . "\r\n" . '        sum(IF((t.playtime/1000)<5, 1, 0)) as shortvedionum ,' . "\r\n" . '        count(1) as vediototalnum ' . "\r\n" . '        from zm_video_list t where t.uploaddate like \'' . $statdate . '%\' and t.filetype=\'MP4\' group by t.hostcode, t.hostbody, t.danwei, date(t.createdate)';
echo '[INFO] sql=[' . $sql . '].' . "\n" . '';
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
	$sql_ins = sprintf('insert into zm_prewarn_stat(statdate,usecode,unitcode,hostcode,shortvedionum,' . "\r\n" . '		           vediototalnum,noopervedionum,usetimelength,creatime) values(\'%s\',\'%s\',\'%s\',\'%s\',%d,%d,%d,%d,now())' . "\r\n" . '		           on duplicate key update shortvedionum=shortvedionum + %d, vediototalnum=vediototalnum + %d,' . "\r\n" . '		           noopervedionum=noopervedionum + %d, usetimelength=usetimelength + %d, creatime=now()', $row['date'], $row['hostcode'], $row['danwei'], $row['hostbody'], $row['shortvedionum'], $row['vediototalnum'], $row['noopervedionum'], $row['filelen'], $row['shortvedionum'], $row['vediototalnum'], $row['noopervedionum'], $row['filelen']);
	echo '[INFO] sql_ins=[' . $sql_ins . '].' . "\n" . '';
	mysql_query($sql_ins);
}

?>

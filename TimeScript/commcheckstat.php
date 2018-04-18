<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
date_default_timezone_set('PRC');
$statdate = '';

global $argc;
if ($argc == 2) {
	$statdate = $argv[1];
}
else {
	$statdate = date('Y-m-d', strtotime('-1 day'));//'2017-03-04';//
}

$conf = array();
$conf = @include ('../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);

if (!$con) {
	echo date('Y-m-d H:i:s') . '[ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie shibai.' . "\n" . '<p></p>';
	echo 'Could not connect: ' . mysql_error() . '  code:' . mysql_errno();
}
else {
	echo date('Y-m-d H:i:s') . '[INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie chenggong.' . "\n" . '<p></p>';
}

mysql_select_db($db_dbname[1], $con);
mysql_query('set names utf8');
$sql = 'select t.hostcode, t.danwei, date(t.createdate) as date, t.filetype, count(*) as num, sum(t.filelen) as len, ' . "\r\n" . '        round(sum(t.playtime/1000)) as fitime, sum(t.is_flg) as fignum ' . "\r\n" . '        from zm_video_list t where t.uploaddate like \'' . $statdate . '%\' group by t.hostcode, t.danwei, date(t.createdate), t.filetype';
echo date('Y-m-d H:i:s') . '[INFO] sql=[' . $sql . '].' . "\n" . '<p></p>';
$result = mysql_query($sql);
$resarray = array();
$biaozhunum = 0;
$date = ""; $hostcode = ""; $danwei = "";
while ($row = mysql_fetch_array($result)) {
	if (in_array(strtolower($row['filetype']), $conf['global']['media_type']['video'])) {
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['vedionum'] = $row['num'];
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['vediosize'] = $row['len'];
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['vediotime'] = $row['fitime'];
	}
	else if (in_array(strtolower($row['filetype']), $conf['global']['media_type']['photo'])) {
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['photonum'] = $row['num'];
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['photosize'] = $row['len'];
	}
	else {
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['audionum'] = $row['num'];
		$resarray[$row['date']][$row['hostcode']][$row['danwei']]['audiosize'] = $row['len'];
	}

	$date = $row['date']; $hostcode = $row['hostcode']; $danwei = $row['danwei'];
	$biaozhunum += $row['fignum'];
	$resarray[$date][$hostcode][$danwei]['biaozhunum'] = $biaozhunum;
}

echo '<br><hr /><br>';

foreach ($resarray as $key1 => $val1 ) {
	foreach ($val1 as $key2 => $val2 ) {
		foreach ($val2 as $key3 => $val3 ) {
			$sql_ins = sprintf('insert into zm_check_stat(statdate,usecode,unitcode,vedionum,' . "\r\n" . '				           audionum,photonum,biaozhunum,vediosize,audiosize, photosize,vediotime,creatime) ' . "\r\n" . '				           values(\'%s\',\'%s\',\'%s\',%d,%d,%d,%d,%f,%f,%f,%d,now())' . "\r\n" . '				           on duplicate key update vedionum=vedionum + %d, audionum=audionum + %d,' . "\r\n" . '				           photonum=photonum + %d,biaozhunum=biaozhunum + %d, vediosize=vediosize + %f, audiosize=audiosize + %f,' . "\r\n" . '				           photosize=photosize + %f, vediotime=vediotime + %d,creatime=now()', $key1, $key2, $key3, $val3['vedionum'], $val3['audionum'], $val3['photonum'], $val3['biaozhunum'], $val3['vediosize'], $val3['audiosize'], $val3['photosize'], $val3['vediotime'], $val3['vedionum'], $val3['audionum'], $val3['photonum'], $val3['biaozhunum'], $val3['vediosize'], $val3['audiosize'], $val3['photosize'], $val3['vediotime']);
			echo date('Y-m-d H:i:s') . '[INFO] sql_ins=[' . $sql_ins . '].<br>';
			//mysql_query($sql_ins);
		}
	}
}

?>

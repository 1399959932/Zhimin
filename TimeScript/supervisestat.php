<?php
/* no using... */

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
date_default_timezone_set('PRC');
$statdate = '';

global $argc;
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
	echo date('Y-m-d H:i:s') . ' [ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie shibai.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	echo date('Y-m-d H:i:s') . ' [INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie chenggong.' . "\n" . '';
}

mysql_select_db($db_dbname[1], $con);
mysql_query('set names utf8');

if ($argc == 2) {
	$sql_del = 'delete from zm_supervise_stat where statdate like \'' . $statdate . '%\'';
	$result = mysql_query($sql_del);
}

$sql = 'select t.filename, t.hostbody, round(t.playtime/1000) as playtime, t.createdate from zm_video_list t where t.filetype=\'MP4\'  order by t.filename';
echo '[INFO] sql=[' . $sql . '].<br>';
$result = mysql_query($sql);
$onevideotime = 0;
$totvideotime = 0;
$lastusecode = '';
$usecode = '';
$playtime = 0;
$lastcreatedate = '';
$nextcreatedate = '';
$i = 0;
$diff15min = 0;
$videoendtime = '';
$videousedetial = '';

while ($row = mysql_fetch_array($result)) {
	if ($i == 0) {
		$lastusecode = $row['hostbody'];
		$lastcreatedate = $row['createdate'];
		$videousedetial = $row['createdate'];
		$i = 1;
	}

	$playtime = $row['playtime'];
	$usecode = $row['hostbody'];
	$nextcreatedate = $row['createdate'];

	if ($lastusecode != $usecode) {
		$videoendtime = date('Y-m-d H:i:s', strtotime($lastcreatedate) + $onevideotime);
		echo 'lastcreatedate=[' . $lastcreatedate . '], onevideotime=[' . $onevideotime . '], videoendtime=[' . $videoendtime . '].<br>';
		$videousedetial .= '--' . $videoendtime;
		$sql_ins = sprintf('insert into zm_supervise_stat( statdate, usecode, large15mnum, usetimelength, usetimedetail, creatime)' . "\r\n" . '		           values(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',now())', $statdate, $lastusecode, $diff15min, $totvideotime, $videousedetial);
		echo '[INFO] sql_ins=[' . $sql_ins . '].<br>';
		mysql_query($sql_ins);
		$onevideotime = 0;
		$totvideotime = 0;
		$diff15min = 0;
		$lastusecode = $row['hostbody'];
		$lastcreatedate = $row['createdate'];
		$videousedetial = $row['createdate'];
		$onevideotime += $playtime;
		$totvideotime += $playtime;
		echo '#####################################################################################################.<br>';
		continue;
	}

	echo 'lastcreatedate = [' . $lastcreatedate . ']、nextcreatedate=[' . $nextcreatedate . '].<br>';

	if ($lastcreatedate != $nextcreatedate) {
		$difftime = strtotime($nextcreatedate) - strtotime($lastcreatedate) - $onevideotime;

		if ((15 * 60) < $difftime) {
			$diff15min = $diff15min + 1;
		}

		if ((1 * 60) < $difftime) {
			$videoendtime = date('Y-m-d H:i:s', strtotime($lastcreatedate) + $onevideotime);
			echo $lastcreatedate . '=[' . $lastcreatedate . '], videotime=[' . $onevideotime . '], endtime=[' . $videoendtime . '], nextcreatedate=[' . $nextcreatedate . ']<br>';
			$videousedetial .= '--';
			$videousedetial .= $videoendtime;
			$videousedetial .= ' || ' . $nextcreatedate;
		}

		$lastcreatedate = $nextcreatedate;
		$onevideotime = 0;
	}

	$onevideotime += $playtime;
	$totvideotime += $playtime;
}

$videoendtime = date('Y-m-d H:i:s', strtotime($lastcreatedate) + $onevideotime);
$videousedetial .= '--' . $videoendtime;
$sql_ins = sprintf('insert into zm_supervise_stat( statdate, usecode, large15mnum, usetimelength, usetimedetail, creatime)' . "\r\n" . '           values(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',now())', $statdate, $lastusecode, $diff15min, $totvideotime, $videousedetial);
echo '[INFO] sql_ins=[' . $sql_ins . '].<br>';
mysql_query($sql_ins);
$sql = 'select distinct t.hostbody  from zm_video_list t where t.filetype=\'MP4\' and t.major=1 and t.createdate ' . "\r\n" . '        BETWEEN CONCAT(ADDDATE(\'' . $statdate . '\',-3),\' 00:00:00\') and CONCAT(\'' . $statdate . '\',\' 23:59:59\') ';
echo '[INFO] sql=[' . $sql . '].<br>';
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
	$usecode_1 = $row['hostbody'];
	$sqlupdate = 'update zm_supervise_stat set ishadimpvideo=1 where statdate=\'' . $statdate . '\' and usecode=\'' . $usecode_1 . '\'';
	echo '[INFO] sqlupdate=[' . $sqlupdate . '].<br>';
	mysql_query($sqlupdate);
}

$sql_update = 'UPDATE  zm_supervise_stat t1, zm_workforce t2 SET t1.classid=t2.classid, t1.unitcode=t2.unitcode where ' . "\r\n" . '               t1.usecode=t2.usecode and t1.statdate=t2.statdate AND t1.classid is null and statdate=\'' . $statdate . '\';';
echo '[INFO] sql_update=[' . $sql_update . '].<br>';
mysql_query($sql_update);
$sql_update = 'update zm_supervise_stat t  set t.ishadvideo=1 where statdate=\'' . $statdate . '\' and case when t.classid=1 ' . "\r\n" . '               then \'14:30\' when t.classid=2 then \'22:30\' when t.classid=3 then \'21:30\' ' . "\r\n" . '               when t.classid=4 then \'06:30\' end  < SUBSTR(t.usetimedetail, -8, 5);';
echo '[INFO] sql_update=[' . $sql_update . '].<br>';
mysql_query($sql_update);

?>

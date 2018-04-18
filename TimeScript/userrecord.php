<?php
//接口：根据用户的hostcode获取用户姓名和其上传的所有视频播放时长

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');

date_default_timezone_set('PRC');

$conf = array();
$conf = @include ('../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
//echo $db_host[1] . '<br>' . $conf['db']['params'][1] . '<br>' . $conf['db']['params'][2] . '<br><br><br>';
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);

$hostcode=$_GET['userid'];

mysql_select_db($db_dbname[1], $con);
mysql_query('set names utf8');

$sql_media = 'select sum(playtime) as sm from zm_video_list where hostcode = \'' . $hostcode . '\'';
//die($sql_media);
$result = mysql_query($sql_media);

require_once('../app/core/Common.php');
if(mysql_num_rows($result))
{ 
	$media = mysql_fetch_array($result);
		
	$sm  = $media['sm'];
}

$sql_media = 'select realname from zm_user where hostcode = \'' . $hostcode . '\'';
//die($sql_media);
$result = mysql_query($sql_media);

require_once('../app/core/Common.php');
if(mysql_num_rows($result))
{ 
	$media = mysql_fetch_array($result);
		
	$name  = $media['realname'];
}
echo $name . '<br>';
echo $sm . '秒';

?>

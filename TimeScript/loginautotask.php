<?php

header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');
include ('PhpMailer.php');
date_default_timezone_set('PRC');
//$statdate = '';
$nowdatetime = date('Y-m-d H:i:s');

/*
if ($argc == 2) {
	$statdate = $argv[1];
}
else {
	$statdate = date('Y-m-d', strtotime('-1 day'));
}
*/

$conf = array();
$conf = @include ('../app/config/main.php');
$db_str = explode(';', $conf['db']['params'][0]);
$db_host = explode('=', $db_str[0]);
$db_dbname = explode('=', $db_str[1]);
//echo $db_host[1] . '<br>' . $conf['db']['params'][1] . '<br>' . $conf['db']['params'][2] . '<br><br><br>';
$con = mysql_connect($db_host[1], $conf['db']['params'][1], $conf['db']['params'][2]);

/* connect mysql test
if (!$con) {
	echo date('Y-m-d H:i:s') . ' [ERROR] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie shibai.' . "\n" . '';
	exit('Could not connect: ' . mysql_error());
}
else {
	echo date('Y-m-d H:i:s') . ' [INFO] host=[' . $db_host[1] . '], use=[' . $conf['db']['params'][1] . ']lianjie chenggong.' . "\n" . '';
}
*/

mysql_select_db($db_dbname[1], $con);
mysql_query('set names utf8');
echo '1、' . date('Y-m-d H:i:s') . ' [INFO] start clear log data.' . "\n<br><br>" . '';
$date_log = getconfval('auto_del_log');

if ($date_log != '0') {
	$sql_del = 'delete from zm_log where logtime < ' . (time() - (floatval($date_log) * 3600 * 24));
	echo '2、' . date('Y-m-d H:i:s') . ' [INFO] sql_log_del=[' . $sql_del . '].' . "\n<br><br>" . '';
	$result = mysql_query($sql_del);
}

$date_log = getconfval('auto_del_device_log');

if ($date_log != '0') {
	$sql_del = 'delete from zm_device_log where logtime < ADDDATE(NOW(),-' . $date_log . ')';
	echo '3、' . date('Y-m-d H:i:s') . ' [INFO] sql_device_del=[' . $sql_del . '].' . "\n<br><br>" . '';
	$result = mysql_query($sql_del);
}

$date_log = getconfval('auto_del_hostip_log');

if ($date_log != '0') {
	$sql_del = 'delete from zm_station_log where logtime < ADDDATE(NOW(),-' . $date_log . ')';
	echo '4、' . date('Y-m-d H:i:s') . ' [INFO] sql_station_del=[' . $sql_del . '].' . "\n<br><br>" . '';
	$result = mysql_query($sql_del);
}

$date_media = getconfval('auto_del_file');
// echo $date_media;exit;
// $date_media = '30';
if ($date_media != '0') {
	$media_del = 'INSERT INTO `zm_video_list_del` SELECT * FROM `zm_video_list` where (sort=\'\' or sort is NULL) and onlyread=0 and DATEDIFF(\'' . $nowdatetime . '\',uploaddate) > ' . $date_media;
	echo '5、' . date('Y-m-d H:i:s') . ' [INFO] media_del=[' . $media_del . '].' . "\n<br><br>" . '';
	$result = mysql_query($media_del);
	//modify:清理未分类(sort=\'\' or sort is NULL)【媒体的“文件类型”】 且上传日期与当前的日期差超过“自动清理文件天数”值的媒体记录   三个月  六个月  十二个月  永久
	$media_del = 'DELETE FROM zm_video_list WHERE (sort=\'\' or sort is NULL) and onlyread=0 and DATEDIFF(\'' . $nowdatetime . '\',uploaddate) > ' . $date_media;
	echo '6、' . date('Y-m-d H:i:s') . ' [INFO] media_del=[' . $media_del . '].' . "\n<br><br>" . '';
	// echo $media_del;exit;
	$result = mysql_query($media_del);
}

$sql_sort = 'select gname, cunchu from zm_sort';
$result = mysql_query($sql_sort);

while ($row_c = mysql_fetch_array($result)) {
	$delete_sort = $date_media;
	if (($row_c['cunchu'] != '') && ($row_c['cunchu'] != '0')) {
		$delete_sort = $row_c['cunchu'];
	}

	if ($delete_sort != '0') {
		//delete file script
		//...............

		$media_del = 'INSERT INTO `zm_video_list_del` SELECT * FROM `zm_video_list` where sort=\'' . $row_c['gname'] . '\'  and onlyread=0 and DATEDIFF(\'' . $nowdatetime . '\',uploaddate) > ' . $delete_sort;
		echo '7、' . date('Y-m-d H:i:s') . ' [INFO] media_del=[' . $media_del . '].' . "\n<br><br>" . '';
		$result = mysql_query($media_del);
		$media_del = 'DELETE FROM zm_video_list WHERE sort=\'' . $row_c['gname'] . '\' and onlyread=0 and DATEDIFF(\'' . $nowdatetime . '\',uploaddate) > ' . $delete_sort;
		echo '8、' . date('Y-m-d H:i:s') . ' [INFO] media_del=[' . $media_del . '].' . "\n<br><br>" . '';
		$result = mysql_query($media_del);
	}
}
echo '9、' . date('Y-m-d H:i:s') . ' [INFO] END clear log data.' . "\n<br><br>" . '';


//==============================================//modify：针对表video_list中save_date（“存储天数”）的值对媒体记录及文件进行删除处理=====================================================//
echo '<hr />10、删除“存储天数”达到指定值的媒体记录和文件' . "\n<br><br>";
$sql_media = 'select id, bfilename, filename, save_date, uploaddate, filetype, thumb, saveposition from zm_video_list where onlyread = 0 and save_date != 4 order by id';// and DATEDIFF(Now(),uploaddate) > ' . $date_media . ' order by id';
$result = mysql_query($sql_media);

require_once('../app/core/Common.php');
$media_cfg = $conf['global']['media_type'];
$document_root = $conf['global']['document_root'];
$i = 0;
if(mysql_num_rows($result))
{ 
	while ($media = mysql_fetch_array($result)) {
		$i = $i + 1;
		$del_id = $media['id'];
		$delfilename = $media['filename'];
		$save_date = $media['save_date'];
		$uploaddate = $media['uploaddate'];
		$filetype = strtolower($media['filetype']);
		$thumb = $media['thumb'];
		$saveposition = $media['saveposition'];
		$str = $media['bfilename'] . '(' . $saveposition . ')，媒体id: ' . $media['id'];

		$media_filepath = '';
		$thumb_filepath = '';
		$today = date("Y-m-d");
		$diff = diffBetweenTwoDays($uploaddate, $today);
		//echo '<br>' . $uploaddate . '和' . $today . '相差：' . $diff . '天<br>';

		if ($save_date == 1) {
			$limit_day = 90;
		}
		else if ($save_date == 2) {
			$limit_day = 180;
		}
		if ($save_date == 3) {
			$limit_day = 360;
		}
		if ($diff > $limit_day) {
			//echo $saveposition . '需要删除！(允许存在天数：' . $limit_day . ')<br /><br />';
			if (in_array($filetype, $media_cfg['video'])) {
				if ($saveposition != ''){
					$media_filepath = $document_root . "media/" . $saveposition;
				}
				if ($thumb != ''){
					$thumb_filepath = $document_root . $thumb;
				}
			}
			if (in_array($filetype, $media_cfg['photo'])) {
				if ($saveposition != ''){
					$media_filepath = $document_root . $saveposition;
				}
				if ($thumb != ''){
					$thumb_filepath = $document_root . $thumb;
				}
			}
			if (in_array($filetype, $media_cfg['audio'])) {
				if ($saveposition != ''){
					$media_filepath = $document_root . $saveposition;
				}
				//audio具有统一的缩略图images/audio.gif，不可删除
			}

			//del video audio jpg
			if ($media_filepath != ''){
				@unlink($media_filepath);
			}
			//del jpg thumb
			if ($thumb_filepath != ''){
				@unlink($thumb_filepath);
			}

			$media_del = 'INSERT INTO `zm_video_list_del` SELECT * FROM `zm_video_list` WHERE onlyread=0 and save_date != 4 and id=\'' . $del_id . '\'';
			mysql_query($media_del);
			$media_del = 'DELETE FROM zm_video_list WHERE onlyread=0 and save_date != 4 and id=\'' . $del_id . '\'';
			mysql_query($media_del);
			echo '<br>自动删除存储到期的媒体文件与记录: ' . $str . '<hr /><br />';
		}
		else {
			//echo $saveposition . '不需要删除！(允许存在天数：' . $limit_day . ')<br /><br />';
		}
	}
}
else 
{  
	die(mysql_error());
}


//==============================================获取统计数据，通过mail发送到管理员邮箱=====================================================//
$smtp_host = getconfval('mail_host');
echo '<hr /><br />11、' . date('Y-m-d H:i:s') . ' [INFO] start stat data and send mail.' . "\n<br><br>" . '';
$str = '<br><table width="98%"  border="1" cellpadding="1" cellspacing="1">' . "\n" . '';
$str .= '<tr bgcolor="#3366FF"><td width="10%" align="center">序号</td><td width="40%" align="center">文件类型</td><td width="25%" align="center">文件数量</td><td width="25%" align="center">文件大小</td>  </tr>' . "\n" . '';
$i = 0;
$file_count = 0;
$file_count_size = 0;
$sql = 'select count(id) AS cou,filetype,SUM(filelen) AS file_sum from zm_video_list  group by filetype ';
$result = mysql_query($sql);

while ($row_c = mysql_fetch_array($result)) {
	$i++;
	$file_count += $row_c['cou'];
	$file_count_size += $row_c['file_sum'];
	$str .= '<tr class="bg"><td align="center">' . $i . '</td><td align="center">' . $row_c['filetype'] . '</td><td align="center">' . $row_c['cou'] . '</td><td align="center">' . getrealsize($row_c['file_sum']) . '</td></tr>' . "\n" . '';
}

$str .= '<tr class="bg"><td align="center"></td><td align="center">统计时间:' . date('Y-m-j H:i:s', time()) . '</td><td align="center">总媒体文件数量:' . $file_count . '个</td><td align="center">总占用空间:' . getrealsize($file_count_size) . '</td></tr></table>' . "\n" . '';
$FreeDisk = disk_free_space('.');
$str .= '<br>&nbsp;&nbsp;存储空间剩余容量:' . getrealsize($FreeDisk / 1024 / 1024);
echo '11-1、' . date('Y-m-d H:i:s') . ' [INFO] mail content is : ' . $str . "\n<hr /><br><br>" . '';
$title = '统计报告';
$content = $str;
$attachments = '';
$fromname = 'zhimin';
$smtp_host = getconfval('mail_host');
$smtp_pass = getconfval('mail_password');
$smtp_user = getconfval('admin_mail');
$receivers = getconfval('mail_post');
$send = send_mail($title, $content, $attachments, $smtp_host, $smtp_pass, $smtp_user, $receivers, $fromname);
$disk_size = getconfval('disk_size');
$free_size = disk_free_space('.') / 1024 / 1024;

if ($free_size < $disk_size) {
	$str = '磁盘空间预警，执行于' . date('Y-m-j H:i:s', time()) . '，自动提示磁盘空间预警；<br>服务器磁盘空间目前已小于预警大小：&nbsp;' . $disk_size . ' M；&nbsp;请及时清理文件<br>目前服务器剩余空间：&nbsp;' . getrealsize($free_size);
	$content = $str;
	$send = send_mail($title, $content, $attachments, $smtp_host, $smtp_pass, $smtp_user, $receivers, $fromname);
}


//==============================================ftp delete=====================================================//
$date_media = getsysteminfo('ftian');
$server_sql = 'SELECT * FROM zm_serverinfo WHERE flag = 1;';
$serveinfo = mysql_query($server_sql);
$server = mysql_fetch_array($serveinfo);
if ((intval($date_media) != 0) && !empty($server['serverip']) && false) {
	$sql_media = 'select * from zm_video_list where onlyread=0 and DATEDIFF(Now(),uploaddate) > ' . $date_media . ' order by id';
	$del_medias = mysql_query($sql_media);

	if (!empty($del_medias)) {
		$media_cfg = $conf['global']['media_type'];
		$i = 0;
		($ftp_conn = @ftp_connect($server['serverip'], $server['port'])) || exit('Could not connect');
		ftp_login($ftp_conn, $server['ftpusername'], $server['pwd']);

		foreach ($del_medias as $media ) {
			$i = $i + 1;
			$filepath = $media['saveposition'];
			$thumb = $media['thumb'];
			$filetype = strtolower($media['filetype']);
			$del_id = $media['id'];
			$delfilename = $media['filename'];
			$str = $media['bfilename'] . ',媒体id: ' . $media['id'] . '|';

			//默认连接到http://192.168.1.26/media/，所以要替换media/
			if (in_array($filetype, $media_cfg['video'])) {
				if ($thumb != '') {
					@ftp_delete($ftp_conn, str_replace('media/', '', $thumb));
				}

				if ($filepath != '') {
					@ftp_delete($ftp_conn, str_replace('media/', '', $filepath));
				}
			}
			else if (in_array($filetype, $media_cfg['audio'])) {
				if ($filepath != '') {
					@ftp_delete($ftp_conn, str_replace('media/', '', $filepath));
				}
			}
			else if (in_array($filetype, $media_cfg['photo'])) {
				if ($thumb != '') {
					@ftp_delete($ftp_conn, str_replace('media/', '', $thumb));
				}

				if ($filepath != '') {
					@ftp_delete($ftp_conn, str_replace('media/', '', $filepath));
				}
			}

			$media_del = 'INSERT INTO `zm_video_list_del` SELECT * FROM `zm_video_list` WHERE onlyread=0 and id=\'' . $del_id . '\'';
			$result = mysql_query($media_del);
			$media_del = 'DELETE FROM zm_video_list WHERE onlyread=0 and id=\'' . $del_id . '\'';
			$result = mysql_query($media_del);
		}

		ftp_close($ftp_conn);
		echo '<br>自动删除媒体文件与记录: ' . $str;
	}
}
?>

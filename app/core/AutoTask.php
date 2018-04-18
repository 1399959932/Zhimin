<?php
header('content-Type: text/html; charset=utf-8');
include ('../app/config/main.php');

class AutoTask
{
	static public function mediaCount()
	{
		$tasks_m = new TasksModel();
		$sql = 'SELECT * FROM `' . $tasks_m->table() . '` where runstate=0 and tasksflag=\'count\'';
		$tasks = $tasks_m->fetchAll('', $sql);

		if (!empty($tasks)) {
			$task = $tasks[0];
			$sql = '';
			$str1 = '';
			$filelen_tj = $task['filelen_tj'];
			$id = $task['id'];

			if ($task['bfilename'] != '') {
				$bfilename = $task['bfilename'];
				$sql .= ' and bfilename like \'%' . $bfilename . '%\' ';
				$str1 .= ',文件别名:' . $bfilename;
			}

			if ($task['filelen'] != '') {
				$filelen = $task['filelen'];
				$sql .= 'and filelen ' . $filelen_tj . ' \'' . $filelen . '\' ';
				$str1 .= ',文件长度:' . $filelen_tj . $filelen;
			}

			if ($task['filetype'] != '') {
				$filetypes = $task['filetype'];
				$sql .= ' and filetype = \'' . $filetypes . '\'';
				$str1 .= ',文件类型:' . $filetypes;
			}

			if ($task['hostname'] != '') {
				$hostname = $task['hostname'];
				$sql .= ' and hostname like \'%' . $hostname . '%\' ';
				$str1 .= ',主机名:' . $hostname;
			}

			if ($task['hostcode'] != '') {
				$hostcode = $task['hostcode'];
				$sql .= ' and hostcode   like \'%' . $hostcode . '%\' ';
				$str1 .= ',机主编号:' . $hostcode;
			}

			if ($task['hostbody'] != '') {
				$hostbody = $task['hostbody'];
				$sql .= ' and hostbody = \'' . $hostbody . '\'';
				$str1 .= ',机身编号:' . $hostbody;
			}

			if ($task['danwei'] != '') {
				$danwei = $task['danwei'];
				$sql .= ' and danwei   like \'%' . $danwei . '%\' ';
				$str1 .= ',单位:' . $danwei;
			}

			if (($task['createdate'] != '') && ($task['createdate_end'] != '')) {
				$createdate = '';
				$createdate_end = '';

				if (isset($task['createdate'])) {
					$createdate = $task['createdate'];
				}

				if (isset($task['createdate_end'])) {
					$createdate_end = $task['createdate_end'];
				}

				$sql .= ' and createdate between \'' . $createdate . '\' and  \'' . $createdate_end . '\' ';
				$str1 .= ',上传时间:' . $createdate . '至' . $createdate_end;
			}

			$smtp = $task['smtp'];
			$smtp_pass = $task['smtp_pass'];
			$source_mail = $task['source_mail'];
			$post_mail = $task['post_mail'];
			$taskuser = $task['creater'];
			$taskuserid = $task['createrid'];
			$fromname = get_info('site');
			$tasksflag = $task['tasksflag'];
			$runfs = $task['runfs'];
			$fsvalue = $task['fsvalue'];
			$rundate = $row['rundate'];
			$r_date = date('d', $rundate);
			$r_time = date('H:i:s', $rundate);

			if ($runfs == 'dates') {
				$rundate_tmp = date('Y-m-d', strtotime('+' . $fsvalue . ' days')) . ' ' . $r_time;
			}
			else if ($runfs == 'week') {
				$zhou = date('w');
				$dates = date('w', $rundate);

				if ($zhou < $dates) {
					$tian = $dates - $zhou;
					$rundate_tmp = date('Y-m-d', strtotime('+' . $tian . ' days')) . ' ' . $r_time;
				}
				else {
					$tian = $zhou - $dates;
					$rundate_tmp = date('Y-m-d', strtotime('+1 week -' . $tian . ' days')) . ' ' . $r_time;
				}
			}

			if ($rundate < time()) {
				$str .= '以下列表是根据这些搜索条件的结果:' . $str1 . '<br><table width="98%"  border="1" cellpadding="1" cellspacing="1">' . "\n" . '';
				$str .= '<tr bgcolor="#3366FF"><td width="10%" align="center">序号</td><td width="40%" align="center">文件类型</td><td width="25%" align="center">文件数量</td><td width="25%" align="center">文件大小</td>  </tr>' . "\n" . '';
				$i = 0;
				$media_m = new MediaModel();
				$medias = $media_m->fetchAll('', 'select count(id) AS cou,filetype,SUM(filelen) AS file_sum from zm_video_list where 1=1 ' . $sql . '  group by filetype  ');

				foreach ($medias as $row_c ) {
					$i++;
					$file_count += $row_c['cou'];
					$file_count_size += $row_c['file_sum'];
					$str .= '<tr class="bg"><td align="center">' . $i . '</td><td align="center">' . $row_c['filetype'] . '</td><td align="center">' . $row_c['cou'] . '</td><td align="center">' . getrealsize($row_c['file_sum']) . '</td></tr>' . "\n" . '';
				}

				$str .= '<tr class="bg"><td align="center"></td><td align="center">统计时间:' . date('Y-m-j H:i:s', time()) . '</td><td align="center">总媒体文件数量:' . $file_count . '个</td><td align="center">总占用空间:' . getrealsize($file_count_size) . '</td></tr></table>' . "\n" . '';
				$FreeDisk = disk_free_space('.');
				$str .= '<br>下次自动执行时间:' . $rundate_tmp . '&nbsp;&nbsp;存储空间剩余容量:' . getrealsize($FreeDisk / 1024 / 1024);
				$rundate_tmp = strtotime($rundate_tmp);
				$tasks_m->insertRow(array('bfilename' => $bfilename, 'filelen_tj' => $filelen_tj, 'filelen' => $filelen, 'filetype' => $filetype, 'hostname' => $hostname, 'hostcode' => $hostcode, 'hostbody' => $hostbody, 'danwei' => $danwei, 'createdate' => $createdate, 'createdate_end' => $createdate_end, 'runfs' => $runfs, 'fsvalue' => $fsvalue, 'runstate' => 0, 'rundate' => $rundate_tmp, 'smtp' => $smtp, 'smtp_pass' => $smtp_pass, 'source_mail' => $source_mail, 'post_mail' => $post_mail, 'createrid' => $taskuserid, 'creater' => $taskuser, 'createrdate' => time(), 'tasksflag' => 'count'));
				$tasks_m->updateRow('id=\'' . $id . '\'', array('runstate' => 2));
				MailerUtils::send_mail('自动统计报告,执行于' . date('Y-m-j H:i:s', time()) . '', $str, '', $smtp, $smtp_pass, $source_mail, $post_mail, $fromname);
				$log_m = new LogModel();
				$log_m->writeLog('成功执行自动统计,发送邮件');
			}
		}
	}

	static public function spaceWarning()
	{
		$disk_size = get_info('disk_size');
		$free_size = disk_free_space('.') / 1024 / 1024;
		$tasks_m = new TasksModel();

		if ($disk_size < $free_size) {
			$sql = 'SELECT id FROM `' . $tasks_m->table() . '` where tasksflag=\'disk_space\' order by id desc limit 1';
			$task = $tasks_m->fetchOne('', $sql);

			if (!empty($task)) {
				$tasks_m->updateRow('tasksflag=\'disk_space\' and runstate<>2', array('runstate' => 2, 'creater' => $_SESSION['username'], 'tasksflag' => 'disk_space', 'rundate' => time(), 'createrdate' => time()));
			}
			else {
				$tasks_m->insertRow(array('runstate' => 2, 'creater' => $_SESSION['username'], 'tasksflag' => 'disk_space', 'rundate' => time(), 'createrdate' => time()));
			}
		}
		else {
			$sql = 'SELECT id FROM `' . $tasks_m->table() . '` where tasksflag=\'disk_space\' and runstate=1';
			$task1 = $tasks_m->fetchOne('', $sql);

			if (empty($task1)) {
				$str = '磁盘空间预警，执行于' . date('Y-m-j H:i:s', time()) . '，自动提示磁盘空间预警；<br>服务器磁盘空间目前已小于预警大小：&nbsp;' . $disk_size . ' M；&nbsp;请及时清理文件<br>目前服务器剩余空间：&nbsp;' . getrealsize($FreeDisk);
				$tasks_m->insertRow(array('runstate' => 1, 'creater' => $_SESSION['username'], 'tasksflag' => 'disk_space', 'rundate' => time(), 'createrdate' => time()));
				MailerUtils::system_send_mail('服务器磁盘空间报告,执行于' . date('Y-m-j H:i:s', time()) . '', $str, '');
				$log_m = new LogModel();
				$log_m->writeLog('成功执行磁盘空间预警,自动发送邮件成功');
			}
		}
	}

	static public function clearServer()
	{
		$systeminfo_m = new SysteminfoModel();
		$systeminfo = $systeminfo_m->fetchOne('', 'SELECT * FROM `' . $systeminfo_m->table() . '`');
		$date_log = $systeminfo['ftian1'];
		$log_m = new LogModel();

		if ($date_log != 0) {
			$log_m->deleteRow('logtime < ' . (time() - (floatval($date_log) * 3600 * 24)));
		}

		$log_device_m = new DevicelogModel();
		$date_device_log = $systeminfo['ftian_device'];
		$device_temp = date('Y-m-d H:i:s', time() - (floatval($date_device_log) * 3600 * 24));

		if ($date_device_log != 0) {
			$log_device_m->deleteRow('logtime < \'' . $device_temp . '\'');
		}

		$date_station_log = $systeminfo['ftian_station'];
		$log_station_m = new StationlogModel();
		$station_temp = date('Y-m-d H:i:s', time() - (floatval($date_station_log) * 3600 * 24));

		if ($date_station_log != 0) {
			$log_station_m->deleteRow('logtime < \'' . $station_temp . '\'');
		}

		$server_m = new ServerModel();
		$server_sql = 'SELECT * FROM `' . $server_m->table() . '` WHERE flag = 1;';
		$server = $server_m->fetchOne('', $server_sql);
		$date_media = $systeminfo['ftian'];
		$media_m = new MediaModel();
		if (($date_media != 0) && !empty($server['serverip'])) {
			$sql = 'select * from `' . $media_m->table() . '` where onlyread=0 and DATEDIFF(Now(),uploaddate) > ' . $date_media . ' order by id';
			$del_medias = $media_m->fetchAll('', $sql);

			if (!empty($del_medias)) {
				$media_cfg = Zhimin::g('media_type');
				$mediadel_m = new MediadelModel();
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

					$mediadel_m->dquery('INSERT INTO `zm_video_list_del` SELECT * FROM `zm_video_list` WHERE onlyread=0 and id=\'' . $del_id . '\';');
					$media_m->deleteRow('onlyread=0 and id=\'' . $del_id . '\'');
				}

				ftp_close($ftp_conn);
				$log_m->writeLog('自动删除媒体文件与记录: ' . $str);
			}
		}
	}

	static public function resetStationState()
	{
		$station_m = new StationModel();
		$station_m->updateRow('`modtime` < \'' . date('Y-m-d H:i:s', time() - 1800) . '\'', array('online' => 0, 'modtime' => date('Y-m-d H:i:s')));
	}
}


?>

<?php

class MediatuwenAction extends Action
{
	protected $units = array();
	protected $url_base = '';
	protected $module_sn = 10011;

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$action = Zhimin::request('action');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$units_array = get_units_by_web();
		$this->_data['units_array'] = $units_array;
		$sysconf_m = new SysconfModel();
		$restypes = $sysconf_m->get_by_type('3');
		$arr_types = array();

		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}

		$this->_data['biaozhu_types'] = $arr_types;
		$restypes = $sysconf_m->get_by_type('1');
		$arr_types = array();

		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}

		$this->_data['file_types'] = $arr_types;
		$major = Zhimin::param('major', 'get');

		switch ($action) {
		case 'search':
			$this->search();
			break;

		case 'highsearch':
			$this->highsearch();
			break;

		case 'patchdel':
			$this->patchdel();
			break;

		case 'patchdown':
			$this->all_download();
			break;

		case 'onedel':
			$this->onedel();
			break;

		case 'media_down':
			$this->mediadown();
			break;

		default:
			$this->mlist();
			break;
		}

		$kind_m = new MediakindModel();
		$kinds = $kind_m->readAll('id, gname as name');
		$this->_data['sorts'] = $kinds;
		$this->_data['url_base'] = $this->url_base;
		$level_m = new MedialevelModel();
		$levels = $level_m->readAll();
		$this->_data['levels'] = $levels;
	}

	protected function patchdel()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有删除的权限！', 'url' => $this->url_base);
			return;
		}

		$this->_hasView = 0;
		$media_m = new MediaModel();
		$idarray = Zhimin::param('idarray', 'post');
		$insertdel = 'INSERT INTO zm_video_list_del SELECT * from zm_video_list where id in(' . $idarray . ') and major=0';
		$rs = $media_m->dquery($insertdel);
		$insertdel = 'DELETE from zm_video_list where id in(' . $idarray . ') and major=0';
		$rs = $media_m->dquery($insertdel);
		$log_m = new LogModel();
		$log_m->writeLog('015', '批量删除文件,记录ID为:' . $idarray);
		echo 0;
	}

	protected function onedel()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有删除的权限！', 'url' => $this->url_base);
			return;
		}

		$this->_hasView = 0;
		$media_m = new MediaModel();
		$fileid = Zhimin::param('fileid', 'post');
		$sql_query = 'SELECT major from zm_video_list where id = \'' . $fileid . '\' and major=0';
		$sql_info = $media_m->fetchOne('', $sql_query);

		if (empty($sql_info)) {
			echo '1';
		}
		else {
			$insertdel = 'INSERT INTO zm_video_list_del SELECT * from zm_video_list where id = \'' . $fileid . '\'';
			$rs = $media_m->dquery($insertdel);
			$insertdel = 'DELETE from zm_video_list_flg where video_id = \'' . $fileid . '\'';
			$rs = $media_m->dquery($insertdel);
			$insertdel = 'DELETE from zm_video_list where id = \'' . $fileid . '\'';
			$rs = $media_m->dquery($insertdel);
			$log_m = new LogModel();
			$log_m->writeLog('015', '删除文件,记录ID为:' . $fileid);
			echo 0;
		}
	}

	protected function mediadown()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDown($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有下载的权限！', 'url' => $this->url_base);
			return;
		}

		$this->_hasView = false;
		$post_id = intval(Zhimin::param('id', 'get'));
		$code = Zhimin::request('code');

		if (!empty($post_id)) {
			$media_m = new MediaModel();
			$auth = Zhimin::getComponent('auth');
			$media_cfg = Zhimin::g('media_type');
			$media = $media_m->read($post_id, 'id,filename,bfilename,filetype,serverurl,playposition,saveposition,creater');

			if (empty($media)) {
				exit('非法操作！');
			}

			$downid = $media['id'];
			$station_m = new StationModel();
			$arr_urlinfo = $station_m->GetAllStationServerUrl();
			$path = str_replace('media', '', $media['playposition']);
			$path = ltrim($path, '/');
			$downfile = $arr_urlinfo[$media['serverurl']] . $path;
			$fs = Zhimin::param('fs', 'get');

			switch ($fs) {
			case 'xunlei':
				$downxunlei = 'thunder://' . base64_encode('AA' . $downfile . 'ZZ');
				echo '<script language=\'javascript\'>location.href=\'' . $downxunlei . '\'</script>';
				break;

			case 'flashget':
				$downflashget = 'flashget://' . base64_encode('[FLASHGET]' . $downfile . '[FLASHGET]');
				echo '<script language=\'javascript\'>location.href=\'' . $downflashget . '\';</script>';
				break;

			default:
				echo '<script language=\'javascript\'>location.href=\'' . $downfile . '\';</script>';
				break;
			}

			if ($code == $_SESSION['code']) {
				$media_m->dquery('UPDATE zm_video_list set downloads=downloads+1 WHERE id=' . $post_id);
				$log_m = new LogModel();
				$log_m->writeLog('013', '下载文件,文件名称为:' . $media['bfilename'], $media['bfilename']);
			}

			unset($_SESSION['code']);

			if (!empty($fs)) {
				echo '<script language=\'javascript\'>self.close();</script>';
			}
			else {
				exit();
			}
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
			return;
		}

		$media_m = new MediaModel();
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$wssql = '';
		$wsql = '';

		switch (Zhimin::g('zhimintype')) {
		case 1:
			$wssql = 'select hostname from zm_hostip order by id limit 0,3';
			break;

		case 2:
			$wssql = 'select hostname from zm_hostip order by id limit 0,30';
			break;

		default:
			break;
		}

		$hlist = array();
		$station_m = new StationModel();

		if (!empty($wssql)) {
			$stations = $station_m->dquery($wssql);

			foreach ($stations as $row ) {
				$hlist[] = $row['hostname'];
			}

			$wsql .= ' where t1.creater in (\'' . join('\',\'', $hlist) . '\')';
		}

		if ($auth->isSuperAdmin()) {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 LEFT JOIN zm_danwei t2 ON t1.danwei=t2.bh';
			$sql = 'SELECT t1.id, t1.serverurl, t1.thumb,t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime,t1.major from zm_video_list t1 LEFT JOIN zm_danwei t2 ON t1.danwei=t2.bh';
		}
		else if ($auth->canViewStair()) {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\'';
			$sql = 'SELECT t1.id, t1.serverurl, t1.thumb,t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime,t1.major from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\'';
		}
		else {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\' and t1.hostcode = \'' . $_SESSION['hostcode'] . '\'';
			$sql = 'SELECT t1.id, t1.serverurl, t1.thumb,t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime,t1.major from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\' and t1.hostcode = \'' . $_SESSION['hostcode'] . '\'';
		}

		$sql_count .= $wsql;
		$sql .= $wsql;
		$rs = $media_m->dquery($sql_count);
		$count = $rs[0]['count'];

		if ($count == 0) {
		}
		else {
			if (!is_numeric($lines)) {
				$lines = 16;
			}

			(!is_numeric($page) || ($page < 1)) && ($page = 1);
			$pageNums = ceil($count / $lines);
			if ($pageNums && ($pageNums < $page)) {
				$page = $pageNums;
			}

			$start = ($page - 1) * $lines;
			$limit = 'LIMIT ' . $start . ',' . $lines;
			$sql .= ' order by t1.createdate desc ' . $limit;
			$this->_data['sql'] = $sql;
			$medias = $media_m->dquery($sql);
			$media_cfg = Zhimin::g('media_type');
			$station_m = new StationModel();
			$arr_urlinfo = $station_m->GetAllStationServerUrl();

			foreach ($medias as &$media ) {
				$thumburl_def = '';
				$isaudio = false;
				$filetype = strtolower($media['filetype']);

				if (in_array($filetype, $media_cfg['video'])) {
					$thumburl_def = Zhimin::g('assets_uri') . 'images/video.png';
				}
				else if (in_array($filetype, $media_cfg['audio'])) {
					$thumburl_def = Zhimin::g('assets_uri') . 'images/voice.png';
					$isaudio = true;
				}
				else if (in_array($filetype, $media_cfg['photo'])) {
					$thumburl_def = Zhimin::g('assets_uri') . 'images/picture.png';
				}

				$media['thumburl_def'] = $thumburl_def;

				if (!$isaudio) {
					if (!empty($arr_urlinfo[$media['serverurl']])) {
						$path = str_replace('media', '', $media['thumb']);
						$path = ltrim($path, '/');
						$media['thumburl'] = $arr_urlinfo[$media['serverurl']] . $path;
					}
					else {
						$media['thumburl'] = $thumburl_def;
					}
				}
				else {
					$media['thumburl'] = $thumburl_def;
				}
			}

			$this->_data['medias'] = $medias;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function search()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
			return;
		}

		$media_m = new MediaModel();
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$danwei = Zhimin::request('danwei');
		$hostname = Zhimin::request('hostname');
		$date_time = Zhimin::request('date_time');
		$unitsyscode = $_SESSION['unitsyscode'];
		$searchtype = Zhimin::request('search_type');
		$unit_m = new UnitModel();

		if (!empty($danwei)) {
			$unitsyscode = $danwei;
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pu.dbh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_syscode($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		$startdate == '';
		$enddate == '';

		if ($date_time == '1') {
			$startdate = get_week_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else if ($date_time == '2') {
			$startdate = get_month_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else if ($date_time == '3') {
			$startdate = Zhimin::request('startdate');
			$enddate = Zhimin::request('enddate');
		}

		$hostcode = Zhimin::request('hostcode');
		$hostbody = Zhimin::request('hostbody');
		$main_media = Zhimin::request('main_media');
		$main_video = Zhimin::request('main_video');
		$key = Zhimin::request('key');
		$biaozhu = Zhimin::request('biaozhu');
		$biaozhutype = Zhimin::request('biaozhutype');
		$filetype = Zhimin::request('filetype');
		$this->url_base .= '&danwei=' . urlencode($danwei) . '&hostname=' . urlencode($hostname);
		$this->url_base .= '&hostcode=' . urlencode($hostcode) . '&hostbody=' . urlencode($hostbody);
		$this->url_base .= '&main_media=' . urlencode($main_media) . '&main_video=' . urlencode($main_video);
		$this->url_base .= '&key=' . urlencode($key) . '&biaozhu=' . urlencode($biaozhu);
		$this->url_base .= '&biaozhutype=' . urlencode($biaozhutype) . '&filetype=' . urlencode($filetype) . '&startdate=' . urlencode($startdate);
		$this->url_base .= '&enddate=' . urlencode($enddate) . '&date_time=' . urlencode($date_time) . '&search_type=' . urlencode($searchtype);
		$wsql = '';
		$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $unitsyscode . '%\'';
		$sql = 'SELECT t1.id, t1.hostname, t1.serverurl, t1.thumb, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime,t1.major from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $unitsyscode . '%\'';
		$wssql = '';

		switch (Zhimin::g('zhimintype')) {
		case 1:
			$wssql = 'select hostname from zm_hostip order by id limit 0,3';
			break;

		case 2:
			$wssql = 'select hostname from zm_hostip order by id limit 0,30';
			break;

		default:
			break;
		}

		$hlist = array();
		$station_m = new StationModel();

		if (!empty($wssql)) {
			$stations = $station_m->dquery($wssql);

			foreach ($stations as $row ) {
				$hlist[] = $row['hostname'];
			}

			$wsql .= ' where t1.creater in (\'' . join('\',\'', $hlist) . '\')';
		}

		if (!$auth->isSuperAdmin() && !$auth->canViewStair()) {
			$wsql .= ' and t1.hostcode = \'' . $_SESSION['hostcode'] . '\'';
		}

		if ($startdate != '') {
			$startdate_tmp = $startdate . ' 00:00:00';
			$wsql .= ' and t1.createdate >= \'' . $startdate_tmp . '\'';
		}

		if ($enddate != '') {
			$enddate_tmp = $enddate . ' 23:59:59';
			$wsql .= ' and t1.createdate <= \'' . $enddate_tmp . '\'';
		}

		if ($hostname != '') {
			$wsql .= ' and t1.hostname = \'' . $hostname . '\'';
		}

		if ($hostcode != '') {
			$wsql .= ' and t1.hostcode = \'' . $hostcode . '\'';
		}

		if ($hostbody != '') {
			$wsql .= ' and t1.hostbody = \'' . $hostbody . '\'';
		}

		if (($main_video != '') && ($main_video != '-1')) {
			$wsql .= ' and t1.major = ' . $main_video;
		}

		if (($biaozhu != '') && ($biaozhu != '-1')) {
			$wsql .= ' and t1.is_flg = ' . $biaozhu;
		}

		if ($filetype != '') {
			$wsql .= ' and t1.sort = \'' . $filetype . '\'';
		}

		$media_cfg = Zhimin::g('media_type');

		if (!is_null($main_media)) {
			switch ($main_media) {
			case '1':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['video'])) . '\')';
				break;

			case '2':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['audio'])) . '\')';
				break;

			case '3':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['photo'])) . '\')';
				break;

			default:
				break;
			}
		}

		$biao_id = 0;
		$sqlbiaozhu = 'SELECT video_id from zm_video_list_flg ';
		if (($key != '文件名、号牌号码、当事人、地点') && ($key != '')) {
			$wsql .= ' and t1.note like \'%' . $key . '%\' ';
		}

		if ($biaozhutype != '') {
			if ($biao_id == 0) {
				$sqlbiaozhu .= ' where type = \'' . $biaozhutype . '\'';
			}
			else {
				$sqlbiaozhu .= ' and type = \'' . $biaozhutype . '\'';
			}

			$biao_id = $biao_id + 1;
		}

		if (0 < $biao_id) {
			$wsql .= ' and t1.id in (' . $sqlbiaozhu . ')';
		}

		$sql_count .= $wsql;
		$sql .= $wsql;
		$rs = $media_m->dquery($sql_count);
		$count = $rs[0]['count'];

		if ($count == 0) {
		}
		else {
			if (!is_numeric($lines)) {
				$lines = 16;
			}

			(!is_numeric($page) || ($page < 1)) && ($page = 1);
			$pageNums = ceil($count / $lines);
			if ($pageNums && ($pageNums < $page)) {
				$page = $pageNums;
			}

			$start = ($page - 1) * $lines;
			$limit = 'LIMIT ' . $start . ',' . $lines;
			$sql .= ' order by t1.createdate desc ' . $limit;
			$this->_data['sql'] = $sql;
			$medias = $media_m->dquery($sql);
		}

		foreach ($medias as $k => $v ) {
			$media_m->query('', 'update  ' . $media_m->table() . '  set  modtime =\'' . time() . '\', querys = querys +1 where  id =\'' . $v['id'] . '\'');
		}

		$station_m = new StationModel();
		$arr_urlinfo = $station_m->GetAllStationServerUrl();

		foreach ($medias as &$media ) {
			$thumburl_def = '';
			$isaudio = false;
			$filetype = strtolower($media['filetype']);

			if (in_array($filetype, $media_cfg['video'])) {
				$thumburl_def = Zhimin::g('assets_uri') . 'images/video.png';
			}
			else if (in_array($filetype, $media_cfg['audio'])) {
				$thumburl_def = Zhimin::g('assets_uri') . 'images/voice.png';
				$isaudio = true;
			}
			else if (in_array($filetype, $media_cfg['photo'])) {
				$thumburl_def = Zhimin::g('assets_uri') . 'images/picture.png';
			}

			$media['thumburl_def'] = $thumburl_def;

			if (!$isaudio) {
				if (!empty($arr_urlinfo[$media['serverurl']])) {
					$path = str_replace('media', '', $media['thumb']);
					$path = ltrim($path, '/');
					$media['thumburl'] = $arr_urlinfo[$media['serverurl']] . $path;
				}
				else {
					$media['thumburl'] = $thumburl_def;
				}
			}
			else {
				$media['thumburl'] = $thumburl_def;
			}
		}

		$this->_data['medias'] = $medias;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function all_download()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDown($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有下载的权限！', 'url' => $this->url_base);
			return;
		}

		$this->_hasView = false;
		$post_id_string = Zhimin::request('idarray');
		$post_id_array = explode(',', $post_id_string);
		$document_root = Zhimin::g('document_root');
		$location_root = $document_root . 'upload/media_txt/';
		$download_string = '';
		$new_path = $location_root . time() . '.txt';
		$media_m = new MediaModel();
		$station_m = new StationModel();
		$arr_urlinfo = $station_m->GetAllStationServerUrl();

		for ($i = 0; $i < count($post_id_array); $i++) {
			$post_id = $post_id_array[$i];

			if ($post_id == '-1') {
				continue;
			}

			$media = $media_m->read($post_id, 'id,filename,bfilename,filetype,serverurl,playposition,saveposition,creater');

			if (empty($media)) {
				exit('非法操作！');
			}

			$downid = $media['id'];
			$downfile = MediaUtils::media_url($media['saveposition'], $media['serverurl']);
			$path = str_replace('media', '', $media['saveposition']);
			$path = ltrim($path, '/');
			$media['thumburl'] = $arr_urlinfo[$media['serverurl']] . $path;
			$download_string .= $downfile . "\r\n";
			$media_m->dquery('UPDATE zm_video_list set downloads=downloads+1 WHERE id=' . $post_id);
			$log_m = new LogModel();
			$log_m->writeLog('013', '下载文件,文件名称为:' . $media['bfilename'], $media['bfilename']);
		}

		if (!file_exists($location_root)) {
			if (!mkdir($location_root, 511)) {
				exit('upload files directory does not exist and creation failed');
			}
		}

		$stream = fopen($new_path, 'w+');
		fwrite($stream, $download_string);
		$file = fopen($new_path, 'r');
		$file_name = date('YmdHi', time()) . '.txt';
		header('Content-type: application/octet-stream');
		header('Accept-Ranges: bytes');
		header('Accept-Length: ' . filesize($new_path));
		header('Content-Disposition: attachment;filename=' . $file_name);
		echo fread($file, filesize($new_path));
		fclose($file);
		exit();
	}
}


?>

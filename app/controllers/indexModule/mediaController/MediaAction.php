<?php

class MediaAction extends Action
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
		$media_cfg = Zhimin::g('media_type');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有删除的权限！', 'url' => $this->url_base);
			return;
		}

		$this->_hasView = 0;
		$log_m = new LogModel();
		$media_m = new MediaModel();
		$idarray = Zhimin::param('idarray', 'post');
		$insertdel = 'INSERT INTO zm_video_list_del SELECT * from zm_video_list where id in(' . $idarray . ') and major=0';
		$rs = $media_m->dquery($insertdel);

		//modify:add delete file action
		//$insertdel = 'DELETE from zm_video_list where id in(' . $idarray . ') and major=0';
		//$rs = $media_m->dquery($insertdel);

		$document_root = Zhimin::g('document_root');
		$filepath = "";
		$medias = $media_m->fetchAll('', 'SELECT filetype, thumb, saveposition from zm_video_list where id in(' . $idarray . ') and major=0');
		foreach ($medias as $row_c ) {
			$filetype = strtolower(trim($row_c['filetype']));
			$thumb = trim($row_c['thumb']);
			$saveposition = trim($row_c['saveposition']);
			if (in_array($filetype, $media_cfg['video']) || in_array($filetype, $media_cfg['audio'])) {
				$filepath = $document_root . "media/" . $saveposition;
			}
			if (in_array($filetype, $media_cfg['photo'])) {
				$filepath = $document_root . $saveposition;
			}
			//del video audio jpg
			@unlink($filepath);
			//$log_m->writeLog('0xx', '批量删除video audio jpg文件,文件路径为:' . $filepath);

			//del jpg thumb
			$filepath = $document_root . $thumb;
			@unlink($filepath);
			//$log_m->writeLog('1xx', '批量删除jpg thumb文件,文件路径为:' . $filepath);
		}
		$insertdel = 'DELETE from zm_video_list where id in(' . $idarray . ') and major=0';
		$rs = $media_m->dquery($insertdel);
		//

		$log_m->writeLog('015', '批量删除文件,记录ID为:' . $idarray);
		echo 0;
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
			$media = $media_m->read($post_id, 'id,filename,bfilename,filetype,serverurl,playposition,saveposition,source_type,media_play_url,creater');

			if (empty($media)) {
				exit('非法操作！');
			}

			$downid = $media['id'];
			$station_m = new StationModel();
			$arr_urlinfo = $station_m->GetAllStationServerUrl();
			$path = str_replace('media', '', $media['playposition']);
			$path = ltrim($path, '/');

			if ($media['source_type'] == '1') {
				$downfile = $media['media_play_url'];
			}
			else {
				$downfile = $arr_urlinfo[$media['serverurl']] . $path;
			}

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

		/* 去掉对采集站的获取，以便显示在后台上传的媒体文件
		if (!empty($wssql)) {
			$stations = $station_m->dquery($wssql);

			foreach ($stations as $row ) {
				$hlist[] = $row['hostname'];
			}

			$wsql .= ' where t1.creater in (\'' . join('\',\'', $hlist) . '\')';
		}
		*/

		if ($auth->isSuperAdmin()) {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 LEFT JOIN zm_danwei t2 ON t1.danwei=t2.bh';
			$sql = 'SELECT t1.id,t1.biaozhu_location, t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filename, t1.bfilename, t1.filetype, t1.is_flg, t1.playtime,t1.major, t1.note from zm_video_list t1 LEFT JOIN zm_danwei t2 ON t1.danwei=t2.bh';
		}
		else if ($auth->canViewStair()) {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\'';
			$sql = 'SELECT t1.id,t1.biaozhu_location, t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filename, t1.bfilename, t1.filetype, t1.is_flg, t1.playtime,t1.major, t1.note from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\'';
		}
		else {
			$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\' and t1.hostcode = \'' . $_SESSION['hostcode'] . '\'';
			$sql = 'SELECT t1.id,t1.biaozhu_location, t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filename, t1.bfilename, t1.filetype, t1.is_flg, t1.playtime,t1.major, t1.note from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $_SESSION['unitsyscode'] . '%\' and t1.hostcode = \'' . $_SESSION['hostcode'] . '\'';
		}
		$sql_count .= $wsql;//echo "<p></p>".$sql_count."<p></p>";
		$sql .= $wsql;//echo "<p></p>".$sql."<p></p>";
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
			// echo '<pre>';print_r($sql);exit;
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
		$update_date_time = Zhimin::request('update_date_time');
		$searchtype = Zhimin::request('search_type');
		$unitsyscode = $_SESSION['unitsyscode'];
		$unit_m = new UnitModel();
		$logStr = '查询文件，条件为：';
		if (!empty($danwei)) {
			$unitsyscode = $danwei;
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pu.dbh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_syscode($danwei);
			$this->_data['select_unit'] = $select_unit;
			$dw_sql = 'select * from zm_danwei where unitsyscode like \''.$danwei.'\'';
			$danwei_m = new DanweiModel();
			$dw_res = $danwei_m->dquery($dw_sql);
			$logStr .= '单位：' . $dw_res[0]['dname'];
		}else{
			$logStr .= '单位：空';
		}

		$startdate == '';
		$enddate == '';

		//创建时间
		if ($date_time == '1') {
			$startdate = get_week_first_day();
			$enddate = date('Y-m-d H:i:s', time());
			$logStr .= '，拍摄时间：本周';
		}
		else if ($date_time == '2') {
			$startdate = get_month_first_day();
			$enddate = date('Y-m-d H:i:s', time());
			$logStr .= '，拍摄时间：本月';
		}
		else if ($date_time == '3') {
			$startdate = Zhimin::request('startdate');
			$enddate = Zhimin::request('enddate');
			$logStr .= '，拍摄时间：'.$startdate.'-'.$enddate;
		}else if($date_time == ''){
			$logStr .= '，拍摄时间：空';
		}

		//上传时间
		$update_startdate == '';
		$update_enddate == '';
		if ($update_date_time == '1') {
			$update_startdate = get_week_first_day();
			$update_enddate = date('Y-m-d H:i:s', time());
			$logStr .= '，上传时间：本周';
		}
		else if ($update_date_time == '2') {
			$update_startdate = get_month_first_day();
			$update_enddate = date('Y-m-d H:i:s', time());
			$logStr .= '，上传时间：本月';
		}
		else if ($update_date_time == '3') {
			$update_startdate = Zhimin::request('update_startdate');
			$update_enddate = Zhimin::request('update_enddate');
			$logStr .= '，上传时间：'.$update_startdate.'-'.$update_enddate;
		}else if($update_date_time == ''){
			$logStr .= '，上传时间：空';
		}

		$hostcode = Zhimin::request('hostcode');
		$hostbody = Zhimin::request('hostbody');
		$main_media = Zhimin::request('main_media');
		$main_video = Zhimin::request('main_video');
		$biaozhu_location = Zhimin::request('biaozhu_location');
		$key = Zhimin::request('key');
		$biaozhu = Zhimin::request('biaozhu');
		$biaozhutype = Zhimin::request('biaozhutype');
		$filetype = Zhimin::request('filetype');
		$this->url_base .= '&danwei=' . urlencode($danwei) . '&hostname=' . urlencode($hostname);
		$this->url_base .= '&hostcode=' . urlencode($hostcode) . '&hostbody=' . urlencode($hostbody);
		$this->url_base .= '&main_media=' . urlencode($main_media) . '&main_video=' . urlencode($main_video);
		$this->url_base .= '&key=' . urlencode($key) . '&biaozhu=' . urlencode($biaozhu);
		$this->url_base .= '&biaozhutype=' . urlencode($biaozhutype) . '&filetype=' . urlencode($filetype);
		$this->url_base .= '&startdate=' . urlencode($startdate) . '&enddate=' . urlencode($enddate) . '&date_time=' . urlencode($date_time);
		$this->url_base .= '&update_startdate=' . urlencode($update_startdate) . '&update_enddate=' . urlencode($update_enddate) . '&update_date_time=' . urlencode($update_date_time);
		$this->url_base .= '&search_type=' . urlencode($searchtype) . '&biaozhu_location=' . urlencode($biaozhu_location);
		// echo $biaozhu_location;exit;
		$wsql = '';
		$sql_count = 'SELECT count(1) as count from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $unitsyscode . '%\'';
		$sql = 'SELECT t1.id,t1.biaozhu_location, t1.hostname, t1.hostcode, t2.dname, t1.hostbody, t1.createdate, t1.filename, t1.bfilename, t1.filetype, t1.is_flg, t1.playtime,t1.major, t1.note from zm_video_list t1 JOIN zm_danwei t2 ON t1.danwei=t2.bh and t2.unitsyscode like \'' . $unitsyscode . '%\'';
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

		//创建时间
		if ($startdate != '') {
			$startdate_tmp = $startdate . ' 00:00:00';
			$wsql .= ' and t1.createdate >= \'' . $startdate_tmp . '\'';
		}

		if ($enddate != '') {
			$enddate_tmp = $enddate . ' 23:59:59';
			$wsql .= ' and t1.createdate <= \'' . $enddate_tmp . '\'';
		}

		//上传时间
		if ($update_startdate != '') {
			$update_startdate_tmp = $update_startdate . ' 00:00:00';
			$wsql .= ' and t1.uploaddate >= \'' . $update_startdate_tmp . '\'';
		}

		if ($update_enddate != '') {
			$update_enddate_tmp = $update_enddate . ' 23:59:59';
			$wsql .= ' and t1.uploaddate <= \'' . $update_enddate_tmp . '\'';
		}

		if ($hostname != '') {
			$wsql .= ' and t1.hostname = \'' . $hostname . '\'';
			$logStr .= '，警员姓名：' . $hostname;
		}else{
			$logStr .= '，警员姓名：空';
		}

		if ($hostcode != '') {
			$wsql .= ' and t1.hostcode = \'' . $hostcode . '\'';
			$logStr .= '，警员编号：' . $hostcode;
		}else{
			$logStr .= '，警员编号：空';
		}

		if ($hostbody != '') {
			$wsql .= ' and t1.hostbody = \'' . $hostbody . '\'';
			$logStr .= '，设备编号：' . $hostbody;
		}else{
			$logStr .= '，设备编号：空';
		}

		if (($main_video != '') && ($main_video != '-1')) {
			$wsql .= ' and t1.major = ' . $main_video;
		}
		$mainStr = $main_video=='-1' ? '不限' : ($main_video=='0' ? '否' : '是' );
		$logStr .= '，重要视频：' . $mainStr;

		if (($biaozhu_location != '') && ($biaozhu_location != '-1')) {
			$wsql .= ' and t1.biaozhu_location = ' . $biaozhu_location;
		}
		$biaozhuStr = $biaozhu_location=='-1' ? '不限' : ($biaozhu_location=='0' ? '未标注' : ($biaozhu_location=='1' ? '执法仪标注' : '后台标注') );
		$logStr .= '，标注位置：' . $biaozhuStr;

		if (($biaozhu != '') && ($biaozhu != '-1')) {
			$wsql .= ' and t1.is_flg = ' . $biaozhu;
		}
		$bzStr = $biaozhu=='-1' ? '不限' : ($biaozhu=='0' ? '未标注' : '已标注');
		$logStr .= '，标注位置：' . $bzStr;

		if ($filetype != '') {
			$wsql .= ' and t1.sort = \'' . $filetype . '\'';
			switch ($filetype) {
				case '100':
					$logStr .= '，文件类型：执勤执法类';
					break;
				case '103':
					$logStr .= '，文件类型：事故处理类';
					break;
				case '104':
					$logStr .= '，文件类型：车驾管类';
					break;
				case '105':
					$logStr .= '，文件类型：监督管理类';
					break;
				case '106':
					$logStr .= '，文件类型：其他类';
					break;
			}
		}else{
			$logStr .= '，文件类型：不限';
		}

		if (!is_null($main_media)) {
			$media_cfg = Zhimin::g('media_type');

			switch ($main_media) {
			case '1':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['video'])) . '\')';
				$logStr .= '，媒体类型：视频';
				break;

			case '2':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['audio'])) . '\')';
				$logStr .= '，媒体类型：音频';
				break;

			case '3':
				$wsql .= '  and t1.filetype in (\'' . join('\',\'', array_change_value_case($media_cfg['photo'])) . '\')';
				$logStr .= '，媒体类型：图片';
				break;

			default:
				$logStr .= '，媒体类型：不限';
				break;
			}
		}

		$biao_id = 0;
		$sqlbiaozhu = 'SELECT video_id from zm_video_list_flg ';
		if (($key != '文件名称、文件描述') && ($key != '')) {
			$wsql .= ' and (t1.note like \'%' . $key . '%\' or t1.bfilename like \'%' . $key . '%\') ';
			$logStr .= '，关键字：' . $key;
		}else{
			$logStr .= '，关键字：空';
		}

		if ($biaozhutype != '') {
			if ($biao_id == 0) {
				$sqlbiaozhu .= ' where type = \'' . $biaozhutype . '\'';
			}
			else {
				$sqlbiaozhu .= ' and type = \'' . $biaozhutype . '\'';
			}

			$biao_id = $biao_id + 1;

			switch ($biaozhutype) {
				case '101':
					$logStr .= '，标注类型：简易处罚';
					break;
				case '113':
					$logStr .= '，标注类型：非现场处罚';
					break;
				case '114':
					$logStr .= '，标注类型：强制措施';
					break;
				case '115':
					$logStr .= '，标注类型：接处警';
					break;
				case '116':
					$logStr .= '，标注类型：车管';
					break;
				case '117':
					$logStr .= '，标注类型：窗口';
					break;
				case '118':
					$logStr .= '，标注类型：其他';
					break;
			}
		}else{
			$logStr .= '，标注类型：不限';
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

		$this->_data['medias'] = $medias;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		$log_m = new LogModel();
		$log_m->writeLog('132', $logStr);
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

			$media = $media_m->read($post_id, 'id,filename,bfilename,filetype,serverurl,playposition,saveposition,source_type,media_play_url,creater');

			if (empty($media)) {
				exit('非法操作！');
			}

			$downid = $media['id'];
			$path = str_replace('media', '', $media['saveposition']);
			$path = ltrim($path, '/');

			if ($media['source_type'] == '1') {
				$downfile = $media['media_play_url'];
			}
			else {
				$downfile = $arr_urlinfo[$media['serverurl']] . $path;
			}

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

	//将秒数转换成时分秒（支持超过24小时的秒数转换）
	function changeTimeType($seconds){
		if ($seconds > 3600){
			$hours = intval($seconds/3600);
			$minutes = $seconds % 3600;
			$time = $hours.":".gmstrftime('%M:%S', $minutes);
		}else{
			$time = gmstrftime('%H:%M:%S', $seconds);
		}
		return $time;
	}
}


?>

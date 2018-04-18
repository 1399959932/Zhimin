<?php

class MedialogAction extends Action
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

		//将标注类型3的值存入数组
		$restypes = $sysconf_m->get_by_type('3');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['biaozhu_types'] = $arr_types;
		//

		//将文件类型1的值存入数组
		$restypes = $sysconf_m->get_by_type('1');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['file_types'] = $arr_types;
		//

		//modify
		//将号码类型5的值存入数组
		$restypes = $sysconf_m->get_by_type('5');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['code_types'] = $arr_types;
		//

		switch ($action) {
		case 'media_edit':
			$this->media_edit();
			break;

		case 'mediaflg_edit':
			$this->mediaflg_edit();
			break;

		case 'media_down':
			$this->mediadown();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{

		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitPlay($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
			return;
		}

		$media_m = new MediaModel();
		$post_id = intval(Zhimin::param('id', 'get'));
		$sql = 'SELECT t1.danwei, t1.filename,t1.playposition, t1.serverurl, t1.id, t1.bfilename, t1.hostname, t1.creater, t1.uploaddate, t1.downloads,t1.opens, t1.querys, t1.hot, t1.major, t1.save_date, t1.note , t1.filelen,t1.hostcode, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime, t1.sort,t1.media_play_url, t1.source_type, t1.biaozhu_location  from zm_video_list t1 where t1.id = \'' . $post_id . '\'';
		$media = $media_m->fetchOne('', $sql);
		$sql = 'SELECT   t2.dname from  zm_danwei t2 where t2.bh = \'' . $media['danwei'] . '\'';
		$media_danwei = $media_m->fetchOne('', $sql);
		// echo '<pre>';print_r($media_danwei);exit;
		$this->_data['medias'] = $media;
		$this->_data['media_danwei'] = $media_danwei['dname'];
		$sql = 'SELECT * FROM_UNIXTIME(createdate) as cjsj from zm_video_list_flg where video_id = \'' . $post_id . '\'';
		$videoflg = $media_m->fetchOne('', $sql);
		$this->_data['video_flg'] = $videoflg;

		//modify
		$sql = 'SELECT hostip from zm_hostip where hostname = \'' . $media['creater'] . '\'';
		$res = $media_m->fetchOne('', $sql);
		$this->_data['hostip'] = $res['hostip'];//echo($sql);

		$sql = 'SELECT * from zm_video_gps t where t.filename = \'' . $media['filename'] . '\' and t.packgps != \'\'';
		$gps_info = $media_m->fetchOne('', $sql);

		if (empty($gps_info)) {
			$this->_data['gps_flg'] = '0';
		}
		else {
			$this->_data['gps_flg'] = '1';
		}

		$media_m->dquery('update `' . $media_m->table() . '` set opens=opens+1 where id=' . $media['id']);
		$station_m = new StationModel();
		$arr_urlinfo = $station_m->GetAllStationServerUrl();
		$path = str_replace('media', '', $media['playposition']);
		$path = ltrim($path, '/');

		if ($media['source_type'] == '1') {
			$playurl = $media['media_play_url'];
		}
		else {
			//$playurl = $arr_urlinfo[$media['serverurl']] . $path;

			//modify
			if(!empty($media['serverurl'])){
				$playurl = $arr_urlinfo[$media['serverurl']] . $path;
			}else{
				$playurl = $media['playposition'];
			}
		}

		$this->_data['playurl'] = $playurl;
		// 上一个
		// $sql_prenext = 'SELECT t.id from zm_video_list t where t.createdate<=\'' . $media['createdate'] . '\' and t.hostcode = \'' . $media['hostcode'] . '\'  and t.id != \'' . $media['id'] . '\' and t.filetype=\'' . $media['filetype'] . '\' ORDER BY t.createdate DESC limit 1';
		// $res_prenext = $media_m->fetchOne('', $sql_prenext);
		$res_pre = array();
		$sqlList = Zhimin::request('sql');
		$this->_data['sqlList'] = $sqlList;
		$res = $media_m->dquery($sqlList);
		foreach ($res as $key => $value) {
			if($value['id'] == $post_id){
				if($key==0){
					$res_pre = $res[$key];
				}else{
					$res_pre = $res[$key-1];
				}
			}
		}
		$this->_data['pre_id'] = $res_pre['id'];
		// 下一个
		// $sql_prenext = 'SELECT t.id from zm_video_list t where t.createdate>=\'' . $media['createdate'] . '\' and t.hostcode = \'' . $media['hostcode'] . '\'  and t.id != \'' . $media['id'] . '\' and t.filetype=\'' . $media['filetype'] . '\' ORDER BY t.createdate limit 1';
		// $res_prenext = $media_m->fetchOne('', $sql_prenext);
		$res_next = array();
		foreach ($res as $key => $value) {
			if($value['id'] == $post_id){
				if($key==15){
					$res_next = $res[$key];
				}else{
					$res_next = $res[$key+1];
				}
			}
		}
		// echo '<pre>';print_r($res_next);exit;
		$this->_data['next_id'] = $res_next['id'];

		$click_count_m = new ClickcountModel();
		$client_ip = NetUtils::get_client_ip();
		$click_count_m->insertRow(array('filename' => $media['filename'], 'ip' => $client_ip, 'click_date' => time()));
		$hot_time = Zhimin::g('hot_time');
		$hot_count = Zhimin::g('hot_count');

		if ($media['hot'] != 1) {
			$click_count_sql = 'select count(distinct `ip`) as `click_count` from `zm_click_count` where `filename`=\'' . $media['filename'] . '\' and `click_date`>=(' . time() . '-' . $hot_time . '*60*60)';
			$click_count_record = $click_count_m->dquery($click_count_sql);

			if ($hot_count <= $click_count_record[0]['click_count']) {
				$media_m->updateRow('id=' . $media['id'], array('hot' => 1, 'moder' => $_SESSION['username'], 'modtime' => time()));
			}
		}

		$log_m = new LogModel();
		$log_m->writeLog('011', '播放文件,文件名称为:' . $media['bfilename'], $media['bfilename']);
		//日志信息
		$wsql .= ' and `pl`.`logtime` between \'' . strtotime($sdate1) . '\' and  \'' . strtotime($edate1) . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $log_m->table() . '` as `pl` left join `zm_danwei` as `pd` on `pl`.`unit_no`=`pd`.`bh`  where ' . $wsql;
		$rs = $log_m->fetchOne('', $sql);
		$count = $rs['count'];

		if (!is_numeric($lines)) {
			$lines = 15;
		}

		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$pageNums = ceil($count / $lines);
		if ($pageNums && ($pageNums < $page)) {
			$page = $pageNums;
		}

		$start = ($page - 1) * $lines;
		$limit = 'LIMIT ' . $start . ',' . $lines;
		
		$sql = "SELECT `pl`.*,`pd`.`dname` FROM `zm_log` as `pl` left join `zm_danwei` as `pd` on `pl`.`unit_no`=`pd`.`bh` where `pd`.`id`='{$post_id}'";
		$logs = $log_m->dquery($sql);
		foreach($logs as $k=>$v){
			foreach($v as $key=>$val){
				$date[$key]=$val;
			}
		}
		// var_dump($date);
		$this->_data['dates'] = $date;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function media_edit()
	{
		$this->_hasView = 0;
		$media_m = new MediaModel();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有编辑的权限！', 'url' => $this->url_base);
			return;
		}

		$fileid = intval(Zhimin::param('fileid', 'post'));
		$save_day = Zhimin::param('save_day', 'post');
		$note = Zhimin::param('media_note', 'post');
		$main_video = Zhimin::param('main_video', 'post');
		$filetype = Zhimin::param('filetype', 'post');
		$bfilename = Zhimin::param('bfilename', 'post');
		$media_m->updateRow('id=' . $fileid, array('save_date' => $save_day, 'bfilename' => $bfilename, 'note' => $note, 'major' => $main_video, 'onlyread' => $main_video, 'sort' => $filetype, 'moder' => $_SESSION['username'], 'modtime' => time()));
		$log_m = new LogModel();
		$log_m->writeLog('012', '添加批注,记录ID为:' . $fileid);
		echo 0;
	}

	protected function mediaflg_edit()
	{
		$this->_hasView = 0;
		$media_m = new MediaflgModel();
		$media_m1 = new MediaModel();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有编辑的权限！', 'url' => $this->url_base);
			return;
		}

		$fileid = intval(Zhimin::param('fileid', 'post'));
		$biaozhutype = Zhimin::param('biaozhutype', 'post');
		$data_no = Zhimin::param('data_no', 'post');
		$data_location = Zhimin::param('data_location', 'post');
		$client = Zhimin::param('client', 'post');
		$codetype = Zhimin::param('codetype', 'post');//modify
		$car_no = Zhimin::param('car_no', 'post');
		$caijidate = Zhimin::param('caijidate', 'post');
		$remark = Zhimin::param('remark', 'post');
		if (empty($biaozhutype) || empty($data_no) || empty($data_location) || empty($client) || empty($car_no) || empty($caijidate) || empty($remark)) {
			echo 1;
			return;
		}

		$sql = 'SELECT video_id FROM zm_video_list_flg where video_id = \'' . $fileid . '\'';
		$res = $media_m->fetchOne('', $sql);

		if (!empty($res)) {
			//modify
			//$media_m->updateRow('video_id=' . $fileid, array('type' => $biaozhutype, 'data_no' => $data_no, 'data_location' => $data_location, 'client' => $client, 'car_no' => $car_no, 'createdate' => strtotime($caijidate), 'remark' => $remark, 'update_user' => $_SESSION['username'], 'update_date' => time()));
			$media_m->updateRow('video_id=' . $fileid, array('type' => $biaozhutype, 'data_no' => $data_no, 'data_location' => $data_location, 'client' => $client, 'codetype' => $codetype, 'car_no' => $car_no, 'createdate' => strtotime($caijidate), 'remark' => $remark, 'update_user' => $_SESSION['username'], 'update_date' => time()));
		}
		else {
			//modify
			//$media_m->insertRow(array('video_id' => $fileid, 'type' => $biaozhutype, 'data_no' => $data_no, 'data_location' => $data_location, 'client' => $client, 'car_no' => $car_no, 'createdate' => strtotime($caijidate), 'remark' => $remark, 'update_user' => $_SESSION['username'], 'update_date' => time()));
			$media_m->insertRow(array('video_id' => $fileid, 'type' => $biaozhutype, 'data_no' => $data_no, 'data_location' => $data_location, 'client' => $client, 'codetype' => $codetype, 'car_no' => $car_no, 'createdate' => strtotime($caijidate), 'remark' => $remark, 'update_user' => $_SESSION['username'], 'update_date' => time()));
		}

		$media_m1->updateRow('id=' . $fileid, array('is_flg' => '1', 'moder' => $_SESSION['username'], 'modtime' => time()));
		$log_m = new LogModel();
		$log_m->writeLog('012', '修改或添加媒体文件标注信息,记录ID为:' . $fileid);
		echo 0;
	}

	
}


?>

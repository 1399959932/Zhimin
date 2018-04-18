<?php

class VideoAction extends Action
{
	protected $units = array();
	protected $url_base = '';

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

//		switch (1) {
//		default:
			$this->mlist();
			break;
//		}
	}

	protected function mlist()
	{
		$media_m = new MediaModel();
		$post_id = intval(Zhimin::param('id', 'get'));
		$sql = 'SELECT t1.danwei, t1.filename,t1.playposition, t1.serverurl, t1.id, t1.bfilename, t1.hostname, t1.creater, t1.uploaddate, t1.downloads, t1.querys, t1.hot, t1.major, t1.save_date, t1.note , t1.filelen,t1.hostcode, t1.hostbody, t1.createdate, t1.filetype, t1.is_flg, t1.playtime  from zm_video_list t1 where t1.id = \'' . $post_id . '\'';
		$media = $media_m->fetchOne('', $sql);
		$sql = 'SELECT   t2.dname from  zm_danwei t2 where t2.bh = \'' . $media['danwei'] . '\'';
		$media_danwei = $media_m->fetchOne('', $sql);
		$this->_data['medias'] = $media;
		$this->_data['media_danwei'] = $media_danwei['dname'];
		$sql = 'SELECT *, FROM_UNIXTIME(createdate) as cjsj from zm_video_list_flg where video_id = \'' . $post_id . '\'';
		$videoflg = $media_m->fetchOne('', $sql);
		$this->_data['video_flg'] = $videoflg;
		$station_m = new StationModel();
		$arr_urlinfo = $station_m->GetAllStationServerUrl();
		$path = str_replace('media', '', $media['playposition']);
		$path = ltrim($path, '/');
		$playurl = $arr_urlinfo[$media['serverurl']] . $path;
		$this->_data['playurl'] = $playurl;
		$sql_prenext = 'SELECT t.id from zm_video_list t where t.createdate<=\'' . $media['createdate'] . '\' and t.hostcode = \'' . $media['hostcode'] . '\'  and t.id != \'' . $media['id'] . '\' and t.filetype=\'' . $media['filetype'] . '\' ORDER BY t.createdate DESC limit 1';
		$res_prenext = $media_m->fetchOne('', $sql_prenext);
		$this->_data['pre_id'] = $res_prenext['id'];
		$sql_prenext = 'SELECT t.id from zm_video_list t where t.createdate>=\'' . $media['createdate'] . '\' and t.hostcode = \'' . $media['hostcode'] . '\'  and t.id != \'' . $media['id'] . '\' and t.filetype=\'' . $media['filetype'] . '\' ORDER BY t.createdate limit 1';
		$res_prenext = $media_m->fetchOne('', $sql_prenext);
		$this->_data['next_id'] = $res_prenext['id'];
	}
}


?>

<?php

class GetmediaAction extends Action
{
	public $lines = 50;

	public function __construct()
	{
		$this->_hasView = 0;
	}

	protected function _main()
	{
		$media_m = new MediaModel();
		$unit_m = new UnitModel();
		$station_m = new StationModel();
		$media_cfg = Zhimin::g('media_type');
		$page = trim(Zhimin::request('page'));
		$upload_date = trim(Zhimin::request('begin_time'));
		$police_id = trim(Zhimin::request('police_id'));
		$org_code = trim(Zhimin::request('org_code'));
		$wsql = ' where 1=1';

		if (empty($upload_date)) {
			write_log('请求文件数据,时间参数为空', $flg = '0');
			$res = '时间参数为空';
			$total = 0;
			$unit_json = json_encode($res);
			return_log('fail', $total, $unit_json);
			exit();
		}
		else {
			list($y, $m, $d) = explode('-', $upload_date);

			if (!checkdate($m, $d, $y)) {
				write_log('请求文件数据,时间参数格式不对，正确的格式如‘2015-01-12’', $flg = '0');
				$res = '请求文件数据,时间参数格式不对，正确的格式如‘2015-01-12’';
				$total = 0;
				$unit_json = json_encode($res);
				return_log('fail', $total, $unit_json);
				exit();
			}
			else {
				$startdate_tmp = $upload_date . ' 00:00:00';
				$wsql .= ' and t1.uploaddate >= \'' . $startdate_tmp . '\'';
				$enddate_tmp = $upload_date . ' 23:59:59';
				$wsql .= ' and t1.uploaddate <= \'' . $enddate_tmp . '\'';
			}
		}

		if ($police_id != '') {
			$wsql .= ' and t1.hostcode = \'' . $police_id . '\'';
		}

		if ($org_code != '') {
			$wsql .= ' and t1.danwei = \'' . $org_code . '\'';
		}

		$arr_urlinfo = $station_m->GetAllStationServerUrl();
		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$start = ($page - 1) * $this->lines;
		$limit = ' LIMIT ' . $start . ',' . $this->lines;
		write_log('请求文件数据,第' . $page . '页', $flg = '1');
		$sql = 'SELECT t1.id as `data_id`, t1.`createdate` as `capture_date`, t1.hostbody as `device_no`,t1.`uploaddate` as `creation_date`,t1.`filename` as `media_name`,`t1`.`bfilename` as `file_name`,t1.hostcode as `police_no`,t1.`danwei` as `org_no`,t4.dname as `org_name`,t1.filetype as `file_type`,t1.`serverurl`,t1.`playposition`,t1.`thumb`,t1.filelen as file_length,t1.playtime AS file_duration,t1.note AS media_desc,t3.hostip as upload_station_ip,t1.creater as `upload_station`,t1.media_play_url, t1.source_type FROM zm_video_list t1 LEFT JOIN zm_hostip t3 ON t1.creater=t3.hostname  LEFT JOIN zm_danwei t4 ON t1.danwei=t4.bh ';
		$sql .= $wsql;
		$sql .= ' order by t1.createdate desc' . $limit;
		write_log('请求文件数据,sql【' . $sql . '】', $flg = '1');
		$res = $media_m->fetchAll('', $sql);

		foreach ($res as &$media ) {
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

			$path = str_replace('media', '', $media['playposition']);
			$path = ltrim($path, '/');

			if ($media['source_type'] == '1') {
				$playurl = $media['media_play_url'];
			}
			else {
				$playurl = $arr_urlinfo[$media['serverurl']] . $path;
			}

			$media['playurl'] = $playurl;
		}

		$total = count($res);
		write_log('请求文件数据,此次请求总条数【' . $total . '】', $flg = '1');
		$unit_json = json_encode($res);
		return_log('success', $total, $unit_json);
	}
}


?>

<?php

class NorelationAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->title = '文件管理-' . Zhimin::$name;
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有管理员的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$action = Zhimin::request('action');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('edit_a' => 1);
		$this->_data['user_auth'] = $user_auth;

		switch ($action) {
		case 'outo_relation':
			$this->outorelation();
			break;

		case 'relation':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->relationsave();
			}
			else {
				$this->relation();
			}

			break;

		case 'search':
		default:
			$this->mlist();
		}
	}

	protected function outorelation()
	{
		$device_m = new DeviceModel();
		$usecode = Zhimin::param('usecode', 'post');
		$usename = Zhimin::param('usename', 'post');
		$sql = 'SELECT * FROM `' . $device_m->table() . '` WHERE `hostcode`=' . $usecode;
		$device_num = $device_m->fetchOne('', $sql);
		$statement = 'SELECT * FROM `' . $device_m->table() . '` WHERE `hostname`=\'' . $usename . '\'';
		$device_name = $device_m->fetchOne('', $statement);

		if ($usename) {
			if (!$device_name) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '姓名不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usecode = $device_name['hostcode'];
				$danwei = $device_name['danwei'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usecode . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}
		else if ($usecode) {
			if (!$device_num) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能不存在';
				echo json_encode($result_array);
				exit();
			}
			else {
				$usename = $device_num['hostname'];
				$danwei = $device_num['danwei'];
				$result_array['state'] = 'success';
				$result_array['msg'] = $usename . ',' . $danwei;
				echo json_encode($result_array);
				exit();
			}
		}
	}

	protected function relation()
	{
		$media_m = new MediaModel();
		$id = Zhimin::param('id', 'post');
		$media = $media_m->read($id);
		$result_array = array();

		if (empty($media)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '编辑失败';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'success';
			$result_array['id'] = $id;
			$result_array['devicenum'] = $media['hostbody'];
			echo json_encode($result_array);
			exit();
		}
	}

	protected function relationsave()
	{
		$media_m = new MediaModel();
		$device_m = new DeviceModel();
		$result_array = array();
		$id = Zhimin::param('media_id', 'post');
		$hostbody = Zhimin::param('hostbody', 'post');
		$name = trim(Zhimin::param('policename', 'post'));
		$number = trim(Zhimin::param('number', 'post'));
		$danweinumber = trim(Zhimin::param('danweinumber', 'post'));
		$device_res = $device_m->data_by_hostcode($number);

		if ($number == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空！';
			echo json_encode($result_array);
			exit();
		}

		if (empty($device_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不存在！';
			echo json_encode($result_array);
			exit();
		}

		if ($name != $device_res['hostname']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号与' . $_SESSION['zfz_type'] . '姓名不匹配！';
			echo json_encode($result_array);
			exit();
		}

		if ($danweinumber != $device_res['danwei']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号与单位号不匹配！';
			echo json_encode($result_array);
			exit();
		}

		$sql = 'UPDATE zm_video_list t set t.hostcode=\'' . $number . '\', t.hostname=\'' . $name . '\', t.danwei=\'' . $danweinumber . '\', t.modtime=' . time() . ' where ((t.hostcode=\'0000\' or t.danwei=\'0000\') and t.hostbody=\'' . $hostbody . '\') ';
		$res = $media_m->dquery($sql);
		$log_m = new LogModel();
		$log_type = '131';
		$log_message = '文件关联成功，' . $_SESSION['zfz_type'] . '编号：' . $number . '，' . $_SESSION['zfz_type'] . '姓名：' . $name . ',单位编号：' . $danweinumber;
		$log_m->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '关联文件成功';
		echo json_encode($result_array);
		exit();
	}

	protected function mlist()
	{
		$unitcode = Zhimin::request('selid1');
		$usercode = Zhimin::request('selid2');
		$date_time = Zhimin::request('date_time');
		$startdate = Zhimin::request('start_date');
		$enddate = Zhimin::request('end_date');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$stat_m = new PrewarnstatModel();
		$wsql = '(t.hostcode=\'0000\' or t.danwei=\'0000\')';

		if ($date_time == '2') {
			$startdate = date('Y-m-01');
			$enddate = date('Y-m-d');
			$date_time_name = '本月';
		}
		else if ($date_time == '3') {
			if ($startdate == '') {
				$startdate = date('Y-m-d');
			}

			if ($enddate == '') {
				$enddate = date('Y-m-d');
			}
		}
		else {
			$year = date('Y', time());
			$startdate = $year . '-01-01';
			$enddate = date('Y-m-d');
		}

		$wsql .= ' and t.createdate BETWEEN \'' . $startdate . ' 00:00:01\' and \'' . $enddate . ' 23:59:59\'';

		if ($unitcode != '') {
			$wsql .= ' and t.danwei=\'0000\'';
		}

		if ($usercode != '') {
			$wsql .= ' and t.hostcode=\'0000\'';
		}

		$sql_1 = 'SELECT count(*) as num from zm_video_list t LEFT JOIN zm_danwei t2 ON t2.bh=t.danwei' . "\r\n" . '                where ' . $wsql;
		$counts = $stat_m->dquery($sql_1);
		$count = $counts[0]['num'];

		if (!is_numeric($lines)) {
			$lines = 15;
		}

		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$numofpage = ceil($count / $lines);
		if ($numofpage && ($numofpage < $page)) {
			$page = $numofpage;
		}

		$start = ($page - 1) * $lines;
		$limit = 'LIMIT ' . $start . ',' . $lines;
		$sql = 'SELECT t.id, t.filename, t.createdate, t.filetype, t.hostname, t.playtime, t.hostbody, t.thumb, t.major, t.hostcode, t2.dname from zm_video_list t LEFT JOIN zm_danwei t2 ON t2.bh=t.danwei' . "\r\n" . '                where ' . $wsql;
		$sql .= $limit;
		$devices = $stat_m->dquery($sql);
		$this->_data['devices'] = $devices;
		$url['danwei'] = $usecode;
		$url['date_time'] = $unitcode;
		$url['sort'] = $date_time;
		$url['sdate'] = $startdate;
		$url['edate'] = $enddate;
		$this->url_base = suffix_url($this->url_base, $url);
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $numofpage, 'lines' => $lines, 'base_url' => $this->url_base);
	}
}


?>

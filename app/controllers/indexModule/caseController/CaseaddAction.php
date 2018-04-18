<?php

class CaseaddAction extends Action
{
	protected $units = array();
	protected $module_sn = '10031';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$sysconf_m = new SysconfModel();
		$sql = 'SELECT * FROM `' . $sysconf_m->table() . '` WHERE type = 2';
		$configs = $sysconf_m->dquery($sql);

		foreach ($configs as $v ) {
			$casetaxon[$v['confcode']] = $v['confname'];
		}

		$this->_data['casetaxon'] = $casetaxon;

		switch ($action) {
		case 'add':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->add();
			}
			else {
				$this->saveAdd();
			}

			break;

		case 'video':
			$this->videolist();
			break;
		}
	}

	protected function add()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$media_m = new MediaModel();
		$unit_m = new UnitModel();
		$ids = Zhimin::request('ids');
		$sql = 'select pm.*, pd.dname as unitname from `' . $media_m->table() . '` pm LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pm.danwei where pm.id in (\'' . join('\',\'', $ids) . '\')';
		$media_videos = $media_m->dquery($sql);echo $sql;
		$html = '';

		if (empty($media_videos)) {
			$html = '<tr class="td_back">' . "\r\n" . '                <td colspan="6">暂无记录</td>' . "\r\n" . '                </tr>';
			echo $html;
			exit();
		}
		function time2second($seconds)
		{
			$seconds = (int) $seconds;

			if ($seconds < 86400) {
				$format_time = gmstrftime('%H时%M分%S秒', $seconds);
			}
			else {
				$time = explode(' ', gmstrftime('%j %H %M %S', $seconds));
				$format_time = ($time[0] - 1) . '天' . $time[1] . '时' . $time[2] . '分' . $time[3] . '秒';
			}

			return $format_time;
		}

		foreach ($media_videos as $k => $v ) {
			$i = $k + 1;
			$urlplay = Zhimin::buildUrl('casedetail', 'case', 'index', 'id=' . $v['id']);

			if ($v['major'] != '1') {
				$html .= '<tr>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="check_span">' . "\r\n" . '								    	<input name="medias[]" class="ipt-hide" value="' . $v['id'] . '">' . "\r\n" . '								        ' . $i . '' . "\r\n" . '								    </span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a target="_blank" href="' . $urlplay . '">查看</a>' . "\r\n" . '									</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . $v['hostname'] . '(' . $v['hostcode'] . ')</td>' . "\r\n" . '								<td>' . $v['unitname'] . '</td>' . "\r\n" . '								<td>' . $v['hostbody'] . '</td>' . "\r\n" . '								<td>' . $v['createdate'] . '(' . time2second($v['playtime'] / 1000) . ')</td>' . "\r\n" . '    	' . "\r\n" . '							</tr>';
			}
			else {
				$html .= '<tr class="td_back td_red">' . "\r\n" . '								<td>' . "\r\n" . '									<span class="check_span">' . "\r\n" . '								    	<input name="medias[]" class="ipt-hide" value="' . $v['id'] . '">' . "\r\n" . '								        ' . $i . '' . "\r\n" . '								    </span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a target="_blank" href="' . $urlplay . '">查看</a>' . "\r\n" . '									</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . $v['hostname'] . '(' . $v['hostcode'] . ')</td>' . "\r\n" . '								<td>' . $v['unitname'] . '</td>' . "\r\n" . '								<td>' . $v['hostbody'] . '</td>' . "\r\n" . '								<td>' . $v['createdate'] . '(' . time2second($v['playtime'] / 1000) . ')</td>' . "\r\n" . '    	' . "\r\n" . '							</tr>';
			}
		}

		echo $html;
		exit();
	}

	protected function saveAdd()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '没有添加的权限！';
			echo json_encode($result_array);
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$pnumber = Zhimin::request('pnumber');
		$title = Zhimin::request('ptitle');
		$danwei = Zhimin::request('danwei');
		$casetaxon = Zhimin::request('casetaxon');
		$subject = Zhimin::request('subject');
		$note = Zhimin::request('note');
		$occurtime = Zhimin::request('occurtime');
		$brains = Zhimin::request('brains');
		$medias = Zhimin::request('medias');
		$loginuser = $_SESSION['username'];
		$sn = $casetopic_m->get_next_sn($danwei);
		$casetopicsn = $sn;
		$video_ids = implode(',', $medias);
		$occurtime = strtotime($occurtime);
		$sql1 = 'select * from `' . $casetopic_m->table() . '` where pnumber = ' . $pnumber;
		$casetopic = $casetopic_m->dquery($sql1);

		if ($pnumber == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请填写接警单号';
			echo json_encode($result_array);
			exit();
		}

		if (!empty($casetopic)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '接警单号已存在';
			echo json_encode($result_array);
			exit();
		}

		if ($title == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请填写主题';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if ($casetaxon == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择案件类型';
			echo json_encode($result_array);
			exit();
		}

		if ($occurtime == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择发生时间';
			echo json_encode($result_array);
			exit();
		}

		$flag = $casetopic_m->insertRow(array('sn' => $casetopicsn, 'danwei' => $danwei, 'pnumber' => $pnumber, 'casetaxon' => $casetaxon, 'title' => $title, 'brains' => $brains, 'subject' => $subject, 'note' => $note, 'creater' => $loginuser, 'createtime' => time(), 'occurtime' => $occurtime, 'case_videoid' => $video_ids));

		if (0 < intval($flag)) {
			$log_type = '031';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '成功添加案件!';
			$log_m->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加成功！';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function videolist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$this->_hasView = 0;
		$media_m = new MediaModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$danwei = Zhimin::request('danwei');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$page = Zhimin::request('pageNum');
		$where = '1=1';
		$media_typies = Zhimin::g('media_type');
		$where .= '  and pm.filetype in (\'' . join('\',\'', array_change_value_case($media_typies['video'])) . '\')';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pd.bh in (' . $dlist . ')';
		}

		if ($sdate != '') {
			$sdate1 = $sdate . ' 00:00:00';
		}

		if ($edate != '') {
			$edate1 = $edate . ' 23:59:59';
		}

		if ($sdate == '') {
			$startdate = date('Y-m-d', strtotime('-1 days'));
			$sdate1 = $startdate . ' 00:00:00';
		}

		if ($edate == '') {
			$enddate = date('Y-m-d');
			$edate1 = $enddate . ' 23:59:59';
		}

		$where .= ' and pm.createdate between \'' . $sdate1 . '\' and  \'' . $edate1 . '\'';

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pd.bh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_syscode($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $media_m->table() . '` pm ';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pm.danwei';
		$sql .= ' WHERE ' . $where . ' order by pm.createdate desc';
		$rs = $media_m->dquery($sql);
		$count = $rs[0]['count'];
		$arr = array();
		$pageSize = 10;
		$totalPage = ceil($count / $pageSize);
		$startPage = $page * $pageSize;
		$arr['count'] = $count;
		$arr['pageSize'] = $pageSize;
		$arr['totalPage'] = $totalPage;
		$limit = 'LIMIT ' . $startPage . ',' . $pageSize;
		$sql = 'SELECT pm.*, pd.dname as unitname FROM `' . $media_m->table() . '` pm ';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pm.danwei';
		$sql .= ' WHERE ' . $where . ' order by pm.createdate desc ' . $limit;
		$media_videos = $media_m->fetchAll('', $sql);
		$arr['medias'] = $media_videos;
		echo json_encode($arr);
	}
}


?>

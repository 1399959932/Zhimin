<?php

class CasetopicAction extends Action
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
		$auth = Zhimin::getComponent('auth');
		$user_auth = array('add' => 0, 'edit' => 0, 'del' => 0);

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitEdit($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['del'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$sysconf_m = new SysconfModel();
		$sql = 'SELECT * FROM `' . $sysconf_m->table() . '` WHERE type = 2';
		$configs = $sysconf_m->dquery($sql);

		foreach ($configs as $v ) {
			$casetaxon[$v['confcode']] = $v['confname'];
		}

		$this->_data['casetaxon'] = $casetaxon;

		switch ($action) {
		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;

		case 'editvideo':
			$this->editvideo();
			break;

		case 'add':
			$this->addvideo();
			break;

		case 'del':
			$this->del();
			break;

		case 'search':
		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$casetopic_m = new CasetopicModel();
		$sysconf_m = new SysconfModel();
		$unit_m = new UnitModel();
		$danwei = Zhimin::request('danwei');
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('start_date');
		$edate = Zhimin::request('end_date');
		$key = Zhimin::request('key');
		$sort = Zhimin::request('sort');
		$odd_num = Zhimin::request('odd_num');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['danwei'] = $danwei;
		$url['date_time'] = $date_time;
		$url['sort'] = $sort;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$url['odd_num'] = $odd_num;
		$url['key'] = $key;
		$this->url_base = suffix_url($this->url_base, $url);

		if (empty($date_time)) {
			$date_time = '1';
		}

		$this->_data['date_time'] = $date_time;
		$wsql = '1=1';

		if ($odd_num != '') {
			$wsql .= ' and  pcp.pnumber = \'' . $odd_num . '\'';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$wsql .= ' and pd.bh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}
		else {
			$danwei_default = $unit_m->get_down();
			$danwei = $danwei_default['bh'];
		}

		$this->_data['danwei_default'] = $danwei;

		if (!empty($sort)) {
			$wsql .= ' and pcp.casetaxon = \'' . $sort . '\'';
		}

		if (($key != '主题、简要警情') && !empty($key)) {
			$wsql .= ' and (pcp.subject  like  \'%' . $key . '%\' or pcp.title  like  \'%' . $key . '%\')';
		}

		if ($date_time == '2') {
			$sdate1 = get_month_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$sdate1 = strtotime($sdate1);
			$edate1 = strtotime($edate1);
			$date_time_name = '本月';
		}
		else if ($date_time == '3') {
			if ($sdate != '') {
				$sdate1 = $sdate . ' 00:00:00';
				$sdate1 = strtotime($sdate1);
			}

			if ($edate != '') {
				$edate1 = $edate . ' 23:59:59';
				$edate1 = strtotime($edate1);
			}

			if ($sdate == '') {
				$startdate = date('Y-m-d');
				$sdate1 = $startdate . ' 00:00:00';
				$sdate1 = strtotime($sdate1);
			}

			if ($edate == '') {
				$enddate = date('Y-m-d');
				$edate1 = $enddate . ' 23:59:59';
				$edate1 = strtotime($edate1);
			}

			$date_time_name = '一段时间';
		}
		else {
			$sdate1 = get_week_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$sdate1 = strtotime($sdate1);
			$edate1 = strtotime($edate1);
			$date_time_name = '本周';
		}

		$this->_data['date_time_name'] = $date_time_name;
		$wsql .= ' and pcp.occurtime between \'' . $sdate1 . '\' and  \'' . $edate1 . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $casetopic_m->table() . '` pcp ';
		$sql .= ' LEFT JOIN `' . $sysconf_m->table() . '` psc ON psc.confcode=pcp.casetaxon';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pcp.danwei';
		$sql .= ' WHERE ' . $wsql;
		$rs = $casetopic_m->dquery($sql);//echo $sql;
		$count = $rs[0]['count'];

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
		$sql = 'SELECT pcp.*, pd.dname as unitname,psc.confname FROM `' . $casetopic_m->table() . '` pcp ';
		$sql .= ' LEFT JOIN `' . $sysconf_m->table() . '` psc ON psc.confcode=pcp.casetaxon';
		$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pcp.danwei';
		$sql .= ' WHERE ' . $wsql . ' order by pcp.createtime desc ' . $limit;
		$casetopics = $casetopic_m->dquery($sql);//echo '<br />'.$sql;
		$this->_data['datas'] = $casetopics;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function edit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$result_array = array();
		$id = intval(Zhimin::request('id'));
		$casetopic = $casetopic_m->read($id);
		$media_sql = 'select pvl.*,pdw.dname as unitname from `' . $media_m->table() . '` pvl left join zm_danwei pdw on pdw.bh=pvl.danwei where pvl.id in (' . $casetopic['case_videoid'] . ')';
		$medias = $media_m->fetchAll('', $media_sql);
		$casetopic['medias'] = $medias;
		$this->_data['data'] = $casetopic;

		if (empty($casetopic)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '编辑失败';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'success';
			$result_array['id'] = $id;
			$result_array['pnumber'] = $casetopic['pnumber'];
			$result_array['brains'] = $casetopic['brains'];
			$result_array['title'] = $casetopic['title'];
			$result_array['danwei'] = $casetopic['danwei'];
			$result_array['casetaxon'] = $casetopic['casetaxon'];
			$result_array['occurtime'] = date('Y-m-d', $casetopic['occurtime']);
			$result_array['subject'] = $casetopic['subject'];
			$result_array['note'] = $casetopic['note'];
			$result_array['medias'] = $casetopic['medias'];
			echo json_encode($result_array);
			exit();
		}
	}

	protected function editvideo()
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

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pd.bh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_syscode($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if ($sdate != '') {
			$sdate1 = $sdate . ' 00:00:00';
		}

		if ($edate != '') {
			$edate1 = $edate . ' 23:59:59';
		}

		if ($sdate == '') {
			$startdate = date('Y-m-d', 0);
			$sdate1 = $startdate . ' 00:00:00';
		}

		if ($edate == '') {
			$enddate = date('Y-m-d');
			$edate1 = $enddate . ' 23:59:59';
		}

		$where .= ' and pm.createdate between \'' . $sdate1 . '\' and  \'' . $edate1 . '\'';
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

	protected function addvideo()
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
		$media_videos = $media_m->dquery($sql);
		$html = '';

		if (empty($media_videos)) {
			$html = '<tr class="td_back">' . "\r\n" . '                <td colspan="6">暂无记录</td>' . "\r\n" . '                </tr>';
			echo $html;
			exit();
		}

		foreach ($media_videos as $k => $v ) {
			$i = $k + 1;
			$urlplay = Zhimin::buildUrl('casedetail', 'case', 'index', 'id=' . $v['id']);

			if ($v['major'] != '1') {
				$html .= '<tr>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="check_span">' . "\r\n" . '								    	<input name="medias[]" class="ipt-hide" value="' . $v['id'] . '">' . "\r\n" . '								        ' . $i . '' . "\r\n" . '								    </span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a target="_blank" href="' . $urlplay . '">查看</a>' . "\r\n" . '									</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . $v['hostname'] . '(' . $v['hostcode'] . ')</td>' . "\r\n" . '								<td>' . $v['unitname'] . '</td>' . "\r\n" . '								<td>' . $v['hostbody'] . '</td>' . "\r\n" . '								<td>' . $v['createdate'] . '(' . getfiletime($v['playtime']) . ')</td>' . "\r\n" . '   ' . "\r\n" . '							</tr>';
			}
			else {
				$html .= '<tr class="td_back td_red">' . "\r\n" . '								<td>' . "\r\n" . '									<span class="check_span">' . "\r\n" . '								    	<input name="medias[]" class="ipt-hide" value="' . $v['id'] . '">' . "\r\n" . '								        ' . $i . '' . "\r\n" . '								    </span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a target="_blank" href="' . $urlplay . '">查看</a>' . "\r\n" . '									</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . $v['hostname'] . '(' . $v['hostcode'] . ')</td>' . "\r\n" . '								<td>' . $v['unitname'] . '</td>' . "\r\n" . '								<td>' . $v['hostbody'] . '</td>' . "\r\n" . '								<td>' . $v['createdate'] . '(' . getfiletime($v['playtime']) . ')</td>' . "\r\n" . '   ' . "\r\n" . '							</tr>';
			}
		}

		echo $html;
		exit();
	}

	protected function saveEdit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '没有编辑权限！';
			echo json_encode($result_array);
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$id = Zhimin::request('id');
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
		$video_ids = implode(',', $medias);
		$occurtime = strtotime($occurtime);
		$sql1 = 'select * from `' . $casetopic_m->table() . '` where pnumber = \'' . $pnumber . '\'';
		$cases = $casetopic_m->dquery($sql1);
		$ids = $cases[0]['id'];
		$casetopic = $casetopic_m->read($id);
		$casetopicsn = $casetopic['sn'];

		if ($pnumber == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $pnumber;
			echo json_encode($result_array);
			exit();
		}

		if ($ids != $id) {
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

		$flag = $casetopic_m->updateRow('id=' . $id, array('pnumber' => $pnumber, 'casetaxon' => $casetaxon, 'danwei' => $danwei, 'brains' => $brains, 'occurtime' => $occurtime, 'title' => $title, 'note' => $note, 'subject' => $subject, 'note' => $note, 'moder' => $loginuser, 'modtime' => time(), 'case_videoid' => $video_ids));

		if (0 < intval($flag)) {
			$log_type = '032';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '成功修改案件编号为' . $casetopicsn . '的案件!';
			$log_m->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '修改成功！';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function del()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '没有删除权限！';
			echo json_encode($result_array);
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$id = intval(Zhimin::request('id'));
		$loginuser = $_SESSION['username'];

		if ($id <= 0) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除失败！';
			echo json_encode($result_array);
			exit();
		}

		if ($id) {
			$casetopic = $casetopic_m->read($id);

			if (empty($casetopic)) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '删除失败！';
				echo json_encode($result_array);
				exit();
			}

			$casetopic_m->deleteRow('id=\'' . $id . '\'');
			$log_type = '033';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '成功删除案件!';
			$log_m->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '删除成功！';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '删除失败！';
			echo json_encode($result_array);
			exit();
		}
	}
}


?>

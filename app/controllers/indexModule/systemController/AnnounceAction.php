<?php

class AnnounceAction extends Action
{
	protected $module_sn = '10082';
	protected $units = array();
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$announce_m = new AnnounceModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$user_auth = array('check' => 0, 'add' => 0, 'del' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['check'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['del'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$user_groups = array();
		getusergroups($user_groups, '');
		$this->_data['user_groups'] = $user_groups;

		switch ($action) {
		case 'select':
			$this->selectData();
			break;

		case 'add':
			$this->saveAdd();
			break;

		case 'view':
			$this->view();
			break;

		case 'del':
			$this->savedel();
			break;

		default:
			$this->mlist();
			break;
		}
	}
	// 页面加载，判断有无紧急公告
	public function selectData(){
		 $announce_m = new AnnounceModel();
		 $sql = 'SELECT * FROM zm_announce where `jinji`=1 ORDER BY createtime DESC';
		 $rs = $announce_m -> fetchAll('',$sql);
		 // echo '<pre>';print_r($rs[0]['id']);exit;
		 if(isset($rs)&&!empty($rs)){
		 	echo json_encode(array('status'=>1,'id'=>$rs[0]['id']));exit;
		 }else{
		 	echo json_encode(array('status'=>0));exit;
		 }
	}
	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$user_m = new UserModel();
		$announce_m = new AnnounceModel();
		$unit_m = new UnitModel();
		$danwei = Zhimin::request('danwei');
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['danwei'] = $danwei;
		$url['date_time'] = $date_time;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pa.receive_unit in (' . $dlist . ')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pa.receive_unit in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if ($date_time == '1') {
			$sdate1 = get_week_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本周';
		}
		else if ($date_time == '2') {
			$sdate1 = get_month_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本月';
		}
		else if ($date_time == '3') {
			if (($sdate != '') && ($edate != '')) {
				$sdate1 = $sdate . ' 00:00:00';
				$edate1 = $edate . ' 23:59:59';
			}

			$date_time_name = '一段时间';
		}
		else {
			$sdate1 = '1970-00-00 00:00:00';
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '不限';
		}

		$this->_data['date_time_name'] = $date_time_name;
		$where .= ' AND (\'' . strtotime($sdate1) . '\' <= \'' . strtotime($edate1) . '\')';
		$where .= ' and `pa`.`startdate` between \'' . strtotime($sdate1) . '\' and  \'' . strtotime($edate1) . '\'';
		$where .= ' and `pa`.`enddate` > \'' . time() . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $announce_m->table() . '` as `pa` left join `zm_danwei` as `pd` on `pa`.`receive_unit`=`pd`.`bh`  where ' . $where;
		$rs = $announce_m->fetchOne('', $sql);
		$count = $rs['count'];

		if ($count == 0) {
		}
		else {
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
			$sql = 'SELECT pa.*, pd.dname as unitname FROM `' . $announce_m->table() . '` pa';
			$sql .= ' LEFT JOIN `' . $user_m->table() . '` pu ON pu.username=pa.creater';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pa.receive_unit';
			$sql .= ' WHERE ' . $where . ' order by pa.startdate desc ' . $limit;
			$announces = $announce_m->fetchAll('', $sql);
			$this->_data['announces'] = $announces;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function saveAdd()
	{
		$announce_m = new AnnounceModel();
		$user_m = new UserModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有添加的权限';
			echo json_encode($result_array);
			exit();
		}

		$subject = Zhimin::param('subject', 'post');
		$content = Zhimin::param('content', 'post');
		$danwei = Zhimin::param('danwei', 'post');
		$enddate = Zhimin::param('enddate', 'post');
		$jinji = Zhimin::param('jinji', 'post');

		if ($subject == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '公告主题不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($content == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '公告内容不能为空';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}

		if ($jinji == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择公告紧急状态';
			echo json_encode($result_array);
			exit();
		}

		if ($enddate == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择过期时间';
			echo json_encode($result_array);
			exit();
		}

		if ($enddate < date('Y-m-d H:i:s', time())) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '过期日期有误，该时间已过期';
			echo json_encode($result_array);
			exit();
		}

		$enddate = strtotime($enddate);
		$user_a = $user_m->read($_SESSION['userid']);
		$sql = 'SELECT COUNT(*) as count FROM `' . $announce_m->table() . '`';
		$rs = $announce_m->fetchOne('', $sql);
		$res = $rs['count'] + 1;
		$insert_flg = $announce_m->insertRow(array('subject' => $subject, 'content' => $content, 'jinji' => $jinji, 'creater' => $user_a['username'], 'author' => $user_a['username'], 'createtime' => time(), 'startdate' => time(), 'receive_unit' => $danwei, 'enddate' => $enddate));

		if ($insert_flg) {
			$log_type = '111';
			$unit_m = new UnitModel();
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_message = '添加主题公告成功，主题公告：' . $subject . '，主题内容：' . $content . '，单位：' . $log_unit['dname'] . '，过期时间：' . date('Y-m-d', $enddate);
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加公告成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加公告失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function saveDel()
	{
		$announce_m = new AnnounceModel();
		$log = new LogModel();
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有删除的权限';
			echo json_encode($result_array);
			exit();
		}

		$id = Zhimin::param('id', 'post');
		$announce_res = $announce_m->get_by_id($id);

		if (!$announce_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $announce_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法删除自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$announce_m->deleteRow('`id`=\'' . $id . '\'');
		$log_type = '113';
		$unit_m = new UnitModel();
		$log_unit = $unit_m->get_by_sn($announce_res['receive_unit']);
		$log_message = '删除公告成功，公告名：' . $announce_res['subject'] . '，单位：' . $log_unit['dname'];
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '删除公告成功';
		echo json_encode($result_array);
		exit();
	}

	public function view()
	{
		$auth = Zhimin::getComponent('auth');
		$announce_m = new AnnounceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$user = $user_m->get_by_name($_SESSION['username']);
		$units = array();
		$unitid = $user['dbh'];
		$unit_result = $unit_m->get_by_sn($unitid);

		if ($auth->canViewStair()) {
			$unit_m->get_units_stair($units, $unit_result['id']);
			$this->_data['units'] = $units;
		}
		else {
			$units[$unit_result['bh']]['name'] = $unit_result['dname'];
			$units[$unit_result['bh']]['bh'] = $unit_result['bh'];
			$units[$unit_result['bh']]['pbh'] = '';
			$this->_data['units'] = $units;
		}

		$id = Zhimin::param('id', 'get');
		$announces = $announce_m->data_by_id($id);
		$user_a = $user_m->get_by_name($announces['author']);
		$unit_a = $unit_m->get_by_sn($user_a['dbh']);
		$unit_c = $unit_m->get_by_sn($announces['receive_unit']);
		$announces['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
		$announces['unit_receive'] = ($announces['receive_unit'] == '' ? '所有单位' : $unit_c['dname']);
		$announces['user_name'] = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$announces['hostcode'] = ($user_a['hostcode'] == '' ? '--' : $user_a['hostcode']);
		$announces['status'] = ($announces['jinji'] == '1' ? 'checked' : '');
		$announces['status1'] = ($announces['jinji'] == '0' ? 'checked' : '');

		$html = '<div class="con_atten_wrap recorder_notice" style="margin-left: 47px;">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">发布' . $_SESSION['zfz_type'] . '：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . $announces['user_name'] . '								' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">' . $_SESSION['zfz_type'] . '编号：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . $announces['hostcode'] . '					' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							' . $announces['unit_name'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">公告主题：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							' . $announces['subject'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">紧急公告：</span>' . "\r\n" . '						<div class="select_260 select_div2 select_radio">' . "\r\n" . '								<label for="radio_yes">' . "\r\n" . '									是' . "\r\n" . '									<input type="radio" id="radio_yes" name="jinji" ' . $announces['status'] . ' value="1" disabled/>' . "\r\n" . '								</label>' . "\r\n" . '								<label for="radio_no">' . "\r\n" . '									否' . "\r\n" . '									<input type="radio" id="radio_no" name="jinji" ' . $announces['status1'] . ' value="0" disabled/>' . "\r\n" . '								</label>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">接收单位：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							' . $announces['unit_receive'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">发布时间：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							' . date('Y-m-d H:i:s', $announces['startdate']) . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">过期时间：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							' . date('Y-m-d H:i:s', $announces['enddate']) . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top" style="width: 500px;height: 200px;">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height" style="width: 517px;height: 200px;">' . "\r\n" . '						<span class="condition_title">公告内容：</span>' . "\r\n" . '						<div class="select_260 select_div select_days textarea_in" style="width: 432px;height: 200px;">	' . "\r\n" . '<div class="input_error" name="content" style="min-height:198px;overflow-y:auto;max-height:200px;width:432px;">' . $announces['content'] . '</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top level_btn">' . "\r\n" . '					<span class="sure_cancle close_btn">返回</span>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>';
		echo $html;
		exit();
	}
}


?>

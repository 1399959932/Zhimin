<?php

class StnotifyAction extends Action
{
	protected $module_sn = '10083';
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
		$stnotify_m = new StnotifyModel();
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

		switch ($action) {
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
		$stnotify_m = new StnotifyModel();
		$unit_m = new UnitModel();
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['date_time'] = $date_time;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = '1=1';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

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
		$where .= ' AND (\'' . $sdate1 . '\' <= \'' . $edate1 . '\')';
		$where .= ' and `ps`.`publishdate` > (\'' . $sdate1 . '\') and `ps`.`publishdate` < (\'' . $edate1 . '\')';
		$sql = 'SELECT COUNT(*) as count FROM `' . $stnotify_m->table() . '` as `ps`  where ' . $where;
		$rs = $stnotify_m->fetchOne('', $sql);
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
			$sql = 'SELECT ps.* FROM `' . $stnotify_m->table() . '` ps';
			$sql .= ' LEFT JOIN `' . $user_m->table() . '` pu ON pu.username=ps.creater';
			$sql .= ' WHERE ' . $where . ' order by ps.vieworder asc,ps.status desc,ps.publishdate desc ' . $limit;
			$stnotifys = $stnotify_m->fetchAll('', $sql);
			$this->_data['stnotifys'] = $stnotifys;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function saveAdd()
	{
		$stnotify_m = new StnotifyModel();
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

		$status = Zhimin::param('status', 'post');
		$content = Zhimin::param('content', 'post');
		$vieworder = Zhimin::param('vieworder', 'post');

		if ($content == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站公告内容不能为空';
			echo json_encode($result_array);
			exit();
		}

		if (($vieworder == '') || !is_numeric($vieworder)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '顺序不能为空且要是数字';
			echo json_encode($result_array);
			exit();
		}

		$user_a = $user_m->read($_SESSION['userid']);
		$sql = 'SELECT COUNT(*) as count FROM `' . $stnotify_m->table() . '`';
		$rs = $stnotify_m->fetchOne('', $sql);
		$res = $rs['count'] + 1;
		$insert_flg = $stnotify_m->insertRow(array('status' => $status, 'retype' => 1, 'vieworder' => $vieworder, 'content' => $content, 'creater' => $user_a['username'], 'publisher' => $user_a['username'], 'publishdate' => date('Y-m-d H:i:s', time()), 'receiver' => 0, 'createtime' => date('Ymd', time()), 'modifitime' => date('Ymd', time())));

		if ($insert_flg) {
			$log_type = '114';
			$unit_m = new UnitModel();
			$log_message = '添加工作站公告成功，工作站公告内容：' . $content;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '添加工作站公告成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '添加工作站公告失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}

	protected function saveDel()
	{
		$stnotify_m = new StnotifyModel();
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
		$stnotify_res = $stnotify_m->get_by_id($id);

		if (!$stnotify_res) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '非法进入';
			echo json_encode($result_array);
			exit();
		}

		if ($_SESSION['userid'] == $stnotify_res['id']) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '无法删除自己的账号';
			echo json_encode($result_array);
			exit();
		}

		$stnotify_m->deleteRow('`id`=\'' . $id . '\'');
		$log_type = '116';
		$unit_m = new UnitModel();
		$log_unit = $unit_m->get_by_sn($stnotify_res['receiver']);
		$log_message = '删除工作站公告成功，工作站公告内容：' . $stnotify_res['content'];
		$log->writeLog($log_type, $log_message);
		$result_array['state'] = 'success';
		$result_array['msg'] = '删除工作站公告成功';
		echo json_encode($result_array);
		exit();
	}

	public function view()
	{
		$auth = Zhimin::getComponent('auth');
		$stnotify_m = new StnotifyModel();
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
		$stnotifys = $stnotify_m->data_by_id($id);
		$user_a = $user_m->get_by_name($stnotifys['creater']);
		$unit_a = $unit_m->get_by_sn($user_a['dbh']);
		$unit_c = $unit_m->get_by_sn($stnotifys['receiver']);
		$stnotifys['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
		$stnotifys['unit_receive'] = ($stnotifys['receiver'] == '' ? '所有单位' : $unit_c['dname']);
		$stnotifys['user_name'] = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$stnotifys['hostcode'] = ($user_a['hostcode'] == '' ? '--' : $user_a['hostcode']);
		$stnotifys['statu'] = ($stnotifys['status'] == '1' ? 'checked' : '');
		$stnotifys['statu1'] = ($stnotifys['status'] == '0' ? 'checked' : '');
		$html = '<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">发布' . $_SESSION['zfz_type'] . '：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . $stnotifys['user_name'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">' . $_SESSION['zfz_type'] . '编号：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . $stnotifys['hostcode'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							' . $stnotifys['unit_name'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">工作站公告：</span>' . "\r\n" . '						<div class="select_260 select_div select_days textarea_in">' . "\r\n" . '							<textarea disabled style="background:#fff;color:#000;">' . $stnotifys['content'] . '</textarea>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">是否发布：</span>' . "\r\n" . '						<div class="select_260 select_div2 select_radio">' . "\r\n" . '								<label for="radio_yes">' . "\r\n" . '									是' . "\r\n" . '									<input type="radio" id="radio_yes" name="status" ' . $stnotifys['statu'] . ' value="1" disabled/>' . "\r\n" . '								</label>' . "\r\n" . '								<label for="radio_no">' . "\r\n" . '									否' . "\r\n" . '									<input type="radio" id="radio_no" name="status" ' . $stnotifys['statu1'] . ' value="0" disabled/>' . "\r\n" . '								</label>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>	' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">顺序&nbsp;:</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							<input type="text" name="vieworder" value="' . $stnotifys['vieworder'] . '" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>							' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">发布时间：</span>' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							' . $stnotifys['publishdate'] . '' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top level_btn">' . "\r\n" . '					<span class="sure_cancle close_btn">返回</span>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>';
		echo $html;
		exit();
	}
}


?>

<?php

function getUserGroups(&$groups, $bh)
{
	$auth = Zhimin::getComponent('auth');
	$group_m = new GroupModel();

	if ($auth->isSuperAdmin()) {
		$sql = 'SELECT * FROM `' . $group_m->table() . '` ORDER BY sort asc';
		$groups = $group_m->fetchAll('', $sql);
		return true;
	}

	if (trim($bh) == '') {
		$bh = $_SESSION['groupid'];
	}

	if (!isset($groups[$bh])) {
		$group = $group_m->fetchOne('', 'SELECT * FROM `' . $group_m->table() . '` WHERE bh=\'' . $bh . '\'');

		if (!empty($group)) {
			$groups[] = $group;
		}
	}

	$sql = 'SELECT * FROM `' . $group_m->table() . '` WHERE sort>\'' . $group['sort'] . '\' ORDER BY sort asc';
	$grs = $group_m->fetchAll('', $sql);

	if (!empty($grs)) {
		foreach ($grs as $val ) {
			$groups[] = $val;
		}
	}
}

function getUserUnitsStair(&$units, $id)
{
	$auth = Zhimin::getComponent('auth');
	$unit_m = new UnitModel();
	if (($id == '') && !$auth->isSuperAdmin()) {
		$id = $_SESSION['dbh'];
	}

	if (($id == 0) || ($auth->isSuperAdmin() && ($id == ''))) {
		$sql = 'SELECT * FROM `' . $unit_m->table() . '` WHERE parentid=\'0\' ORDER BY id asc';
		$unit = $unit_m->fetchOne('', $sql);

		if (!empty($unit)) {
			$units[$unit['id']] = $unit;
			$id = $unit['id'];
		}
	}

	if (empty($id)) {
		return false;
	}

	if (!isset($units[$id])) {
		$unit = $unit_m->read($id);
		$units[$unit['id']] = $unit;
	}

	$child = &$units[$id]['child'];
	$sql = 'SELECT * FROM `' . $unit_m->table() . '` WHERE parentid=\'' . $id . '\' ORDER BY id asc';
	$urs = $unit_m->fetchAll('', $sql);

	foreach ($urs as $val ) {
		$child[$val['id']] = $val;

		if (!empty($val['id'])) {
			getuserunitsstair($child, $val['id']);
		}
	}
}

function mudule_left_view($bh)
{
	$auth = Zhimin::getComponent('auth');
	$group_m = new GroupModel();
	$modules_m = new ModuleModel();
	$modules = array();
	$m_id = $modules_m->get_by_bh($bh);
	$modules_m->get_stair($modules, $m_id['id']);
	$flg1 = $auth->checkPermitView($bh);

	if (!$flg1) {
		return false;
	}
	else {
		$flg1 = true;
	}

	$flg2 = false;

	if (!empty($modules[$bh]['child'])) {
		foreach ($modules[$bh]['child'] as $k => $v ) {
			if ($auth->checkPermitView($v['bh'])) {
				$flg2 = true;
				break;
			}
		}
	}

	$flg = $flg1 & $flg2;
	return $flg;
}

function mudule_main_view($bh)
{
	$auth = Zhimin::getComponent('auth');
	$flg = $auth->checkPermitView($bh);
	return $flg;
}

function mudule_first($bh)
{
	$auth = Zhimin::getComponent('auth');
	$group_m = new GroupModel();
	$modules_m = new ModuleModel();
	$f_mud = $modules_m->get_by_bh($bh);
	$modules = array();
	$m_id = $modules_m->get_by_bh($bh);
	$modules_m->get_stair($modules, $m_id['id']);

	if (!empty($modules[$bh]['child'])) {
		foreach ($modules[$bh]['child'] as $k => $v ) {
			if ($auth->checkPermitView($v['bh'])) {
				return $v['filename'];
				break;
			}
		}
	}
	else {
		return false;
	}
}

function mudule_view_array($bh)
{
	$auth = Zhimin::getComponent('auth');
	$group_m = new GroupModel();
	$modules_m = new ModuleModel();
	$f_mud = $modules_m->get_by_bh($bh);
	$modules = array();
	$view_array = array();
	$m_id = $modules_m->get_by_bh($bh);
	$modules_m->get_stair($modules, $m_id['id']);

	if (!empty($modules[$bh]['child'])) {
		foreach ($modules[$bh]['child'] as $k => $v ) {
			if ($auth->checkPermitView($v['bh'])) {
				array_push($view_array, $v);
			}
		}
	}

	return $view_array;
}

function user_unit_stair($loginunit)
{
	$auth = Zhimin::getComponent('auth');
	$unit_m = new UnitModel();
	$units_all = array();

	if ($auth->canViewStair()) {
		foreach ($loginunit as $k => $v ) {
			$units = array();
			$unit_m->get_subs_by_sn($units, $v);

			foreach ($units as $k1 => $v1 ) {
				array_push($units_all, $v1);
			}

			reset($units);
		}
	}
	else {
		$units_all = $unit_m->get_by_bh_array($loginunit);
	}

	return $units_all;
}

function unit_string_sql($units)
{
	$dlist = '\'\'';

	if (is_array($units)) {
		$dlist = '';
		$delimiter = '';

		foreach ($units as $val ) {
			$dlist .= $delimiter . '\'' . $val['bh'] . '\'';
			$delimiter = ',';
		}
	}

	return $dlist;
}

function select_output($result_array, $class, $input_name, $key_field = 'id', $val_field = 'name', $view_string = '-请选择-', $val_sel = '', $val_sel_name = '')
{
	$string = '';
	$string .= '<div class="' . $class[0] . '">';
	$string .= '   	<div class="' . $class[1] . '">';

	if ($val_sel == '') {
		$string .= '   	   	<p>' . $view_string . '</p>';
		$string .= '   	   	<input type="hidden" name="' . $input_name . '" value="" />';
	}
	else {
		$string .= '   	   	<p>' . $val_sel_name . '</p>';
		$string .= '   	   	<input type="hidden" name="' . $input_name . '" value="' . $val_sel . '" />';
	}

	$string .= '   	   	<ul class="' . $class[2] . '">';

	if ($view_string == '不限') {
		$string .= '   	   	    <li date=""><font>' . $view_string . '</font></li>';
	}

	if (!empty($result_array)) {
		foreach ($result_array as $k => $v ) {
			$string .= '   	   	    <li date="' . $v[$key_field] . '"><font>' . $v[$val_field] . '</font></li>';
		}
	}

	$string .= '   	   	</ul>';
	$string .= '   	</div>';
	$string .= '   	<div class="select_button"></div>';
	$string .= '</div>';
	return $string;
}

function select_output_sample($result_array, $class, $input_name, $view_string = '-请选择-', $val_sel = '', $val_sel_name = '')
{
	$string = '';
	$string .= '<div class="' . $class[0] . '">';
	$string .= '   	<div class="' . $class[1] . '">';

	if ($val_sel == '') {
		$string .= '   	   	<p>' . $view_string . '</p>';
		$string .= '   	   	<input type="hidden" name="' . $input_name . '" value="" />';
	}
	else {
		$string .= '   	   	<p>' . $val_sel_name . '</p>';
		$string .= '   	   	<input type="hidden" name="' . $input_name . '" value="' . $val_sel . '" />';
	}

	$string .= '   	   	<ul class="' . $class[2] . '">';

	if ($view_string == '不限') {
		$string .= '   	   	    <li date=""><font>' . $view_string . '</font></li>';
	}

	if (!empty($result_array)) {
		foreach ($result_array as $k => $v ) {
			$string .= '   	   	    <li date="' . $k . '"><font>' . $v . '</font></li>';
		}
	}

	$string .= '   	   	</ul>';
	$string .= '   	</div>';
	$string .= '   	<div class="select_button"></div>';
	$string .= '</div>';
	return $string;
}

function get_units_by_web()
{
	$auth = Zhimin::getComponent('auth');
	$unit_m = new UnitModel();
	$user_m = new UserModel();
	$units = array();
	$loginuser = $user_m->read($_SESSION['userid']);
	$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

	if (!$auth->isSuperAdmin()) {
		if (!empty($loginunit)) {
			foreach ($loginunit as $k => $v ) {
				$units_temp = array();
				$unit_id = $unit_m->get_by_sn($v);

				if (!$auth->canViewStair()) {
					$unit_m->get_units_stair($units_temp, $unit_id['id'], false);
				}
				else {
					$unit_m->get_units_stair($units_temp, $unit_id['id']);
				}

				$units[$v] = $units_temp[$v];
			}
		}
	}
	else {
		$unit = $unit_m->get_down();
		$pid = $unit['id'];
		$unit_m->get_units_stair($units, $pid);
	}

	return $units;
}

function get_units_by_json($select_id = 'bh', $select_text = 'dname')
{
	$auth = Zhimin::getComponent('auth');
	$unit_m = new UnitModel();
	$user_m = new UserModel();
	$units = array();
	$loginuser = $user_m->read($_SESSION['userid']);
	$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

	if (!$auth->isSuperAdmin()) {
		if (!empty($loginunit)) {
			foreach ($loginunit as $k => $v ) {
				$units_temp = array();
				$unit_id = $unit_m->get_by_sn($v);

				if (!$auth->canViewStair()) {
					$unit_m->get_units_stair_json($units_temp, $unit_id['id'], $select_id, $select_text, false);
				}
				else {
					$unit_m->get_units_stair_json($units_temp, $unit_id['id'], $select_id, $select_text);
				}

				$units[$k] = $units_temp[0];
			}
		}
	}
	else {
		$unit = $unit_m->get_down();
		$pid = $unit['id'];
		$unit_m->get_units_stair_json($units, $pid, $select_id, $select_text);
	}

	return $units;
}

//modify：专为“设备管理”模块的“执法仪管理”下记录编辑界面里的单位列表显示【单位名称(编号)】
function get_units_by_json2($select_id = 'bh', $select_text = 'dname')
{
	$auth = Zhimin::getComponent('auth');
	$unit_m = new UnitModel();
	$user_m = new UserModel();
	$units = array();
	$loginuser = $user_m->read($_SESSION['userid']);
	$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

	if (!$auth->isSuperAdmin()) {
		if (!empty($loginunit)) {
			foreach ($loginunit as $k => $v ) {
				$units_temp = array();
				$unit_id = $unit_m->get_by_sn($v);

				if (!$auth->canViewStair()) {
					$unit_m->get_units_stair_json2($units_temp, $unit_id['id'], $select_id, $select_text, false);
				}
				else {
					$unit_m->get_units_stair_json2($units_temp, $unit_id['id'], $select_id, $select_text);
				}

				$units[$k] = $units_temp[0];
			}
		}
	}
	else {
		$unit = $unit_m->get_down();
		$pid = $unit['id'];
		$unit_m->get_units_stair_json2($units, $pid, $select_id, $select_text);
	}

	return $units;
}
//

function indexTopAnnounce()
{
	$announce_m = new AnnounceModel();
	$announces = $announce_m->dquery('SELECT * FROM `' . $announce_m->table() . '` where position in(\'main\',\'all\') order by vieworder LIMIT 0, 10 ');
	return $announces;
}

function isSuperAdmin()
{
	$auth = Zhimin::getComponent('auth');
	return $auth->isSuperAdmin();
}

function Pe_unlink($filename)
{
	if ((strpos($filename, '..') !== false) || (strpos($filename, './') !== false) || (strpos($filename, '/.') !== false)) {
		return false;
	}

	if (strpos($filename, 'nopic.gif') !== false) {
		return false;
	}

	if (strpos($filename, 'audio.gif') !== false) {
		return false;
	}

	return @unlink($filename);
}

function getRootPath()
{
	$path = $_SERVER['DOCUMENT_ROOT'] . Zhimin::g('assets_uri');
	return $path;
}

function getRootUrl()
{
	$url = 'http://' . $_SERVER['HTTP_HOST'] . Zhimin::g('assets_uri');
	return $url;
}

function isMenuHot($a = '', $c = '', $q = array())
{
	$isHot = true;
	$_a = Zhimin::getRouteInfo('a');
	$_c = Zhimin::getRouteInfo('c');

	if (!empty($a)) {
		$a = strtolower($a) . 'Action';

		if ($a == $_a) {
			$isHot = true;
		}
		else {
			$isHot = false;
		}
	}

	if (!$isHot) {
		return $isHot;
	}

	if (!empty($c)) {
		$c = strtolower($c) . 'Controller';

		if ($c == $_c) {
			$isHot = true;
		}
		else {
			$isHot = false;
		}
	}

	if (!$isHot) {
		return $isHot;
	}

	foreach ($q as $k => $v ) {
		if (!$isHot) {
			break;
		}

		if (Zhimin::param($k, 'get') == $v) {
			$isHot = true;
		}
		else {
			$isHot = false;
		}
	}

	return $isHot;
}

function get_info($key = '')
{
	$config_m = new ConfigModel();
	$ret = array();

	if (!empty($key)) {
		$key = addslashes($key);
		$sql = 'SELECT id, db_config, db_value FROM `' . $config_m->table() . '` WHERE `db_config`=\'' . $key . '\'';

		if ($row = $config_m->fetchOne('', $sql)) {
			$ret = $row['db_value'];
		}
	}
	else {
		$sql = 'SELECT id, db_config, db_value FROM `' . $config_m->table() . '` order by orders';
		$ret = $config_m->fetchOne('', $sql);
	}

	return $ret;
}

function FindDanwei($arrinfo, $danweino, &$arr)
{
	foreach ($arrinfo as $val ) {
		if (0 == strcmp($val[1], $danweino)) {
			foreach ($arrinfo as $val1 ) {
				if (0 == strcmp($val1[3], $val[0])) {
					$arrtest = '';
					$arrtest .= $val1[1] . ',';
					findparentid($arrinfo, $val1[0], $arrtest);
					$arr[$val1[2]] = substr($arrtest, 0, -1);
				}
			}
		}
	}
}

function FindParentid($arrinfo, $parentid, &$arr)
{
	foreach ($arrinfo as $val ) {
		if (0 == strcmp($val[3], $parentid)) {
			$arr .= $val[1] . ',';
			findparentid($arrinfo, $val[0], $arr);
		}
	}
}

function FindAbnormInfo($array, $unit, $weekmonth)
{
	foreach ($array as $key => $val ) {
		if (($val['stweek'] == $weekmonth) && ($val['unit'] == $unit)) {
			return $val['tishnum'];
		}
	}

	return '0';
}

function FindUnitUser($array, &$arrparm)
{
	$arrtemp = array();

	foreach ($array as $key => $val ) {
		if ($val['unit'] != '其他') {
			array_push($arrtemp, $val['unit']);
		}
	}

	$arrparm = array_unique($arrtemp);
}

function array_sort($arr, $keys, $type = 'asc')
{
	$keysvalue = $new_array = array();

	foreach ($arr as $k => $v ) {
		$keysvalue[$k] = $v[$keys];
	}

	if ($type == 'asc') {
		asort($keysvalue);
	}
	else {
		arsort($keysvalue);
	}

	reset($keysvalue);

	foreach ($keysvalue as $k => $v ) {
		$new_array[$k] = $arr[$k];
	}

	return $new_array;
}

function suffix_url($url, $data)
{
	if (empty($data)) {
		return $url;
	}

	foreach ($data as $k => $v ) {
		$url .= '&' . $k . '=' . $v;
	}

	return $url;
}

function get_week_first_day()
{
	return date('Y-m-d', time() - (((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600)) . ' 00:00:00';
}

function get_month_first_day()
{
	return date('Y-m', time()) . '-01 00:00:00';
}

function getMonthNum($date1, $date2)
{
	$date1_stamp = strtotime($date1);
	$date2_stamp = strtotime($date2);
	list($date_1['y'], $date_1['m']) = explode('-', date('Y-m', $date1_stamp));
	list($date_2['y'], $date_2['m']) = explode('-', date('Y-m', $date2_stamp));
	return ((abs($date_1['y'] - $date_2['y']) * 12) + $date_2['m']) - $date_1['m'];
}

function timediff($begin_time, $end_time)
{
	if ($begin_time < $end_time) {
		$starttime = $begin_time;
		$endtime = $end_time;
	}
	else {
		$starttime = $end_time;
		$endtime = $begin_time;
	}

	$timediff = $endtime - $starttime;
	$days = intval($timediff / 86400);
	$remain = $timediff % 86400;
	$hours = intval($remain / 3600);
	$remain = $remain % 3600;
	$mins = intval($remain / 60);
	$secs = $remain % 60;
	$res = array('day' => $days, 'hour' => $hours, 'min' => $mins, 'sec' => $secs);
	return $res;
}

//modify
/** * 
求两个日期之间相差的天数
* @param string $day1，格式：2017-02-14
* @param string $day2，格式：2017-02-14
* @return number 
*/
function diffBetweenTwoDays($day1, $day2)
{
	$second1 = strtotime($day1);  $second2 = strtotime($day2);
	if ($second1 < $second2) {
		$tmp = $second2;
		$second2 = $second1;
		$second1 = $tmp;
	}
	return ($second1 - $second2) / 86400;
}

function write_log($result_json, $flg = '1')
{
	global $DOCUMENT_ROOT;
	$server_date = date('Y-m');
	$filename = $server_date . '.txt';
	$file_path = $DOCUMENT_ROOT . 'log/' . $filename;
	$file = $DOCUMENT_ROOT . 'log/';
	$ft = fopen($file_path, 'a+');

	if ($flg == '1') {
		$log_string = date('Y-m-d H:i:s', time()) . '[INFO] =success[' . $result_json . '].' . "\n" . '';
	}
	else {
		$log_string = date('Y-m-d H:i:s', time()) . '[INFO] =error[' . $result_json . '].' . "\n" . '';
	}

	fwrite($ft, $log_string);
}

function return_log($state, $count, $body)
{
	$string = '{' . "\r\n" . ' 	"header":{' . "\r\n" . '		"state": "' . $state . '",' . "\r\n" . '		"count": ' . $count . '},' . "\r\n" . '	"body":' . $body . '' . "\r\n" . ' 	}';
	echo $string;
}


?>

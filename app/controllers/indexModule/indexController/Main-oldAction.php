<?php

class MainAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function getReportData()
	{

	}

	protected function _main()
	{
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$auth = Zhimin::getComponent('auth');
		$announce_m = new AnnounceModel();
		$unitbyuser = $unit_m->get_by_sn($_SESSION['unitcode']);
		$groupid = $_SESSION['groupid'];
		$data['unit_name'] = ($unitbyuser['dname'] == '' ? $_SESSION['unitcode'] : $unitbyuser['dname']);
		$data['groupname'] = $_SESSION['groupname'];
		$data['realname'] = ($_SESSION['realname'] == '' ? $_SESSION['username'] : $_SESSION['realname']);
		$data['lastlogtime'] = $_SESSION['lastlogtime'];
		$data['logip'] = $_SESSION['logip'];
		$settings = Zhimin::a()->getData('settings');
		$data['title'] = $settings['site'];
		$startdate = get_month_first_day();
		$enddate = date('Y-m-d H:i:s', time());
		$sql_stat_person = 'SELECT  sum(t.vedionum) as n1, sum(t.audionum) as n2, sum(t.photonum) as n3 from zm_check_stat t where t.usecode = \'' . $_SESSION['hostcode'] . '\' and (t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\')';
		$res_tmp_person = $unit_m->fetchOne('', $sql_stat_person);
		$person_num = $res_tmp_person['n1'] + $res_tmp_person['n2'] + $res_tmp_person['n3'];

		if ($auth->isSuperAdmin()) {
			$sql = 'SELECT dname, bh, unitsyscode from zm_danwei ORDER BY unitsyscode;';

			//modify：首页顶部（数据、用户、设备、单位）统计
			$sql_tongji = 'SELECT count(id) as data_count from zm_video_list';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['data_count'] = $res_tongji['data_count'];

			$sql_tongji = 'SELECT count(id) as user_count from zm_user';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['user_count'] = $res_tongji['user_count'];

			$sql_tongji = 'SELECT count(id) as device_count from zm_device';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['device_count'] = $res_tongji['device_count'];

			$sql_tongji = 'SELECT count(id) as danwei_count from zm_danwei';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['danwei_count'] = $res_tongji['danwei_count'];
			//
		}
		else if ($auth->canViewStair()) {  //单位管理员
			$loginunit = $user_m->get_manager_unit($_SESSION['userid']);
			$unit_one_level = $unit_m->get_child_one_level($loginunit);
			$strloginunit = '\'' . implode('\',\'', $unit_one_level) . '\'';
			$sql = 'SELECT dname, bh, unitsyscode from zm_danwei ORDER BY unitsyscode;';

			//modify：首页顶部（数据、用户、设备、单位）统计
			$sql_tongji = 'SELECT count(id) as data_count from zm_video_list where danwei = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['data_count'] = $res_tongji['data_count'];

			$sql_tongji = 'SELECT count(id) as user_count from zm_user where dbh = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['user_count'] = $res_tongji['user_count'];

			$sql_tongji = 'SELECT count(id) as device_count from zm_device where danwei = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['device_count'] = $res_tongji['device_count'];

			$sql_tongji = 'SELECT count(id) as danwei_count from zm_danwei where bh = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['danwei_count'] = $res_tongji['danwei_count'];
			//
		}
		else {  //民警账号
			$usercode_tmp = $_SESSION['hostcode'];
			$sql_stat = 'SELECT  sum(t.vedionum) as n1, sum(t.audionum) as n2, sum(t.photonum) as n3, ' . "\r\n" . '	    	            sum(t.vediosize) as s1, sum(t.audiosize) as s2, sum(t.photosize) as s3, sum(t.vediotime) as t1 ' . "\r\n" . '	    	            from zm_check_stat t where t.usecode = \'' . $usercode_tmp . '\' and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\'';
			$res_tmp = $unit_m->dquery($sql_stat);
			$resarray[$usercode_tmp]['unitname'] = $_SESSION['unitname'];
			$resarray[$usercode_tmp]['unitcode'] = $_SESSION['unitcode'];
			$resarray[$usercode_tmp]['bodynum'] = 1;
			$resarray[$usercode_tmp]['videonum'] = $res_tmp[0]['n1'];
			$resarray[$usercode_tmp]['audionum'] = $res_tmp[0]['n2'];
			$resarray[$usercode_tmp]['photonum'] = $res_tmp[0]['n3'];
			$resarray[$usercode_tmp]['videotime'] = $res_tmp[0]['t1'];
			$resarray[$usercode_tmp]['videosize'] = $res_tmp[0]['s1'];
			$resarray[$usercode_tmp]['audiosize'] = $res_tmp[0]['s2'];
			$resarray[$usercode_tmp]['photosize'] = $res_tmp[0]['s3'];

			//modify：首页顶部（数据、用户、设备、单位）统计
			$sql_tongji = 'SELECT count(id) as data_count from zm_video_list where danwei = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['data_count'] = $res_tongji['data_count'];

			$sql_tongji = 'SELECT count(id) as user_count from zm_user where dbh = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['user_count'] = $res_tongji['user_count'];

			$sql_tongji = 'SELECT count(id) as device_count from zm_device where danwei = \'' . $_SESSION['unitcode'] . '\'';
			$res_tongji = $unit_m->fetchOne('', $sql_tongji);
			$data['device_count'] = $res_tongji['device_count'];

			$data['danwei_count'] = 1;
			//
		}

		if ($auth->isSuperAdmin() || $auth->canViewStair()) {
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unit_temp[$v['bh']] = $v['unitsyscode'];

				if ($auth->isSuperAdmin()) {
					if (6 < strlen($v['unitsyscode'])) {
						continue;
					}
				}
				else if (!in_array($v['bh'], $unit_one_level)) {
					continue;
				}

				$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
				$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
				$resarray[$v['unitsyscode']]['bodynum'] = 0;
				$resarray[$v['unitsyscode']]['videonum'] = 0;
				$resarray[$v['unitsyscode']]['audionum'] = 0;
				$resarray[$v['unitsyscode']]['photonum'] = 0;
				$resarray[$v['unitsyscode']]['videotime'] = 0;
				$resarray[$v['unitsyscode']]['videosize'] = 0;
				$resarray[$v['unitsyscode']]['audiosize'] = 0;
				$resarray[$v['unitsyscode']]['photosize'] = 0;
			}

			$sql = 'SELECT t.danwei, count(DISTINCT t.hostcode) as num1, count(DISTINCT t.hostbody) as num2 from zm_device t GROUP BY t.danwei;';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['danwei']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

					if (array_key_exists($unitsys_temp, $resarray)) {
						$resarray[$unitsys_temp]['bodynum'] += $v['num2'];
					}
				}
			}

			$sql = 'SELECT t.unitcode, sum(t.vedionum) as n1, sum(t.audionum) as n2, sum(t.photonum) as n3, ' . "\r\n" . '	    	        sum(t.vediosize) as s1, sum(t.audiosize) as s2, sum(t.photosize) as s3, sum(t.vediotime) as t1 ' . "\r\n" . '	    	        from zm_check_stat t where t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.unitcode';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['unitcode']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

					if (array_key_exists($unitsys_temp, $resarray)) {
						$resarray[$unitsys_temp]['videonum'] += $v['n1'];
						$resarray[$unitsys_temp]['audionum'] += $v['n2'];
						$resarray[$unitsys_temp]['photonum'] += $v['n3'];
						$resarray[$unitsys_temp]['videotime'] += $v['t1'];
						$resarray[$unitsys_temp]['videosize'] += $v['s1'];
						$resarray[$unitsys_temp]['audiosize'] += $v['s2'];
						$resarray[$unitsys_temp]['photosize'] += $v['s3'];
					}
				}
			}
		}

		$this_unit = $unit_m->get_by_sn($_SESSION['unitcode']);
		$ann_units = array();
		$unit_m->get_subs_parents($ann_units, $this_unit['id'], $this_unit['parentid']);
		$dlist = unit_string_sql($ann_units);
		$announces_sql = 'select * from `zm_announce` WHERE `enddate`>\'' . time() . '\' and (`receive_unit` in (' . $dlist . ') or `receive_unit`=\'\' or `receive_unit` is NULL) order by `vieworder` asc,`createtime` desc limit 0,3';
		$announces = $announce_m->fetchAll('', $announces_sql);
		$announces_array = array();

		if (!empty($announces)) {
			foreach ($announces as $k => $v ) {
				$announces_array[$k] = $v;
				$user_a = $user_m->get_by_name($v['author']);
				$unit_a = $unit_m->get_by_sn($user_a['dbh']);
				$announces_array[$k]['username'] = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
				$announces_array[$k]['hostcode'] = $user_a['hostcode'];
				$announces_array[$k]['unit_name'] = $unit_a['dname'];
			}
		}

		$this->_data['data'] = $data;
		$this->_data['tongjidata'] = $resarray;
		$this->_data['person_num'] = $person_num;
		$this->_data['announces'] = $announces_array;

		//modify
		//获取统计图表：统计分析->趋势对比图（各单位或当前登录的执法者最近一周上传的文件总数）
		require_once('Chart.php');
		$ctat = new Chart();
		$ctat->_main();
		$this->_data['datas'] = $ctat->_data['datas'];
	}
}


?>

<?php
//modify

class Chart extends Action
{
	protected $module_sn = 10054;

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$units_array = get_units_by_web();
		$this->_data['units_array'] = $units_array;

		$this->mlist();
	}

	protected function mlist()
	{
		$resarray = array();
		$unit_temp = array();
		$auth = Zhimin::getComponent('auth');

/*
		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
			return NULL;
		}
*/

		$auth = Zhimin::getComponent('auth');
		$unit_m = new UnitModel();
		$danwei = Zhimin::request('danwei');

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pu.dbh in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_syscode($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		$unitsyscode = $danwei;
		$unitcode = $_SESSION['unitcode'];
		$usercode_tmp = $_SESSION['hostcode'];

		if ($unitsyscode == '') {
			$unitsyscode = $_SESSION['unitsyscode'];
		}

		$result = array();
		$result['status'] = 1;
		$timetype = Zhimin::request('date_time');
		$querytype = Zhimin::request('querytype');

		if ($querytype == '') {
			$querytype = '1';
		}

		$result['date']['xAxis1'] = array();
		$result['date']['series1'] = array();
		$result['date']['danwei'] = array();

		$unit_m = new UnitModel();
		$sql1 = ""; $sql2 = "";
					//根据当前用户权限，获取不同数据
					if ($auth->isSuperAdmin()) {
						$sql1 = 'SELECT dname, bh, unitsyscode from zm_danwei where unitsyscode like \'' . $unitsyscode . '%\' ORDER BY unitsyscode;';
					}
					else if ($auth->canViewStair()) {  //单位管理员
						$sql1 = 'SELECT dname, bh, unitsyscode from zm_danwei where bh = \'' . $unitcode . '\'';
					}
					else {  //执法者（如：民警）
						$sql1 = 'SELECT t.realname as dname, bh, unitsyscode from zm_user t, zm_danwei t1 where t.dbh = t1.bh and hostcode = \'' . $usercode_tmp . '\'';
					}

		$res = $unit_m->dquery($sql1);
		//echo $sql1."<br>";

		foreach ($res as $k => $v ) {
			if ((strlen($unitsyscode) + 3) < strlen($v['unitsyscode'])) {
				continue;
			}

			$unitcodetemp = $v['unitsyscode'];
			array_push($result['date']['danwei'], $v['dname']);
			$arrtemp = array();
			$arrtemp['unit'] = $v['bh'];
			$arrtemp['name'] = $v['dname'];
			$arrtemp['type'] = 'line';
			$arrtemp['step'] = 'start';

				$startdate = date('Y-m-d', strtotime('-7 day'));
				$enddate = date('Y-m-d', strtotime('-0 day'));
				$arrtemp['data'] = array(0, 0, 0, 0, 0, 0, 0, 0);

				if ($querytype == '1') {
					if ($auth->isSuperAdmin()) {  //当前登陆者为超级管理员，获取所有单位下用户上传的文件总数
						$sql2 = 'SELECT t.statdate, sum(t.vedionum)+sum(t.audionum)+sum(t.photonum) as queryval   ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate;';
					}
					else if ($auth->canViewStair()) {  //当前登陆者为单位管理员，获取其所属单位下所有用户上传的文件总数
						$sql2 = 'SELECT t.statdate, sum(t.vedionum)+sum(t.audionum)+sum(t.photonum) as queryval   ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.bh = \'' . $unitcode . '\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\';';
					}
					else {  //当前登陆者为执法者（如：民警），获取其上传的文件总数
						$sql2 = 'SELECT statdate, sum(vedionum)+sum(audionum)+sum(photonum) as queryval   ' . "\r\n" . '		    	        from zm_check_stat WHERE usecode = \'' . $usercode_tmp . '\' ' . "\r\n" . '		    	        and statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\';';
					}
					//echo $sql2."<p><hr /></p>";
				}
				else {
					//$sql = 'SELECT t.statdate, FORMAT(sum(t.vediotime)/3600, 2) as queryval    ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate';
				}

				$res_data = $unit_m->dquery($sql2);

				foreach ($res_data as $k => $v ) {
					if (empty($v['queryval'])) {
						continue;
					}

					$days = round((strtotime($v['statdate']) - strtotime($startdate)) / 3600 / 24);

					if (0 <= $days) {
						$arrtemp['data'][$days] = $v['queryval'];
					}
				}
			array_push($result['date']['series1'], $arrtemp);
		}

			$startdate = date('Y-m-d', strtotime('-7 day'));
			$enddate = date('Y-m-d', strtotime('-0 day'));
			$i = 7;

			for ($i = 7; 0 <= $i; $i--) {
				$dateday = date('w', time() - ($i * 24 * 3600));

				if ($dateday == 0) {
					$zhouming = '周日';
				}
				else if ($dateday == 1) {
					$zhouming = '周一';
				}
				else if ($dateday == 2) {
					$zhouming = '周二';
				}
				else if ($dateday == 3) {
					$zhouming = '周三';
				}
				else if ($dateday == 4) {
					$zhouming = '周四';
				}
				else if ($dateday == 5) {
					$zhouming = '周五';
				}
				else {
					$zhouming = '周六';
				}

				array_push($result['date']['xAxis1'], $zhouming);
			}


		if (($querytype == '1') || ($querytype == '3')) {
			$result['unittype'] = '单位:个 ';
		}
		else if (($querytype == '2') || ($querytype == '4')) {
			$result['unittype'] = '单位: 小时 ';
		}
		else {
			$result['unittype'] = '单位: % ';
		}

		$this->_data['datas'] = json_encode($result);
	}
}


?>

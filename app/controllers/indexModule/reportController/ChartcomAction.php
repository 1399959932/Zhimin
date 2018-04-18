<?php

class ChartcomAction extends Action
{
	protected $module_sn = 10054;

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$action = Zhimin::param('action', 'get');
		$units_array = get_units_by_web();
		$this->_data['units_array'] = $units_array;

		switch ($action) {
		case 'search':
		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$resarray = array();
		$unit_temp = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有查看的权限！', 'url' => $this->url_base);
			return NULL;
		}

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

		if ($unitsyscode == '') {
			$unitsyscode = $_SESSION['unitsyscode'];
		}

		$result = array();
		$result['status'] = 1;
		$timetype = Zhimin::request('date_time');
		$querytype = Zhimin::request('querytype');

		if ($timetype == '') {
			$timetype = '1';
		}

		if ($querytype == '') {
			$querytype = '1';
		}

		$result['date']['xAxis1'] = array();
		$result['date']['series1'] = array();
		$result['date']['danwei'] = array();
		$unit_m = new UnitModel();
		$sql = 'SELECT dname, bh, unitsyscode from zm_danwei where unitsyscode like \'' . $unitsyscode . '%\' ORDER BY unitsyscode;';
		$res = $unit_m->dquery($sql);

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

			if ($timetype == '1') {
				$startdate = date('Y-m-d', strtotime('-7 day'));
				$enddate = date('Y-m-d', strtotime('-0 day'));
				$arrtemp['data'] = array(0, 0, 0, 0, 0, 0, 0, 0);

				if ($querytype == '1') {
					$sql = 'SELECT t.statdate, sum(t.vedionum)+sum(t.audionum)+sum(t.photonum) as queryval   ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate';
				}
				else {
					$sql = 'SELECT t.statdate, FORMAT(sum(t.vediotime)/3600, 2) as queryval    ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate';
				}

				$res_data = $unit_m->dquery($sql);

				foreach ($res_data as $k => $v ) {
					if (empty($v['queryval'])) {
						continue;
					}

					$days = round((strtotime($v['statdate']) - strtotime($startdate)) / 3600 / 24);

					if (0 <= $days) {
						$arrtemp['data'][$days] = $v['queryval'];
					}
				}
			}
			else if ($timetype == '2') {
				$startdate = date('Y-m-d', strtotime('-31 day'));
				$enddate = date('Y-m-d', strtotime('-0 day'));
				$arrtemp['data'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

				if ($querytype == '1') {
					$sql = 'SELECT t.statdate, sum(t.vedionum)+sum(t.audionum)+sum(t.photonum) as queryval   ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate';
				}
				else {
					$sql = 'SELECT t.statdate, FORMAT(sum(t.vediotime)/3600, 2) as queryval    ' . "\r\n" . '		    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '		    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.statdate';
				}

				$res_data = $unit_m->dquery($sql);

				foreach ($res_data as $k => $v ) {
					if (empty($v['queryval'])) {
						continue;
					}

					$days = round((strtotime($v['statdate']) - strtotime($startdate)) / 3600 / 24);

					if (0 <= $days) {
						$arrtemp['data'][$days] = $v['queryval'];
					}
				}
			}
			else if ($timetype == '3') {
				$startdate = date('Y-m-01', strtotime('-365 day'));
				$shangfirst = date('Y-m', strtotime('-365 day'));
				$enddate = date('Y-m-d', strtotime('-0 day'));
				$arrtemp['data'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

				if ($querytype == '1') {
					$sql = 'SELECT LEFT(t.statdate,7) AS statdate, sum(t.vedionum)+sum(t.audionum)+sum(t.photonum) as queryval   ' . "\r\n" . '	    	            from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '	    	            and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY LEFT(t.statdate,7)';
				}
				else {
					$sql = 'SELECT LEFT(t.statdate,7) AS statdate, FORMAT(sum(t.vediotime)/3600, 2) as queryval   ' . "\r\n" . '	    	            from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitcodetemp . '%\' ' . "\r\n" . '	    	            and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY LEFT(t.statdate,7)';
				}

				$res_data = $unit_m->dquery($sql);

				foreach ($res_data as $k => $v ) {
					if (empty($v['queryval'])) {
						continue;
					}

					$yues = getmonthnum($shangfirst, $v['statdate']);

					if (0 <= $days) {
						$arrtemp['data'][$yues] = $v['queryval'];
					}
				}
			}

			array_push($result['date']['series1'], $arrtemp);
		}

		if ($timetype == '1') {
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
		}
		else if ($timetype == '2') {
			$startdate = date('Y-m-d', strtotime('-31 day'));
			$enddate = date('Y-m-d', strtotime('-0 day'));
			$i = 31;

			for ($i = 31; 0 <= $i; $i--) {
				$dateday = date('d', time() - ($i * 24 * 3600));
				array_push($result['date']['xAxis1'], $dateday);
			}
		}
		else if ($timetype == '3') {
			$startdate = date('Y-m-01', strtotime('-365 day'));
			$shangfirst = date('Y-m', strtotime('-365 day'));
			$enddate = date('Y-m-d', strtotime('-0 day'));
			$shangyue = date('Y-m-d h:i:s', time());
			$arr_yue = array();

			for ($i = 12; 0 <= $i; $i--) {
				$dateday = date('m', strtotime($shangyue . ' -1 month'));
				$shangyue = date('Y-m-d', strtotime($shangyue . ' -1 month'));
				array_push($arr_yue, $dateday);
			}

			krsort($arr_yue);

			foreach ($arr_yue as $k => $val ) {
				array_push($result['date']['xAxis1'], $val);
				array_push($result['date']['series1'], 0);
			}
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

<?php

class SupchatAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'zhou':
			$this->zhou();
			break;

		case 'yue':
			$this->yue();
			break;

		case 'nian':
			$this->nian();
			break;

		case 'qushi':
			$this->qushi();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$unitcode = Zhimin::param('unitcode', 'get');
		$startdate = Zhimin::param('st', 'get');
		$enddate = Zhimin::param('ed', 'get');
		$type = Zhimin::param('type', 'get');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$config_m = new ConfigModel();
		$configval = $config_m->dquery('SELECT db_value FROM  zm_config where `db_config`=\'onworktime\' or db_config=\'onworkday\' ORDER BY db_config');
		$onworktime = $configval[1]['db_value'];
		$onworkday = $configval[0]['db_value'];
		$configval = $config_m->dquery('SELECT dname from zm_danwei where unitsyscode = \'' . $unitcode . '\'');
		$this->_data['unitname'] = $configval[0]['dname'];
		$host_temp = array();
		$unit_m = new UnitModel();
		$sql = 'SELECT hostcode, hostname from zm_device;';
		$res_1 = $unit_m->dquery($sql);

		foreach ($res_1 as $k => $v ) {
			$host_temp[$v['hostcode']] = $v['hostname'];
		}

		$this->_data['host_temp'] = $host_temp;

		if ($type == '3') {
			$sql_count = 'SELECT count(*) as count from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\'';
		}
		else if ($type == '2') {
			$sql_count = 'SELECT count(*) as count from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\' and t1.videotimelength<25920';
		}
		else {
			$sql_count = 'SELECT count(*) as count from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\'';
		}

		$rs = $unit_m->dquery($sql_count);
		$count = $rs[0]['count'];

		if (!is_numeric($lines)) {
			$lines = 16;
		}

		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$pageNums = ceil($count / $lines);
		if ($pageNums && ($pageNums < $page)) {
			$page = $pageNums;
		}

		$start = ($page - 1) * $lines;
		$limit = 'LIMIT ' . $start . ',' . $lines;

		if ($type == '3') {
			$sql = 'SELECT t2.dname, t1.hostcode, t1.statdate, t1.videototalnum as val1, t1.wanvideonum as val2 from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\' order by t1.statdate desc ' . $limit;
		}
		else if ($type == '2') {
			$sql = 'SELECT t2.dname, t1.hostcode, t1.statdate, t1.videotimelength as val2 from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\' and t1.videotimelength<25920 order by t1.statdate desc ' . $limit;
		}
		else {
			$sql = 'SELECT t2.dname, t1.hostcode, t1.statdate, t1.videotimelength as val2 from ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 JOIN zm_danwei t2 on t1.unitcode=t2.bh and t2.unitsyscode like \'' . $unitcode . '%\' and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' and \'' . $enddate . '\' order by t1.statdate desc ' . $limit;
		}

		$res = $config_m->dquery($sql);
		$this->_data['datas'] = $res;
		$this->_data['unitcode'] = $unitcode;
		$this->_data['type'] = $type;
		$this->_data['onworktime'] = $onworktime;
		$this->url_base .= '&unitcode=' . urlencode($unitcode) . '&type=' . urlencode($type);
		$this->url_base .= '&st=' . urlencode($startdate) . '&ed=' . urlencode($enddate);
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function zhou()
	{
		$this->_hasView = 0;
		$result = array();
		$result['status'] = 1;
		$unitcode = Zhimin::param('unitcode', 'post');
		$type = Zhimin::param('type', 'post');
		$result['date']['unitcode'] = $unitcode;
		$result['date']['xAxis'] = array('上周', '本周');
		$result['date']['series'] = array('0' => '0', '1' => '0');
		$result['date']['xAxis1'] = array('周一', '周二', '周三', '周四', '周五', '周六', '周日');
		$result['date']['series1'] = array(
			'prevWeek' => array('0', '0', '0', '0', '0', '0', '0'),
			'nowWeek'  => array('0', '0', '0', '0', '0', '0', '0')
			);
		$shangstart = date('Y-m-d', time() - ((((date('w') == 0 ? 7 : date('w')) - 1) + 7) * 24 * 3600));
		$shangend = date('Y-m-d', time() - ((((date('w') == 0 ? 7 : date('w')) - 1) + 1) * 24 * 3600));
		$benzhoustart = date('Y-m-d', time() - (((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));

		if ($type == '3') {
			$sql = 'SELECT t.statdate , sum(t.wanvideonum) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         GROUP BY t.statdate';
		}
		else if ($type == '2') {
			$sql = 'SELECT t.statdate , sum(CASE WHEN t.videotimelength<25920 THEN 1 ELSE 0 END) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         GROUP BY t.statdate';
		}
		else {
			$sql = 'SELECT t.statdate , FORMAT(sum(t.videotimelength)/3600,2) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         GROUP BY t.statdate';
		}

		$unit_m = new UnitModel();
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			if (($v['statdate'] <= $shangend) && ($shangstart <= $v['statdate'])) {
				$result['date']['series'][0] += $v['tottime'];
			}
			else {
				$result['date']['series'][1] += $v['tottime'];
			}

			$days = round((strtotime($v['statdate']) - strtotime($shangstart)) / 3600 / 24);
			if ((0 <= $days) && ($days <= 6)) {
				$result['date']['series1']['prevWeek'][$days] = $v['tottime'];
			}
			else {
				if ((7 <= $days) && ($days <= 13)) {
					$result['date']['series1']['nowWeek'][$days - 7] = $v['tottime'];
				}
			}
		}

		echo json_encode($result);
	}

	protected function yue()
	{
		$this->_hasView = 0;
		$result = array();
		$result['status'] = 1;
		$unitcode = Zhimin::param('unitcode', 'post');
		$type = Zhimin::param('type', 'post');
		$result['date']['unitcode'] = $unitcode;
		$result['date']['xAxis'] = array('上月', '本月');
		$result['date']['series'] = array('0' => '0', '1' => '0');
		$result['date']['xAxis1'] = array('01', '\\n02', '03', '\\n04', '05', '\\n06', '07', '\\n08', '09', '\\n10', '11', '\\n12', '13', '\\n14', '15', '\\n16', '17', '\\n18', '19', '\\n20', '21', '\\n22', '23', '\\n24', '25', '\\n26', '27', '\\n28', '29', '\\n30', '31');
		$result['date']['series1'] = array(
			'prevWeek' => array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
			'nowWeek'  => array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')
			);
		$shangstart = date('Y-m-01', strtotime('-1 month'));
		$shangend = date('Y-m-t', strtotime('-1 month'));
		$shangdays = date('t', strtotime('-1 month'));
		$benzhoustart = date('Y-m-01', time());
		$benzhouend = date('Y-m-d', strtotime($benzhoustart . ' +1 month -1 day'));

		if ($type == '3') {
			$sql = 'SELECT t.statdate , sum(t.wanvideonum) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY t.statdate';
		}
		else if ($type == '2') {
			$sql = 'SELECT t.statdate , sum(CASE WHEN t.videotimelength<25920 THEN 1 ELSE 0 END) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY t.statdate';
		}
		else {
			$sql = 'SELECT t.statdate , FORMAT(sum(t.videotimelength)/3600,2) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY t.statdate';
		}

		$unit_m = new UnitModel();
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			if (($v['statdate'] <= $shangend) && ($shangstart <= $v['statdate'])) {
				$result['date']['series'][0] += $v['tottime'];
			}
			else {
				$result['date']['series'][1] += $v['tottime'];
			}

			$days = round((strtotime($v['statdate']) - strtotime($shangstart)) / 3600 / 24);
			if ((0 <= $days) && ($days < $shangdays)) {
				$result['date']['series1']['prevWeek'][$days] = $v['tottime'];
			}
			else if ($shangdays <= $days) {
				$result['date']['series1']['nowWeek'][$days - $shangdays] = $v['tottime'];
			}
		}

		echo json_encode($result);
	}

	protected function nian()
	{
		$this->_hasView = 0;
		$result = array();
		$result['status'] = 1;
		$unitcode = Zhimin::param('unitcode', 'post');
		$type = Zhimin::param('type', 'post');
		$result['date']['unitcode'] = $unitcode;
		$result['date']['xAxis'] = array('上年', '本年');
		$result['date']['series'] = array('0' => '0', '1' => '0');
		$result['date']['xAxis1'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
		$result['date']['series1'] = array(
			'prevWeek' => array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
			'nowWeek'  => array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')
			);
		$shangstart = date('Y-01-01', strtotime('-1 year'));
		$shangfirst = date('Y-01', strtotime('-1 year'));
		$shanglast = date('Y-12', strtotime('-1 year'));
		$benzhouend = date('Y-12-31', time());

		if ($type == '3') {
			$sql = 'SELECT LEFT(t.statdate,7) as statdate , sum(t.wanvideonum) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY LEFT(t.statdate,7)';
		}
		else if ($type == '2') {
			$sql = 'SELECT LEFT(t.statdate,7) as statdate , sum(CASE WHEN t.videotimelength<25920 THEN 1 ELSE 0 END) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY LEFT(t.statdate,7)';
		}
		else {
			$sql = 'SELECT LEFT(t.statdate,7) as statdate , FORMAT(sum(t.videotimelength)/3600,2) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $benzhouend . '\' GROUP BY LEFT(t.statdate,7)';
		}

		$unit_m = new UnitModel();
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			if (($v['statdate'] <= $shanglast) && ($shangfirst <= $v['statdate'])) {
				$result['date']['series'][0] += $v['tottime'];
			}
			else {
				$result['date']['series'][1] += $v['tottime'];
			}

			$yues = getmonthnum($shangfirst, $v['statdate']);

			if ((0 <= $yues) && ($yues < 12)) {
				$result['date']['series1']['prevWeek'][$yues] = $v['tottime'];
			}
			else if ((12 <= $yues) && ($yues < 24)) {
				$result['date']['series1']['nowWeek'][$yues - 12] = $v['tottime'];
			}
		}

		echo json_encode($result);
	}

	protected function qushi()
	{
		$this->_hasView = 0;
		$result = array();
		$result['status'] = 1;
		$unitcode = Zhimin::param('unitcode', 'post');
		$type = Zhimin::param('type', 'post');
		$result['date']['unitcode'] = $unitcode;
		$result['date']['xAxis1'] = array();
		$result['date']['series1'] = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
		$shangstart = date('Y-m-d', strtotime('-30 day'));
		$shangend = date('Y-m-d', time());
		$i = 30;

		for ($i = 30; 0 <= $i; $i--) {
			$dateday = date('d', time() - ($i * 24 * 3600));
			array_push($result['date']['xAxis1'], $dateday);
		}

		if ($type == '3') {
			$sql = 'SELECT t.statdate , sum(t.wanvideonum) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $shangend . '\' GROUP BY t.statdate';
		}
		else if ($type == '2') {
			$sql = 'SELECT t.statdate , sum(CASE WHEN t.videotimelength<25920 THEN 1 ELSE 0 END) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $shangend . '\' GROUP BY t.statdate';
		}
		else {
			$sql = 'SELECT t.statdate , FORMAT(sum(t.videotimelength)/3600,2) as tottime from zm_lowsupervise_stat t JOIN ' . "\r\n" . '			        zm_danwei t1 ON t.unitcode=t1.bh where t1.unitsyscode like \'' . $unitcode . '%\' and t.statdate>=\'' . $shangstart . '\'' . "\r\n" . '			         and t.statdate<=\'' . $shangend . '\' GROUP BY t.statdate';
		}

		$unit_m = new UnitModel();
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$days = round((strtotime($v['statdate']) - strtotime($shangstart)) / 3600 / 24);

			if (0 <= $days) {
				$result['date']['series1'][$days] = $v['tottime'];
			}
		}

		echo json_encode($result);
	}
}


?>

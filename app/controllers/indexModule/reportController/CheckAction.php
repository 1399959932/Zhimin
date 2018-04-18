<?php

class CheckAction extends Action
{
	protected $module_sn = 10051;

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
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
		$excel = Zhimin::param('excel', 'get');

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

		$stattype = Zhimin::request('stattype');
		$date_time = Zhimin::request('date_time');

		if (empty($date_time)) {
			$date_time = '1';
		}

		$this->_data['date_time'] = $date_time;

		if ($date_time == '1') {
			$startdate = get_week_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else if ($date_time == '2') {
			$startdate = get_month_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else {
			$startdate = Zhimin::request('startdate');
			$enddate = Zhimin::request('enddate');

			if ($startdate == '') {
				$startdate = get_month_first_day();
			}

			if ($enddate == '') {
				$enddate = date('Y-m-d H:i:s', time());
			}
		}

		$this->_data['startdate'] = $startdate;
		$this->_data['enddate'] = $enddate;

		if ($stattype == '2') {
			$unit_m = new UnitModel();
			$sql = 'SELECT hostcode, hostname from zm_device ORDER BY hostcode;';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unit_temp[$v['hostcode']] = $v['hostname'];
			}

			$sql = 'SELECT t.usecode, t2.dname, sum(t.vedionum) as vedionum, sum(t.audionum) as audionum, ' . "\r\n" . '	    	        sum(t.photonum) as photonum, sum(t.vediosize) as vediosize, sum(t.audiosize) as audiosize, ' . "\r\n" . '	    	        sum(t.photosize) as photosize, sum(t.vediotime) as videotime ' . "\r\n" . '    	            from zm_check_stat t JOIN zm_danwei t2 ON t.unitcode=t2.bh and t.statdate BETWEEN \'' . $startdate . '\' ' . "\r\n" . '    	            AND \'' . $enddate . '\' and unitsyscode like \'' . $unitsyscode . '%\' GROUP BY t.usecode ORDER BY t2.unitsyscode; ';
			$res = $unit_m->dquery($sql);
			//echo("<p></p>104line:".$sql);
			$this->_data['datas'] = $res;
			$this->_data['days'] = $days;
			$this->_data['userarray'] = $unit_temp;

			if ($excel == 'yes') {
				require_once ('./PHPExcel/PHPExcel.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator('ctos')->setLastModifiedBy('ctos')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('Test result file');
				$objPHPExcel->getProperties()->setCreator('Maarten Balliauw');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
				$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
				$objPHPExcel->getActiveSheet()->mergeCells('A3:J3');
				$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
				$tableheader = array('序号', '部门名称', $_SESSION['zfz_type'] . '姓名(' . $_SESSION['zfz_type'] . '编号)', '视频个数', '音频个数', '图片个数', '视频总时长(小时)', '视频总容量(G)', '音频总容量(G)', '图片总容量(G)');

				for ($i = 0; $i < count($tableheader); $i++) {
					$objPHPExcel->getActiveSheet()->setCellValue($letter[$i] . '4', $tableheader[$i]);
				}

				$i = 1;

				foreach ($res as $key => $val ) {
					$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 4), $i);
					$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 4), $val['dname']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 4), $unit_temp[$val['usecode']] . '(' . $val['usecode'] . ')');
					$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 4), $val['vedionum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 4), $val['audionum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 4), $val['photonum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 4), round($val['videotime'] / 3600, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 4), round($val['vediosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 4), round($val['audiosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('J' . ($i + 4), round($val['photosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':J' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':J' . ($i + 4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(16);
					$i++;
				}

				$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(11);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false);
				$A2_title = '【统计单位：' . $resarray[$unitsyscode]['unitname'] . '】 统计时段：' . $startdate . '至' . $enddate;
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(11);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);
				$A3_title = '【制表人：' . $_SESSION['realname'] . '】【生成日期：' . date('Y-m-d H:i:s', time()) . '】';
				$outputFileName = 'DataStat_person';
				$objPHPExcel->getActiveSheet()->setTitle($outputFileName);
				$objPHPExcel->getActiveSheet()->setCellValue('A1', '基本数据统计--个人');
				$objPHPExcel->getActiveSheet()->setCellValue('A2', $A2_title);
				$objPHPExcel->getActiveSheet()->setCellValue('A3', $A3_title);
				$objPHPExcel->setActiveSheetIndex(0);
				ob_end_clean();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $outputFileName . '.xls"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}
		}
		else {
			$unit_m = new UnitModel();
			$sql = 'SELECT dname, bh, unitsyscode from zm_danwei where unitsyscode like \'' . $unitsyscode . '%\' ORDER BY unitsyscode;';
			$res = $unit_m->dquery($sql);
			//echo $sql;

			foreach ($res as $k => $v ) {
				$unit_temp[$v['bh']] = $v['unitsyscode'];
				if (((strlen($unitsyscode) + 3) < strlen($v['unitsyscode'])) || (strlen($v['unitsyscode']) < strlen($unitsyscode))) {
					continue;
				}

				$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
				$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
				$resarray[$v['unitsyscode']]['bodynum'] = 0;
				$resarray[$v['unitsyscode']]['stationnum'] = 0;
				$resarray[$v['unitsyscode']]['usernum'] = 0;
				$resarray[$v['unitsyscode']]['videonum'] = 0;
				$resarray[$v['unitsyscode']]['audionum'] = 0;
				$resarray[$v['unitsyscode']]['photonum'] = 0;
				$resarray[$v['unitsyscode']]['videotime'] = 0;
				$resarray[$v['unitsyscode']]['videosize'] = 0;
				$resarray[$v['unitsyscode']]['audiosize'] = 0;
				$resarray[$v['unitsyscode']]['photosize'] = 0;
				$resarray[$v['unitsyscode']]['parenttype'] = 0;
				$parentcode = substr($v['unitsyscode'], 0, strlen($v['unitsyscode']) - 3);
				if (($parentcode != '') && (strlen($unitsyscode) <= strlen($parentcode))) {
					$resarray[$parentcode]['parenttype'] = 1;
				}
			}

			$sql = 'SELECT t.unitcode, count(DISTINCT t.hostname) as num from zm_hostip t GROUP BY t.unitcode';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['unitcode']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
					if (((strlen($unitsyscode) + 3) < strlen($unitsys_temp)) || (strlen($unitsys_temp) < strlen($unitsyscode))) {
						continue;
					}

					$resarray[$unitsys_temp]['stationnum'] += $v['num'];
				}
			}

			$sql = 'SELECT t.danwei, count(DISTINCT t.hostcode) as num1, count(t.hostbody) as num2 from zm_device t GROUP BY t.danwei;';
			$res = $unit_m->dquery($sql);
			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['danwei']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
					if (((strlen($unitsyscode) + 3) < strlen($unitsys_temp)) || (strlen($unitsys_temp) < strlen($unitsyscode))) {
						continue;
					}

					$resarray[$unitsys_temp]['usernum'] += $v['num1'];
					$resarray[$unitsys_temp]['bodynum'] += $v['num2'];
				}
			}

			$sql = 'SELECT t.unitcode, sum(t.vedionum) as n1, sum(t.audionum) as n2, sum(t.photonum) as n3, ' . "\r\n" . '	    	        sum(t.vediosize) as s1, sum(t.audiosize) as s2, sum(t.photosize) as s3, sum(t.vediotime) as t1 ' . "\r\n" . '	    	        from zm_check_stat t JOIN zm_danwei t1 ON t.unitcode=t1.bh and t1.unitsyscode like \'' . $unitsyscode . '%\' ' . "\r\n" . '	    	        and t.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t.unitcode';
			$res = $unit_m->dquery($sql);
			//echo("<p></p>232line:".$sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['unitcode']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
					if (((strlen($unitsyscode) + 3) < strlen($unitsys_temp)) || (strlen($unitsys_temp) < strlen($unitsyscode))) {
						continue;
					}

					$resarray[$unitsys_temp]['videonum'] += $v['n1'];
					$resarray[$unitsys_temp]['audionum'] += $v['n2'];
					$resarray[$unitsys_temp]['photonum'] += $v['n3'];
					$resarray[$unitsys_temp]['videotime'] += $v['t1'];
					$resarray[$unitsys_temp]['videosize'] += $v['s1'];
					$resarray[$unitsys_temp]['audiosize'] += $v['s2'];
					$resarray[$unitsys_temp]['photosize'] += $v['s3'];
				}
			}

			$this->_data['datas'] = $resarray;

			if ($excel == 'yes') {
				require_once ('./PHPExcel/PHPExcel.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator('ctos')->setLastModifiedBy('ctos')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('Test result file');
				$objPHPExcel->getProperties()->setCreator('Maarten Balliauw');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
				$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
				$objPHPExcel->getActiveSheet()->mergeCells('A3:L3');
				$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L');
				$tableheader = array('序号', '部门/' . $_SESSION['zfz_type'] . '姓名', '工作站个数', $_SESSION['zfz_type'] . '人数', '执法仪个数', '视频个数', '音频个数', '图片个数', '视频总时长(小时)', '视频总容量(G)', '音频总容量(G)', '图片总容量(G)');

				for ($i = 0; $i < count($tableheader); $i++) {
					$objPHPExcel->getActiveSheet()->setCellValue($letter[$i] . '4', $tableheader[$i]);
				}

				$i = 1;

				foreach ($resarray as $key => $val ) {
					$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 4), $i);
					$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 4), $val['unitname']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 4), $val['stationnum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 4), $val['usernum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 4), $val['bodynum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 4), $val['videonum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 4), $val['audionum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 4), $val['photonum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 4), round($val['videotime'] / 3600, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('J' . ($i + 4), round($val['videosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('K' . ($i + 4), round($val['audiosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('L' . ($i + 4), round($val['photosize'] / 1024, 2));
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':L' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':L' . ($i + 4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(16);
					$i++;
				}

				$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(11);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false);
				$A2_title = '【统计单位：' . $resarray[$unitsyscode]['unitname'] . '】 统计时段：' . $startdate . '至' . $enddate;
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(11);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);
				$A3_title = '【制表人：' . $_SESSION['realname'] . '】【生成日期：' . date('Y-m-d H:i:s', time()) . '】';
				$outputFileName = 'DataStat_unit';
				$objPHPExcel->getActiveSheet()->setTitle($outputFileName);
				$objPHPExcel->getActiveSheet()->setCellValue('A1', '基本数据统计--单位');
				$objPHPExcel->getActiveSheet()->setCellValue('A2', $A2_title);
				$objPHPExcel->getActiveSheet()->setCellValue('A3', $A3_title);
				$objPHPExcel->setActiveSheetIndex(0);
				ob_end_clean();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $outputFileName . '.xls"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}
		}
	}

	/* no using... */
	protected function search()
	{
		$resarray = array();
		$unit_temp = array();
		$unitsyscode = Zhimin::request('"unitsyscode"');

		if ($unitsyscode == '') {
			$unitsyscode = $_SESSION['unitsyscode'];
		}

		$stattype = Zhimin::request('stattype');
		$date_time = Zhimin::request('date_time');

		if ($date_time == '1') {
			$startdate = get_week_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else if ($date_time == '2') {
			$startdate = get_month_first_day();
			$enddate = date('Y-m-d H:i:s', time());
		}
		else {
			$startdate = Zhimin::request('startdate');
			$enddate = Zhimin::request('enddate');

			if ($startdate == '') {
				$startdate = get_month_first_day();
			}

			if ($enddate == '') {
				$enddate = date('Y-m-d H:i:s', time());
			}
		}

		$this->_data['startdate'] = $startdate;
		$this->_data['enddate'] = $enddate;
		$days = round((strtotime($enddate) - strtotime($startdate)) / 3600 / 24);
		$hours = $days * 8;
		$unit_m = new UnitModel();
		$sql = 'SELECT dname, bh, unitsyscode from zm_danwei where unitsyscode like \'' . $unitsyscode . '%\' ORDER BY unitsyscode;';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
			$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
			$resarray[$v['unitsyscode']]['bodynum'] = 0;
			$resarray[$v['unitsyscode']]['videoday'] = 0;
			$resarray[$v['unitsyscode']]['totalday'] = $days;
			$resarray[$v['unitsyscode']]['videotime'] = 0;
			$resarray[$v['unitsyscode']]['totaltime'] = $days;
			$resarray[$v['unitsyscode']]['diyu90day'] = 0;
			$resarray[$v['unitsyscode']]['wanyu24num'] = 0;
			$resarray[$v['unitsyscode']]['totalnum'] = 0;
			$resarray[$v['unitsyscode']]['totalusernum'] = 0;
			$resarray[$v['unitsyscode']]['parenttype'] = 0;
			$parentcode = substr($v['unitsyscode'], 0, strlen($v['unitsyscode']) - 3);

			if ($parentcode != '') {
				$resarray[$parentcode]['parenttype'] = 1;
			}

			$unit_temp[$v['bh']] = $v['unitsyscode'];
		}

		$sql = 'SELECT t1.unitcode, count(1) as num1, sum(t1.videotimelength/3600) vtl, sum(t1.videototalnum) vtn, ' . "\r\n" . '    	        sum(t1.wanvideonum) wvn, count(DISTINCT t1.hostcode) as hostnum , count(DISTINCT t1.hostbody) as bodynum ' . "\r\n" . '    	        , sum(CASE WHEN t1.videotimelength<25920 THEN 1 ELSE 0 END) diyu90 from  ' . "\r\n" . '    	        zm_lowsupervise_stat t1 WHERE t1.statdate BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' GROUP BY t1.unitcode';
		$res = $unit_m->dquery($sql);
		//echo("<p></p>385line:".$sql);

		foreach ($res as $k => $v ) {
			$unitsyscode_tmp = $unit_temp[$v['unitcode']];

			for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
				$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
				$resarray[$unitsys_temp]['bodynum'] += $v['bodynum'];
				$resarray[$unitsys_temp]['videoday'] += $v['num1'];
				$resarray[$unitsys_temp]['videotime'] += $v['vtl'];
				$resarray[$unitsys_temp]['diyu90day'] += $v['diyu90'];
				$resarray[$unitsys_temp]['wanyu24num'] += $v['wvn'];
				$resarray[$unitsys_temp]['totalnum'] += $v['vtn'];
				$resarray[$unitsys_temp]['totalusernum'] += $v['hostnum'];
			}
		}

		$this->_data['datas'] = $resarray;
	}
}


?>

<?php

class SuperviseAction extends Action
{
	protected $module_sn = 10021;

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
		$days = round((strtotime($enddate) - strtotime($startdate)) / 3600 / 24) + 1;
		$hours = $days * 8;

		if ($stattype == '2') {
			$sql = 'SELECT hostcode, hostname from zm_device ORDER BY hostcode;';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unit_temp[$v['hostcode']] = $v['hostname'];
			}

			$sql = 'SELECT t1.hostcode, t2.unitsyscode,t2.dname, count(1) as num1, sum(t1.videotimelength/3600) vtl, ' . "\r\n" . '	    	        sum(t1.videototalnum) vtn, sum(t1.wanvideonum) wvn, count(DISTINCT t1.hostcode) as hostnum , ' . "\r\n" . '	    	        count(DISTINCT t1.hostbody) as bodynum , sum(CASE WHEN t1.videotimelength<25920 THEN 1 ELSE 0 END) diyu90 ' . "\r\n" . '	    	        from  zm_lowsupervise_stat t1  JOIN zm_danwei t2 ON t1.unitcode=t2.bh and t1.statdate ' . "\r\n" . '	    	        BETWEEN \'' . $startdate . '\' AND \'' . $enddate . '\' and unitsyscode like \'' . $unitsyscode . '%\' GROUP BY t1.hostcode ORDER BY t2.unitsyscode; ';
			$res = $unit_m->dquery($sql);
			$this->_data['datas'] = $res;
			$this->_data['days'] = $days;
			$this->_data['userarray'] = $unit_temp;

			if ($excel == 'yes') {
				require_once ('./PHPExcel/PHPExcel.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator('ctos')->setLastModifiedBy('ctos')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('Test result file');
				$objPHPExcel->getProperties()->setCreator('Maarten Balliauw');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
				$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
				$objPHPExcel->getActiveSheet()->mergeCells('A3:N3');
				$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
				$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
				$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
				$objPHPExcel->getActiveSheet()->mergeCells('F4:H4');
				$objPHPExcel->getActiveSheet()->mergeCells('I4:K4');
				$objPHPExcel->getActiveSheet()->mergeCells('L4:N4');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '个人执法监督考核')->setCellValue('A4', '单位名称')->setCellValue('B4', $_SESSION['zfz_type'] . '姓名')->setCellValue('C4', '摄录天数')->setCellValue('F4', '摄录时长(小时)')->setCellValue('I4', '摄录时长低于90%')->setCellValue('L4', '晚于24小时长传')->setCellValue('C5', '摄录天数')->setCellValue('D5', '总天数')->setCellValue('E5', '天数比率')->setCellValue('F5', '摄录时长')->setCellValue('G5', '总时长')->setCellValue('H5', '时长比率')->setCellValue('I5', '天数')->setCellValue('J5', '总天数')->setCellValue('K5', '天数比率')->setCellValue('L5', '视频数')->setCellValue('M5', '总视频数')->setCellValue('N5', '上传比率');
				$i = 2;

				foreach ($res as $key => $val ) {
					$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 4), $val['dname']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 4), $unit_temp[$val['hostcode']] . '(' . $val['hostcode'] . ')');
					$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 4), $val['num1']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 4), $days);
					$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 4), round(($val['num1'] / $days) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 4), round($val['vtl'], 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 4), $days * 8);
					$objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 4), round(($val['vtl'] / $days) * 8 * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 4), $val['diyu90']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('J' . ($i + 4), $days);
					$objPHPExcel->getActiveSheet(0)->setCellValue('K' . ($i + 4), round(($val['diyu90'] / $days) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('L' . ($i + 4), $val['wvn']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('M' . ($i + 4), $val['vtn']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('N' . ($i + 4), round(($val['wvn'] / $val['vtn']) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':N' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':N' . ($i + 4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(16);
					$i++;
				}

				$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A5:N5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
				$outputFileName = 'SuperviseCheck_persion';
				$objPHPExcel->getActiveSheet()->setTitle($outputFileName);
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

			foreach ($res as $k => $v ) {
				$unit_temp[$v['bh']] = $v['unitsyscode'];
				if (((strlen($unitsyscode) + 3) < strlen($v['unitsyscode'])) || (strlen($v['unitsyscode']) < strlen($unitsyscode))) {
					continue;
				}

				$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
				$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
				$resarray[$v['unitsyscode']]['bodynum'] = 0;
				$resarray[$v['unitsyscode']]['videoday'] = 0;
				$resarray[$v['unitsyscode']]['totalday'] = $days;
				$resarray[$v['unitsyscode']]['videotime'] = 0;
				$resarray[$v['unitsyscode']]['totaltime'] = $hours;
				$resarray[$v['unitsyscode']]['diyu90day'] = 0;
				$resarray[$v['unitsyscode']]['wanyu24num'] = 0;
				$resarray[$v['unitsyscode']]['totalnum'] = 0;
				$resarray[$v['unitsyscode']]['totalusernum'] = 0;
				$resarray[$v['unitsyscode']]['parenttype'] = 0;
				$parentcode = substr($v['unitsyscode'], 0, strlen($v['unitsyscode']) - 3);
				if (($parentcode != '') && (strlen($unitsyscode) <= strlen($parentcode))) {
					$resarray[$parentcode]['parenttype'] = 1;
				}
			}

			$sql = 'SELECT t.danwei, count(DISTINCT t.hostcode) as num1, count(DISTINCT t.hostbody) as num2 from zm_device t GROUP BY t.danwei;';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['danwei']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
					if (((strlen($unitsyscode) + 3) < strlen($unitsys_temp)) || (strlen($unitsys_temp) < strlen($unitsyscode))) {
						continue;
					}

					$resarray[$unitsys_temp]['bodynum'] += $v['num2'];
				}
			}

			$sql = 'SELECT t1.unitcode, count(1) as num1, sum(t1.videotimelength/3600) vtl, sum(t1.videototalnum) vtn, ' . "\r\n" . '	    	        sum(t1.wanvideonum) wvn, count(DISTINCT t1.hostcode) as hostnum , count(DISTINCT t1.hostbody) as bodynum ' . "\r\n" . '	    	        , sum(CASE WHEN t1.videotimelength<25920 THEN 1 ELSE 0 END) diyu90 from  ' . "\r\n" . '	    	        zm_lowsupervise_stat t1 where t1.statdate BETWEEN \'' . $startdate . '\' ' . "\r\n" . '	    	        AND \'' . $enddate . '\'  GROUP BY t1.unitcode';
			$res = $unit_m->dquery($sql);

			foreach ($res as $k => $v ) {
				$unitsyscode_tmp = $unit_temp[$v['unitcode']];

				for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
					$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);
					if (((strlen($unitsyscode) + 3) < strlen($unitsys_temp)) || (strlen($unitsys_temp) < strlen($unitsyscode))) {
						continue;
					}

					$resarray[$unitsys_temp]['videoday'] += $v['num1'];
					$resarray[$unitsys_temp]['videotime'] += $v['vtl'];
					$resarray[$unitsys_temp]['diyu90day'] += $v['diyu90'];
					$resarray[$unitsys_temp]['wanyu24num'] += $v['wvn'];
					$resarray[$unitsys_temp]['totalnum'] += $v['vtn'];
					$resarray[$unitsys_temp]['totalusernum'] += $v['hostnum'];
				}
			}

			$this->_data['datas'] = $resarray;

			if ($excel == 'yes') {
				require_once ('./PHPExcel/PHPExcel.php');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator('ctos')->setLastModifiedBy('ctos')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('Test result file');
				$objPHPExcel->getProperties()->setCreator('Maarten Balliauw');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
				$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
				$objPHPExcel->getActiveSheet()->mergeCells('A3:N3');
				$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
				$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
				$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
				$objPHPExcel->getActiveSheet()->mergeCells('F4:H4');
				$objPHPExcel->getActiveSheet()->mergeCells('I4:K4');
				$objPHPExcel->getActiveSheet()->mergeCells('L4:N4');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '单位执法监督考核')->setCellValue('A4', '部门/' . $_SESSION['zfz_type'] . '姓名')->setCellValue('B4', '记录仪台数')->setCellValue('C4', '摄录天数')->setCellValue('F4', '摄录时长(小时)')->setCellValue('I4', '摄录时长低于90%')->setCellValue('L4', '晚于24小时长传')->setCellValue('C5', '摄录天数')->setCellValue('D5', '总天数')->setCellValue('E5', '天数比率')->setCellValue('F5', '摄录时长')->setCellValue('G5', '总时长')->setCellValue('H5', '时长比率')->setCellValue('I5', '天数')->setCellValue('J5', '总天数')->setCellValue('K5', '天数比率')->setCellValue('L5', '视频数')->setCellValue('M5', '总视频数')->setCellValue('N5', '上传比率');
				$i = 2;

				foreach ($resarray as $key => $val ) {
					$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 4), $val['unitname']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 4), $val['bodynum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 4), $val['videoday']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 4), $val['totalday'] * $val['bodynum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 4), round(($val['videoday'] / $val['totalday'] / $val['bodynum']) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 4), round($val['videotime'], 2));
					$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 4), $val['totaltime'] * $val['bodynum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 4), round(($val['videotime'] / $val['totaltime'] / $val['bodynum']) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 4), $val['diyu90day']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('J' . ($i + 4), $val['totalday'] * $val['bodynum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('K' . ($i + 4), round(($val['diyu90day'] / $val['totalday'] / $val['bodynum']) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet(0)->setCellValue('L' . ($i + 4), $val['wanyu24num']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('M' . ($i + 4), $val['totalnum']);
					$objPHPExcel->getActiveSheet(0)->setCellValue('N' . ($i + 4), round(($val['wanyu24num'] / $val['totalnum']) * 100, 2) . '%');
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':N' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':N' . ($i + 4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(16);
					$i++;
				}

				$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle('A5:N5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
				$outputFileName = 'SuperviseCheck_unit';
				$objPHPExcel->getActiveSheet()->setTitle($outputFileName);
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
}


?>

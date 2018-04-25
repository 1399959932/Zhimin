<?php

class AssetsAction extends Action
{
	protected $module_sn = 10052;

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

		//我怀疑上面是公共的
		$unit_m = new UnitModel();
		$sql = 'SELECT dname, bh, unitsyscode from zm_danwei where unitsyscode like \'' . $unitsyscode . '%\' ORDER BY unitsyscode;';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
			$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
			$resarray[$v['unitsyscode']]['bodynum'] = 0;
			$resarray[$v['unitsyscode']]['stationnum'] = 0;
			$resarray[$v['unitsyscode']]['usernum'] = 0;
			$resarray[$v['unitsyscode']]['stationtotsize'] = 0;
			$resarray[$v['unitsyscode']]['stationfreesize'] = 0;
			$resarray[$v['unitsyscode']]['bodyzhangnum'] = 0;
			$resarray[$v['unitsyscode']]['bodyfeinum'] = 0;
			$resarray[$v['unitsyscode']]['jibie'] = (strlen($v['unitsyscode']) - strlen($unitsyscode)) / 3;
			$unit_temp[$v['bh']] = $v['unitsyscode'];
		}

		$sql = 'SELECT t.unitcode, count(DISTINCT t.hostname) as num, sum(t.totalspace) as totspa, sum(t.freespace) as freespa from zm_hostip t GROUP BY t.unitcode';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$unitsyscode_tmp = $unit_temp[$v['unitcode']];

			for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
				$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

				if (array_key_exists($unitsys_temp, $resarray)) {
					$resarray[$unitsys_temp]['stationnum'] += $v['num'];
					$resarray[$unitsys_temp]['stationtotsize'] += $v['totspa'];
					$resarray[$unitsys_temp]['stationfreesize'] += $v['freespa'];
				}
			}
		}

		$sql = 'SELECT t.danwei, count(DISTINCT t.hostcode) as num1, count(DISTINCT t.hostbody) as num2 from zm_device t GROUP BY t.danwei;';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$unitsyscode_tmp = $unit_temp[$v['danwei']];

			for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
				$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

				if (array_key_exists($unitsys_temp, $resarray)) {
					$resarray[$unitsys_temp]['usernum'] += $v['num1'];
					$resarray[$unitsys_temp]['bodynum'] += $v['num2'];
				}
			}
		}

		$sql = 'SELECT t.danwei, count(DISTINCT t.hostbody) as num from zm_device t where t.state=1 GROUP BY t.danwei;';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$unitsyscode_tmp = $unit_temp[$v['danwei']];

			for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
				$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

				if (array_key_exists($unitsys_temp, $resarray)) {
					$resarray[$unitsys_temp]['bodyzhangnum'] += $v['num'];
				}
			}
		}

		$sql = 'SELECT t.danwei, count(DISTINCT t.hostbody) as num from zm_device t where t.state=2 GROUP BY t.danwei;';
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$unitsyscode_tmp = $unit_temp[$v['danwei']];

			for ($i = 1; $i <= strlen($unitsyscode_tmp) / 3; $i++) {
				$unitsys_temp = substr($unitsyscode_tmp, 0, $i * 3);

				if (array_key_exists($unitsys_temp, $resarray)) {
					$resarray[$unitsys_temp]['bodyfeinum'] += $v['num'];
				}
			}
		}

		$this->_data['datas'] = $resarray;

		if ($excel == 'yes') {
			require_once ('./PHPExcel/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator('ctos')->setLastModifiedBy('ctos')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('Test result file');
			$objPHPExcel->getProperties()->setCreator('Maarten Balliauw');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
			$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
			$tableheader = array('序号', '部门名称', $_SESSION['zfz_type'] . '人数', '工作站台数', '执法仪个数', '采集工作站容量', '采集工作站已使用容量', '记录仪保修', '记录仪报废');

			for ($i = 0; $i < count($tableheader); $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue($letter[$i] . '4', $tableheader[$i]);
			}

			$i = 1;

			foreach ($resarray as $key => $val ) {
				$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 4), $i);
				$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 4), $val['unitname']);
				$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 4), $val['usernum']);
				$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 4), $val['stationnum']);
				$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 4), $val['bodynum']);
				$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 4), round($val['stationtotsize'] / 1024, 2) . ' G');
				$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 4), round(($val['stationtotsize'] - $val['stationfreesize']) / 1024, 2) . ' G');
				$objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 4), $val['bodyzhangnum']);
				$objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 4), $val['bodyfeinum']);
				$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':I' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':I' . ($i + 4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(16);
				$i++;
			}

			$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false);
			$A2_title = '【统计单位：' . $resarray[$unitsyscode]['unitname'] . '】';
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);
			$A3_title = '【制表人：' . $_SESSION['realname'] . '】【生成日期：' . date('Y-m-d H:i:s', time()) . '】';
			$outputFileName = 'AssetsStat';
			$objPHPExcel->getActiveSheet()->setTitle($outputFileName);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', '资产统计');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', $A2_title);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', $A3_title);
			$objPHPExcel->setActiveSheetIndex(0);
			ob_end_clean();
			header('Content-Type: application/vnd.ms-excel;charset=UTF-8');
			header('Content-Disposition: attachment;filename="' . $outputFileName . '.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
	}
}


?>

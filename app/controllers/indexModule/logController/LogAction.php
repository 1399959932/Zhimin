<?php

class LogAction extends Action
{
	protected $units = array();
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有访问权限', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'patchdel':
			$this->patchdel();
			break;

		case 'patchdown':
			$this->all_download();
			break;

		case 'search':
		default:
			$this->mlist();
			return $this;
			break;
		}
	}

	protected function mlist()
	{
		$log_m = new LogModel();
		$unit_m = new UnitModel();
		$log_types = $log_m->log_type;
		$this->_data['log_types'] = $log_types;
		$danwei = Zhimin::request('danwei');
		$date_time = Zhimin::request('date_time');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$sort = Zhimin::request('sort');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');

		if (empty($date_time)) {
			$date_time = '1';
		}

		$this->_data['date_time'] = $date_time;
		$url['danwei'] = $danwei;
		$url['date_time'] = $date_time;
		$url['sort'] = $sort;
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$this->url_base = suffix_url($this->url_base, $url);
		$wsql = '1=1';

		if (!empty($danwei)) {
			$danwei_array = array();
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$dlist1 = unit_string_sql($danwei_array);
			$wsql .= ' and `pl`.`unit_no` in (' . $dlist1 . ')';
		}
		else {
			$danwei_default = $unit_m->get_down();
			$danwei = $danwei_default['bh'];
		}

		$this->_data['danwei_default'] = $danwei;

		if (!empty($sort)) {
			$wsql .= ' and `pl`.`sort` = \'' . $sort . '\'';
		}

		if ($date_time == '2') {
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

			if ($edate1 < $sdate1) {
				$this->_hasError = true;
				$this->_error[0] = 'error.info';
				$this->_error[1] = array('message' => '开始时间不能晚于结束时间。', 'url' => Zhimin::buildUrl());
				return;
			}
		}
		else {
			$sdate1 = get_week_first_day();
			$edate1 = date('Y-m-d', time()) . ' 23:59:59';
			$date_time_name = '本周';
		}

		$wsql .= ' and `pl`.`logtime` between \'' . strtotime($sdate1) . '\' and  \'' . strtotime($edate1) . '\'';
		$sql = 'SELECT COUNT(*) as count FROM `' . $log_m->table() . '` as `pl` left join `zm_danwei` as `pd` on `pl`.`unit_no`=`pd`.`bh`  where ' . $wsql;
		$rs = $log_m->fetchOne('', $sql);
		$count = $rs['count'];

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
		$sql = 'SELECT `pl`.*,`pd`.`dname` FROM `' . $log_m->table() . '` as `pl` left join `zm_danwei` as `pd` on `pl`.`unit_no`=`pd`.`bh` where ' . $wsql . ' order by id desc ' . $limit;//echo($sql);
		$logs = $log_m->dquery($sql);
		$this->_data['logs'] = $logs;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function patchdel()
	{
		$auth = Zhimin::getComponent('auth');
		$this->_hasView = 0;
		$log_m = new LogModel();
		$idarray = Zhimin::param('idarray', 'post');
		$sql = 'DELETE from ' . $log_m->table() . ' where id in(' . $idarray . ')';
		$log_m->dquery($sql);

		echo 0;
	}

	protected function all_download()
	{
		$auth = Zhimin::getComponent('auth');
/*
		if (!$auth->checkPermitDown($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有下载的权限！', 'url' => $this->url_base);
			return;
		}
*/
		$this->_hasView = false;

		$log_m = new LogModel();
		$log_types = $log_m->log_type;
		$post_id_string = Zhimin::request('idarray');

		$sql = 'SELECT `pl`.*,`pd`.`dname` FROM `' . $log_m->table() . '` as `pl` left join `zm_danwei` as `pd` on `pl`.`unit_no`=`pd`.`bh` where `pl`.id in (' . $post_id_string . ') order by id desc ' . $limit;//echo($sql);
		$result = $log_m->fetchAll('', $sql);
		/*
		$i = 0;
		foreach ($result as &$val ) {
			echo $val['dname'] . "<br>";
			$i++;
		}
		*/
		/*
		$main_cfg = Zhimin::config('main');
		$config = $main_cfg['db'];
		$Connect = @mysql_connect($config['host'], $config['login'], $config['password']) or die("Couldn't connect.");  
		@mysql_query('set names utf8');
		@mysql_select_db($config['dbname'], $Connect) or die("Couldn't select  database"); 
		$result = @mysql_query($sql,$Connect) or die(mysql_error());  
		//while($val = mysql_fetch_array($result)) {
		//	echo $val['dname'] . "<br>";
		//}
		*/
		
		$this->exportToExcel('系统日志', $log_types, $result, 'log_'.date("YmjHis"));
	}

	function exportToExcel($top_title, $logtypes, $data, $outputFileName) {
		require_once('./PHPExcel/PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setCreator('ctos') -> setLastModifiedBy('ctos') -> setTitle('Office 2007 XLSX Test Document') -> setSubject('Office 2007 XLSX Test Document') -> setDescription('Test document for Office 2007 XLSX, generated using PHP classes.') -> setKeywords('office 2007 openxml php') -> setCategory('Test result file');
		$objPHPExcel -> getProperties() -> setCreator('Maarten Balliauw');
		$objPHPExcel -> getActiveSheet() -> mergeCells('A1:H1');
		$objPHPExcel -> getActiveSheet() -> mergeCells('A2:H2');
		$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
		$tableheader = array('序号', '所属单位', '警员姓名（警员编号）', '操作类型', '操作IP', '操作时间', '描述', '文件信息');
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(10);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(24);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(24);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(19);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(19);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(21);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(25);
		$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(24);
		$objPHPExcel -> getActiveSheet() -> getStyle('A') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('B') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('C') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('D') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('E') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('F') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('G') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('H') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		for ($i = 0; $i < count($tableheader); $i++) {
			$objPHPExcel -> getActiveSheet() -> setCellValue($letter[$i].'4', $tableheader[$i]);
		}
		$i = 1;
		foreach($data as & $val) {
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('A'.($i + 4), $i);
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('B'.($i + 4), $val['dname']);
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('C'.($i + 4), $val['realname'] == '' ? $val['username'] : $val['realname'].'('.$val['hostcode'].')');
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('D'.($i + 4), $logtypes[$val['sort']]);
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('E'.($i + 4), $val['net_ip']);
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('F'.($i + 4), date('Y-m-d H:i:s', $val['logtime']));
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('G'.($i + 4), $val['context']);
			$objPHPExcel -> getActiveSheet(0) -> setCellValue('H'.($i + 4), $val['filename']);
			$objPHPExcel -> getActiveSheet() -> getStyle('A'.($i + 4).':H'.($i + 4)) -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel -> getActiveSheet() -> getStyle('A'.($i + 4).':H'.($i + 4)) -> getBorders() -> getAllBorders() -> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel -> getActiveSheet() -> getRowDimension($i + 4) -> setRowHeight(16);
			$i++;
		}
		$objPHPExcel -> getActiveSheet() -> getStyle('A3:H3') -> getBorders() -> getAllBorders() -> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel -> getActiveSheet() -> getStyle('A1') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('A1') -> getFont() -> setSize(16);
		$objPHPExcel -> getActiveSheet() -> getStyle('A1') -> getFont() -> setBold(true);
		$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getFont() -> setSize(11);
		$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getFont() -> setBold(false);
		$A2_title = '【制表人：'.$_SESSION['realname'].'】【生成日期：'.date('Y-m-d H:i:s', time()).'】';
		$objPHPExcel -> getActiveSheet() -> setTitle($outputFileName);
		$objPHPExcel -> getActiveSheet() -> setCellValue('A1', $top_title);
		$objPHPExcel -> getActiveSheet() -> setCellValue('A2', $A2_title);
		$objPHPExcel -> setActiveSheetIndex(0);
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$outputFileName.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter -> save('php://output');
	}
}
?>

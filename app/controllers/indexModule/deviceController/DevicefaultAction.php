<?php

class DevicefaultAction extends Action
{
	protected $module_sn = '10062';

	public function init()
	{
		$this->layout('');
		$this->title = '记录仪管理-' . Zhimin::$name;
		return $this;
	}

	protected function _main()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$devicefault_m = new DevicerepairModel();
		$device_m = new DeviceModel();
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$this->url_base = Zhimin::buildUrl();

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$danwei = Zhimin::request('danwei');
		$hostname = Zhimin::request('hostname');
		$sdate = Zhimin::request('sdate');
		$edate = Zhimin::request('edate');
		$reason = Zhimin::request('reason');
		$hostbody = Zhimin::request('hostbody');
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$url['sdate'] = $sdate;
		$url['edate'] = $edate;
		$url['hostname'] = $hostname;
		$url['reason'] = $reason;
		$url['hostbody'] = $hostbody;
		$this->url_base = suffix_url($this->url_base, $url);
		$where = ' 1 = 1 ';
		$loginuser = $user_m->read($_SESSION['userid']);
		$loginunit = $user_m->get_manager_unit($_SESSION['userid']);

		if (!$auth->isSuperAdmin()) {
			$units = user_unit_stair($loginunit);
			$dlist = unit_string_sql($units);
			$where .= ' AND pdr.unit_no in (' . $dlist . ')';
		}

		if (!empty($danwei)) {
			$danwei_array = array();
			$deep_flg = $auth->canViewStair();
			$unit_m->get_subs_by_sn($danwei_array, $danwei, $deep_flg);
			$unit_m->get_subs_by_sn($danwei_array, $danwei);
			$dlist1 = unit_string_sql($danwei_array);
			$where .= ' AND pdr.unit_no in (' . $dlist1 . ')';
			$select_unit = $unit_m->get_by_sn($danwei);
			$this->_data['select_unit'] = $select_unit;
		}

		if (!empty($hostname)) {
			$where .= ' AND pdr.hostname like \'%' . $hostname . '%\' ';
		}

		if (!empty($reason)) {
			$where .= ' AND pdr.reason like \'%' . $reason . '%\' ';
		}

		if (!empty($hostbody)) {
			$where .= ' AND pdr.hostbody like \'%' . $hostbody . '%\' ';
		}

		if (!empty($sdate) && !empty($edate)) {
			$sdate = $sdate . '00:00:00';
			$edate = $edate . '23:59:59';
			$where .= ' and `pdr`.`report_date` between \'' . strtotime($sdate) . '\' and  \'' . strtotime($edate) . '\'';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $devicefault_m->table() . '` as `pdr` left join `zm_danwei` as `pd` on `pdr`.`unit_no`=`pd`.`bh`  where ' . $where;
		$rs = $devicefault_m->fetchOne('', $sql);
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
			$sql = 'SELECT pdr.*, pd.dname as unitname FROM `' . $devicefault_m->table() . '` pdr';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pdr.unit_no';
			$sql .= ' WHERE ' . $where . ' order by pdr.report_date desc ' . $limit;
			$devicefaults = $devicefault_m->fetchAll('', $sql);
			$this->_data['devicefaults'] = $devicefaults;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}
}


?>

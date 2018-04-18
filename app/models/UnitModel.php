<?php

class UnitModel extends BaseModel
{
	protected $_tbname = 'zm_danwei';
	protected $_p_k = 'id';
	public $tree_string = '';

	public function get_by_sn($sn, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `bh`=\'' . $sn . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_ids($id, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `id`=\'' . $id . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_syscode($id, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `unitsyscode`=\'' . $id . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_down($id = 0, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `parentid`=' . $id . ';';
		$ret = $this->fetchOne('', $statement);
		return $ret;
	}

	public function get_downs($id = 0, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `parentid`=' . $id . ';';
		$ret = $this->fetchAll('', $statement);
		return $ret;
	}

	public function get_by_bh_array($loginunit)
	{
		$units = array();

		foreach ($loginunit as $k => $v ) {
			$res = $this->get_by_sn($v);
			$units[$v]['name'] = $res['dname'];
			$units[$v]['bh'] = $res['bh'];
			$units[$v]['id'] = $res['id'];
			$units[$v]['parentid'] = $res['parentid'];

			if ($res['parentid'] != 0) {
				$punit = $this->read($res['parentid']);
				$units[$v]['pbh'] = $punit['bh'];
			}
			else {
				$units[$v]['pbh'] = '';
			}
		}

		return $units;
	}

	public function get_subs_by_sn(&$units, $sn, $deep = true, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (empty($sn)) {
			return false;
		}

		$unit = $this->get_by_sn($sn);

		if (empty($unit)) {
			return false;
		}

		$pid = $unit['parentid'];

		if ($pid != 0) {
			$punit = $this->read($pid);
			$psn = $punit['bh'];
		}
		else {
			$psn = '';
		}

		$this->get_subs($units, $unit['id'], $psn, $deep, $with_owner, $fetchStyle);
	}

	public function get_subs(&$units, $id, $psn = '', $deep = true, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		$unit = $this->read($id);

		if ($with_owner) {
			$units[$unit['bh']]['name'] = $unit['dname'];
			$units[$unit['bh']]['bh'] = $unit['bh'];
			$units[$unit['bh']]['id'] = $unit['id'];
			$units[$unit['bh']]['parentid'] = $unit['parentid'];
			$units[$unit['bh']]['pbh'] = $psn;
		}

		$sql = 'SELECT id, bh, dname, parentid from `' . $this->table() . '` where parentid = ' . $id;
		$dws = $this->dquery($sql);

		if (is_array($dws)) {
			foreach ($dws as $dw ) {
				$units[$dw['bh']]['name'] = $dw['dname'];
				$units[$dw['bh']]['bh'] = $dw['bh'];
				$units[$dw['bh']]['id'] = $dw['id'];
				$units[$dw['bh']]['parentid'] = $dw['parentid'];
				$units[$dw['bh']]['pbh'] = $unit['bh'];

				if ($deep) {
					$this->get_subs($units, $dw['id'], $unit['bh'], $deep, $with_owner, $fetchStyle);
				}
			}
		}
	}

	public function get_units_stair(&$units, $id, $deep = true, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		if ($id != 0) {
			$unit = $this->read($id);
			if ($with_owner && empty($units)) {
				$units[$unit['bh']]['name'] = $unit['dname'];
				$units[$unit['bh']]['bh'] = $unit['bh'];
				$units[$unit['bh']]['id'] = $unit['id'];
				$units[$unit['bh']]['unitsyscode'] = $unit['unitsyscode'];
				$units[$unit['bh']]['parentid'] = $unit['parentid'];
				$units[$unit['bh']]['pbh'] = '';
				$child = &$units[$unit['bh']]['child'];
			}
			else {
				$child = &$units['child'];
			}
		}
		else {
			$child = &$units;
		}

		if ($deep) {
			$sql = 'SELECT id, bh, dname,parentid, unitsyscode from `' . $this->table() . '` where parentid = ' . $id . ' order by orderby asc';
			$dws = $this->dquery($sql);

			if (is_array($dws)) {
				foreach ($dws as $dw ) {
					$child[$dw['bh']]['name'] = $dw['dname'];
					$child[$dw['bh']]['bh'] = $dw['bh'];
					$child[$dw['bh']]['id'] = $dw['id'];
					$child[$dw['bh']]['unitsyscode'] = $dw['unitsyscode'];
					$child[$dw['bh']]['parentid'] = $dw['parentid'];

					if ($id != 0) {
						$child[$dw['bh']]['pbh'] = $unit['bh'];
					}

					if ($deep) {
						$this->get_units_stair($child[$dw['bh']], $dw['id'], $deep, $with_owner, $fetchStyle);
					}
				}
			}
		}
	}

	public function get_units_stair_json(&$units, $id, $select_id, $select_text, $deep = true, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		if ($id != 0) {
			$unit = $this->read($id);
			if ($with_owner && empty($units)) {
				$tmp = array();
				$tmp['id'] = $unit[$select_id];
				$tmp['text'] = $unit[$select_text];
				$tmp['children'] = array();
				$child = &$tmp['children'];
				array_push($units, $tmp);
			}
			else {
				$child = &$units['children'];
			}
		}
		else {
			$child = &$units;
		}

		if ($deep) {
			$sql = 'SELECT id, bh, dname,parentid, unitsyscode from `' . $this->table() . '` where parentid = ' . $id . ' order by orderby asc';
			$dws = $this->dquery($sql);

			if (is_array($dws)) {
				foreach ($dws as $dw ) {
					$tmp1 = array();
					$tmp1['id'] = $dw[$select_id];
					$tmp1['text'] = $dw[$select_text];
					$tmp1['children'] = array();

					if ($deep) {
						$this->get_units_stair_json($tmp1, $dw['id'], $select_id, $select_text, $deep, $with_owner, $fetchStyle);
					}

					if (!empty($tmp1['children'])) {
						$tmp1['state'] = 'closed';
					}

					$child[] = $tmp1;
				}
			}
		}

		if (!empty($child)) {
			$units[0]['state'] = 'closed';
		}
	}

	//modify：专为“设备管理”模块的“执法仪管理”下记录编辑界面里的单位列表显示【单位名称(编号)】
	public function get_units_stair_json2(&$units, $id, $select_id, $select_text, $deep = true, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		if ($id != 0) {
			$unit = $this->read($id);
			if ($with_owner && empty($units)) {
				$tmp = array();
				$tmp['id'] = $unit[$select_id];
				//modify
				//$tmp['text'] = $unit[$select_text];
				$tmp['text'] = $unit[$select_text] . '(' . $unit['bh'] . ')';
				//
				$tmp['children'] = array();
				$child = &$tmp['children'];
				array_push($units, $tmp);
			}
			else {
				$child = &$units['children'];
			}
		}
		else {
			$child = &$units;
		}

		if ($deep) {
			$sql = 'SELECT id, bh, dname,parentid, unitsyscode from `' . $this->table() . '` where parentid = ' . $id . ' order by orderby asc';
			$dws = $this->dquery($sql);

			if (is_array($dws)) {
				foreach ($dws as $dw ) {
					$tmp1 = array();
					$tmp1['id'] = $dw[$select_id];
					//$tmp1['text'] = $dw[$select_text];
					//modify
					$tmp1['text'] = $dw[$select_text] . '(' . $dw['bh'] . ')';
					//
					$tmp1['children'] = array();

					if ($deep) {
						$this->get_units_stair_json2($tmp1, $dw['id'], $select_id, $select_text, $deep, $with_owner, $fetchStyle);
					}

					if (!empty($tmp1['children'])) {
						$tmp1['state'] = 'closed';
					}

					$child[] = $tmp1;
				}
			}
		}

		if (!empty($child)) {
			$units[0]['state'] = 'closed';
		}
	}
	//
	
	public function MenuListUnit($pid)
	{
		$auth = Zhimin::getComponent('auth');

		if ($pid == 0) {
			$query = 'SELECT `id`,`bh`,`dname`,`parentid` FROM `zm_danwei` where `parentid`=' . $pid . ' order by orderby asc';
			$punit = $this->fetchOne('', $query);
		}
		else {
			$punit = $this->get_by_ids($pid);
		}

		if (!empty($punit)) {
			if (empty($punit['bh'])) {
				$this->tree_string = 'd.add(\'' . $punit['id'] . '\',-1,\'' . $punit['dname'] . '\',\'javascript:void(0);\',\'\',\'\');';
			}
			else {
				$this->tree_string = 'd.add(\'' . $punit['id'] . '\',-1,\'' . $punit['dname'] . '\',\'' . Zhimin::buildUrl('', '', '', 'action=highsearch&danwei=' . $punit['bh']) . '\',\'点击查看\',\'\');';
			}

			if ($auth->canViewStair()) {
				$this->MenuListUnitChildrens($pid);
			}

			return $this->tree_string;
		}
	}

	public function MenuListUnitChildrens($pid)
	{
		$query = 'SELECT `id`,`bh`,`dname`,`parentid` FROM `zm_danwei` where `parentid`=' . $pid . ' order by orderby asc';
		$rows = $this->dquery($query);

		if (0 < count($rows)) {
			foreach ($rows as $row ) {
				if (empty($row['bh'])) {
					$this->tree_string .= 'd.add(\'' . $row['id'] . '\',' . $row['parentid'] . ',\'' . $row['dname'] . '\',\'javascript:void(0);\',\'\',\'\');';
				}
				else {
					$this->tree_string .= 'd.add(\'' . $row['id'] . '\',' . $row['parentid'] . ',\'' . $row['dname'] . '\',\'' . Zhimin::buildUrl('', '', '', 'action=highsearch&danwei=' . $row['bh']) . '\',\'点击查看\',\'\');';
				}

				$this->MenuListUnitChildrens($row['id']);
			}
		}
		else {
			$sql = 'SELECT bh  FROM ' . $this->_tbname . ' where id = ' . $pid;
			$unitcode = $this->fetchOne('', $sql);
			$sql = 'select t.hostbody, t.hostname from zm_device t where t.danwei=\'' . $unitcode['bh'] . '\'';
			$rows = $this->dquery($sql);

			if (0 < count($rows)) {
				foreach ($rows as $row ) {
					if (preg_match('/^0*$/', $row['hostbody'])) {
						continue;
					}

					if (empty($row['hostbody'])) {
						$this->tree_string .= 'd.add(\'' . $row['hostbody'] . '\',' . $pid . ',\'' . $row['hostname'] . '\',\'javascript:void(0);\',\'\',\'\');';
					}
					else {
						$this->tree_string .= 'd.add(\'' . $row['hostbody'] . '\',' . $pid . ',\'' . $row['hostname'] . '\',\'' . Zhimin::buildUrl('', '', '', 'action=highsearch&hostbody=' . $row['hostbody']) . '\',\'点击查看\',\'\');';
					}
				}
			}
		}
	}

	public function getBrotherUnit($bh)
	{
		$own_unit = $this->get_by_ids($bh);
		$father_query = 'select * from `' . $this->table() . '` where `id`=\'' . $own_unit['parentid'] . '\'';
		$father_record = $this->dquery($father_query);
		$brother_query = 'select * from `' . $this->table() . '` where `parentid`=\'' . $father_record[0]['id'] . '\' and `id`!=\'' . $bh . '\'';
		$brother_record = $this->dquery($brother_query);
		return $brother_record;
	}

	public function getUnitSelect($unitsyscode, $type)
	{
		$auth = Zhimin::getComponent('auth');

		if ($auth->isSuperAdmin()) {
			$sql = 'SELECT t.bh, t.unitsyscode, t.dname from zm_danwei t ORDER BY t.unitsyscode';
		}
		else {
			$sql = 'SELECT t.bh, t.unitsyscode, t.dname from zm_danwei t WHERE t.unitsyscode LIKE \'' . $unitsyscode . '%\' ORDER BY t.unitsyscode';
		}

		$resarray = array();
		$unit_m = new UnitModel();
		$res = $unit_m->dquery($sql);

		foreach ($res as $k => $v ) {
			$resarray[$v['unitsyscode']]['unitname'] = $v['dname'];
			$resarray[$v['unitsyscode']]['unitcode'] = $v['bh'];
			$resarray[$v['unitsyscode']]['unitsyscode'] = $v['unitsyscode'];
			$resarray[$v['unitsyscode']]['parenttype'] = 0;
			$parentcode = substr($v['unitsyscode'], 0, strlen($v['unitsyscode']) - 3);

			if ($parentcode != '') {
				$resarray[$parentcode]['parenttype'] = 1;
			}
		}

		$strunit = '<ul class="ul_band">';

		foreach ($resarray as $unit ) {
			if ($unit['parenttype'] == 1) {
				$strunit .= '<li date="' . $unit['unitsyscode'] . '" class="li_child">' . "\r\n" . '							 <span></span>' . $unit['dname'] . '<ul>';
			}
		}
	}

	public function judge_deep_equiry($units)
	{
		if (empty($units)) {
			return false;
		}

		if (count($units) == 1) {
			return true;
		}

		$unit_first = $this->get_by_sn($units[0]);
		$unit_first_code = $unit_first['unitsyscode'];

		foreach ($units as $k => $v ) {
			$unit_temp = $this->get_by_sn($v);
			$unit_syn = $unit_temp['unitsyscode'];

			if (strlen($unit_first_code) != strlen($unit_syn)) {
				return false;
				exit();
			}
		}

		return true;
	}

	public function get_subs_parents(&$units, $id, $pid, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		$unit = $this->read($id);

		if ($with_owner) {
			$units[$unit['bh']]['name'] = $unit['dname'];
			$units[$unit['bh']]['bh'] = $unit['bh'];
			$units[$unit['bh']]['id'] = $unit['id'];
			$units[$unit['bh']]['parentid'] = $unit['parentid'];
		}

		if ($unit['parentid'] != 0) {
			$sql = 'SELECT id, bh, dname, parentid from `' . $this->table() . '` where `id` = ' . $unit['parentid'];
			$dw = $this->fetchOne('', $sql);

			if (!empty($dw)) {
				$this->get_subs_parents($units, $dw['id'], $dw['parentid'], $with_owner, $fetchStyle);
			}
		}
	}

	public function get_child_one_level($loginunit)
	{
		if (empty($loginunit)) {
			return false;
		}

		$units = array();

		foreach ($loginunit as $k => $v ) {
			$this_unit = $this->get_by_sn($v);
			$unit_one_level = $this->get_downs($this_unit['id']);
			array_push($units, $v);

			if (!empty($unit_one_level)) {
				foreach ($unit_one_level as $k1 => $v1 ) {
					array_push($units, $v1['bh']);
				}
			}
		}

		return $units;
	}
}


?>

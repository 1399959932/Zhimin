<?php

class ModuleModel extends BaseModel
{
	protected $_tbname = 'zm_module';
	protected $_p_k = 'bh';

	public function get_by_id($id, $fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$id = intval($id);
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '` WHERE `id`=' . $id . ';';
		$ret = $this->fetchOne('', $statement);
		return $ret;
	}

	public function get_by_bh($bh, $fields = '*', $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT ' . $fields . ' FROM `' . $this->_tbname . '` WHERE `bh`=' . $bh . ';';
		$ret = $this->fetchOne('', $statement);
		return $ret;
	}

	public function get_stair(&$modules, $id, $with_owner = true, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (trim($id) == '') {
			return false;
		}

		if ($id != 'SELF') {
			$module = $this->get_by_id($id);

			if ($with_owner) {
				$modules[$module['bh']] = $module;
				$child = &$modules[$module['bh']]['child'];
			}
			else {
				$child = &$modules['child'];
			}
		}
		else {
			$child = &$modules;
		}

		if ($id == 'SELF') {
			$sql = 'SELECT * FROM  `' . $this->table() . '` where mtype=\'SELF\' order by forder asc';
		}
		else {
			$sql = 'SELECT * FROM  `' . $this->table() . '` where isopen=0 and parentid=' . $id . ' order by bh';
		}

		$mds = $this->dquery($sql);

		if (is_array($mds)) {
			foreach ($mds as $md ) {
				$child[$md['bh']] = $md;
				$this->get_stair($child[$md['bh']], $md['id'], false, $fetchStyle);
			}
		}
	}
}


?>

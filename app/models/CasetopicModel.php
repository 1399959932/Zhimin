<?php

class CasetopicModel extends BaseModel
{
	protected $_tbname = 'zm_casetopic';
	protected $_p_k = 'id';

	public function get_by_sn($sn, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `sn`=\'' . $sn . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_by_pnumber($pnumber, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `pnumber`=\'' . $pnumber . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_next_sn($unit, $strdate = '')
	{
		if (empty($unit)) {
			return false;
		}

		if (empty($strdate)) {
			$strdate = date('Ymd');
		}

		$snumber = 1;
		$where .= ' sn like \'' . $unit . '-' . $strdate . '-%\'';
		$casetopic = $this->fetchOne('', 'select sn as min_sn from `' . $this->table() . '` where ' . $where . ' order by `id` desc limit 1;');

		if (empty($casetopic)) {
			return $unit . '-' . $strdate . '-' . sprintf('%03d', $snumber);
		}

		$snumber = end(explode('-', $casetopic['min_sn']));

		if (!is_numeric($snumber)) {
			return false;
		}

		$snumber++;
		return $unit . '-' . $strdate . '-' . sprintf('%03d', $snumber);
	}
}


?>

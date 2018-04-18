<?php

class CasetaxonModel extends BaseModel
{
	protected $_tbname = 'zm_casetaxon';
	protected $_p_k = 'id';

	public function get_next_sn()
	{
		$min_sn = '100';
		$group = $this->fetchOne('', 'select max(bh) as min_sn from `' . $this->table() . '`');
		if (empty($group) || ($group['min_sn'] < $min_sn)) {
			return $min_sn;
		}

		return $group['min_sn'] + 1;
	}
}


?>

<?php

class UnitjsonAction extends Action
{
	public function init()
	{
		return $this;
	}

	public function _main()
	{
		$unit_m = new UnitModel();
		$user_m = new UserModel();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

//		switch (1) {
//		default:
			$this->mlist();
			break;
//		}
	}

	protected function mlist()
	{
		$unit_m = new UnitModel();
		$select_id = trim(Zhimin::param('id', 'get'));
		$select_text = trim(Zhimin::param('text', 'get'));
		//$units_array_json = get_units_by_json($select_id, $select_text);
				
		//modify
		$type = trim(Zhimin::param('type', 'get'));
		if (!empty($type) && $type = "1") {
			$units_array_json = get_units_by_json2($select_id, $select_text);
		} else {
			$units_array_json = get_units_by_json($select_id, $select_text);
		}
		//

		echo json_encode($units_array_json);
		exit();
	}
}


?>

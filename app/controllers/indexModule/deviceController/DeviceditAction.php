<?php

class DeviceditAction extends Action
{
	protected $module_sn = '10061';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '记录仪编辑-' . Zhimin::$name;
		return $this;
	}

	protected function _main()
	{
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$this->_data['device_state'] = $device_m->_state;

		switch ($action) {
		case 'edit':
		default:
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;
		}
	}

	protected function edit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '您没有编辑的权限');
			return;
		}

		$device_m = new DeviceModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'get');
		$device = $device_m->read($id);

		if (empty($device)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '记录仪不存在');
			return;
		}

		$user_unit = $unit_m->get_by_sn($device['danwei']);
		$device['unit_name'] = $user_unit['dname'];
		$this->_data['data'] = $device;
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$unit_m = new UnitModel();
		$device_m = new DeviceModel();
		$id = Zhimin::param('id', 'post');
		$hostname = trim(Zhimin::param('hostname', 'post'));
		$hostcode = trim(Zhimin::param('hostcode', 'post'));
		$danwei = Zhimin::param('danwei', 'post');
		$product_name = trim(Zhimin::param('product_name', 'post'));
		$product_firm = trim(Zhimin::param('product_firm', 'post'));
		$capacity = trim(Zhimin::param('capacity', 'post'));
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';
		$device_res = $device_m->read($id);

		if (empty($device_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '记录仪不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($hostname == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '姓名不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，配发' . $_SESSION['zfz_type'] . '：' . $hostname;
		}

		if ($hostcode == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = $_SESSION['zfz_type'] . '编号不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，' . $_SESSION['zfz_type'] . '编号：' . $hostcode;
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '请选择单位';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_string .= '，单位：' . $log_unit['dname'];
		}

		if ($product_name != '') {
			$log_string .= '，产品名称：' . $product_name;
		}

		if ($product_firm != '') {
			$log_string .= '，厂商：' . $product_firm;
		}

		if ($capacity != '') {
			$log_string .= '，容量(MB)：' . $capacity;
		}

		$edit_flg = $device_m->updateRow('id=' . $id, array('hostname' => $hostname, 'hostcode' => $hostcode, 'danwei' => $danwei, 'product_name' => $product_name, 'product_firm' => $product_firm, 'capacity' => $capacity, 'moder' => $_SESSION['username'], 'modtime' => time()));

		if ($edit_flg) {
			$log_type = '092';
			$log_message = '编辑记录仪成功，记录仪编号：' . $device_res['hostbody'] . $log_string;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '编辑成功';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '编辑失败，请稍后重试';
			echo json_encode($result_array);
			exit();
		}
	}
}


?>

<?php

class HostipeditAction extends Action
{
	protected $module_sn = '10071';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		$this->title = '工作站编辑-' . Zhimin::$name;
		return $this;
	}

	protected function _main()
	{
		$units_array = get_units_by_web();
		$this->_data['units_array'] = get_units_by_web();
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

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

		$station_m = new StationModel();
		$unit_m = new UnitModel();
		$id = Zhimin::param('id', 'get');
		$hostip = $station_m->read($id);

		if (empty($hostip)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_iframe';
			$this->_error[1] = array('message' => '工作站不存在');
			return;
		}

		$user_unit = $unit_m->get_by_sn($hostip['unitcode']);
		$hostip['unit_name'] = $user_unit['dname'];
		$this->_data['data'] = $hostip;
	}

	protected function saveEdit()
	{
		$log = new LogModel();
		$unit_m = new UnitModel();
		$station_m = new StationModel();
		$id = Zhimin::param('id', 'post');
		$danwei = Zhimin::param('danwei', 'post');
		$hostip = trim(Zhimin::param('hostip', 'post'));
		$contact = trim(Zhimin::param('contact', 'post'));
		$telephone = trim(Zhimin::param('telephone', 'post'));
		$address = Zhimin::param('address', 'post');
		$memo = trim(Zhimin::param('memo', 'post'));
		$result_array = array();
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '您没有编辑的权限';
			echo json_encode($result_array);
			exit();
		}

		$log_string = '';
		$hostip_res = $station_m->read($id);

		if (empty($hostip_res)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '工作站不存在';
			echo json_encode($result_array);
			exit();
		}

		if ($danwei == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '单位不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_unit = $unit_m->get_by_sn($danwei);
			$log_string .= '，所属单位：' . $log_unit['dname'];
		}

		if ($hostip == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = 'IP地址不能为空';
			echo json_encode($result_array);
			exit();
		}
		else {
			$log_string .= '，IP地址：' . $hostip;
		}

		if ($contact != '') {
			$log_string .= '，负责人：' . $contact;
		}

		if ($telephone != '') {
			$log_string .= '，联系电话：' . $telephone;
		}

		if ($address != '') {
			$log_string .= '，工作站地址：' . $address;
		}

		if ($memo != '') {
			$log_string .= '，备注：' . $memo;
		}

		$edit_flg = $station_m->updateRow('id=' . $id, array('hostip' => $hostip, 'contact' => $contact, 'address' => $address, 'telephone' => $telephone, 'memo' => $memo, 'unitcode' => $danwei));

		if ($edit_flg) {
			$log_type = '062';
			$log_message = '编辑工作站成功，工作站名称：' . $hostip_res['hostname'] . $log_string;
			$log->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '编辑工作站成功';
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

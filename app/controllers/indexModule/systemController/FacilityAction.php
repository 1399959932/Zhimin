<?php

class FacilityAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$auth = Zhimin::getComponent('auth');
		$action = Zhimin::param('action', 'post');
		if($action == 'facilityCheck'){
			$this->facilityCheck();
			exit;
		}
		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			//无权限跳转
			$this->_error[1] = array('message' => '您没有管理员的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$config_m = new ConfigModel();
		$checkBoxes = array('safecode', 'main_file_logo', 'admin_file_logo', 'login_file_logo', 'station_file');
		$location = Zhimin::g('web_root');
		$document_root = Zhimin::g('document_root');
		// echo $location;exit;
		$this->_data['configs'] = $config_m->dquery('SELECT * FROM  `' . $config_m->table() . '` order by orders;');
		$this->_data['checkBoxes'] = $checkBoxes;
		$this->_data['location'] = $location;
		$this->_data['document_root'] = $document_root;

		$announce_m = new AnnounceModel();
		$announces = $announce_m->dquery('SELECT * FROM `' . $announce_m->table() . '` where position in(\'main\',\'all\') order by vieworder LIMIT 0, 10 ');
		$this->_data['top_announces'] = $announces;
		// 提交执行
		if (!is_null(Zhimin::request('submit_config')) && (Zhimin::request('submit_config') == 'config')) {
			$facility = Zhimin::request('facility');
			if(!$config_m->dquery('SELECT * FROM  `' . $config_m->table() . '` where `db_config` = "facility";')){
				$insert = $config_m->insertRow(array('db_config'=>'facility','db_name'=>'设备数量上限','db_value'=>$facility,'type'=>'input','moder'=>$_SESSION['username'],'modtime'=>time()));
				// echo '<pre>';print_r($insert);exit;
			}else{
				$config_m->updateRow('db_config = "facility"',array('db_value'=>$facility,'moder'=>$_SESSION['username'],'modtime'=>time()));
			}

			
			$log_type = '124';
			$log_m = new LogModel();
			$loginuser = $_SESSION['username'];
			$log_message = '用户：' . $loginuser . '设置设备管理!';
			$log_m->writeLog($log_type, $log_message);
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '修改成功!', 'url' => Zhimin::buildUrl('facility', 'system'));
			return NULL;
		}
		$val = $config_m->dquery('SELECT * FROM  `' . $config_m->table() . '` where `db_config` = "facility";');
		$this->_data['val'] = $val;
	}

}


?>

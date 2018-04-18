<?php

class ConfigAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function PrefixIndex($prefix, $id, $digitlength)
	{
		$temp = $id;

		for ($i = 0; $i < ($digitlength - strlen($id)); $i++) {
			$temp = '0' . $temp;
		}

		return $prefix . $temp;
	}

	public function _main()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->isSuperAdmin()) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有管理员的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return NULL;
		}

		$config_m = new ConfigModel();
		$checkBoxes = array('safecode', 'main_file_logo', 'admin_file_logo', 'login_file_logo', 'station_file');
		$location = Zhimin::g('web_root');
		$document_root = Zhimin::g('document_root');
		$this->_data['configs'] = $config_m->dquery('SELECT * FROM  `' . $config_m->table() . '` order by orders;');
		$this->_data['checkBoxes'] = $checkBoxes;
		$this->_data['location'] = $location;
		$this->_data['document_root'] = $document_root;
		$announce_m = new AnnounceModel();
		$announces = $announce_m->dquery('SELECT * FROM `' . $announce_m->table() . '` where position in(\'main\',\'all\') order by vieworder LIMIT 0, 10 ');
		$this->_data['top_announces'] = $announces;
		if (!is_null(Zhimin::request('submit_config')) && (Zhimin::request('submit_config') == 'config')) {
			$configs = $config_m->dquery('SELECT * FROM  `' . $config_m->table() . '`;');

			foreach ($configs as $config ) {
				$key = $config['db_config'];
				$val = Zhimin::param($key, 'post');

				//modify
				$_SESSION['zfz_type'] = Zhimin::param('zfz_type', 'post');
				//

				$note = Zhimin::param('note', 'post');
				if (($key == 'main_file_logo') || ($key == 'user_help_file') || ($key == 'station_file')) {
					@mkdir($document_root . 'upload/zm_config/', 511, true);
					$location_root = $document_root . 'upload/zm_config/';
					$is_del = Zhimin::param('remove_' . $key, 'post');

					if (@'is_del' == 'true') {
						@unlink($location_root . $config['db_value']);
						$config_m->updateRow('db_config=\'' . $key . '\'', array('db_value' => '', 'moder' => $_SESSION['username'], 'note' => $note, 'modtime' => time()));
					}
					else {
						if (is_uploaded_file($_FILES[$key]['tmp_name']) && (!$_FILES[$key]['name'] == '')) {
							$temp = explode('.', $_FILES[$key]['name']);
							$ext = $temp[1];
							$filename = $this->PrefixIndex($key, $config['id'], 5) . '.' . $ext;
							@unlink($location_root . $filename);
							copy($_FILES[$key]['tmp_name'], $location_root . $filename);
							$config_m->updateRow('db_config=\'' . $key . '\'', array('db_value' => $filename, 'moder' => $_SESSION['username'], 'note' => $note, 'modtime' => time()));
						}
					}
				}
				else if ($key == 'safecode') {
					if (is_null($val)) {
						$val = 0;
					}

					$config_m->updateRow('db_config=\'' . $key . '\'', array('db_value' => $val, 'moder' => $_SESSION['username'], 'modtime' => time()));
				}
				else {
					if (($key == 'version') || ($key == 'gpscenter') || ($key == 'gpsuri') || ($key == 'gpservuri')) {
					}
					else {
						$config_m->updateRow('db_config=\'' . $key . '\'', array('db_value' => $val, 'moder' => $_SESSION['username'], 'modtime' => time()));
					}
				}
			}

			$log_type = '124';
			$log_m = new LogModel();
			$loginuser = $_SESSION['username'];
			$log_message = '用户：' . $loginuser . '设置基本资料!';
			$log_m->writeLog($log_type, $log_message);
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '修改成功!', 'url' => Zhimin::buildUrl('config', 'system'));
			return NULL;
		}
	}
}


?>

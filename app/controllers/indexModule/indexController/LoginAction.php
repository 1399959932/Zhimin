<?php

class LoginAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$this->url_base = Zhimin::buildUrl();
		$action = Zhimin::request('action');
		$mac = new GetMacAddr(Zhimin::g('server_type'));
		$macencode = base64_encode($mac->mac_addr);

	/*
		if ($macencode != Zhimin::g('maccheckid')) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info_noreturn';
			$this->_error[1] = array('message' => '此软件未被授权,或已过期请和软件客服人员联系。电话95013-100-9000', 'url' => $this->url_base);
			return;
		}
	*/

		
		$user_m = new UserModel();
		$log = new LogModel();
		$group_m = new GroupModel();
		$unit_m = new UnitModel();
		$settings = Zhimin::a()->getData('settings');
		$this->_data['settings'] = $settings;
		if (($settings['main_file_logo'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['main_file_logo'])) {
			$logo_img = Zhimin::g('assets_uri') . 'upload/zm_config/' . $settings['main_file_logo'];
		}
		else {
			$logo_img = 'images/logo/login_file_logo_' . Zhimin::g('rowcustertype') . '.png';
		}

		$this->_data['logo'] = $logo_img;
		$zhimintype_num = Zhimin::g('zhimintype');

		switch ($zhimintype_num) {
		case '1':
			$zhimintype = '初级用户版';
			break;

		case '2':
			$zhimintype = '中级用户版';
			break;

		case '3':
		default:
			$zhimintype = '高级用户版';
			break;
		}

		$this->_data['zhimintype'] = $zhimintype;
		$this->_data['rowcustertype'] = Zhimin::g('rowcustertype');
		$this->_data['version'] = Zhimin::g('version');
		$help_file = '';
		if (($settings['user_help_file'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['user_help_file'])) {
			$help_file = getrooturl() . 'upload/zm_config/' . $settings['user_help_file'];
		}

		$this->_data['help_file'] = $help_file;

		if ($action == 'help_file') {
			$file_name = $help_file;
			$log_type = '013';
			$log_message = '下载用户手册';
			$log_filename = $settings['user_help_file'];
			$log->writeLog($log_type, $log_message, $log_filename);
			echo '<script language=\'javascript\'>location.href=\'' . $file_name . '\';</script>';
			exit();
		}

		$result_array = array();

		if ($action == 'check_username') {
			$username = trim(Zhimin::param('username', 'post', Zhimin::PARAM_MODE_SQL));
			$user = $user_m->get_by_name($username);

			if (empty($user)) {
				$result_array['state'] = 'fail';
			}
			else {
				$result_array['state'] = 'success';
			}

			echo json_encode($result_array);
			exit();
		}

		if ($action == 'check_user') {
			$username = trim(Zhimin::param('username', 'post', Zhimin::PARAM_MODE_SQL));
			$password = md5(trim(Zhimin::param('password', 'post', Zhimin::PARAM_MODE_SQL)));
			$user = $user_m->get_by_name($username);
			if (empty($user) || ($user['pdw'] != $password)) {
				$result_array['state'] = 'fail';
			}
			else {
				$result_array['state'] = 'success';
			}

			echo json_encode($result_array);
			exit();
		}

		if ($action == 'check_verify') {
			$p_vcode = md5(strtolower(Zhimin::param('verify', 'post')));

			if ($p_vcode != $_SESSION['vcode']) {
				$result_array['state'] = 'fail';
			}
			else {
				$result_array['state'] = 'success';
			}

			echo json_encode($result_array);
			exit();
		}

		if (($action == 'login_in') && (Zhimin::param('formstatus', 'post') == 'submit')) {
			$username = trim(Zhimin::param('username', 'post', Zhimin::PARAM_MODE_SQL));
			$password = md5(trim(Zhimin::param('password', 'post', Zhimin::PARAM_MODE_SQL)));
			$p_vcode = md5(strtolower(Zhimin::param('verify', 'post')));

			if ($settings['safecode'] == '1') {
				if ($p_vcode != $_SESSION['vcode']) {
					$this->_hasError = true;
					$this->_error[0] = 'error.info';
					$this->_error[1] = array('message' => '输入验证码不正确,或者超时', 'url' => $this->url_base);
					return;
				}
			}

			$user = $user_m->get_by_name($username);
			if (empty($user) || ($user['pdw'] != $password)) {
				$this->_hasError = true;
				$this->_error[0] = 'error.info';
				$this->_error[1] = array('message' => '用户名或密码错误！', 'url' => $this->url_base);
				return;
			}
			else if ($user['ispass'] == '0') {
				$this->_hasError = true;
				$this->_error[0] = 'error.info';
				$this->_error[1] = array('message' => '账号已冻结，请联系管理员！', 'url' => $this->url_base);
				return;
			}
			else {
				$group = $group_m->get_by_sn($user['gid']);
				$unitbyuser = $unit_m->get_by_sn($user['dbh']);
				$timestamp = time();
				$onlineip = NetUtils::get_client_ip();
				$logincode = num_rand(16);
				$_SESSION['username'] = $user['username'];
				$_SESSION['usersn'] = $user['userid'];
				$_SESSION['userid'] = $user['id'];
				$_SESSION['level'] = $user['ifadmin'];
				$_SESSION['hostcode'] = $user['hostcode'];
				$_SESSION['logincode'] = $logincode;
				$_SESSION['viewtype'] = $user['viewtype'];
				$_SESSION['groupid'] = ($user['ifadmin'] == 1 ? 'admin' : $user['gid']);
				$_SESSION['groupname'] = ($user['ifadmin'] == 1 ? '系统管理员' : $group['gname']);
				$_SESSION['realname'] = $user['realname'];
				$_SESSION['logtime'] = $timestamp;
				$_SESSION['logip'] = $user['loginip'];
				$_SESSION['unitcode'] = $user['dbh'];
				$_SESSION['unitsyscode'] = $unitbyuser['unitsyscode'];
				$_SESSION['unitname'] = $unitbyuser['dname'];
				//modify
				//$_SESSION['lastlogtime'] = date('Y-m-d H:i:s', $user['logintime']);
				$_SESSION['lastlogtime'] = empty($user['logintime']) ? '' : date('Y-m-d H:i', $user['logintime']);
				$config_m = new ConfigModel();
				$_SESSION['zfz_type'] = $config_m->getZfzType();
				//
				$login_usersn = $user['userid'];
				$login_username = $user['username'];
				cookie('logincode', $logincode, 'F');
				cookie('loginusername', $user['username'], 'F');
				$user_m->dquery('UPDATE `' . $user_m->table() . '` SET `loginnum`=loginnum+1,`logintime`=\'' . $timestamp . '\',logincode=\'' . $logincode . '\',`loginip`=\'' . $onlineip . '\' WHERE `id` =\'' . $user['id'] . '\'');
				$log_type = '001';
				$log_message = '单位：' . $unitbyuser['dname'] . '，用户：' . $user['username'] . '，成功登录!';
				$log->writeLog($log_type, $log_message);
				Zhimin::forward('index', 'index');
			}
		}
	}
}


?>

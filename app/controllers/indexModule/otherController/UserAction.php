<?php

class UserAction extends Action
{
	public function init()
	{
		return $this;
	}

	public function _main()
	{
		$action = Zhimin::param('action', 'get');

		if ($action == 'changepass') {
			if (Zhimin::request('saveflag') == '1') {
				$this->savePass();
			}
			else {
				$this->changePassPage();
			}

			return $this;
		}

		if ($action == 'user_exist') {
			$this->user_exist();
			return $this;
		}
	}

	protected function changePassPage()
	{
		$this->_layout = '';
		$id = intval(Zhimin::request('id'));

		if (!empty($id)) {
			$user_m = new UserModel();
			$user = $user_m->read($id);
			$this->_data['data'] = $user;
		}
	}

	protected function savePass()
	{
		$this->_hasView = false;
		$result_array = array();
		$result_array = array();
		$username = $_SESSION['username'];
		$post_oldpassword = Zhimin::param('number', 'post');
		$password = Zhimin::param('newnumber', 'post');
		$repassword = Zhimin::param('againnumber', 'post');
		$oldpassword = md5($post_oldpassword);
		$pwd_len = strlen($password);
		$user_m = new UserModel();
		$user = $user_m->get_by_name($username);
		$userpdw = $user['pdw'];
		if (($password != '') && ($oldpassword == $userpdw) && ($password == $repassword)) {
			$password = md5($password);
			$user_m->updateRow('username=\'' . $username . '\'', array('pdw' => $password));
			$result_array['state'] = 'success';
			$result_array['msg'] = '修改用户密码成功';
			$log_type = '093';
			$log_m = new LogModel();
			$log_message = '用户名：' . $username . '，修改密码成功!';
			$log_m->writeLog($log_type, $log_message);
			echo json_encode($result_array);
			exit();
		}
		else {
			if ($oldpassword != $userpdw) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '旧密码输入错误';
				echo json_encode($result_array);
				exit();
			}

			if ($password == '') {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '新密码不能为空';
				echo json_encode($result_array);
				exit();
			}

			if ($pwd_len < 6) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '新密码长度不能少于6位';
				echo json_encode($result_array);
				exit();
			}

			if (12 < $pwd_len) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '新密码长度不能多于12位';
				echo json_encode($result_array);
				exit();
			}

			if ($password == $post_oldpassword) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '新密码不能与旧密码一样';
				echo json_encode($result_array);
				exit();
			}

			if (($password == '') || ($password != $repassword)) {
				$result_array['state'] = 'fail';
				$result_array['msg'] = '新密码和确认密码不一致';
				echo json_encode($result_array);
				exit();
			}
		}
	}

	protected function user_exist()
	{
		$this->_hasView = false;
		$username = Zhimin::param('username', 'get');
		$user_m = new UserModel();
		$user = $user_m->get_by_name($username);

		if (!empty($user)) {
			echo 1;
		}
		else {
			echo 0;
		}
	}
}


?>

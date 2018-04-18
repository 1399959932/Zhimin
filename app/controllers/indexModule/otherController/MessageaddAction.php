<?php

class MessageaddAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		return $this;
	}

	public function _main()
	{
		$user_m = new UserModel();
		$sql = 'SELECT * FROM `' . $user_m->table() . '`';
		$users = $user_m->dquery($sql);
		$this->_data['users'] = $users;
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'sendmsg':
			if (Zhimin::request('saveflag') == '1') {
				$this->saveMessage();
			}
			else {
				$this->sendmsg();
			}

			break;

		case 'list':
		default:
			$this->mlist();
			break;
		}

		return $this;
	}

	protected function mlist()
	{
		$this->_layout = '';
		$message_m = new MessageModel();
		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$uusersn = $_SESSION['usersn'];
		$sql = 'SELECT COUNT(*) as count FROM `' . $message_m->table() . '` where is_del=0 and touserid=\'' . $uusersn . '\'';
		$rs = $message_m->dquery($sql);
		$count = $rs[0]['count'];

		if ($count == 0) {
			return NULL;
		}

		if (!is_numeric($lines)) {
			$lines = 12;
		}

		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$pageNums = ceil($count / $lines);
		if ($pageNums && ($pageNums < $page)) {
			$page = $pageNums;
		}

		$start = ($page - 1) * $lines;
		$limit = 'LIMIT ' . $start . ',' . $lines;
		$sql = 'SELECT * FROM `' . $message_m->table() . '` WHERE is_del=0 and touserid=\'' . $uusersn . '\' order by msgid desc ' . $limit;
		$messages = $message_m->dquery($sql);
		$this->_data['messages'] = $messages;
		$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
	}

	protected function sendmsg()
	{
		$this->_layout = '';
		$message_m = new MessageModel();
		$remsgid = intval(Zhimin::param('msgid', 'get'));
		$remsg = $message_m->read($remsgid);
		$message_m->updateRow('msgid=' . $remsgid, array('is_new' => 0));
		$data = array('rename' => $remsg['username'], 'retitle' => 're:' . $remsg['title'], 'recontent' => $remsg['content'] . "\n" . DateUtils::cdate($remsg['in_time']) . '发送的短信息' . "\n" . '----------------------------------------------------------' . "\n" . '');
		$this->_data['data'] = $data;
	}

	protected function saveMessage()
	{
		$uusersn = $_SESSION['userid'];
		$loginuser = $_SESSION['username'];
		$postusername = Zhimin::param('tousername', 'post');
		$posttitle = Zhimin::param('title', 'post');
		$postcontent = Zhimin::param('content', 'post');
		$user_m = new UserModel();
		$result_array = array();
		$puser = $user_m->get_by_name($postusername);

		if ($postusername == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '收信人不能为空！';
			echo json_encode($result_array);
			exit();
		}

		if (empty($puser)) {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '收信人不存在！';
			echo json_encode($result_array);
			exit();
		}

		if ($posttitle == '') {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '标题不能为空！';
			echo json_encode($result_array);
			exit();
		}

		$touserid = $puser['id'];
		$tousername = $puser['username'];
		$message_m = new MessageModel();
		$id = $message_m->insertRow(array('userid' => $uusersn, 'username' => $loginuser, 'touserid' => $touserid, 'tousername' => $tousername, 'title' => $posttitle, 'content' => $postcontent, 'is_new' => 1, 'in_time' => time()));

		if (0 < intval($id)) {
			$log_type = '004';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '向用户：' . $tousername . '发送站内信成功!';
			$log_m->writeLog($log_type, $log_message);
			$result_array['state'] = 'success';
			$result_array['msg'] = '发送短信息成功!';
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			$result_array['msg'] = '发送短信息失败!';
			echo json_encode($result_array);
			exit();
		}

		exit();
	}
}


?>

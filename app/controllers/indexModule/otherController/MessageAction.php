<?php

class MessageAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		return $this;
	}

	public function _main()
	{
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;

		switch ($action) {
		case 'delmsg':
			$this->delmsg();
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
		$uusersn = $_SESSION['userid'];
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

	protected function delmsg()
	{
		$loginuser = $_SESSION['username'];
		$postid = Zhimin::param('id', 'post');
		$message_m = new MessageModel();
		$result_array = array();
		$mun = $message_m->deleteRow('msgid=' . $postid . ' and tousername=\'' . $loginuser . '\'');

		if (0 < intval($mun)) {
			$result_array['state'] = 'success';
			$log_type = '005';
			$log_m = new LogModel();
			$log_message = '用户：' . $loginuser . '，删除站内信!';
			$log_m->writeLog($log_type, $log_message);
			echo json_encode($result_array);
			exit();
		}
		else {
			$result_array['state'] = 'fail';
			echo json_encode($result_array);
			exit();
		}
	}
}


?>

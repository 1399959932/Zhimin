<?php

class MessageviewAction extends Action
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
		$this->mlist();
		return $this;
	}

	protected function mlist()
	{
		$this->_layout = '';
		$msgid = Zhimin::request('msgid');
		$message_m = new MessageModel();
		$message = $message_m->read($msgid);
		$this->_data['message'] = $message;
		$message_m->updateRow('msgid=' . $msgid, array('is_new' => 0));
		$tousername = $message['username'];
		$loginuser = $message['tousername'];
		$log_type = '003';
		$log_m = new LogModel();
		$log_message = '用户：' . $loginuser . '查看用户：' . $tousername . '发送的站内信!';
		$log_m->writeLog($log_type, $log_message);
	}
}


?>

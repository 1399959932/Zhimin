<?php

class Report
{
	/**
     * @var resource $_socket
     */
	protected $_socket;
	protected $_error;
	protected $_host;
	protected $_port;
	protected $_status;
	protected $_receiver;

	public function error($e)
	{
		return $this->send($e['message']);
	}

	public function __construct($param)
	{
		$this->_host = $param['host'];
		$this->_port = $param['port'];
		$this->_status = $param['status'];
		$this->_receiver = $param['receiver'];
	}

	protected function _init($host, $port)
	{
		$this->_socket = @socket_create(AF_INET, SOCK_STREAM, 0);

		if ($this->_socket !== false) {
			if (!@socket_connect($this->_socket, $host, $port)) {
				$this->_socket = false;
			}
		}

		if ($this->_socket === false) {
			$this->_error = socket_strerror(socket_last_error());
		}
	}

	public function send($msg, $name = NULL)
	{
		if ($this->_status == 'off') {
			return true;
		}

		if (!$this->_socket) {
			$this->_init($this->_host, $this->_port);
		}

		if ($this->_error) {
			return false;
		}

		if (is_null($name)) {
			$name = $this->_receiver;
		}

		$data = json_encode(array('to' => $name, 'msg' => $msg));
		$rs = socket_write($this->_socket, $data, strlen($data));

		if ($rs === false) {
			$this->_error = socket_strerror(socket_last_error());
		}
		else {
			socket_recv($this->_socket, $data, 1024, MSG_WAITALL);

			if ($data == 'success') {
				$rs = true;
			}
			else {
				$rs = false;
				$this->_error = '服务端接收失败。';
			}
		}

		return $rs;
	}

	public function getError()
	{
		return $this->_error;
	}
}


?>

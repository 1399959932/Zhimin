<?php

class LogoutAction extends Action
{
	public function init()
	{
		$this->_hasView = false;
		return $this;
	}

	public function _main()
	{
		$unit_m = new UnitModel();
		$log = new LogModel();
		$unitbyuser = $unit_m->get_by_sn($_SESSION['unitcode']);
		$log_type = '002';
		$log_message = '单位：' . $unitbyuser['dname'] . ',用户：' . $_SESSION['username'] . '，成功注销!';
		$log->writeLog($log_type, $log_message);
		cookie('logincode', '', 0);
		cookie('loginusername', '', 0);
		session_destroy();
		Zhimin::forward('login');
	}
}


?>

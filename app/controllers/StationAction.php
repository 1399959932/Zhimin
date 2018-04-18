<?php

class StationAction extends Action
{
	public function __construct()
	{
		$this->_hasView = 0;
	}

	protected function _main()
	{
		$hostname = Zhimin::param('s', 'get', Zhimin::PARAM_MODE_SQL);
		$sCheck = Zhimin::param('p', 'get');
		$sKey = 'ZmStation20160618';
		$md5 = md5($hostname . '-' . $sKey);
		$sVal = substr($md5, 12, 10);
		Zhimin::$log->record('工作站:' . $hostname . '验证:' . $sVal . '-' . $sCheck, 'info', 'common');

		if ($sVal == $sCheck) {
			$station_m = new StationModel();
			$station = $station_m->get_by_name($hostname);

			if (!$station) {
				exit(1);
			}

			$stime = time();
			$ltime = strtotime($station['modtime']);
			$lonline = $station['online'];
			$valid_time = 10 * 60;
			$data = array('modtime' => date('Y-m-d H:i:s', $stime), 'online' => '1');
			$sversion = get_info('version');

			if (in_array(substr($sversion, 0, 3), array('2.1', '2.2', '2.3'))) {
				if ($valid_time < ($stime - $ltime)) {
					$data['startime'] = date('Y-m-d H:i:s', $stime);
				}
			}

			$station_m->updateRow('hostname=\'' . $hostname . '\'', $data);

			if (Zhimin::param('debug', 'get') == '1') {
				$data['lastime'] = date('Y-m-d H:i:s', $ltime);
				Zhimin::$log->record(json_encode($data), 'info', 'common');
			}

			echo 0;
		}
	}
}


?>

<?php

class MediagpsModel extends BaseModel
{
	protected $_tbname = 'zm_video_gps';
	protected $_p_k = 'id';

	public function get_one($filename, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT * FROM `' . $this->_tbname . '` WHERE `filename`=\'' . $filename . '\';';
		$this->query('', $statement);
		$ret = $this->fetch('', $fetchStyle);
		$this->free_result('');
		return $ret;
	}

	public function get_lnglat(&$lat, &$lng, $filename, $ftime, $starttime)
	{
		$gps = $this->get_one($filename);

		if (!empty($gps)) {
			$packgps_arr = explode(';', $gps['packgps']);

			foreach ($packgps_arr as $packgps ) {
				$_arr = explode(',', $packgps);

				if (count($_arr) < 6) {
					continue;
				}

				$_time = strtotime($_arr[5]);
				$_tmp = $_time - $starttime - $ftime;
				if ((1 < abs($_tmp)) && (abs($_tmp) < 3)) {
					$lat = floor($_arr[1] / 100) + round(($_arr[1] % 100) / 60, 8);
					$lng = floor($_arr[3] / 100) + round(($_arr[3] % 100) / 60, 8);

					return true;
				}

				if (2 < $_tmp) {
					break;
				}
			}
		}

		return false;
	}

	public function get_lnglats($filename, $starttime)
	{
		$ret = array();
		$gps = $this->get_one($filename);
		$i = 0;

		if (!empty($gps)) {
			$packgps_arr = explode(';', $gps['packgps']);

			foreach ($packgps_arr as $packgps ) {
				$_arr = explode(',', $packgps);

				if (count($_arr) < 6) {
					continue;
				}

				if ($_arr[0] == 0) {
					continue;
				}

				$_time = strtotime($_arr[5]);
				$_tmp = $_time - $starttime;
				$nLat = floor($_arr[1] / 100);
				$nLng = floor($_arr[3] / 100);
				$lat = $nLat + round(($_arr[1] - ($nLat * 100)) / 60, 10);
				$lng = $nLng + round(($_arr[3] - ($nLng * 100)) / 60, 10);
				$ret[] = array('lat' => $lat, 'lng' => $lng, 'ftime' => $_tmp);
			}
		}

		return $ret;
	}
}


?>

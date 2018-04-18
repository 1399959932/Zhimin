<?php

class MapAction extends Action
{
	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$filename = Zhimin::request('filename');
		$mediagps_m = new MediagpsModel();
		$this->load_gps($filename, strtotime('2020-04-08 17:50:39'));
	}

	private function load_gps($fileName, $createTime)
	{
		$point_s = get_info('gpscenter');
		$point_arr = array();

		if (!empty($point_s)) {
			$point_arr = explode(',', $point_s);
			if (is_numeric($point_arr[0]) && is_numeric($point_arr[1])) {
				$this->_data['gpscenter'] = array('lat' => $point_arr[1], 'lng' => $point_arr[0]);
			}
		}

		if (!isset($this->_data['gpscenter'])) {
			$this->_data['gpscenter'] = array('lat' => 22.53126, 'lng' => 113.9425);
		}

		$gps_uri = get_info('gpsuri');

		if (empty($gps_uri)) {
			$this->_data['gpserror'] = 'GPS接口未配置！！！';
			return;
		}
		else {
			$this->_data['gpsuri'] = $gps_uri;
		}

		$gps_servuri = get_info('gpservuri');

		if (empty($gps_servuri)) {
			$this->_data['gpservuri'] = 'GPS服务接口未配置！！！';
			return;
		}
		else {
			$this->_data['gpservuri'] = $gps_servuri;
		}

		$mediagps_m = new MediagpsModel();
		$gps_datas = $mediagps_m->get_lnglats($fileName, $createTime);
		$xml = '<Gis_Req Ver="1.0.0">' . "\r\n" . '				<COR>';

		foreach ($gps_datas as $gps ) {
			$xml .= '' . "\r\n" . '				<pos isOriginalCoord="true">' . $gps['lng'] . ' ' . $gps['lat'] . '</pos>';
		}

		$xml .= '' . "\r\n" . '			</COR>' . "\r\n" . '			</Gis_Req>';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $gps_uri);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$ret_xml = curl_exec($ch);
		curl_close($ch);

		try {
			$ret_sxml = new SimpleXMLElement($ret_xml);
		}
		catch (Exception $ex) {
			$this->_data['gps_data'] = array();
			return;
		}

		if ($ret_sxml) {
			$error_arr = $ret_sxml->xpath('HDA/Error');
			$pos_arr = $ret_sxml->xpath('COA/pos');
			if ((0 < count($error_arr)) || (count($pos_arr) == 0)) {
				$gps_datas = array();
			}
			else {
				$ret_count = count($gps_datas);

				for ($i = 0; $i < $ret_count; $i++) {
					$ret_item = $pos_arr[$i];

					if ($ret_item) {
						$lng_lat_arr = explode(' ', $ret_item);
						$gps_datas[$i]['lng'] = $lng_lat_arr[0];
						$gps_datas[$i]['lat'] = $lng_lat_arr[1];
					}
				}
			}
		}

		$this->_data['gps_data'] = $gps_datas;
	}
}


?>

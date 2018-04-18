<?php

class MediaModel extends BaseModel
{
	protected $_tbname = 'zm_video_list';
	protected $_p_k = 'id';
	protected $wsdl = 'http://127.0.0.1/cqjxjwsservice/services/ZhptOutAccess?wsdl';
	protected $xtlb = '84';
	protected $jkxlh = '7C1E1D080314E1F38E99E485879A8CD5E7E5EF908CE5EE848099A2C7A49D636E';
	protected $jkid = '84C01';
	protected $yhbz = '';
	protected $dwmc = '';
	protected $dwjgdm = '';
	protected $yhxm = '';
	protected $zdbs = '127.0.0.2';

	public function get_jdsbh($data_array)
	{
		$QueryXmlDoc = $this->create_xml_all($data_array);
		$client = new SoapClient($this->wsdl);
		$ret = $client->queryObjectOut($this->xtlb, $this->jkxlh, $this->jkid, $this->yhbz, $this->dwmc, $this->dwjgdm, $this->yhxm, $this->zdbs, $QueryXmlDoc);

		if ($ret) {
			$output_xml = $ret;
		}
		else {
			return false;
		}

		$objXML = simplexml_load_string($output_xml);
		$jdsbh_array = array();
		$jdsbh_temp = array();
		$head = $objXML->head;
		$code = $head->code;
		$message = $head->message;
		$rownum = $head->rownum;
		$body = $objXML->body;

		if ($code == 1) {
			foreach ($body->violation as $v ) {
				if ($v['id'] == 0) {
					$temp_obj = (array) $v;
				}
			}

			$jdsbh_temp = $temp_obj;

			if (!empty($jdsbh_temp)) {
				foreach ($jdsbh_temp as $k => $v ) {
					$k_temp = strtolower($k);
					if (($k_temp == 'wfsj') || ($k_temp == 'clsj') || ($k_temp == 'lrsj') || ($k_temp == 'gxsj')) {
						$jdsbh_array[0][$k_temp] = strtotime($this->gbk_to_utf($jdsbh_temp[$k]));
					}
					else if ($k_temp == '@attributes') {
						continue;
					}
					else {
						$jdsbh_array[0][$k_temp] = $this->gbk_to_utf($jdsbh_temp[$k]);
					}
				}
			}

			return $jdsbh_array;
		}
		else {
			return false;
		}
	}

	public function gbk_to_utf($string)
	{
		return urldecode(mb_convert_encoding($string, 'utf-8', 'gbk'));
	}

	public function create_xml_all($data_array)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n" . '';
		$xml .= '<root>' . "\n" . '';
		$xml .= $this->create_xml($data_array);
		$xml .= '</root>' . "\n" . '';
		return $xml;
	}

	public function create_xml($data_array)
	{
		$item = '<QueryCondition>' . "\n" . '';

		foreach ($data_array as $k => $v ) {
			$item .= '<' . $k . '>';
			$item .= $v;
			$item .= '</' . $k . '>';
		}

		$item .= '</QueryCondition>' . "\n" . '';
		return $item;
	}
}


?>

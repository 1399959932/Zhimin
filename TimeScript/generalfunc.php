<?php
require_once ('connection.php');
function PrefixIndex($prefix, $id, $digitlength)
{
	$temp = $id;

	for ($i = 0; $i < ($digitlength - strlen($id)); $i++) {
		$temp = '0' . $temp;
	}

	return $prefix . $temp;
}

function RunQuery($query, $DB = NULL)
{
	global $DATABASE;
	global $CONNECTION;
	global $_SHOW_ERROR;

	if (!isset($DB)) {
		mysql_select_db($DATABASE, $CONNECTION);
		mysql_query('SET NAMES \'utf8\'');
		$result = mysql_query($query, $CONNECTION);

		if (!$result) {
			if ($_SHOW_ERROR) {
				show_error('错误SQL语句：', $query);
			}
		}

		return $result;
	}
	else {
		mysql_select_db($DB, $CONNECTION);
		mysql_query('SET NAMES \'utf8\'');
		($result = mysql_query($query, $CONNECTION)) || exit(mysql_error());
		return $result;
	}
}

function show_error($message = '', $sql = '')
{
	global $_BULLETIN;
	global $_IS_ERROR;
	global $DOCUMENT_ROOT;

	if (!$sql) {
		echo '<font color=\'red\'>' . $message . '</font>';
		echo '<br />';
	}
	else {
		echo '<fieldset>';
		echo '<legend>错误信息提示:</legend><br />';
		echo '<div style=\'font-size:14px; clear:both; font-family:Verdana, Arial, Helvetica, sans-serif;\'>';
		echo '<div style=\'height:20px; background:#000000; border:1px #000000 solid\'>';
		echo '<font color=\'white\'>错误号：12142</font>';
		echo '</div><br />';
		echo '错误原因：' . mysql_error() . '<br /><br />';
		echo '<div style=\'height:20px; background:#FF0000; border:1px #FF0000 solid\'>';
		echo '<font color=\'white\'>' . $message . '</font>';
		echo '</div>';
		echo '<font color=\'red\'><pre>' . $sql . '</pre></font>';
		$ip = getip();

		if ($_BULLETIN) {
			$time = date('Y-m-d H:i:s');
			$message = $message . "\r\n" . $sql . '' . "\r\n" . '客户IP:' . $ip . '' . "\r\n" . '时间 :' . $time . '' . "\r\n" . '' . "\r\n" . '';
			$server_date = date('Y-m-d');
			$filename = $server_date . '.txt';
			$file_path = $DOCUMENT_ROOT . 'upload/error/' . $filename;
			$error_content = $message;
			$file = $DOCUMENT_ROOT . 'upload/error/';

			if (!file_exists($file)) {
				if (!mkdir($file, 511)) {
					exit('upload files directory does not exist and creation failed');
				}
			}

			if (!file_exists($file_path)) {
				fopen($file_path, 'w+');

				if (is_writable($file_path)) {
					if (!$handle = fopen($file_path, 'a')) {
						echo '不能打开文件 ' . $filename;
						exit();
					}

					if (!fwrite($handle, $error_content)) {
						echo '不能写入到文件 ' . $filename;
						exit();
					}

					echo '——错误记录被保存!';
					fclose($handle);
				}
				else {
					echo '文件 ' . $filename . ' 不可写';
				}
			}
			else if (is_writable($file_path)) {
				if (!$handle = fopen($file_path, 'a')) {
					echo '不能打开文件 ' . $filename;
					exit();
				}

				if (!fwrite($handle, $error_content)) {
					echo '不能写入到文件 ' . $filename;
					exit();
				}

				echo '——错误记录被保存!';
				fclose($handle);
			}
			else {
				echo '文件 ' . $filename . ' 不可写';
			}
		}

		echo '<br />';

		if ($_IS_ERROR) {
			exit();
		}
	}

	echo '</div>';
	echo '</fieldset>';
	echo '<br />';
}

function dateArray($sql)
{
	$array_result = array();
	$result = mysql_query($sql);

	if ($result) {
		$i = 0;

		while ($row = mysql_fetch_assoc($result)) {
			$array_result[$i] = $row;
			$i++;
		}
	}

	mysql_free_result($result);
	return $array_result;
}

function TodayTS($next_month = 0, $next_day = 0, $next_year = 0)
{
	return mktime(0, 0, 0, date('m') + $next_month, date('d') + $next_day, date('Y') + $next_year);
}

function ArrayRemove($elment, $array)
{
	$key = array_search($elment, $array);
	return array_merge(array_slice($array, 0, $key), array_slice($array, $key + 1, sizeof($array) - ($key + 1)));
}

function cut_str($sourcestr, $cutlength)
{
	$returnstr = '';
	$i = 0;
	$n = 0;
	$str_length = strlen($sourcestr);
	$mb_str_length = mb_strlen($sourcestr, 'utf-8');
	while (($n < $cutlength) && ($i <= $str_length)) {
		$temp_str = substr($sourcestr, $i, 1);
		$ascnum = ord($temp_str);

		if (224 <= $ascnum) {
			$returnstr = $returnstr . substr($sourcestr, $i, 3);
			$i = $i + 3;
			$n++;
		}
		else if (192 <= $ascnum) {
			$returnstr = $returnstr . substr($sourcestr, $i, 2);
			$i = $i + 2;
			$n++;
		}
		else {
			if ((65 <= $ascnum) && ($ascnum <= 90)) {
				$returnstr = $returnstr . substr($sourcestr, $i, 1);
				$i = $i + 1;
				$n++;
			}
			else {
				$returnstr = $returnstr . substr($sourcestr, $i, 1);
				$i = $i + 1;
				$n = $n + 0.5;
			}
		}
	}

	if ($cutlength < $mb_str_length) {
		$returnstr = $returnstr . '...';
	}

	return $returnstr;
}

function getip()
{
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	}
	else {
		if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else {
			if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
				$ip = getenv('REMOTE_ADDR');
			}
			else {
				if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
					$ip = $_SERVER['REMOTE_ADDR'];
				}
				else {
					$ip = 'unknown';
				}
			}
		}
	}

	return $ip;
}

function gbk_to_utf($string)
{
	return urldecode(mb_convert_encoding($string, 'utf-8', 'gbk'));
}

function create_xml_all($data_array)
{
	$xml = '<?xml version=\'1.0\' encoding=\'utf-8\'?>' . "\n" . '';
	$xml .= '<root>' . "\n" . '';
	$xml .= create_xml($data_array);
	$xml .= '</root>' . "\n" . '';
	return $xml;
}

function create_xml($data_array)
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

function get_auto_jdsbh($data_array)
{
	global $wsdl;
	global $xtlb;
	global $jkxlh;
	global $jkid;
	global $yhbz;
	global $dwmc;
	global $dwjgdm;
	global $yhxm;
	global $zdbs;
	$QueryXmlDoc = create_xml_all($data_array);
	$client = new SoapClient($wsdl);
	$ret = $client->queryObjectOut($xtlb, $jkxlh, $jkid, $yhbz, $dwmc, $dwjgdm, $yhxm, $zdbs, $QueryXmlDoc);

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
	if (($code == 1) && (1 <= $rownum)) {
		$num = 0;

		foreach ($body->violation as $v1 ) {
			$jdsbh_temp = (array) $v1;

			if (!empty($jdsbh_temp)) {
				foreach ($jdsbh_temp as $k => $v ) {
					$k_temp = strtolower($k);
					if (($k_temp == 'wfsj') || ($k_temp == 'clsj') || ($k_temp == 'lrsj') || ($k_temp == 'gxsj')) {
						$jdsbh_array[$num][$k_temp] = strtotime(gbk_to_utf($jdsbh_temp[$k]));
					}
					else if ($k_temp == '@attributes') {
						continue;
					}
					else {
						$jdsbh_array[$num][$k_temp] = gbk_to_utf($jdsbh_temp[$k]);
					}
				}
			}

			$num++;
		}

		return $jdsbh_array;
	}
	else {
		return false;
	}
}



?>

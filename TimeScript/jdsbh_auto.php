<?php

include_once ('generalfunc.php');
$nowdatetime = date('Y-m-d H:i:s');
$select_media_sql = 'SELECT `id`,`filename`,`hostname`,`hostcode`,`danwei`,`createdate`,`playtime`,`uploaddate` FROM `zm_video_list` where DATEDIFF(\'' . $nowdatetime . '\',uploaddate) < ' . $_BEFOR_DAY . ' and `filetype` in (\'' . join('\',\'', $VIDEO_TYPE) . '\') and (`conn_type` is Null or `conn_type`=0) and `isdel`=0';
$select_media_query = runquery($select_media_sql);

while ($res = mysql_fetch_assoc($select_media_query)) {
	$zqmj = $res['hostcode'];
	$kssj = date('Y-m-d H:i:s', strtotime($res['createdate']) - $_DEV_TIME);
	$jssj = date('Y-m-d H:i:s', strtotime($kssj) + $_MIN_TIME);
	$data_array = array('zqmj' => $zqmj, 'kssj' => $kssj, 'jssj' => $jssj);
	$temp_array = array();
	$start_time = microtime(true);
	$jdsbh_array = get_auto_jdsbh($data_array);
	$end_time = microtime(true);
	$total_time = $end_time - $start_time;
	echo date('Y-m-d H:i:s') . ' [INFO] 此次从6合1平台匹配数据共花费' . $total_time . '秒' . "\n" . '';

	if (!empty($jdsbh_array)) {
		echo date('Y-m-d H:i:s') . ' [INFO] ' . $res['filename'] . '从6合1平台匹配到' . count($jdsbh_array) . '条记录' . "\n" . '';
		$udpate_sql = 'update `zm_video_list` set `vio_jdsbh`=\'' . $jdsbh_array[0]['jdsbh'] . '\',`conn_type`=\'1\',`moder`=\'6in1\',`modtime`=\'' . time() . '\' where `id`=\'' . $res['id'] . '\'';
		echo date('Y-m-d H:i:s') . ' [INFO] sql_video_list_update=[' . $udpate_sql . '].' . "\n" . '';
		runquery($udpate_sql);
		$insert_sql = 'insert into `zm_vio_jdsbh` (`id`, `video_id`,`filename`, `wfbh`, `jdslb`, `jdsbh`, `wsjyw`, `ryfl`, `fzjg`, `zjcx`, `dsr`, `zsxzqh`, `zsxxdz`, `dh`, `clfl`, `hpzl`, `hphm`, `jdcsyr`, `syxz`, `jtfs`, `wfsj`, `wfdd`, `wfdz`, `wfxw`, `zqmj`, `fxjg`, `fxjgmc`, `cljg`, `cljgmc`, `cfzl`, `clsj`, `pzbh`, `jsjqbj`, `jllx`, `lrr`, `lrsj`, `jbr1`, `jbr2`, `sgdj`, `xxly`, `xrms`, `jsjg`, `fsjg`, `gxsj`, `bz`,`clfl_co`,`wfxw_co`,`cfzl_co`,`sgdj_co`,`xxly_co`,`wfxw1`,`wfxw2`,`wfxw3`,`wfxw4`,`wfxw5`,`jszh`,`lxfs`) values (\'0\', \'' . $res['id'] . '\',\'' . $res['filename'] . '\', \'' . $jdsbh_array[0]['wfbh'] . '\', \'' . $jdsbh_array[0]['jdslb'] . '\', \'' . $jdsbh_array[0]['jdsbh'] . '\', \'' . $jdsbh_array[0]['wsjyw'] . '\', \'' . $jdsbh_array[0]['ryfl'] . '\', \'' . $jdsbh_array[0]['fzjg'] . '\', \'' . $jdsbh_array[0]['zjcx'] . '\', \'' . $jdsbh_array[0]['dsr'] . '\', \'' . $jdsbh_array[0]['zsxzqh'] . '\', \'' . @($jdsbh_array[0]['zsxxdz']) . '\', \'' . $jdsbh_array[0]['dh'] . '\', \'' . $jdsbh_array[0]['clfl'] . '\', \'' . $jdsbh_array[0]['hpzl'] . '\', \'' . $jdsbh_array[0]['hphm'] . '\', \'' . $jdsbh_array[0]['jdcsyr'] . '\', \'' . $jdsbh_array[0]['syxz'] . '\', \'' . $jdsbh_array[0]['jtfs'] . '\', \'' . $jdsbh_array[0]['wfsj'] . '\', \'' . $jdsbh_array[0]['wfdd'] . '\', \'' . $jdsbh_array[0]['wfdz'] . '\', \'' . $jdsbh_array[0]['wfxw'] . '\', \'' . $jdsbh_array[0]['zqmj'] . '\', \'' . $jdsbh_array[0]['fxjg'] . '\', \'' . $jdsbh_array[0]['fxjgmc'] . '\', \'' . $jdsbh_array[0]['cljg'] . '\', \'' . $jdsbh_array[0]['cljgmc'] . '\', \'' . $jdsbh_array[0]['cfzl'] . '\', \'' . $jdsbh_array[0]['clsj'] . '\', \'' . $jdsbh_array[0]['pzbh'] . '\', \'' . $jdsbh_array[0]['jsjqbj'] . '\', \'' . $jdsbh_array[0]['jllx'] . '\', \'' . $jdsbh_array[0]['lrr'] . '\', \'' . $jdsbh_array[0]['lrsj'] . '\', \'' . $jdsbh_array[0]['jbr1'] . '\', \'' . $jdsbh_array[0]['jbr2'] . '\', \'' . $jdsbh_array[0]['sgdj'] . '\', \'' . $jdsbh_array[0]['xxly'] . '\', \'' . $jdsbh_array[0]['xrms'] . '\', \'' . $jdsbh_array[0]['jsjg'] . '\', \'' . $jdsbh_array[0]['fsjg'] . '\', \'' . $jdsbh_array[0]['gxsj'] . '\', \'' . $jdsbh_array[0]['bz'] . '\', \'' . $jdsbh_array[0]['clfl_co'] . '\', \'' . $jdsbh_array[0]['wfxw_co'] . '\', \'' . $jdsbh_array[0]['cfzl_co'] . '\', \'' . @($jdsbh_array[0]['sgdj_co']) . '\',\'' . $jdsbh_array[0]['xxly_co'] . '\',\'' . $jdsbh_array[0]['wfxw1'] . '\',\'' . $jdsbh_array[0]['wfxw2'] . '\',\'' . $jdsbh_array[0]['wfxw3'] . '\',\'' . $jdsbh_array[0]['wfxw4'] . '\',\'' . $jdsbh_array[0]['wfxw5'] . '\',\'' . $jdsbh_array[0]['jszh'] . '\',\'' . $jdsbh_array[0]['lxfs'] . '\')';
		echo date('Y-m-d H:i:s') . ' [INFO] sql_vio_jdsbh_insert=[' . $insert_sql . '].' . "\n" . '';
		runquery($insert_sql);
	}
	else {
		echo date('Y-m-d H:i:s') . ' [INFO] ' . $res['filename'] . '没有从6合1平台匹配到数据.' . "\n" . '';
	}
}

mysql_free_result($select_media_query);
echo ' ';

?>

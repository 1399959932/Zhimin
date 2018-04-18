<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>详情页</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/default/easyui.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/icon.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/re_easyui.css">' . "\r\n";
echo '	<script type="text/javascript" src="' . Zhimin::g('assets_uri') . 'js/jquery.easyui.min.js"></script>';
echo "\r\n" . '	<link href="';
echo Zhimin::g('assets_uri');
echo 'style/viewfile.css" rel="stylesheet" type="text/css" />' . "\r\n" . '	<style type="text/css">' . "\r\n" . '	.gps_a{ color: #0e7fd3; }' . "\r\n" . '	.pos{position: relative;top: -222px;left: 0;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '';
$media_cfg = Zhimin::g('media_type');
$filetype = strtolower($medias['filetype']);
echo '<body>' . "\r\n" . '	<div class="layer_iframe">' . "\r\n" . '		<div class="iframe_top"><span style="display: inline-block;width:15px;"></span>正在查看';

if (in_array($filetype, $media_cfg['video'])) {
	echo '视频';
}
else if (in_array($filetype, $media_cfg['audio'])) {
	echo '音频';
}
else {
	echo '图片';
}

echo '：';
echo $medias['bfilename'];
echo '<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body">' . "\r\n" . '			<div class="iframe_left">' . "\r\n" . '				<div class="cont_iframe_top"></div>' . "\r\n" . '				<div class="cont_iframe_body">' . "\r\n" . '					<div class="video_wrap">' . "\r\n" . '					';

if (in_array($filetype, $media_cfg['video'])) {
	echo '	' . "\r\n" . '						  <object id="peplayer" classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase = "http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" width="450" height="420">' . "\r\n" . '						  	<param name="Mode" value="1" />' . "\r\n" . '						  	<param name="AutoLoop" value="1" />' . "\r\n" . '						  	<param name="AutoPlay" value="1" />' . "\r\n" . '						  	<param name="showdisplay" value="1" />' . "\r\n" . '						  </object>' . "\r\n" . '						  ' . "\r\n" . '					';
}
else if (in_array($filetype, $media_cfg['audio'])) {
	echo '							<object id="MediaPlayer" width="440" height="380"' . "\r\n" . '								classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"' . "\r\n" . '								type="application/x-oleobject">' . "\r\n" . '								<param name="AutoStart" value="0" />' . "\r\n" . '								<param name="PlayCount" value="1" />' . "\r\n" . '								<param name="EnableContextMenu" value="0" />' . "\r\n" . '								<param name="Volume" value="100" />' . "\r\n" . '								<embed src="';
	echo $playurl;
	echo '" name="MediaPlayer" ' . "\r\n" . '									type="video/x-ms-wmv" width="400" height="68" autostart="1"' . "\r\n" . '									showcontrols="1" allowscan="1" playcount="100" enablecontextmenu="0"></embed>' . "\r\n" . '							</object>' . "\r\n" . '							<script language="JavaScript">' . "\r\n" . '								var isFF=(navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)' . "\r\n" . '								var objPlayer = document.getElementById("MediaPlayer");' . "\r\n" . '								if(isFF){objPlayer=document.MediaPlayer;}' . "\r\n" . '								var strFile33 = "';
	echo $playurl;
	echo '";' . "\r\n" . '								objPlayer.url = strFile33;' . "\r\n" . '								objPlayer.src = strFile33;' . "\r\n" . '							</script>' . "\r\n" . '					';
}
else {
	echo '	' . "\r\n" . '							<a title="点击查看大图" target="_blank" href="';
	echo $playurl;
	echo '"> <img' . "\r\n" . '								border="0" onload="DrawImage(this,640,480);" src="';
	echo $playurl;
	echo '" width="640" height="360" />' . "\r\n" . '							</a>' . "\r\n" . '					';
}

echo '					' . "\r\n" . '						  <!--<img src="./images/video_img.jpg" width="450" height="420" alt="" />-->' . "\r\n" . '						' . "\r\n" . '					<div class="video_action">' . "\r\n" . '						<span>文件大小：';
echo round($medias['filelen'], 2);
echo 'M</span>' . "\r\n" . '						<span class="span_awrap">' . "\r\n" . '							<a class="video_span_a video_down" target="_blank" href="';
echo Zhimin::buildUrl('media', 'media', 'index', 'action=media_down&id=' . $medias['id']);
echo '"></a>|' . "\r\n" . '							<a href="';

if (!empty($pre_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $pre_id.'&sql='.$sqlList);
}
else {
	echo '#';
}

echo '" class="video_span_a video_prev" ></a>|' . "\r\n" . '							<a href="';

if (!empty($next_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $next_id.'&sql='.$sqlList);
}
else {
	echo '#';
}

echo '" class="video_span_a video_next"></a>' . "\r\n" . '						</span>					' . "\r\n" . '						<span class="video_type">标  清</span>' . "\r\n" . '						';

if ($gps_flg == '1') {
	echo '						<span class="map_span1" date="';
	echo Zhimin::buildUrl('map', 'media', 'index', 'filename=' . $medias['filename']);
	echo '"><a class="gps_a" href="';
	echo Zhimin::buildUrl('map', 'media', 'index', 'filename=' . $medias['filename']);
	echo '">GPS轨迹</a></span>' . "\r\n" . '						';
}
else {
	echo '						<span class="map_span" date="#">GPS轨迹</span>' . "\r\n" . '						';
}

echo '						<div class="video_typelist">' . "\r\n" . '							 <ul>' . "\r\n" . '								<li><a href="#">标  清</a></li>' . "\r\n" . '								<li><a href="#">高  清</a></li>' . "\r\n" . '								<li><a href="#">流  畅</a></li>' . "\r\n" . '							</ul>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="video_notice">' . "\r\n" . '						如无法播放视频，请下载并安装播放器插件 <a href="images/player/prPlayer.exe">点击下载</a>' . "\r\n" . '					</div>' . "\r\n" . '				</div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="cont_iframe_foot"></div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="iframe_right">' . "\r\n" . '				<ul class="tab_ul">' . "\r\n" . '					<li class="active">基本信息</li>' . "\r\n" . '					<li class="li_after li_1">标注类型</li>' . "\r\n" . '				</ul>' . "\r\n" . '				<div class="right_iframe_top"></div>' . "\r\n" . '				<div class="right_iframe_body">' . "\r\n" . '					<div class="tab_wrap tab_base" style="display: block;">' . "\r\n" . '						<form id="media_flg_form_1" action="';
echo Zhimin::buildUrl();
echo '&action=edit" method="post">' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">姓名（' . $_SESSION['zfz_type'] . '编号）：';
echo $medias['hostname'] . ' ( ' . $medias['hostcode'] . ' )';
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传站点：';
echo $medias['creater'] . '（' . $hostip . '）';
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">拍摄时间：';
echo $medias['createdate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传时间：';
echo $medias['uploaddate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">所属单位：';
echo $media_danwei;
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">下载次数：';
echo $medias['downloads'];
echo '次</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">播放次数：';
echo $medias['opens'];
echo '次</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">热点视频：';
echo $medias['hot'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">重要视频：</span>' . "\r\n" . '							<div class="select_270 select_div select_radio">' . "\r\n" . '								<label for="radio_yes">' . "\r\n" . '									是' . "\r\n" . '									<input type="radio" id="radio_yes" name="main_video" ';

if ($medias['major'] == '1') {
	echo 'checked';
}

echo ' value="1"/>' . "\r\n" . '								</label>' . "\r\n" . '								<label for="radio_no">' . "\r\n" . '									否' . "\r\n" . '									<input type="radio" id="radio_no" name="main_video" ';

if ($medias['major'] == '0') {
	echo 'checked';
}

echo ' value="0"/>' . "\r\n" . '								</label>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n";
echo '						<div class="condition_335 condition_s">
							<span class="condition_title">标注位置：';
if ($medias['biaozhu_location'] == '0') {
	echo '未标注';
}
if ($medias['biaozhu_location'] == '1') {
	echo '执法仪标注';
}
if ($medias['biaozhu_location'] == '2') {
	echo '后台标注';
}
echo '</span>
	</div>';
echo '						<div class="condition_213 condition_s">' . "\r\n" . '							<span class="condition_title">文件类型：</span>' . "\r\n" . '							<div class="select_150 select_div">' . "\r\n" . '								<select class="easy_u" name="filetype" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($file_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if ($medias['sort'] == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">存储天数：</span>' . "\r\n" . '							<div class="select_150 select_div select_days">' . "\r\n" . '								<select class="easy_u" name="save_day" style="width:100%;">' . "\r\n" . '									<option value="1" ';

if ($medias['save_date'] == '1' || $res == '90') {
	echo ' selected';
}

echo '>三个月</option>' . "\r\n" . '									<option value="2" ';

if ($medias['save_date'] == '2' || $res == '180') {
	echo ' selected';
}

echo '>六个月</option>' . "\r\n" . '									<option value="3" ';

if ($medias['save_date'] == '3' || $res == '365') {
	echo ' selected';
}

echo '>十二个月</option>' . "\r\n" . '									<option value="4" ';

//modify
if ($medias['save_date'] == '4') {
	echo ' selected';
}

echo '>永久</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">文件名称：</span>' . "\r\n" . '							<div class="select_260 select_div select_in floLeft">								' . "\r\n" . '								<input type="text" value="';
//

echo $medias['bfilename'];
echo '" id="bfilename" name="bfilename" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s condition_textarea condition_height">' . "\r\n" . '							<span class="condition_title">文件描述：</span>' . "\r\n" . '							<!-- <div class="select_260 select_div select_days textarea_in">								' . "\r\n" . '								<textarea id="media_note">';
echo $medias['note'];
echo '</textarea>' . "\r\n" . '							</div> -->' . "\r\n" . '							<textarea id="media_note" name="media_note" style="width:250px;height:76px; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">';
echo $medias['note'];
echo '</textarea>' . "\r\n" . '						</div>' . "\r\n" . '						<input type="hidden" id="biaozhu_location" name="biaozhu_location" value="' . $medias['biaozhu_location'] . '"><input type="hidden" id="major_old" name="major_old" value="' . $medias['major'] . '"><input type="hidden" id="fileid" name="fileid" value="';
echo $medias['id'];
echo '" >' . "\r\n" . '						<div class="condition_335 condition_s condition_v">' . "\r\n" . '							<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '							<input type="button" class="v_sub" id="v_sub_save" value="保 存" />' . "\r\n" . '						</div>' . "\r\n" . '						</form>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="tab_wrap" style="display:none;">' . "\r\n" . '						<form id="media_flg_form" action="#" method="post">' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">标注类型：</span>' . "\r\n" . '							<div class="select_260 select_div">' . "\r\n" . '								<select class="easy_u" name="biaozhutype" style="width:100%;">' . "\r\n" . '									<option value="">请选择标注类型</option>' . "\r\n" . '									';
$val_sel = '';
$val_sel_name = '';
if (($video_flg['type'] != '') && ($biaozhu_types[$video_flg['type']] != '')) {
	$val_sel = $video_flg['type'];
	$val_sel_name = $biaozhu_types[$video_flg['type']];
}

foreach ($biaozhu_types as $k => $v ) {
	echo '									<option value="' . $k . '"';

	if ($video_flg['type'] == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>' . "\r\n";
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '							';
echo '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">数据编号：</span>' . "\r\n" . '							<div class="select_260 select_div select_in">								' . "\r\n" . '								<input type="text" name="data_no" name="data_no" value="';
echo $video_flg['data_no'];
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">采集地点：</span>' . "\r\n" . '							<div class="select_260 select_div select_in">								' . "\r\n" . '								<input type="text" name="data_location" name="data_location" value="';
echo $video_flg['data_location'];

//modify
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">号码类型：</span>' . "\r\n" . '							<div class="select_260 select_div">' . "\r\n" . '								<select class="easy_u" name="codetype" style="width:100%;">' . "\r\n" . '									<option value="">请选择号码类型</option>' . "\r\n" . '									';
$val_sel = '';
$val_sel_name = '';
if (($video_flg['codetype'] != '') && ($code_types[$video_flg['codetype']] != '')) {
	$val_sel = $video_flg['codetype'];
	$val_sel_name = $code_types[$video_flg['codetype']];
}

foreach ($code_types as $k => $v ) {
	echo '									<option value="' . $k . '"';

	if ($video_flg['codetype'] == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>' . "\r\n";
}
echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '							';
//

echo '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">号码内容：</span>' . "\r\n" . '							<div class="select_260 select_div select_in">								' . "\r\n" . '								<input type="text" name="car_no" name="car_no" value="';
echo $video_flg['car_no'];
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">采集时间：</span>' . "\r\n" . '							<div class="select_260 select_div select_in">								' . "\r\n" . '								<div class="select_235 sele_c select_in select_time_i">' . "\r\n" . '									<input id="end" type="text" name="caijidate" value="';
echo $video_flg['cjsj'] == '' ? $medias['createdate'] : $video_flg['cjsj'];
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#end\',istime: true,format: \'YYYY-MM-DD hh:mm:ss\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">当事人：</span>' . "\r\n" . '							<div class="select_260 select_div select_in">								' . "\r\n" . '								<input type="text" name="client" name="client" value="';
echo $video_flg['client'];
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s condition_textarea">' . "\r\n" . '							<span class="condition_title">标注描述：</span>' . "\r\n" . '							<!-- <div class="select_260 select_div textarea_in">								' . "\r\n" . '								<textarea id="remark" name="remark">';
echo $video_flg['remark'];
echo '</textarea>' . "\r\n" . '							</div> -->' . "\r\n" . '							<textarea id="remark" name="remark" style="width:250px;height:170px; float: right; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">';
echo $video_flg['remark'];
echo '</textarea>' . "\r\n" . '						</div>' . "\r\n" . '						<input type="hidden" id="fileid" name="fileid" value="';
echo $medias['id'];
echo '" >' . "\r\n" . '						<div class="condition_335 condition_s condition_v">' . "\r\n" . '							<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '							<input type="button" class="v_sub" id="v_sub_save_biaozhu" value="保 存" />' . "\r\n" . '						</div>' . "\r\n" . '						</form>' . "\r\n" . '					</div>					' . "\r\n" . '				</div>' . "\r\n" . '				<div class="right_iframe_foot"></div>' . "\r\n" . '			</div>' . "\r\n" . '	</div>' . "\r\n" . '		<div class="iframe_foot"></div>' . "\r\n" . '	<!-- 警告提示框 -->' . "\r\n" . '	<div style="position:relative;">' . "\r\n" . '	<div class="layer_notice lay_add" style="width:449px;height:222px;z-index:9999;">' . "\r\n" . '		<iframe id=\'iframebar1\' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;"></iframe>' . "\r\n" . '		<div class="notice_top pos"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body pos">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>标注信息不能为空......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot pos"></div>' . "\r\n" . '	</div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div style="position:relative;">' . "\r\n" . '		<div class="layer_notice lay_success" style="width:449px;height:222px;z-index:9999;">' . "\r\n" . '			<iframe id=\'iframebar2\' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;background: none;"></iframe>  ' . "\r\n" . '			<div class="notice_top pos"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '			<div class="notice_body1 pos">' . "\r\n" . '				<div class="n_left">' . "\r\n" . '					<img src="./images/success_bg.png">' . "\r\n" . '				</div>' . "\r\n" . '				<div class="n_right">' . "\r\n" . '					<p>保存成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '					<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="notice_foot pos"></div>' . "\r\n" . '		</div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div style="position:relative;">' . "\r\n" . '		<div class="layer_notice lay_wrong" style="width:449px;height:222px;z-index:9999;">' . "\r\n" . '			<iframe id=\'iframebar3\' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;"></iframe>' . "\r\n" . '			<div class="notice_top pos"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '			<div class="notice_body4 pos">' . "\r\n" . '				<div class="n_left">' . "\r\n" . '					<img src="./images/notice_bg.png">' . "\r\n" . '				</div>' . "\r\n" . '				<div class="n_right">' . "\r\n" . '					<p>信息不全,保存失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '					<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="notice_foot pos"></div>' . "\r\n" . '		</div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 视频版本提示框 -->' . "\r\n" . '	<div style="position:relative;">' . "\r\n" . '		<div class="layer_notice lay_wrong1" style="width:449px;height:222px;z-index:9999;">' . "\r\n" . '			<iframe id=\'iframebar3\' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;"></iframe>' . "\r\n" . '			<div class="notice_top pos"><span id="videoClose" class="close close_btn2"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '			<div class="notice_body1 pos">' . "\r\n" . '				<div class="n_left">' . "\r\n" . '					<img src="./images/notice_bg.png">' . "\r\n" . '				</div>' . "\r\n" . '				<div class="n_right">' . "\r\n" . '					<p>请安装最新播放器插件！</p>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '					<span class="cancle_span close_btn2">确 定</span>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="notice_foot pos"></div>' . "\r\n" . '		</div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>' . "\r\n" . '' . "\r\n" . '';

if (in_array($filetype, $media_cfg['video'])) {
	echo '<script language="javascript" for="peplayer" event="TimeChanged(time)">' . "\r\n" . '	$(function(){' . "\r\n" . '		/*if(time > 0)' . "\r\n" . '		{' . "\r\n" . '			if(time - g_presecond >= 1)' . "\r\n" . '			{' . "\r\n" . '				//g_presecond = time;' . "\r\n" . '				//PlayTimeNotify(time);' . "\r\n" . '			}			' . "\r\n" . '		} */' . "\r\n" . '	});      ' . "\r\n" . '</script>	' . "\r\n" . '<script language="javascript" for="peplayer" event="Playover()">' . "\r\n" . '	        ' . "\r\n" . '</script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(function(){' . "\r\n" . '		 ' . "\r\n" . '	var g_presecond = 0;' . "\r\n" . '	/*' . "\r\n" . '		time: MillSeconds' . "\r\n" . '	*/' . "\r\n" . '	function onTimeEvent(time)' . "\r\n" . '	{	' . "\r\n" . '		if(time > 0)' . "\r\n" . '		{' . "\r\n" . '			if(time - g_presecond >= 1)' . "\r\n" . '			{' . "\r\n" . '				g_presecond = time;' . "\r\n" . '				//PlayTimeNotify(time);' . "\r\n" . '			}			' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	' . "\r\n" . '	function onPlayoverEvent()' . "\r\n" . '	{' . "\r\n" . '		' . "\r\n" . '	}' . "\r\n" . '	' . "\r\n" . '	function SetGis(ax){' . "\r\n" . '		//object css里面定义了就不用写 ' . "\r\n" . '		ax.style.width = "450px";' . "\r\n" . '		ax.style.height = "420px";' . "\r\n" . '		' . "\r\n" . '		//调用activex的方法 1：gis播放UI，0：常规播放UI' . "\r\n" . '		ax.setmode(1);' . "\r\n" . '		' . "\r\n" . '		//普通模式' . "\r\n" . '		//ax.style.width = "640px";' . "\r\n" . '		//ax.style.height = "480px";' . "\r\n" . '		//ax.setmode(0);' . "\r\n" . '	}' . "\r\n" . ' 	' . "\r\n" . '	function PlayVideo(url)' . "\r\n" . '	{		' . "\r\n" . '		var activex = document.getElementById("peplayer");' . "\r\n" . '		if( activex )' . "\r\n" . '		{			' . "\r\n" . '			/*try{' . "\r\n" . '				if(document.all.ocx.object == null) ' . "\r\n" . '				{' . "\r\n" . '					alert(\'some activex is not installed!\');' . "\r\n" . '				}' . "\r\n" . '			}catch(e){}*/' . "\r\n" . '			' . "\r\n" . '			//测试activeX是否有 playurl 函数 判断是否安装了播放器插件。' . "\r\n" . '' . "\r\n" . '			/*try{' . "\r\n" . '			//activex.setmode(1);' . "\r\n" . '			//GIS模式可以关联时间事件 ' . "\r\n" . '			activex.attachEvent ("TimeChanged", onTimeEvent);' . "\r\n" . '			//播放完成事件' . "\r\n" . '			activex.attachEvent ("Playover", onPlayoverEvent);' . "\r\n" . '			}catch(e){}*/' . "\r\n" . '			//切换 GIS 模式UI' . "\r\n" . '			//SetGis(activex);' . "\r\n" . '			if(typeof(activex.playurl) == \'undefined\'){' . "\r\n" . '				//alert(\'请安装最新播放器插件.\');' . "\r\n" . '				layer.open({' . "\r\n" . '					type: 1,' . "\r\n" . '					title: false,' . "\r\n" . '					closeBtn: 0,' . "\r\n" . '					// shadeClose: true,' . "\r\n" . '					area: \'449px\',' . "\r\n" . '					time: 4000, //3s后自动关闭' . "\r\n" . '					content: $(\'.lay_wrong1\')' . "\r\n" . '				});' . "\r\n" . '				return;' . "\r\n" . '			}' . "\r\n" . '			activex.playurl(url);' . "\r\n" . '		}' . "\r\n" . '	}	' . "\r\n" . '	' . "\r\n" . '	setTimeout(function()' . "\r\n" . '	{' . "\r\n" . '		var url = "';
	echo $playurl;
	echo '";' . "\r\n" . '		PlayVideo(url);' . "\r\n" . '	}, ' . "\r\n" . '	1000); ' . "\r\n" . '	/*window.onbeforeunload = window.onunload = function()' . "\r\n" . '	{ ' . "\r\n" . '		try{' . "\r\n" . '		var activex = document.getElementById("peplayer");' . "\r\n" . '		if( activex )' . "\r\n" . '		{' . "\r\n" . '			activex.detachEvent ("TimeChanged", onTimeEvent);' . "\r\n" . '			activex.detachEvent ("Playover", onPlayoverEvent);' . "\r\n" . '		}' . "\r\n" . '		}catch(e){}' . "\r\n" . '	}*/' . "\r\n" . '});' . "\r\n" . '	' . "\r\n" . '</script>' . "\r\n" . '';
}

echo '' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(function(){' . "\r\n" . '	function DrawImage(ImgD,iwidth,iheight){    ' . "\r\n" . '    //参数(图片,允许的宽度,允许的高度)' . "\r\n" . '    var minWidth  = 640;' . "\r\n" . '    var minHeight = 360;    ' . "\r\n" . '    var image=new Image();    ' . "\r\n" . '    image.src=ImgD.src;    ' . "\r\n" . '    if(image.width>0 && image.height>0){    ' . "\r\n" . '      if(image.width/image.height>= iwidth/iheight){  ' . "\r\n" . '    	  if(image.width==iwidth){' . "\r\n" . '    		  ImgD.width=image.width;      ' . "\r\n" . '              ImgD.height=image.height;' . "\r\n" . '    	  } else{      ' . "\r\n" . '              ImgD.width=iwidth;    ' . "\r\n" . '              ImgD.height=(image.height*iwidth)/image.width;    ' . "\r\n" . '          }    ' . "\r\n" . '      }else{    ' . "\r\n" . '          if(image.height==iheight){    ' . "\r\n" . '              ImgD.width=image.width;      ' . "\r\n" . '              ImgD.height=image.height;          ' . "\r\n" . '          }else{         ' . "\r\n" . '              ImgD.height=iheight;    ' . "\r\n" . '              ImgD.width=(image.width*iheight)/image.height;   ' . "\r\n" . '          }    ' . "\r\n" . '      }    ' . "\r\n" . '    }    ' . "\r\n" . '  }' . "\r\n" . '});' . "\r\n" . '</script>' . "\r\n" . '' . "\r\n" . '<script>' . "\r\n" . '$(function(){' . "\r\n" . '	$("body").on(\'click\', ".close_btn2",function(){' . "\r\n" . '    	layer.close(); ' . "\r\n" . '    });' . "\r\n" . '' . "\r\n" . '	window.onerror=function(){return false;}' . "\r\n" . '	$(".video_down").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') 0 -2px no-repeat");' . "\r\n" . '	$(".video_prev").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -41px -2px no-repeat");' . "\r\n" . '	$(".video_next").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -80px -2px no-repeat");' . "\r\n" . '});' . "\r\n" . '$(".video_prev").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') -41px -2px no-repeat");' . "\r\n" . '	$(".video_down").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') 0px -2px no-repeat");' . "\r\n" . '	$(".video_next").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -80px -2px no-repeat")' . "\r\n" . '});' . "\r\n" . '$(".video_next").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') -80px -2px no-repeat");' . "\r\n" . '	$(".video_down").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') 0px -2px no-repeat");' . "\r\n" . '	$(".video_prev").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -41px -2px no-repeat");' . "\r\n" . '});' . "\r\n" . '' . "\r\n" . '$("#v_sub_save").click(function(){' . "\r\n" . '	var save_day = $("input[name=\'save_day\']").val();' . "\r\n" . '	var note = $("#media_note").val();' . "\r\n" . '	var main_video = $(\'input[name="main_video"]:checked\').val();' . "\r\n" . '	var fileid = $("#fileid").val();' . "\r\n" . '' . "\r\n" . '	$.ajax({' . "\r\n" . '		type:"POST",' . "\r\n" . '		url: "./?_a=mediaview&_c=media&_m=index&action=media_edit",' . "\r\n" . '		data: $(\'#media_flg_form_1\').serialize(),' . "\r\n" . '		dataType:"json",' . "\r\n" . '		success:function(data){' . "\r\n" . '			if(data == 0){' . "\r\n" . '				layer.open({' . "\r\n" . '					type: 1,' . "\r\n" . '					title: false,' . "\r\n" . '					closeBtn: 0,' . "\r\n" . '					shadeClose: true,' . "\r\n" . '					area: \'449px\',' . "\r\n" . '					 time: 3000, //3s后自动关闭' . "\r\n" . '					content: $(\'.lay_success\')' . "\r\n" . '				});' . "\r\n" . '			}else{' . "\r\n" . '				layer.open({' . "\r\n" . '					type: 1,' . "\r\n" . '					title: false,' . "\r\n" . '					closeBtn: 0,' . "\r\n" . '					shadeClose: true,' . "\r\n" . '					area: \'449px\',' . "\r\n" . '					time: 3000, //3s后自动关闭' . "\r\n" . '					content: $(\'.lay_wrong\')' . "\r\n" . '				});' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '	});' . "\r\n" . '});' . "\r\n" . '' . "\r\n" . '$("#v_sub_save_biaozhu").click(function(){' . "\r\n" . '		' . "\r\n" . '		$.ajax({' . "\r\n" . '			type:"POST",' . "\r\n" . '			url: "./?_a=mediaview&_c=media&_m=index&action=mediaflg_edit",' . "\r\n" . '			data: $(\'#media_flg_form\').serialize(),' . "\r\n" . '			dataType:"json",' . "\r\n" . '			success:function(data){' . "\r\n" . '				if(data == 0){' . "\r\n" . '					layer.open({' . "\r\n" . '						type: 1,' . "\r\n" . '						title: false,' . "\r\n" . '						closeBtn: 0,' . "\r\n" . '						shadeClose: true,' . "\r\n" . '						area: \'449px\',' . "\r\n" . '						time: 2000, //3s后自动关闭' . "\r\n" . '						content: $(\'.lay_success\')' . "\r\n" . '					});' . "\r\n" . '				}else{' . "\r\n" . '					layer.open({' . "\r\n" . '						type: 1,' . "\r\n" . '						title: false,' . "\r\n" . '						closeBtn: 0,' . "\r\n" . '						shadeClose: true,' . "\r\n" . '						area: \'449px\',' . "\r\n" . '						time: 3000, //3s后自动关闭' . "\r\n" . '						content: $(\'.lay_wrong\')' . "\r\n" . '					});' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '		});' . "\r\n" . '});' . "\r\n" . ';/*add tree end*/' . "\r\n" . '$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '});' . "\r\n" . '</script>' . "\r\n" . '';

?>

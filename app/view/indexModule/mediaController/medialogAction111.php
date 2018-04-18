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
echo 'style/re_easyui.css">' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	<link href="';
echo Zhimin::g('assets_uri');
echo 'style/viewfile.css" rel="stylesheet" type="text/css" />' . "\r\n" . '	<style type="text/css">' . "\r\n" . '	.gps_a{ color: #0e7fd3; }' . "\r\n" . '	.pos{position: relative;top: -222px;left: 0;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '';
$media_cfg = Zhimin::g('media_type');
$filetype = strtolower($medias['filetype']);
echo '<body>' . "\r\n" . '	<div class="layer_iframe">' . "\r\n" . '		<div class="iframe_top"><span style="display: inline-block;width:15px;"></span>正在查看';

// if (in_array($filetype, $media_cfg['video'])) {
// 	echo '视频';
// }
// else if (in_array($filetype, $media_cfg['audio'])) {
// 	echo '音频';
// }
// else {
// 	echo '图片';
// }

echo '日志信息';
echo '：';
echo $medias['bfilename'];
echo '<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body">' . "\r\n" . '																</div>' . "\r\n" . '			<div class="iframe_right">' . "\r\n" . '				<ul class="tab_ul">' . "\r\n" . '					<li class="active">日志信息</li>' . "\r\n" . '								</ul>' . "\r\n" . '					<div class="right_iframe_body">' . "\r\n" . '					<div class="tab_wrap tab_base" style="display: block;">' . "\r\n" . '						<form id="media_flg_form_1" action="';
echo Zhimin::buildUrl();
echo '&action=edit" method="post">' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">姓名（' . $_SESSION['zfz_type'] . '编号）：';
echo $medias['hostname'] . ' ( ' . $medias['hostcode'] . ' )';
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传站点：';
echo $medias['creater'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">拍摄时间：';
echo $medias['createdate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传时间：';
echo $medias['uploaddate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">所属单位：';
echo $media_danwei;
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '

<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">下载次数：';
echo $medias['downloads'];
echo '次</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">播放次数：';
echo $medias['opens'];
echo '次</span>' . "\r\n" . '						</div>' . "\r\n" . '		

<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">文件信息：';

	echo $medias['bfilename'];
	echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">操作时间：';
	$dates['logtime'] = $dates['logtime'] ? $dates['logtime'] : '' ;
	echo date('Y-m-d H:i:s', $dates['logtime']);
	echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">日志描述：';
	echo $dates['context'];
	echo '</span></div>' . "\r\n" . ' ';
echo	'						<div class="condition_335 condition_s video_action">' . "\r\n" . '<span class="span_awrap">' . "\r\n" . '							<a href="';

if (!empty($pre_id)) {
	echo Zhimin::buildUrl('medialog', 'media', 'index', 'id=' . $pre_id.'&sql='.$sqlList);
}
else {
	echo '#';
}

echo '" class="video_span_a video_prev" ></a>|' . "\r\n" . '							<a href="';

if (!empty($next_id)) {
	echo Zhimin::buildUrl('medialog', 'media', 'index', 'id=' . $next_id.'&sql='.$sqlList);
}
else {
	echo '#';
}
echo '" class="video_span_a video_next"></a>' . "\r\n" . '</span></div>';
?>

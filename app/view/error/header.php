<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\r\n" . '<head>' . "\r\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '<title>';
echo Zhimin::a()->title;
echo '</title>' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/base.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/stylesheet.css" rel="stylesheet" type="text/css" /> ' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/common.js" type="text/javascript"></script>  ' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.js" type="text/javascript"></script>' . "\r\n" . '<!--[if IE 6]>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . ' 	DD_belatedPNG.fix(\'div, ul, img, li, input , a\');' . "\r\n" . '</script>' . "\r\n" . '<![endif]-->' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '' . "\r\n" . '</script>' . "\r\n" . '<div id="wrapper">' . "\r\n" . '	<div id="container">' . "\r\n" . '		<div id="header">' . "\r\n" . '			<div id="title"><span>';
$settings = Zhimin::a()->getData('settings');
echo $settings['site'];
echo '</span></div>' . "\r\n" . '			<div id="logo">' . "\r\n" . '				<a href="';
echo Zhimin::g('assets_uri');
echo '">' . "\r\n" . '					';
if (($settings['main_file_logo'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['main_file_logo'])) {
	echo '<img src="' . Zhimin::g('assets_uri') . 'upload/zm_config/' . $settings['main_file_logo'] . '" alt="" width="131px"/>';
}
else {
	echo '<img src="images/logo/main_file_logo_' . Zhimin::g('rowcustertype') . '.png" alt="" />';
}

echo '					<!-- <img src="';
echo Zhimin::g('assets_uri');
echo 'upload/zm_config/';
echo $settings['main_file_logo'];
echo '" alt="" /> -->' . "\r\n" . '				</a>' . "\r\n" . '			</div>' . "\r\n" . '			<div id="top_menu">' . "\r\n" . '				<ul>' . "\r\n" . '				';

if (Zhimin::getComponent('auth')->isSuperAdmin()) {
	echo '					<li class="top_shezhi"><a href="';
	echo Zhimin::buildUrl('welcome', 'index', 'admin');
	echo '" >设置</a></li>' . "\r\n" . '				';
}
else {
	echo '					<li class="top_shezhi_1"><a ></a></li>	' . "\r\n" . '				';
}

echo '					<!-- <li class="top_user"><a href="javascript:user_edit(\'';
echo $_SESSION['userid'];
echo '\');" title="';
echo $_SESSION['username'];
echo '">';
echo $_SESSION['username'];
echo '</a></li>' . "\r\n" . '					<li class="top_message"><a href="javascript:message();" >消息</a></li>' . "\r\n" . '					<li class="top_logout"><a href="';
echo Zhimin::buildUrl('logout', 'index', 'index');
echo '" >退出</a></li> -->' . "\r\n" . '' . "\r\n" . '				</ul>' . "\r\n" . '				<div id="message_num">' . "\r\n" . '						<!-- <ul>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_left.gif" /></li>' . "\r\n" . '							<li class="message_count" style="width:17px;">' . "\r\n" . '								<span>';
echo Zhimin::g('message_count');
echo '</span>' . "\r\n" . '							</li>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_right.gif" /></li>' . "\r\n" . '						</ul> -->' . "\r\n" . '					</div>' . "\r\n" . '			</div>' . "\r\n" . '			<!-- <div id="phone"><span>服务热线：';
echo $settings['telephone'];
echo '</span></div> -->' . "\r\n" . '			<div id="menu">' . "\r\n" . '				<div id="left_menu">' . "\r\n" . '				<ul>' . "\r\n" . '					<li class="menu_index" ';

if (Zhimin::param('show', 'get') == '') {
	echo 'id="current_index"';
}

echo '><a href="';
echo Zhimin::g('assets_uri');
echo '">首页</a></li>' . "\r\n" . '					<li class="menu_vedio" ';

if (Zhimin::param('show', 'get') == 'video') {
	echo 'id="current_vedio"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=video');
echo '" >视频</a></li>' . "\r\n" . '					<li class="menu_voice" ';

if (Zhimin::param('show', 'get') == 'audio') {
	echo 'id="current_voice"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=audio');
echo '" >音频</a></li>' . "\r\n" . '					<li class="menu_pic" ';

if (Zhimin::param('show', 'get') == 'photo') {
	echo 'id="current_pic"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=photo');
echo '" >图片</a></li>' . "\r\n" . '				</ul>' . "\r\n" . '				</div>' . "\r\n" . '				<div id="right_menu">' . "\r\n" . '					<ul>' . "\r\n" . '						<li class="menu_user"><a href="';
echo Zhimin::buildUrl('judge', 'report', 'index');
echo '">考核统计</a></li>' . "\r\n" . '						<li class="menu_setting"><a href="';
echo Zhimin::buildUrl('recorder', 'device', 'index');
echo '" >设备台账</a></li>' . "\r\n" . '						<li class="menu_message"><a href="';
echo Zhimin::buildUrl('media', 'file', 'index');
echo '" >文件管理</a></li>' . "\r\n" . '						<li class="menu_quit"><a href="';
echo Zhimin::buildUrl('unit', 'userunit', 'index');
echo '" >用户管理</a></li>' . "\r\n" . '						' . "\r\n" . '					</ul>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="clearfix"></div>		' . "\r\n" . '		</div>';

?>

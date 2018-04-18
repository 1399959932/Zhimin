<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\r\n" . '<head>' . "\r\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '<title>';
echo Zhimin::a()->title;
echo '</title>' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/base.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/admin_index.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.js"></script>' . "\r\n" . '<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/admin_function.js"></script>' . "\r\n" . '<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/Dialog/zDrag.js"></script>' . "\r\n" . '<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/Dialog/zDialog.js"></script>' . "\r\n" . '' . "\r\n" . '<!--[if IE 6]>' . "\r\n" . '<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/DD_belatedPNG_0.0.8a.js"></script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . ' 	DD_belatedPNG.fix(\'div, ul, img, li, input , a\');' . "\r\n" . '</script>' . "\r\n" . '<![endif]-->' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '//时间显示' . "\r\n" . 'function getCurDate(){' . "\r\n" . ' 	var d = new Date();' . "\r\n" . ' 	var week;' . "\r\n" . ' 	switch (d.getDay()){' . "\r\n" . ' 		case 1: week="星期一"; break;' . "\r\n" . ' 		case 2: week="星期二"; break;' . "\r\n" . ' 		case 3: week="星期三"; break;' . "\r\n" . ' 		case 4: week="星期四"; break;' . "\r\n" . ' 		case 5: week="星期五"; break;' . "\r\n" . ' 		case 6: week="星期六"; break;' . "\r\n" . ' 		default: week="星期天";' . "\r\n" . ' 	}' . "\r\n" . ' 	var years = d.getFullYear();' . "\r\n" . ' 	var month = add_zero(d.getMonth()+1);' . "\r\n" . ' 	var days = add_zero(d.getDate());' . "\r\n" . ' 	var hours = add_zero(d.getHours());' . "\r\n" . ' 	var minutes = add_zero(d.getMinutes());' . "\r\n" . ' 	var seconds=add_zero(d.getSeconds());' . "\r\n" . ' 	var ndate = years+"-"+month+"-"+days+"    "+hours+":"+minutes+":"+seconds+" "+week;' . "\r\n" . ' 	document.getElementById("logo_time").innerHTML = ndate;' . "\r\n" . '}' . "\r\n" . 'setInterval("getCurDate()",100);' . "\r\n" . '' . "\r\n" . 'function show_announce(id){' . "\r\n" . '	var diag = new Dialog();' . "\r\n" . '	diag.Width = 600;' . "\r\n" . '	diag.Height = 600;' . "\r\n" . '	diag.Modal = true;' . "\r\n" . '	diag.URL = "';
echo Zhimin::buildUrl('announce', 'index', 'index');
echo '&action=show&position=main&id="+id;' . "\r\n" . '	diag.show();' . "\r\n" . '}' . "\r\n" . 'function message(){       //The message list Diag' . "\r\n" . '	var diag = new Dialog();' . "\r\n" . '	diag.Modal = true;' . "\r\n" . '	diag.Title = \'站内短信\';' . "\r\n" . '	diag.Width = 600;' . "\r\n" . '	diag.Height = 400;' . "\r\n" . '	diag.URL = "';
echo Zhimin::buildUrl('message', 'user', 'index');
echo '&action=list";' . "\r\n" . '	diag.show();' . "\r\n" . '	//return false;' . "\r\n" . '}' . "\r\n" . '</script>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '	<div id="maincontent">' . "\r\n" . '	    <!-- 顶部开始-->' . "\r\n" . '		<div id="header">' . "\r\n" . '			<div id="logo">' . "\r\n" . '				<a href="';
echo Zhimin::g('assets_uri');
echo '">' . "\r\n" . '					';
$settings = Zhimin::a()->getData('settings');
if (($settings['admin_file_logo'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['admin_file_logo'])) {
	echo '<img src="' . Zhimin::g('assets_uri') . 'upload/zm_config/' . $settings['admin_file_logo'] . '" title="logo" width="83px" />';
}
else {
	echo '<img src="images/logo/admin_file_logo_' . Zhimin::g('rowcustertype') . '.png" title="logo" width="83px" />';
}

echo '					<!-- <img src="';
echo Zhimin::g('assets_uri');
echo 'upload/zm_config/';
echo $settings['admin_file_logo'];
echo '" title="logo" width="83px"/> -->' . "\r\n" . '				</a>' . "\r\n" . '			</div>' . "\r\n" . '			<div id="logo_title">' . "\r\n" . '				<span>';
echo Zhimin::a()->title;
echo '</span>' . "\r\n" . '			</div>' . "\r\n" . '			<div id="logo_phone">' . "\r\n" . '				<span class="logo_phone">服务热线：';
echo $settings['telephone'];
echo '</span><br/>' . "\r\n" . '				<span class="logo_time" id="logo_time">2013-07-04 12:00:00 星期四</span>' . "\r\n" . '			</div>' . "\r\n" . '			<!-- 左边menu -->' . "\r\n" . '			<div id="left_menu">' . "\r\n" . '				<ul>' . "\r\n" . '					<li class="left_system';
echo ismenuhot('', 'system') ? '_cur' : '';
echo '"><a href="';
echo Zhimin::buildUrl('index', 'system');
echo '">系统管理</a></li>' . "\r\n" . '					<!--<li class="left_media';
echo ismenuhot('', 'media') ? '_cur' : '';
echo '"><a href="';
echo Zhimin::buildUrl('index', 'media');
echo '">文件管理</a></li>-->' . "\r\n" . '					<!--<li class="left_user';
echo ismenuhot('', 'user') ? '_cur' : '';
echo '"><a href="';
echo Zhimin::buildUrl('index', 'user');
echo '">用户管理</a></li>-->' . "\r\n" . '					<li class="left_daily';
echo ismenuhot('', 'assert') ? '_cur' : '';
echo '"><a href="';
echo Zhimin::buildUrl('index', 'assert');
echo '">日常维护</a></li>' . "\r\n" . '					<!--<li class="left_data"><a href="#">数据库管理</a></li>' . "\r\n" . '					<li class="left_check"><a href="#">考核管理</a></li>-->' . "\r\n" . '				</ul>' . "\r\n" . '			</div>' . "\r\n" . '			<!-- 右边Meun-->' . "\r\n" . '			<div id="right_menu">' . "\r\n" . '				<ul>' . "\r\n" . '				<!--	<li class="right_set"><a href="';
echo Zhimin::buildUrl('index', 'index', 'admin');
echo '">设置</a></li> -->' . "\r\n" . '					<li class="right_exit"><a href="';
echo Zhimin::buildUrl('logout', 'index', 'index');
echo '">退出</a></li>' . "\r\n" . '					<li class="right_index"><a href="';
echo Zhimin::g('assets_uri');
echo '">首页</a></li>' . "\r\n" . '					' . "\r\n" . '				</ul>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<!-- 头部结束-->' . "\r\n" . '		<!-- 左边Menu开始-->' . "\r\n" . '		<div id="left_banner">' . "\r\n" . '			<!-- 管理员的个人信息 -->' . "\r\n" . '			<div id="left_admin">' . "\r\n" . '				<div id="admin_pic">' . "\r\n" . '					<img src="';
echo Zhimin::g('assets_uri');
echo 'images/user_head.jpg" title="admin_picture" />' . "\r\n" . '				</div>' . "\r\n" . '				<div id="admin_info">' . "\r\n" . '				';
$loginuser = Zhimin::g('loginuser');

if ($loginuser['level'] == '1') {
	echo '					<img src="';
	echo Zhimin::g('assets_uri');
	echo 'images/admin_flg.gif"	title="管理员标志" class="is_admin"/>' . "\r\n" . '				';
}
else {
	echo '					<img src="';
	echo Zhimin::g('assets_uri');
	echo 'images/admin_flg.gif"	title="管理员标志" class="is_admin"/>' . "\r\n" . '				';
}

echo '					<div class="admin_username">' . "\r\n" . '						<a href="#" title="';
echo $loginuser['username'];
echo '"><span class="admin_name">';
echo $loginuser['username'];
echo '</span></a>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="admin_usergroup">' . "\r\n" . '						<span class="admin_group">';
echo $loginuser['groupname'];
echo '</span>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="admin_usergroup">' . "\r\n" . '						<span class="admin_group">';
echo $loginuser['usertype'];
echo '</span>' . "\r\n" . '					</div>' . "\r\n" . '					<ul>' . "\r\n" . '						<li class="admin_email"><a title="邮件" href="javascript:message();">' . "\r\n" . '						<!--<li class="admin_setting"><a title="系统设置" href="#">系统设置</a></li>  -->' . "\r\n" . '						<li class="admin_info"><a title="个人信息" href="';
echo Zhimin::buildUrl('user', 'userunit', 'index', 'action=edit&id=' . $_SESSION['userid']);
echo '">个人信息</a></li>' . "\r\n" . '					</ul>' . "\r\n" . '					<div id="message_num">' . "\r\n" . '						<ul>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_left.gif" /></li>' . "\r\n" . '							<li class="message_count" style="width:17px;">' . "\r\n" . '								<span>';
echo Zhimin::g('message_count');
echo '</span>' . "\r\n" . '							</li>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_right.gif" /></li>' . "\r\n" . '						</ul>' . "\r\n" . '					</div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			';
echo $menu;
echo '			<!-- 列表主体-->' . "\r\n" . '		<!-- 左侧menu结束-->' . "\r\n" . '		</div>' . "\r\n" . '		<!--  右侧主体部分开始 -->' . "\r\n" . '		';
echo $main;
echo '	</div>	' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

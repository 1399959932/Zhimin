<?php
//系统管理，基本资料设置页面
echo '<div class="tab_button_wrap">' . "\r\n" . '	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->' . "\r\n" . '	';
//判断是不是有该权限的管理员
if (issuperadmin()) {
	echo '	<div class="tab_button ';
	echo ismenuhot('unit', 'system') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('unit', 'system');
	echo '\'">部门管理</div>' . "\r\n" . '	<div class="tab_button ';
	echo ismenuhot('group', 'system') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('group', 'system');
	echo '\'">角色管理</div>' . "\r\n" . '	';
}

$bh = 1008;
$tab_array = mudule_view_array($bh);

if (!empty($tab_array)) {
	foreach ($tab_array as $k => $v ) {
		echo '		<div class="tab_button ';
		echo ismenuhot($v['filename'], 'system') ? 'active' : '';
		echo '" onclick="location.href=\'';
		echo Zhimin::buildUrl($v['filename'], 'system');
		echo '\'">';
		echo $v['mname'];
		echo '</div>' . "\r\n" . '	';
	}
}

echo '	';

if (issuperadmin()) {
	echo '	<div class="tab_button ';
	echo ismenuhot('sysconf', 'system') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('sysconf', 'system');
	echo '\'">系统配置项</div>' . "\r\n" . '	<div class="tab_button ';
	echo ismenuhot('config', 'system') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('config', 'system');
	echo '\'">基本资料设置</div>' . "\r\n" . '	<div class="tab_button ';
	echo ismenuhot('norelation', 'system') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('norelation', 'system');
	echo '\'">未关联文件</div>' . "\r\n" . '	';

	if ($_SESSION['username'] == 'manager') {
		echo '		<div class="tab_button ';
		echo ismenuhot('pollcode', 'system') ? 'active' : '';
		echo '" onclick="location.href=\'';
		echo Zhimin::buildUrl('pollcode', 'system');
		echo '\'">注册码管理</div>' . "\r\n" . '	';

		echo '		<div class="tab_button ';
		echo ismenuhot('facility', 'system') ? 'active' : '';
		echo '" onclick="location.href=\'';
		echo Zhimin::buildUrl('facility', 'system');
		echo '\'">设备管理</div>' . "\r\n" . '	';
	}
}

echo '</div>';

?>

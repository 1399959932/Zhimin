<?php

echo '<div class="tab_button_wrap">' . "\r\n" . '	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->' . "\r\n" . '	';
$bh = 1007;
$tab_array = mudule_view_array($bh);

if (!empty($tab_array)) {
	foreach ($tab_array as $k => $v ) {
		echo '		<div class="tab_button ';
		echo ismenuhot($v['filename'], 'host') ? 'active' : '';
		echo '" onclick="location.href=\'';
		echo Zhimin::buildUrl($v['filename'], 'host');
		echo '\'">';
		echo $v['mname'];
		echo '</div>' . "\r\n" . '	';
	}
}

echo '	';

if (issuperadmin()) {
	echo '	<div class="tab_button ';
	echo ismenuhot('server', 'host') ? 'active' : '';
	echo '" onclick="location.href=\'';
	echo Zhimin::buildUrl('server', 'host');
	echo '\'">服务器管理</div>' . "\r\n" . '	';
}

echo '</div>';

?>

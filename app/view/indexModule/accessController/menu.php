<?php

echo '<div class="tab_button_wrap">' . "\r\n" . '	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->' . "\r\n" . '	';
$bh = 1004;
$tab_array = mudule_view_array($bh);

if (!empty($tab_array)) {
	foreach ($tab_array as $k => $v ) {
		echo '		<div class="tab_button ';
		echo ismenuhot($v['filename'], 'access') ? 'active' : '';
		echo '" onclick="location.href=\'';
		echo Zhimin::buildUrl($v['filename'], 'access');
		echo '\'">';
		echo $v['mname'];
		echo '</div>' . "\r\n" . '	';
	}
}

echo '</div>';

?>

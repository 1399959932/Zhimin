<?php

echo '<div id="right_main">' . "\r\n" . '<div class="jump_div">' . "\r\n" . '	<div class="jump_sys">' . "\r\n" . '		<b>系统提示信息</b>' . "\r\n" . '	</div>' . "\r\n" . '	<div class="jump_message">' . "\r\n" . '		<br />' . "\r\n" . '		<br />' . "\r\n" . '		<br />' . "\r\n" . '		';
echo $message;
echo '		<br />' . "\r\n" . '		<br />' . "\r\n" . '		<br />' . "\r\n" . '		<input class="btnbg2" onclick="location.href=\'';
echo $url;
echo '\'" value="点击返回" >' . "\r\n" . '		<br>' . "\r\n" . '	</div>' . "\r\n" . '</div>' . "\r\n" . '</div>';

?>

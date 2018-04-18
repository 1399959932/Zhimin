<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\r\n" . '<head>' . "\r\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '<!-- <meta http-equiv=refresh content=3;url=index.php /> -->' . "\r\n" . '<title>';
echo $message;
echo '</title>' . "\r\n" . '<link href="style/reset.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<style type=text/css>' . "\r\n" . '.no_auth{' . "\r\n" . '	width:500px;' . "\r\n" . '	margin:0 auto;' . "\r\n" . '	height:300px;' . "\r\n" . '	/*border:1px solid #f00;*/' . "\r\n" . '}' . "\r\n" . '.img_div{' . "\r\n" . '	width:500px;' . "\r\n" . '	text-align:center;' . "\r\n" . '	height:72px;' . "\r\n" . '	padding-top:60px;' . "\r\n" . '}' . "\r\n" . '.font14 {' . "\r\n" . '	font-size:14px;' . "\r\n" . '	text-align:center;' . "\r\n" . '}' . "\r\n" . '.font12 {' . "\r\n" . '	font-size:12px;' . "\r\n" . '}' . "\r\n" . '</style>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '	<div class="no_auth">' . "\r\n" . '  		<div class="img_div">' . "\r\n" . '			<img src="images/no_auth.jpg" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="font14">' . "\r\n" . '			<span class=font12><font color="#000">';
echo $message;
echo '</font></span>' . "\r\n" . '    	</div>' . "\r\n" . '  </div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

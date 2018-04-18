<?php

echo '<!DOCTYPE html>' . "\r\n" . '<html>' . "\r\n" . '<head>' . "\r\n" . '    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '    <title>oh,出错了</title>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '<pre>' . "\r\n" . '类型:';
echo $type;
echo '<br >' . "\r\n" . '文件名:';
echo $file;
echo '<br >' . "\r\n" . '行数:';
echo $line;
echo '<br >' . "\r\n" . '信息:';
echo $message;
echo '<br />' . "\r\n" . '    ';

if (isset($backtrace)) {
	echo '        <hr >' . "\r\n" . '        ';
	print_r($backtrace);
	echo '    ';
}

echo '</body>' . "\r\n" . '</html>';

?>

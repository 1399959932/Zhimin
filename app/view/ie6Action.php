<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>ie6</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script>' . "\r\n" . '		$(document).ready(function(){' . "\r\n" . '			$(".close_notice").click(function(){' . "\r\n" . '				parent.layer.closeAll();' . "\r\n" . '			})' . "\r\n" . '		})' . "\r\n" . '	</script>' . "\r\n" . '	<style>' . "\r\n" . '		body{width: 305px;height: 132px;overflow: hidden;background: url("./images/notice02_bg.png") 0 0 no-repeat;color:#fff;font-size: 12px;position: relative;}' . "\r\n" . '		.close_notice{position: absolute;top:0px;right: 20px;display: block;width: 14px;height: 14px;overflow: hidden;}' . "\r\n" . '		.not_content{overflow: hidden;}' . "\r\n" . '		.not_content span{display: inline-block;float: left;margin-top: 42px;margin-left: 12px;}' . "\r\n" . '		.not_content p{width: 235px;line-height: 14px;display: inline-block;float: left;margin-left: 10px;margin-top: 35px;}' . "\r\n" . '	</style>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '	<div class="close_notice"><img src="';
echo Zhimin::g('assets_uri');
echo 'images/notice_close01.png" alt="" /></div>' . "\r\n" . '	<div class="not_content">' . "\r\n" . '		<span><img src="';
echo Zhimin::g('assets_uri');
echo 'images/smile01.png" alt="" /></span>' . "\r\n" . '		<p>尊敬的用户，您当前使用的IE版本太旧，可能导致显示异常，为保证您的正常使用，请下载安装IE7以上版本。</p>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

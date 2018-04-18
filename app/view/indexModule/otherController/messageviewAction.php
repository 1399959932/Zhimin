<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>站內信</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/home.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '	<style>' . "\r\n" . '	.letter_top .close{ position:absolute; right:35px;top:15px;}' . "\r\n" . '	.atten_top .close {' . "\r\n" . '    line-height: normal;' . "\r\n" . '    right: 15px;' . "\r\n" . '}' . "\r\n" . '	</style>' . "\r\n" . '	<![endif]-->' . "\r\n" . '<body style="width:760px;">' . "\r\n" . '	<div class="layer_iframe">' . "\r\n" . '		<div class="iframe_top letter_top"><span class="letter_t">站內短信（读信）</span><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body letter_body">' . "\r\n" . '			<div class="letter_wrap">' . "\r\n" . '				<form action="';
echo Zhimin::buildUrl('messageview', 'other', 'index');
echo '&action=viewmsg">' . "\r\n" . '				<div class="table_height letter_w">			' . "\r\n" . '					<table class="table_detail">' . "\r\n" . '						<tbody>' . "\r\n" . '' . "\r\n" . '							<tr>' . "\r\n" . '								<td width="110" class="td_light td_left">发信人</td>' . "\r\n" . '								<td class="td_light td_right">														' . "\r\n" . '									';
echo $message['username'];
echo '			' . "\r\n" . '								</td>' . "\r\n" . '							</tr>' . "\r\n" . '							<tr>' . "\r\n" . '								<td class="td_grey td_left">标 题</td>' . "\r\n" . '								<td class="td_grey td_right">														' . "\r\n" . '									';
echo $message['title'];
echo '			' . "\r\n" . '								</td>' . "\r\n" . '							</tr>' . "\r\n" . '							<tr>' . "\r\n" . '								<td class="td_light td_left ver_top">信息内容</td>' . "\r\n" . '								<td class="letter_textarea td_right">														' . "\r\n" . '									<textarea name="">';
echo $message['content'];
echo '</textarea>	' . "\r\n" . '								</td>' . "\r\n" . '							</tr>' . "\r\n" . '							' . "\r\n" . '						</tbody>' . "\r\n" . '					</table>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="button_case read_letter">' . "\r\n" . '					<span class="sure_cancle" onclick="javascript:history.go(-1)">返 回</span>' . "\r\n" . '				</div>' . "\r\n" . '				</form>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="iframe_foot letter_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 发送确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/letter_tubiao.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定发送站内信？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span letter_submit">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>发送成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>发送失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

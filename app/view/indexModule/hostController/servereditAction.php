<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '    <title>考勤编辑</title>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/serveredit.js"></script>' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '    <style type="text/css">' . "\r\n" . '        .table_detail tbody td{*border-right:none;}' . "\r\n" . '    </style>' . "\r\n" . '    <!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '<div class="layer_iframe1">' . "\r\n" . '    <div class="iframe_top1">修改<span class="close1 close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '    <div class="iframe_body1">' . "\r\n" . '        <form name="server_edit_form" id="server_edit_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">服务器名称：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="servername" value="';
echo $data['servername'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写名称</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">服务IP地址：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="serverip" value="';
echo $data['serverip'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写IP地址</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">登录用户名：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="ftpusername" value="';
echo $data['ftpusername'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写登录用户名</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">登录密码：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="pwd" value="';
echo $data['pwd'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写登录密码</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">端口：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="port" value="';
echo $data['port'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写端口</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">路径url：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="path" value="';
echo $data['path'];
echo '" />' . "\r\n" . '							<span class="error_msg">请填写路径url</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">是否使用：</span>' . "\r\n" . '						<div class="select_265 select_div select_radio select_no">' . "\r\n" . '							<label for="radio_yes">' . "\r\n" . '								是' . "\r\n" . '								<input type="radio" name="flag" id="radio_yes" value="1" ';

if ($data['flag'] == '1') {
	echo 'checked';
}

echo '>' . "\r\n" . '							</label>' . "\r\n" . '							<label for="radio_no">' . "\r\n" . '								否' . "\r\n" . '								<input type="radio" name="flag" id="radio_no" value="0" ';

if ($data['flag'] == '0') {
	echo 'checked';
}

echo '>' . "\r\n" . '							</label>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>				' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">	' . "\r\n" . '						<div class="select_260 select_div  select_  select_in selec_text">' . "\r\n" . '							<input type="hidden" name="id" value="';
echo $data['id'];
echo '" />' . "\r\n" . '	                        <input type="hidden" name="saveflag" value="saveflag" />' . "\r\n" . '							<span class="sure_add edit_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '</div>' . "\r\n" . '<div class="iframe_foot1"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 成功提示框 -->' . "\r\n" . '<div class="layer_notice lay_success_edit">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/success_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="success_flg">编辑成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 失败提示框 -->' . "\r\n" . '<div class="layer_notice lay_wrong_edit">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/notice_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="fail_flg">编辑失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>工作站远程配置</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/hostglobal.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/default/easyui.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/icon.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/re_easyui.css">' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	<style>' . "\r\n" . '		.f_t1{display: inline-block;width: 60px;}' . "\r\n" . '		.f_t2{display: inline-block;width: 85px;}' . "\r\n" . '		.f_t3{display: inline-block;width: 105px;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '	<div class="layer_iframe1">' . "\r\n" . '		<div class="iframe_top1">';

if ($exglobal) {
	echo '全局配置';
}
else {
	echo '远程配置（工作站名：' . $station['hostname'] . ')';
}

echo '<span class="close1 close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body2">' . "\r\n" . '			<div class="config_wrap">' . "\r\n" . '				<div class="config_con">' . "\r\n" . '					<ul class="tab_ul">' . "\r\n" . '						<li class="active">基本信息</li>' . "\r\n" . '						<li class="li_after li_1">采集相关</li>' . "\r\n" . '						<li class="li_after li_2">上传相关</li>' . "\r\n" . '						<li class="li_after li_3">安全配置</li>' . "\r\n" . '					</ul>' . "\r\n" . '					<div class="right_iframe_top"></div>' . "\r\n" . '					<div class="right_iframe_body">' . "\r\n" . '						<!-- 基本信息设置 -->' . "\r\n" . '						<div style="display: block;" class="tab_wrap tab_config">' . "\r\n" . '							<form method="post" action="" name="basic_form" id="basic_form">' . "\r\n" . '							<div class="condition_335 condition_s">' . "\r\n" . '								<span class="condition_title">标题：</span>' . "\r\n" . '								<div class="select_263 select_div select_in">' . "\r\n" . '									<input type="text" value="';
echo $hostcnfs['Title'];
echo '" name="Title" />' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="condition_335 condition_s">' . "\r\n" . '								<span class="condition_title">服务热线：</span>' . "\r\n" . '								<div class="select_263 select_div select_in">' . "\r\n" . '									<input type="text" value="';
echo $hostcnfs['HotTel'];
echo '" name="HotTel" />' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="condition_335 condition_s condition_global">' . "\r\n" . '								<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '								<input type="hidden" name="hostname" value="';
echo $station['hostname'];
echo '" />' . "\r\n" . '								';

if ($exglobal) {
	echo '<input type="hidden" class="saveflag" value="1" />';
}
else {
	echo '<input type="hidden" class="saveflag" value="0" />';
}

echo '								<input type="button" value="确 定" class="v_sub v_sub_basic" id="v_sub_basic"/>' . "\r\n" . '								<input type="button" value="取 消" class="v_cancel close_btn" />								' . "\r\n" . '							</div>' . "\r\n" . '							</form>' . "\r\n" . '						</div>' . "\r\n" . '						<!-- 采集相关 -->' . "\r\n" . '						<div class="tab_wrap tab_config">' . "\r\n" . '							<form method="post" action="" name="collect_form" id="collect_form">' . "\r\n" . '							<div class="condition_335 condition_s condition_c">' . "\r\n" . '								<span class="condition_title">预警容量：</span>' . "\r\n" . '								<div class="select_200 select_div select_in select_config">' . "\r\n" . '									<input type="text" value="';

if ($hostcnfs['CopyParalls']) {
	echo $hostcnfs['ReserveSpace'];
}
else {
	echo '0';
}

echo '" name="ReserveSpace" />' . "\r\n" . '									<div class="sign">' . "\r\n" . '										<span class="plus"></span>' . "\r\n" . '										<span class="minus"></span>' . "\r\n" . '									</div>' . "\r\n" . '								</div>' . "\r\n" . '								&nbsp;&nbsp;GB' . "\r\n" . '							</div>' . "\r\n" . '							<div class="condition_335 condition_s condition_c">' . "\r\n" . '								<span class="condition_title">网络带宽：</span>' . "\r\n" . '								<div class="select_200 select_div select_in select_config">' . "\r\n" . '									<input type="text" value="';

if ($hostcnfs['CopyParalls']) {
	echo $hostcnfs['Bandwidth'];
}
else {
	echo '0';
}

echo '" name="Bandwidth" />' . "\r\n" . '									<div class="sign">' . "\r\n" . '										<span class="plus"></span>' . "\r\n" . '										<span class="minus"></span>' . "\r\n" . '									</div>' . "\r\n" . '								</div>' . "\r\n" . '								&nbsp;&nbsp;bps' . "\r\n" . '							</div>' . "\r\n" . '							<div class="condition_335 condition_s condition_c">' . "\r\n" . '								<span class="condition_title">并发数：</span>' . "\r\n" . '								<div class="select_200 select_div select_in select_config">' . "\r\n" . '									<input type="text" value="';

if ($hostcnfs['CopyParalls']) {
	echo $hostcnfs['CopyParalls'];
}
else {
	echo '0';
}

echo '" name="CopyParalls" />' . "\r\n" . '									<div class="sign">' . "\r\n" . '										<span class="plus"></span>' . "\r\n" . '										<span class="minus"></span>' . "\r\n" . '									</div>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							' . "\r\n" . '							<div class="condition_335 condition_s condition_c check_box">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['Overlay'] == 1) {
	echo ' checked="checked" ';
}

echo ' value="1" name="Overlay"/>' . "\r\n" . '							        <font class="f_t1">自动覆盖：</font>' . "\r\n" . '							        ';

if ($hostcnfs['Overlay']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '								    <input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['DevLog'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="DevLog"/>' . "\r\n" . '							        <font class="f_t1">采集日志：</font>' . "\r\n" . '							         ';

if ($hostcnfs['DevLog']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_box">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['HuntPort'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="HuntPort"/>' . "\r\n" . '							        <font class="f_t1">兼容模式：</font>' . "\r\n" . '							         ';

if ($hostcnfs['HuntPort']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '							    ' . "\r\n" . '						    </div>' . "\r\n" . '							<div class="condition_295 condition_s condition_global">' . "\r\n" . '								<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '								<input type="hidden" name="hostname" value="';
echo $station['hostname'];
echo '" />' . "\r\n" . '                        		';

if ($exglobal) {
	echo '<input type="hidden" class="saveflag" value="1" />';
}
else {
	echo '<input type="hidden" class="saveflag" value="0" />';
}

echo '								<input type="button" value="确 定" class="v_sub v_sub_collect" id="v_sub_collect"/>' . "\r\n" . '								<input type="button" value="取 消" class="v_cancel close_btn" />								' . "\r\n" . '							</div>' . "\r\n" . '							</form>' . "\r\n" . '						</div>' . "\r\n" . '						<!-- 上传相关 -->' . "\r\n" . '						<div class="tab_wrap tab_config">' . "\r\n" . '							<form method="post" action="" name="upload_form" id="upload_form">' . "\r\n" . '							<div class="condition_310 condition_s">' . "\r\n" . '								<span class="condition_title">存储模式：</span>' . "\r\n" . '								<div style="height:20px;" class="select_240 select_div">' . "\r\n" . '								<select class="easy_u" id="StorageMode" name="StorageMode" style="width:100%;">' . "\r\n" . '									<option value="">-请选择-</option>' . "\r\n" . '									';

foreach ($store_model_array as $k => $v ) {
	echo '<option value="' . $k . '"';
	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '								</div>' . "\r\n" . '								<input type="hidden" id="smodeval" value="';
echo $hostcnfs['StorageMode'];
echo '">' . "\r\n" . '							</div>' . "\r\n" . '							<div class="condition_310 condition_s">' . "\r\n" . '								<span class="condition_title">上传方式：</span>' . "\r\n" . '								<div style="height:20px;" class="select_240 select_div">' . "\r\n" . '								<select class="easy_u" id="Upload" name="Upload" style="width:100%;">' . "\r\n" . '									<option value="">-请选择-</option>' . "\r\n" . '									';

foreach ($upload_model_array as $k => $v ) {
	echo '<option value="' . $k . '"';
	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '								</div>' . "\r\n" . '								<input type="hidden" id="Uploadval" value="';
echo $hostcnfs['Upload'];
echo '">' . "\r\n" . '							</div>' . "\r\n" . '							<div class="check_box">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '						    		<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['SyncTime'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="SyncTime"/>' . "\r\n" . '							        <font class="f_t1">同步时间：</font>' . "\r\n" . '							        ';

if ($hostcnfs['SyncTime']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '							  	    <input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['SyncSpace'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="SyncSpace"/>' . "\r\n" . '							        <font class="f_t1">同步容量：</font>' . "\r\n" . '							        ';

if ($hostcnfs['SyncSpace']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_box">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '						    		<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['Desktop' == 1]) {
	echo ' checked=checked ';
}

echo ' value="1" name="Desktop"/>' . "\r\n" . '							        <font class="f_t1">远程桌面：</font>' . "\r\n" . '							        ';

if ($hostcnfs['Desktop']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['MonitorSoft'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="MonitorSoft"/>' . "\r\n" . '							        <font class="f_t2">监控应用程序：</font>' . "\r\n" . '							        ';

if ($hostcnfs['MonitorSoft']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_box">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '						    		<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['MonitorHardware'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="MonitorHardware"/>' . "\r\n" . '							        <font class="f_t2">监控硬件信息：</font>' . "\r\n" . '							        ';

if ($hostcnfs['MonitorHardware']) {
	echo '<label class="checkbox cur"></label>';
}
else {
	echo '<label class="checkbox"></label>';
}

echo '							    </div>' . "\r\n" . '						    </div>' . "\r\n" . '							<div class="condition_295 condition_s condition_global">' . "\r\n" . '								<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '								<input type="hidden" name="hostname" value="';
echo $station['hostname'];
echo '" />' . "\r\n" . '                        		';

if ($exglobal) {
	echo '<input type="hidden" class="saveflag" value="1" />';
}
else {
	echo '<input type="hidden" class="saveflag" value="0" />';
}

echo '								<input type="button" value="确 定" class="v_sub v_sub_upload" id="v_sub_upload"/>' . "\r\n" . '								<input type="button" value="取 消" class="v_cancel close_btn" />								' . "\r\n" . '							</div>' . "\r\n" . '							</form>' . "\r\n" . '						</div>' . "\r\n" . '						<!-- 安全控制 -->' . "\r\n" . '						<div class="tab_wrap tab_config">' . "\r\n" . '							<form method="post" action="" name="safe_form" id="safe_form">' . "\r\n" . '							<div class="check_span check_div">' . "\r\n" . '								<input type="checkbox" class="ipt-hide" ';

if ($hostcnfs['Equipmentcontrol'] == 1) {
	echo ' checked=checked ';
}

echo ' value="1" name="Equipmentcontrol"/>' . "\r\n" . '								';

if ($hostcnfs['Equipmentcontrol'] == 1) {
	echo '<label class="checkbox check_label cur"></label>设备控制策略';
}
else {
	echo '<label class="checkbox check_label"></label>设备控制策略';
}

echo '						    </div>' . "\r\n" . '						    ';

if ($hostcnfs['Equipmentcontrol'] == 1) {
	echo '<div class="check_box">';
}
else {
	echo '<div class="check_box check_div_disable">';
}

echo '						    <!--<div class="check_box check_div_disable">  -->' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '						    		<input type="checkbox" class="ipt-hide" ';
if (($hostcnfs['Equipmentcontrol'] == 1) && ($hostcnfs['Usbswitch'] == 1)) {
	echo ' checked=checked ';
}

echo ' value="1" name="Usbswitch"/>' . "\r\n" . '							        <font class="f_t2">USB存储设备：</font>' . "\r\n" . '							        ';
if (($hostcnfs['Equipmentcontrol'] == 1) && ($hostcnfs['Usbswitch'] == 1)) {
	echo '<label class="check_disable checkbox cur"></label>';
}
else if ($hostcnfs['Equipmentcontrol'] == 1) {
	echo '<label class="check_disable checkbox"></label>';
}
else {
	echo '<label class="check_disable"></label>';
}

echo '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" class="ipt-hide" ';
if (($hostcnfs['Equipmentcontrol'] == 1) && ($hostcnfs['keyboard'] == 1)) {
	echo ' checked=checked ';
}

echo ' value="1" name="keyboard"/>' . "\r\n" . '							        <font class="f_t1">USB键盘：</font>' . "\r\n" . '							        ';
if (($hostcnfs['Equipmentcontrol'] == 1) && ($hostcnfs['keyboard'] == 1)) {
	echo '<label class="check_disable checkbox cur"></label>';
}
else if ($hostcnfs['Equipmentcontrol'] == 1) {
	echo '<label class="check_disable checkbox"></label>';
}
else {
	echo '<label class="check_disable"></label>';
}

echo '							    </div>' . "\r\n" . '							</div>' . "\r\n" . '						    <!-- <div class="check_span check_div">' . "\r\n" . '						    	<input type="checkbox" value="01" class="ipt-hide">' . "\r\n" . '						        <label class="checkbox check_label"></label>导出策略' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_box check_div_disable">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" value="01" class="ipt-hide">' . "\r\n" . '							        <font class="f_t">允许普通U盘导出：</font><label class="check_disable"></label>' . "\r\n" . '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '							    	<input type="checkbox" value="01" class="ipt-hide">' . "\r\n" . '							        <font class="f_t">允许公安U盘导出：</font><label class="check_disable"></label>' . "\r\n" . '							    </div>' . "\r\n" . '						    </div> -->' . "\r\n" . '						    <div class="check_span check_div check_box">' . "\r\n" . '						    	网络控制策略：' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_box select_radio">' . "\r\n" . '						    	<div class="check_span chheck_config">' . "\r\n" . '							    	<label for="radio_yes">' . "\r\n" . '										启用：' . "\r\n" . '										<input type="radio" ';

if ($hostcnfs['Netswitch'] == 1) {
	echo ' checked=checked ';
}

echo ' name="Netswitch" id="radio_yes" value="1">' . "\r\n" . '									</label>' . "\r\n" . '							    </div>' . "\r\n" . '							    <div class="check_span chheck_config">' . "\r\n" . '							    	<label for="radio_no">' . "\r\n" . '										禁用：' . "\r\n" . '										<input type="radio" ';

if ($hostcnfs['Netswitch'] == 0) {
	echo ' checked=checked ';
}

echo ' name="Netswitch" id="radio_no" value="0">' . "\r\n" . '									</label>' . "\r\n" . '							    </div>' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_span check_div check_box">' . "\r\n" . '						    	进程管控策略（白名单）：' . "\r\n" . '						    </div>' . "\r\n" . '						    <div class="check_span process check_box">' . "\r\n" . '						    	<input type="text" name="Process" value="';
echo $hostcnfs['Process'];
echo '"/>' . "\r\n" . '						    </div>' . "\r\n" . '							<div class="condition_295 condition_s condition_global">' . "\r\n" . '								<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '								<input type="hidden" name="hostname" value="';
echo $station['hostname'];
echo '" />' . "\r\n" . '                        		';

if ($exglobal) {
	echo '<input type="hidden" class="saveflag" value="1" />';
}
else {
	echo '<input type="hidden" class="saveflag" value="0" />';
}

echo '								<input type="button" value="确 定" class="v_sub v_sub_safe" id="v_sub_safe"/>' . "\r\n" . '								<input type="button" value="取 消" class="v_cancel close_btn" />								' . "\r\n" . '							</div>' . "\r\n" . '							</form>' . "\r\n" . '						</div>					' . "\r\n" . '					</div>' . "\r\n" . '					<div class="right_iframe_foot"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="iframe_foot1"></div>' . "\r\n" . '	</div>' . "\r\n" . '<!-- 成功提示框 -->' . "\r\n" . '<div class="layer_notice lay_success_edit">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/success_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="success_flg">修改成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 失败提示框 -->' . "\r\n" . '<div class="layer_notice lay_wrong_edit">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/notice_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="fail_flg">修改失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	var smodeval=$("#smodeval").val();' . "\r\n" . '	var Uploadval=$("#Uploadval").val();' . "\r\n" . '	$(".easyui-combotree").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=bh&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$(".easyui-combotree").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});' . "\r\n" . '	$(\'#StorageMode\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '			onLoadSuccess:function(data){ ' . "\r\n" . '				$(\'#StorageMode\').combobox(\'setValue\',[smodeval]);' . "\r\n" . '			}	' . "\r\n" . '		});' . "\r\n" . '	$(\'#Upload\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '			onLoadSuccess:function(data){ ' . "\r\n" . '				$(\'#Upload\').combobox(\'setValue\',[Uploadval]);' . "\r\n" . '			}	' . "\r\n" . '		});' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'';
echo Zhimin::request('date_time');
echo '\']);' . "\r\n" . '	}' . "\r\n" . '});' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

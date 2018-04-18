<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>系统配置项</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/sysconf.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
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
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	<style>' . "\r\n" . '		.condition_textarea .textarea_in textarea{*height: 79px;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
echo '		' . "\r\n" . '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box surpervision">' . "\r\n" . '				<form action="';
echo Zhimin::buildUrl();
echo '&action=search" method="post">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_240 condition_s">' . "\r\n" . '							<span class="condition_title">类别：</span>' . "\r\n" . '							<div class="select_200 select_div">' . "\r\n" . '								<select class="easy_u" id="type" name="type" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($config_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if (Zhimin::request('type') == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_s sub">							' . "\r\n" . '							<input type="submit" value=""/>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				</form>' . "\r\n" . '				<div class="action_div action_state">' . "\r\n" . '				' . "\r\n" . '				';
echo '<span class="addlevel_s add on">添加</span>';
echo '<span class="addlevel_s edit_a">修改</span>';
echo '<span class="addlevel_s action_del" >删 除</span>';
echo '				</div>' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<table class="table_detail">' . "\r\n" . '						<thead>' . "\r\n" . '							<tr>' . "\r\n" . '								<th width="6%" class="t_back">序号</th>' . "\r\n" . '								<th width="11%">类别</th>' . "\r\n" . '								<th width="30%" class="t_back">配置名称</th>' . "\r\n" . '								<th width="16%">配置值</th>' . "\r\n" . '								<th width="15%" class="t_back">备注</th>								' . "\r\n" . '								<th></th>' . "\r\n" . '							</tr>' . "\r\n" . '						</thead>' . "\r\n" . '						<tbody class="tbody_atten">' . "\r\n" . '							<!-- 这里有两个效果，一个隔行换色td_back-->' . "\r\n" . '							';

if ($sysconfs) {
	foreach ($sysconfs as $key => $value ) {
		if ($value['type'] == '1') {
			$value['type'] = '文件类型';
		}
		else if ($value['type'] == '2') {
			$value['type'] = '案件类型';
		}
		else if ($value['type'] == '3') {
			$value['type'] = '标注类型';
		}
		else if ($value['type'] == '4') {
			$value['type'] = '故障类型';
		}
		//modify
		else if ($value['type'] == '5') {
			$value['type'] = '号码类型';
		}
		else if ($value['type'] == '6') {
			$value['type'] = '警情来源';
		}
		else if ($value['type'] == '7') {
			$value['type'] = '采集设备来源';
		}
		//
		else {
			$value['type'] = '';
		}

		if (($key % 2) == 1) {
			$val = '<tr class=\'tr_p td_back\' date=\'' . $value['id'] . '\'>';
		}
		else {
			$val = '<tr class=\'tr_p\' date=\'' . $value['id'] . '\'>';
		}

		$val .= '<td>' . ($key + 1) . '</td>';
		$val .= '<td>' . $value['type'] . '</td>';
		$val .= '<td>' . $value['confname'] . '</td>';
		$val .= '<td>' . $value['confvalue'] . '</td>';
		$val .= '<td>' . $value['note'] . '</td>';
		echo $val;
	}
}
else {
	echo '<tr class=\'td_back\'><td colspan=\'8\'>暂无记录</td></tr>';
}

echo '					' . "\r\n" . '						</tbody>' . "\r\n" . '					</table>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);
echo '				' . "\r\n" . '				</div>' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 添加弹框 -->' . "\r\n" . '	<div class="layer_notice atten_add">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form action="';
echo Zhimin::buildUrl();
echo '&action=add" method="post" name="sysconf_add_form" id="sysconf_add_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_345 condition_s">' . "\r\n" . '							<span class="condition_title">类别：</span>' . "\r\n" . '							<font class="sign_d sign_star">*</font>' . "\r\n" . '							<div class="select_260 select_div">' . "\r\n" . '								<select class="easy_u" name="type" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($config_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if (Zhimin::request('type') == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">配置名称：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="confname" value="" />' . "\r\n" . '				<!-- 			<span class="error_msg">请填写配置名称</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">配置值：</span>' . "\r\n" . '						<font class="sign_d sign_star sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" class="input_error" name="confvalue" value="" />' . "\r\n" . '				<!-- 			<span class="error_msg">请填写配置值</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">备注：</span>' . "\r\n" . '						<font class="sign_d sign_star sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_days textarea_in">								' . "\r\n" . '							<textarea class="input_error" name="note"></textarea>' . "\r\n" . '					<!-- 		<span class="error_msg">请填写备注</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">' . "\r\n" . '						<font class="sign_d sign_star">&nbsp;</font>						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">	' . "\r\n" . '							<span class="sure_add" id="add_sure">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 修改弹框 -->' . "\r\n" . '	<div class="layer_notice atten_edit">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>修改<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form action="" method="post" name="sysconf_edit_form" id="sysconf_edit_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_345 condition_s">' . "\r\n" . '							<span class="condition_title">类别：</span>' . "\r\n" . '							<font class="sign_d sign_star">*</font>' . "\r\n" . '							<div class="select_260 select_div">' . "\r\n" . '								<select class="easy_u" id="edit_type" name="type" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($config_types as $k => $v ) {
	echo '<option value="' . $k . '"';
	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">配置名称：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" id="edit_confname" class="input_error" name="confname" value="" />' . "\r\n" . '				<!-- 			<span class="error_msg">请填写配置名称</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">配置值：</span>' . "\r\n" . '						<font class="sign_d sign_star sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" id="edit_confvalue" class="input_error" name="confvalue" value="" />' . "\r\n" . '				<!-- 			<span class="error_msg">请填写配置值</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">备注：</span>' . "\r\n" . '						<font class="sign_d sign_star sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_days textarea_in">								' . "\r\n" . '							<textarea class="input_error" id="edit_note" name="note"></textarea>' . "\r\n" . '					<!-- 		<span class="error_msg">请填写备注</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">' . "\r\n" . '						<font class="sign_d sign_star">&nbsp;</font>						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">	' . "\r\n" . '							<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '	                        <input type="hidden" name="id" id="edit_id" value="" />									' . "\r\n" . '							<span class="sure_add" id="edit_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除此条信息？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_one_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 编辑弹框 --><!-- 编辑弹框 取消在此页面 新建sysconfedit模板-->' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	typeval=$("").val();' . "\r\n" . '	var n=\'';
echo Zhimin::request('date_time');
echo '\';' . "\r\n" . '	if(n==\'3\'){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '	$(".easyui-combotree").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=bh&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$(".easyui-combotree").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'';
echo Zhimin::request('date_time');
echo '\']);' . "\r\n" . '	}' . "\r\n" . '});' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>工作站公告管理</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/stnotify.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
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
echo '&action=search" method="post">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<!-- <div class="condition_240 condition_s">' . "\r\n" . '							<span class="condition_title">单位：</span>' . "\r\n" . '							<div class="select_200 select_div">' . "\r\n" . '								<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>' . "\r\n" . '							</div>' . "\r\n" . '						</div> -->' . "\r\n" . '						' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">时间范围：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_se" name="date_time" style="width:100%;">' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('date_time') == '1') {
	echo ' selected';
}

echo '>本周</option>' . "\r\n" . '									<option value="2" ';

if (Zhimin::request('date_time') == '2') {
	echo ' selected';
}

echo '>本月</option>' . "\r\n" . '									<option value="3" ';

if (Zhimin::request('date_time') == '3') {
	echo ' selected';
}

echo '>一段时间</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_144 condition_s condition_t condi_time">' . "\r\n" . '							<span>至</span>' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input type="text" id="sdate" name="sdate" value="';
echo Zhimin::request('sdate');
echo '"  />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_start" onclick="laydate({elem: \'#sdate\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>							' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_130 condition_s condi_time">							' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input type="text" id="edate" name="edate" value="';
echo Zhimin::request('edate');
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#edate\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_s sub">							' . "\r\n" . '							<input type="submit" value="" />' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				</form>' . "\r\n" . '				<div class="action_div action_state">' . "\r\n" . '				' . "\r\n" . '				';

if ($user_auth['add'] == 1) {
	echo '<span class="addlevel_s add on">添加</span>';
}

if ($user_auth['check'] == 1) {
	echo '<span class="addlevel_s view_a">查看</span>';
}

if ($user_auth['del'] == 1) {
	echo '<span class="addlevel_s action_del" >删 除</span>';
}

echo '' . "\r\n" . '				</div>' . "\r\n" . '' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<table class="table_detail">' . "\r\n" . '						<thead>' . "\r\n" . '							<tr>' . "\r\n" . '								<th width="6%">序号</th>' . "\r\n" . '								<th width="11%" class="t_back">发布' . $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type'] . '编号）</th>' . "\r\n" . '				     			<th width="16%">单位</th>	' . "\r\n" . '								<th width="24%" class="t_back">公告内容</th>' . "\r\n" . '								<th width="16%">是否发布</th>' . "\r\n" . '								<th width="15%" class="t_back">发布时间</th>' . "\r\n" . '								<th width="6%">顺序</th>' . "\r\n" . '							</tr>' . "\r\n" . '						</thead>' . "\r\n" . '						<tbody class="tbody_atten">' . "\r\n" . '							<!-- 这里有两个效果，一个隔行换色td_back-->' . "\r\n" . '							';

if ($stnotifys) {
	foreach ($stnotifys as $key => $value ) {
		$stnotify_m = new StnotifyModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$stnotify = $stnotify_m->data_by_id($value['id']);
		$user_a = $user_m->get_by_name($stnotify['creater']);
		$unit_a = $unit_m->get_by_sn($user_a['dbh']);
		$unit_c = $unit_m->get_by_sn($stnotify['receiver']);
		$stnotify['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
		$stnotify['status'] = ($value['status'] == '0' ? '未发布' : '已发布');
		$stnotify['user_name'] = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$stnotify['hostcode'] = ($user_a['hostcode'] == '' ? '--' : $user_a['hostcode']);

		if (($key % 2) == 1) {
			$val = '<tr class=\'tr_p td_back\' date=\'' . $value['id'] . '\'>';
		}
		else {
			$val = '<tr class=\'tr_p\' date=\'' . $value['id'] . '\'>';
		}

		$val .= '<td>' . ($key + 1) . '</td>';
		$val .= '<td>' . $stnotify['user_name'] . '(' . $stnotify['hostcode'] . ')</td>';
		$val .= '<td>' . $stnotify['unit_name'] . '</td>';
		$val .= '<td>' . $value['content'] . '</td>';
		$val .= '<td>' . $stnotify['status'] . '</td>';
		$val .= '<td>' . $value['publishdate'] . '</td>';
		$val .= '<td>' . $value['vieworder'] . '</td>';
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
echo '&action=add" method="post" name="stnotify_add_form" id="stnotify_add_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">工作站公告&nbsp;:</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_days textarea_in">								' . "\r\n" . '							<textarea class="input_error" name="content"></textarea>' . "\r\n" . '					<!-- 		<span class="error_msg">请填写工作站公告内容</span>	 -->' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">是否发布&nbsp;:</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_radio select_in selec_text">' . "\r\n" . '							<label for="radio_yes">' . "\r\n" . '								是' . "\r\n" . '								<input type="radio" id="radio_yes" name="status" value="1" checked="checked"/>' . "\r\n" . '							</label>' . "\r\n" . '							<label for="radio_no">' . "\r\n" . '								否' . "\r\n" . '								<input type="radio" id="radio_no" name="status" value="0"/>' . "\r\n" . '							</label>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">填写顺序&nbsp;:</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in select_config">								' . "\r\n" . '							<input type="text" name="vieworder" value="1" />' . "\r\n" . '							<div class="sign">' . "\r\n" . '								<span class="plus"></span>' . "\r\n" . '								<span class="minus"></span>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<!-- <div class="condition_top con_zindex_1">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '							<div class="select_260 select_div">' . "\r\n" . '								<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>' . "\r\n" . '							</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div> -->' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">' . "\r\n" . '						<font class="sign_d sign_star">&nbsp;</font>						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '							<span class="sure_add">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除此条信息？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_one_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 查看 -->' . "\r\n" . '	<div class="layer_notice atten_view">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>查看<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body" id="notice_body">' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	/*search list tree*/' . "\r\n" . '	$("#easyui_search").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=bh&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_search").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});  /*search list tree end*/ ' . "\r\n" . '	/*add tree*/' . "\r\n" . '	$("#easyui_add").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=bh&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_add").combotree(\'setValues\', [\'\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});/*add tree end*/' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '	' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	var n=\'';
echo Zhimin::request('date_time');
echo '\';' . "\r\n" . '	if(n==\'3\'){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '	$(".easyui-combotree").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=bh&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$(".easyui-combotree").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'';
echo Zhimin::request('date_time');
echo '\']);' . "\r\n" . '	}' . "\r\n" . '});' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

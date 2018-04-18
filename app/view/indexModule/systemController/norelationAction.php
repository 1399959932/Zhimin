<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>公告管理</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/norelation.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
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
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '' . "\r\n" . '<body class="main_body">' . "\r\n" . '	';
$media_types = Zhimin::g('media_type');
echo '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
echo '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box">' . "\r\n" . '				<form id="search_form" name="search_form" method="post" action="';
echo Zhimin::buildUrl('norelation', 'system', 'index');
echo '&action=search">' . "\r\n" . '					<div class="condition_top">	' . "\r\n" . '						<div class="condition_s">' . "\r\n" . '							<!-- <span class="check_span">' . "\r\n" . '						    	<input type="checkbox" checked name="selid1" value="0000" class="ipt-hide"> ' . "\r\n" . '						        单位为空 <label class="checkbox" checked></label>' . "\r\n" . '						    </span> -->' . "\r\n" . '						    <span class="check_span">' . "\r\n" . '						    	<lable for="danwei">单位为空</lable>' . "\r\n" . '						    	<input id="danwei" type="checkbox" ';

if (Zhimin::request('selid1')) {
	echo checked;
}

echo ' name="selid1" value="0000"/>' . "\r\n" . '						    </span>' . "\r\n" . '						</div>	' . "\r\n" . '						<div class="condition_s">' . "\r\n" . '<!-- 							<span class="check_span"> -->' . "\r\n" . '<!-- 						    	<input type="checkbox" name="selid2" value="0000" class="ipt-hide" checked > -->' . "\r\n" . '<!-- 						        ' . $_SESSION['zfz_type'] . '编号为空 <label class="checkbox"></label> -->' . "\r\n" . '<!-- 						    </span> -->' . "\r\n" . '						     <span class="check_span">' . "\r\n" . '						    	<lable for="jinghao">' . $_SESSION['zfz_type'] . '编号为空</lable>' . "\r\n" . '						    	<input id="jinghao" type="checkbox" ';

if (Zhimin::request('selid2')) {
	echo checked;
}

echo ' name="selid2" value="0000"/>' . "\r\n" . '						    </span>' . "\r\n" . '						</div>									' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">拍摄日期：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_se" name="date_time" style="width:100%;">' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('date_time') == '1') {
	echo ' selected';
}

echo '>本年</option>' . "\r\n" . '									<option value="2" ';

if (Zhimin::request('date_time') == '2') {
	echo ' selected';
}

echo '>本月</option>' . "\r\n" . '									<option value="3" ';

if (Zhimin::request('date_time') == '3') {
	echo ' selected';
}

echo '>一段时间</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '							' . "\r\n" . '						</div>' . "\r\n" . '						<div id="condi_time1" class="condition_144 condition_s condition_t condi_time">' . "\r\n" . '							<span>至</span>' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input type="text" id="start" name="start_date" value="';
echo Zhimin::request('start_date');
echo '"  />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_start" onclick="laydate({elem: \'#start\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>							' . "\r\n" . '						</div>						' . "\r\n" . '						<div id="condi_time2" class="condition_130 condition_s condi_time">							' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input id="end" type="text" name="end_date" value="';
echo Zhimin::request('end_date');
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#end\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_s sub">							' . "\r\n" . '							<input type="submit" value="" id="submit">' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				</form>' . "\r\n" . '				<div class="action_div action_state">' . "\r\n" . '					';

if ($user_auth['edit_a'] == 1) {
	echo '<span class="addlevel_s edit_a">关联</span>';
}

echo '				</div>' . "\r\n" . '' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<table class="table_detail">' . "\r\n" . '						<thead>' . "\r\n" . '							<tr>' . "\r\n" . '								<th class="t_back" width="6%">序号</th>' . "\r\n" . '								<th width="11%">操作</th>' . "\r\n" . '								<th class="t_back" width="14%">发布' . $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type'] . '编号）</th>' . "\r\n" . '								<th width="19%">单位</th>' . "\r\n" . '								<th class="t_back" width="12%">记录仪编号</th>' . "\r\n" . '								<th width="24%">摄录时间（摄录时长）</th>' . "\r\n" . '								<th class="t_back" width="8%">媒体类型</th>' . "\r\n" . '								<th></th>' . "\r\n" . '							</tr>' . "\r\n" . '						</thead>' . "\r\n" . '						<tbody class="tbody_atten">' . "\r\n" . '							<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->' . "\r\n" . '							';

if (!empty($devices)) {
	foreach ($devices as $k => $v ) {
		$filetype = strtolower($v['filetype']);

		if (in_array($filetype, $media_types['video'])) {
			$filetypename = '视频';
		}
		else if (in_array($filetype, $media_types['audio'])) {
			$filetypename = '音频';
		}
		else if (in_array($filetype, $media_typies['photo'])) {
			$filetypename = '图片';
		}
		else {
			$filetypename = '其他';
		}

		if ($v['major'] != '1') {
			echo '							<tr date="';
			echo $v['id'];
			echo '" ';

			if (($k % 2) == 1) {
				echo 'class="td_back"';
			}

			echo '>' . "\r\n" . '								<td>' . "\r\n" . '									';
			echo $k + 1;
			echo '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a class="a_view" date="';
			echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $v['id']);
			echo '">查看</a>' . "\r\n" . '										</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>';
			echo $v['hostname'] . ' ( ' . $v['hostcode'] . ' )';
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['dname'];
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['hostbody'];
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['createdate'] . ' ( ' . getfiletime($v['playtime']) . ' ) ';
			echo '</td>' . "\r\n" . '								<td>';
			echo $filetypename;
			echo '</td>' . "\r\n" . '								<td></td>' . "\r\n" . '							</tr>' . "\r\n" . '							';
		}
		else {
			echo '							<tr class="td_back td_red" date="';
			echo $v['id'];
			echo '" ';

			if (($k % 2) == 1) {
				echo 'class="td_back"';
			}

			echo '>' . "\r\n" . '								<td>' . "\r\n" . '									';
			echo $k + 1;
			echo '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a class="a_view" date="';
			echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $v['id']);
			echo '">查看</a>' . "\r\n" . '										</span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>';
			echo $v['hostname'] . ' ( ' . $v['hostcode'] . ' )';
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['dname'];
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['hostbody'];
			echo '</td>' . "\r\n" . '								<td>';
			echo $v['createdate'] . ' ( ' . getfiletime($v['playtime']) . ' ) ';
			echo '</td>' . "\r\n" . '								<td>';
			echo $filetypename;
			echo '</td>' . "\r\n" . '								<td></td>' . "\r\n" . '							</tr>' . "\r\n" . '							';
		}
	}
}
else {
	echo '					' . "\r\n" . '							<!-- 没有记录时输出 -->' . "\r\n" . '							<tr class="td_back">' . "\r\n" . '								<td colspan="8">暂无记录</td>' . "\r\n" . '							</tr>	' . "\r\n" . '							';
}

echo '					' . "\r\n" . '						</tbody>' . "\r\n" . '					</table>' . "\r\n" . '				</div>' . "\r\n" . '					<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);
echo '				</div>' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 关联弹框 -->' . "\r\n" . '	<div class="layer_notice atten_add">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>关联<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '		<form name="relation_form" id="relation_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">记录仪编号：</span>' . "\r\n" . '						<div class="select_260 select_div select_no">' . "\r\n" . '						<p id="devicenum"></p>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">' . $_SESSION['zfz_type'] . '编号：</span>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="number" id="usecode" value="" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">' . $_SESSION['zfz_type'] . '姓名：</span>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="policename" id="usename" value="" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位编号：</span>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="danweinumber" id="danwei" value="" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<!-- id -->' . "\r\n" . '							<input type="hidden" name="media_id" id="mediaid" value="">' . "\r\n" . '							<input type="hidden" name="hostbody" id="hostbody" value="">' . "\r\n" . '							<span class="sure_add" id="add_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="success_flg_1">删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>	' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	var n=\'';
echo Zhimin::request('date_time');
echo '\';' . "\r\n" . '	if(n==\'3\'){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'';
echo Zhimin::request('date_time');
echo '\']);' . "\r\n" . '	}' . "\r\n" . '});' . "\r\n" . '})' . "\r\n" . '</script>';

?>

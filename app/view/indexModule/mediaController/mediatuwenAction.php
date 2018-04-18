<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>' . "\r\n" . '	<title>信息标注</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/datamgr.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/default/easyui.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/icon.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/re_easyui.css">' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	' . "\r\n" . '</head>' . "\r\n" . '';
$media_typies = Zhimin::g('media_type');
$arr_zhouqi = array('0' => '不限', '1' => '本周', '2' => '本月', '3' => '一段时间');
$arr_zhongyao = array('-1' => '不限', '0' => '否', '1' => '是');
$arr_leixing = array('0' => '不限', '1' => '视频', '2' => '音频', '3' => '图片');
$arr_biaozhu = array('-1' => '不限', '0' => '未标注', '1' => '已标注');
echo '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
echo '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box">' . "\r\n" . '				<form action="';
echo Zhimin::buildUrl();
echo '&action=search" method="post">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">单位：</span>' . "\r\n" . '							<div class="select_200 select_div">' . "\r\n" . '								<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">' . $_SESSION['zfz_type'] . '姓名：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<input type="text" name="hostname" value="';
echo Zhimin::request('hostname');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">拍摄时间：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_se" name="date_time" style="width:100%;">' . "\r\n" . '									<option value="1" ';

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

echo '>一段时间</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_144 condition_s condition_t condi_time">' . "\r\n" . '							<span>至</span>' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input type="text" id="start" name="startdate" value="';
echo Zhimin::request('startdate');
echo '"  />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_start" onclick="laydate({elem: \'#start\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>							' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_130 condition_s condi_time">							' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input id="end" type="text" name="enddate" value="';
echo Zhimin::request('enddate');
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#end\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<!--<div class="button_wrap button_wrap_n">							' . "\r\n" . '							<div class="button_list button_map" onclick="location.href=\'';
echo Zhimin::buildUrl('media', 'media', 'index');
echo '\'"></div>' . "\r\n" . '							<!-- 1是高级搜索，2是快速搜索，由js控制 -->' . "\r\n" . '							<!--<div class="button_search ';

if (Zhimin::request('search_type') == '2') {
	echo 'quick_search';
}

echo '"><input type="hidden" id="search_type" name="search_type" value="';
echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');
echo '" /></div>' . "\r\n" . '						</div>-->' . "\r\n" . '						<div class="button_wrap">		' . "\r\n" . '							<div></div>' . "\r\n" . '							<div class="button_wrap_n" >' . "\r\n" . '								<div class="button_list button_map" onclick="location.href=\'';
echo Zhimin::buildUrl('media', 'media', 'index');
echo '\'"></div>' . "\r\n" . '								<!-- 1是高级搜索，2是快速搜索，由js控制 -->' . "\r\n" . '								<div class="button_search ';

if (Zhimin::request('search_type') == '2') {
	echo 'quick_search';
}

echo '"><input type="hidden" id="search_type" name="search_type" value="';
echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');
echo '" />' . "\r\n" . '							</div>				' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="condition_top conditon_hidden">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">' . $_SESSION['zfz_type'] . '编号：</span>' . "\r\n" . '							<div class="select_200 select_div select_in">								' . "\r\n" . '								<input type="text" name="hostcode" value="';
echo Zhimin::request('hostcode');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">设备编号：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<input type="text" name="hostbody" value="';
echo Zhimin::request('hostbody');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">媒体类型：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_u" name="main_media" style="width:100%;">' . "\r\n" . '									<option value="0" ';

if (Zhimin::request('main_media') == '0') {
	echo ' selected';
}

echo '>不限</option>' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('main_media') == '1') {
	echo ' selected';
}

echo '>视频</option>' . "\r\n" . '									<option value="2" ';

if (Zhimin::request('main_media') == '2') {
	echo ' selected';
}

echo '>音频</option>' . "\r\n" . '									<option value="3" ';

if (Zhimin::request('main_media') == '3') {
	echo ' selected';
}

echo '>图片</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">文件类型：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_u" name="filetype" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($file_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if (Zhimin::request('filetype') == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>				' . "\r\n" . '						<div class="clear"></div>	' . "\r\n" . '						' . "\r\n" . '					</div>' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">关键字：</span>' . "\r\n" . '							<div class="select_200 select_div select_in">								' . "\r\n" . '								<input type="text" name="key" class="search_in" ';

if (Zhimin::request('key') != '') {
	echo 'style="color:#000" ';
}

echo ' value="';
echo Zhimin::request('key') == '' ? '文件名、号牌号码、当事人、地点' : Zhimin::request('key');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">数据标注：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<select class="easy_u" name="biaozhu" style="width:100%;">' . "\r\n" . '									<option value="-1" ';

if (Zhimin::request('biaozhu') == '1') {
	echo ' selected';
}

echo '>不限</option>' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('biaozhu') == '1') {
	echo ' selected';
}

echo '>已标注</option>' . "\r\n" . '									<option value="0" ';

if (Zhimin::request('biaozhu') == '0') {
	echo ' selected';
}

echo '>未标注</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '' . "\r\n" . '						' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">标注类型：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_u" name="biaozhutype" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($biaozhu_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if (Zhimin::request('biaozhutype') == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>	' . "\r\n" . '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">重要视频：</span>' . "\r\n" . '							<div class="select_112 select_div ">' . "\r\n" . '								<select class="easy_u" name="main_video" style="width:100%;">' . "\r\n" . '									<option value="-1" ';

if (Zhimin::request('main_video') == '-1') {
	echo ' selected';
}

echo '>不限</option>' . "\r\n" . '									<option value="0" ';

if (Zhimin::request('main_video') == '0') {
	echo ' selected';
}

echo '>否</option>' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('main_video') == '1') {
	echo ' selected';
}

echo '>是</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>								' . "\r\n" . '									' . "\r\n" . '						<div class="condition_s sub">							' . "\r\n" . '							<input type="submit" value="" />' . "\r\n" . '						</div>' . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				</form>' . "\r\n" . '				<div class="action_div type_map">' . "\r\n" . '					<span class="select_all">全选</span>' . "\r\n" . '					<span class="delete_all">批量删除</span>' . "\r\n" . '					<span class="down_all">批量下载</span>' . "\r\n" . '					<span class="span_red"></span>重要视频' . "\r\n" . '				</div>' . "\r\n" . '				<div class="table_height">	' . "\r\n" . '				';
$i = 1;

foreach ($medias as $media ) {
	$filetype = strtolower($media['filetype']);
	echo '		' . "\r\n" . '					<dl class="dl_list">' . "\r\n" . '						<dd>' . "\r\n" . '							<div class="img_box"><img src="';
	echo $media['thumburl'];
	echo '" onerror="javascript:this.onerror=null;javascript:this.src=\'';
	echo $media['thumburl_def'];
	echo '\';" width="100%"></div>' . "\r\n" . '							';

	if (in_array($filetype, $media_typies['video'])) {
		echo '							<span class="redio_type"></span>' . "\r\n" . '							';
	}
	else if (in_array($filetype, $media_typies['audio'])) {
		echo '							<span class="redio_type redio_voice"></span>' . "\r\n" . '							';
	}
	else {
		echo '							<span class="redio_type redio_pic"></span>' . "\r\n" . '							';
	}

	echo '							';

	if ($media['major'] == '1') {
		echo '							<span class="redio_main"></span>' . "\r\n" . '							';
	}

	echo '							<div class="action_group">' . "\r\n" . '								<span date="';
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $media['id']);
	echo '" class="action_view a_view"></span>' . "\r\n" . '								<a href="';
	echo Zhimin::buildUrl('', '', '', 'action=media_down&id=' . $media['id']);
	echo '" class="action_down" target="_blank"></a>' . "\r\n" . '								<span class="action_del" date="';
	echo $media['id'];
	echo '"></span>' . "\r\n" . '								<span class="check_span">' . "\r\n" . '							    	<input type="checkbox"  class="ipt-hide" value="';
	echo $media['id'];
	echo '">' . "\r\n" . '							        <label class="checkbox"></label>' . "\r\n" . '							    </span>' . "\r\n" . '							</div>' . "\r\n" . '						</dd>' . "\r\n" . '						<dt>' . "\r\n" . '							<p class="p_num">设备编号：';
	echo $media['hostbody'];
	echo '</p>' . "\r\n" . '							<p class="p_time">拍摄时间：';
	echo $media['createdate'];
	echo '</p>' . "\r\n" . '							<p class="p_police">' . $_SESSION['zfz_type'] . '：';
	echo $media['hostname'];
	echo '</p>' . "\r\n" . '							<p class="p_company">单位：';
	echo $media['dname'];
	echo '</p>' . "\r\n" . '						</dt>						' . "\r\n" . '					</dl>' . "\r\n" . '					';
	$i++;
}

echo '				</div>' . "\r\n" . '				<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 16, $page['total'], $page['page'], 4);
echo '				</div>' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定批量删除？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_btn_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '	<div class="layer_notice lay_confirm_down">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定批量下载？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_btn_down">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '' . "\r\n" . '	<div class="layer_notice lay_confirm_onedel">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除此条媒体文件？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_btn_onedel" id="sure_btn_onedel" date="">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '	<!-- 警告提示框 -->' . "\r\n" . '	<div class="layer_notice lay_add">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body2">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>请至少勾选一个选项！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>操作成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>操作失败(可能是重要视频)......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>' . "\r\n" . '' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function (){' . "\r\n" . '	var searchtype  = \'';
echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');
echo '\';' . "\r\n" . '	if(searchtype != \'1\')' . "\r\n" . '	{' . "\r\n" . '		$(".conditon_hidden").hide();' . "\r\n" . '	}' . "\r\n" . '	//此处的js主要是为了解决当时间范围为【一段时间】时，展开时间段框' . "\r\n" . '	var date_time = \'';
echo Zhimin::request('date_time');
echo '\';' . "\r\n" . '	if(date_time == 3){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '	}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '' . "\r\n" . '$(".action_div span:not(:last)").click(function(){' . "\r\n" . '		$(this).siblings().removeClass("span_on");' . "\r\n" . '		$(this).addClass("span_on");' . "\r\n" . '	});' . "\r\n" . '	$(".action_div span:not(:last)").hover(function(){' . "\r\n" . '		$(this).addClass("span_hover");' . "\r\n" . '	},function(){' . "\r\n" . '		$(this).removeClass("span_hover");' . "\r\n" . '	});' . "\r\n" . '	$("#easyui_search").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_search").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});  /*search list tree end*/ ' . "\r\n" . '	/*add tree*/' . "\r\n" . '	$("#easyui_add").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_add").combotree(\'setValues\', [\'\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});/*add tree end*/' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '' . "\r\n" . '	var n=\'';
echo Zhimin::request('date_time');
echo '\';' . "\r\n" . '	if(n==\'3\'){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '	$(".easyui-combotree").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$(".easyui-combotree").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n" . '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'';
echo Zhimin::request('date_time');
echo '\']);' . "\r\n" . '	}' . "\r\n" . '	});' . "\r\n" . '})' . "\r\n" . '</script>';

?>

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
echo 'style/global.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/default/easyui.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'js/themes/icon.css">' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/re_easyui.css">' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '<style>' . "\r\n" . '#layui-layer-iframe1{position:relative;}' . "\r\n" . '</style>	' . "\r\n" . '</head>' . "\r\n" . '';
$media_typies = Zhimin::g('media_type');
$arr_zhouqi = array('0' => '不限', '1' => '本周', '2' => '本月', '3' => '一段时间');
$arr_zhongyao = array('-1' => '不限', '0' => '否', '1' => '是');
$arr_leixing = array('0' => '不限', '1' => '视频', '2' => '音频', '3' => '图片');
$arr_biaozhu = array('-1' => '不限', '0' => '未标注', '1' => '已标注');
echo '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		<!-- <div class="tab_button">' . "\r\n" . '			信息标注' . "\r\n" . '		</div> -->' . "\r\n" . '		';
include_once ('menu.php');
echo '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box">' . "\r\n" . '				<form action="';
echo Zhimin::buildUrl();
echo '&action=search" method="post">' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title a_view">单位：</span>' . "\r\n" . '							<div class="select_200 select_div">' . "\r\n" . '								<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">' . $_SESSION['zfz_type'] . '姓名：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<input type="text" name="hostname" value="';
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
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#end\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>'  . "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="condition_top conditon_hidden">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">' . $_SESSION['zfz_type'] . '编号：</span>' . "\r\n" . '							<div class="select_200 select_div select_in">								' . "\r\n" . '								<input type="text" name="hostcode" value="';
echo Zhimin::request('hostcode');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">设备编号：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<input type="text" name="hostbody" value="';
echo Zhimin::request('hostbody');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						' . "\r\n";

/*上传时间*/
echo '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">上传时间：</span>' . "\r\n" . '							<div class="select_112 select_div">' . "\r\n" . '								<select class="easy_u" name="update_date_time" id="update_date_time" style="width:100%;">' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('update_date_time') == '1') {
	echo ' selected';
}

echo '>本周</option>' . "\r\n" . '									<option value="2" ';

if (Zhimin::request('update_date_time') == '2') {
	echo ' selected';
}

echo '>本月</option>' . "\r\n" . '									<option value="3" ';

if (Zhimin::request('update_date_time') == '3') {
	echo ' selected';
}

echo '>一段时间</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_144 condition_s condition_t update_condi_time">' . "\r\n" . '							<span>至</span>' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input type="text" id="update_start" name="update_startdate" value="';
echo Zhimin::request('update_startdate');
echo '"  />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_start" onclick="laydate({elem: \'#update_start\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>							' . "\r\n" . '						</div>						' . "\r\n" . '						<div class="condition_130 condition_s update_condi_time">							' . "\r\n" . '							<div class="select_130 select_div">' . "\r\n" . '								<div class="select_105 sele_c select_in">' . "\r\n" . '									<input id="update_end" type="text" name="update_enddate" value="';
echo Zhimin::request('update_enddate');
echo '" />' . "\r\n" . '								</div>' . "\r\n" . '								<div class="select_time condition_end" onclick="laydate({elem: \'#update_end\',format: \'YYYY-MM-DD\'});"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '							';


/**/

echo '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="condition_top">' . "\r\n" . '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">关键字：</span>' . "\r\n" . '							<div class="select_200 select_div select_in">								' . "\r\n" . '								<input id="guanjianzi" type="text" name="key" class="search_in" ';

if (Zhimin::request('key') != '') {
	echo 'style="color:#000" ';
}

echo ' value="';
echo Zhimin::request('key') == '' ? '文件名称、文件描述' : Zhimin::request('key');
echo '" />' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">数据标注：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<select class="easy_u" name="biaozhu" style="width:100%;">' . "\r\n" . '									<option value="-1" ';

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

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>	' . "\r\n";

/**/
echo '							<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">媒体质量：</span>' . "\r\n" . '						<div class="select_100 select_div select_in">' . "\r\n" . '								<select class="easy_u" name="biaozhu" style="width:100%;">' . "\r\n" . '									<option value="-1" ';


if (Zhimin::request('biaozhu') == '1') {
	echo ' selected';
}

echo '>不限</option>' . "\r\n" . '									<option value="0" ';

if (Zhimin::request('biaozhu') == '0') {
	echo ' selected';
}

echo '>标清</option>' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('biaozhu') == '1') {
	echo ' selected';
}

echo '>高清</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n";

/**/
echo '<div class="clear"></div></div>		<div class="condition_top">' . "\r\n";
echo '						<div class="condition_250 condition_s">' . "\r\n" . '							<span class="condition_title">媒体类型：</span>' . "\r\n" . '							<div class="select_200 select_div">' . "\r\n" . '								<select class="easy_u" name="main_media" style="width:100%;">' . "\r\n" . '									<option value="0" ';

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

echo '>图片</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						' . "\r\n" . '						' . "\r\n" . '						<div class="condition_165 condition_s">' . "\r\n" . '							<span class="condition_title">文件类型：</span>' . "\r\n" . '							<div class="select_100 select_div select_in">' . "\r\n" . '								<select class="easy_u" name="filetype" style="width:100%;">' . "\r\n" . '								<option value="">不限</option>' . "\r\n" . '								';

foreach ($file_types as $k => $v ) {
	echo '<option value="' . $k . '"';

	if (Zhimin::request('filetype') == $k) {
		echo ' selected';
	}

	echo '>' . $v . '</option>';
}

echo '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>				' . "\r\n";
echo '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">重要视频：</span>' . "\r\n" . '							<div class="select_112 select_div ">' . "\r\n" . '								<select class="easy_u" name="main_video" style="width:100%;">' . "\r\n" . '									<option value="-1" ';

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

echo '>是</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n";
echo '						';
/*标注位置start*/
echo '						<div class="condition_175 condition_s">' . "\r\n" . '							<span class="condition_title">标注位置：</span>' . "\r\n" . '							<div class="select_112 select_div ">' . "\r\n" . '								<select class="easy_u" name="biaozhu_location" style="width:100%;">' . "\r\n" . '									<option value="-1" ';
if (Zhimin::request('biaozhu_location') == '-1') {
	echo ' selected';
}

echo '>不限</option>' . "\r\n" . '									<option value="0" ';

if (Zhimin::request('biaozhu_location') == '0') {
	echo ' selected';
}

echo '>未标注</option>' . "\r\n" . '									<option value="1" ';

if (Zhimin::request('biaozhu_location') == '1') {
	echo ' selected';
}

echo '>执法仪标注</option>' . "\r\n" . '									<option value="2" ';

if (Zhimin::request('biaozhu_location') == '2') {
	echo ' selected';
}

echo '>后台标注</option>' . "\r\n" . '								</select>' . "\r\n" . '							</div>' . "\r\n" . '						</div>						' . "\r\n";
echo '						';
/*标注位置end*/
echo '						<div class="condition_s sub">							' . "\r\n" . '							<input type="submit" value="" />' . "\r\n" . '						</div>' . "\r\n" . 
'						<div class="button_wrap" style="width:270px; background:#0f0;">		' . "\r\n" . '							<div></div>' . "\r\n" . '							<div class="button_wrap_n" >' . "\r\n" . '								<div class="button_list" onclick="location.href=\'';
echo Zhimin::buildUrl('mediatuwen', 'media', 'index');
echo '\'"></div>' . "\r\n" . '								<!-- 1是高级搜索，2是快速搜索，由js控制 -->' . "\r\n" . '								<div class="button_search ';

if (Zhimin::request('search_type') == '2') {
	echo 'quick_search';
}

echo '"><input type="hidden" id="search_type" name="search_type" value="';
echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');
echo '" />' . "\r\n" . '							</div>				' . "\r\n" . '							</div>' . "\r\n" . '						</div>'
. "\r\n" . '						<div class="clear"></div>' . "\r\n" . '					</div>' . "\r\n" . '				</form>' . "\r\n" . '				<div class="action_div">' . "\r\n" . '					<span class="select_all">全 选</span>' . "\r\n" . '					<span class="delete_all">批量删除</span>' . "\r\n" . '					<span class="down_all">批量下载</span><!--<span class="upload_file" date="./?_a=uploadfile&_c=media&_m=index">上传文件</span><img src="/images/uploadfile.jpg" border="0" id="uploadfile" date="./?_a=uploadfile&_c=media&_m=index" align="absmiddle" style="cursor:pointer" />-->' . "\r\n" . '					<span class="span_red"></span>重要视频' . "\r\n" . '				</div>' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<table class="table_detail" style="width:110%;">' . "\r\n" . '						<thead>' . "\r\n" . '							<tr>' . "\r\n" . '								<th class="t_back">序号</th>' . "\r\n" . '								<th >操作</th>' . "\r\n" . '							<th class="t_back">文件名</th><th>文件描述</th>' . "\r\n" . '								<th class="t_back">发布' . $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type'] . '编号）</th>' . "\r\n" . '								<th>单位</th>' . "\r\n" . '								<th class="t_back">摄录时间（摄录时长）</th>' . "\r\n" . '								<th>记录仪编号</th>' . "\r\n" . '								<th class="t_back">媒体类型</th>' . "\r\n" . '								<th>标注位置</th>'. "\r\n" . '								<th class="t_back">标注情况</th>' . "\r\n" . '							</tr>' . "\r\n" . '						</thead>' . "\r\n" . '						<tbody>' . "\r\n" . "\r\n" . '						';
$i = 1;

foreach ($medias as $media ) {
	$filetype = strtolower($media['filetype']);

	if (in_array($filetype, $media_typies['video'])) {
		$filetypename = '视频';
	}
	else if (in_array($filetype, $media_typies['audio'])) {
		$filetypename = '音频';
	}
	else if (in_array($filetype, $media_typies['photo'])) {
		$filetypename = '图片';
	}
	else {
		$filetypename = '其他';
	}

	echo '							';

	if (($i % 2) == 0) {
		echo '								';

		if ($media['major'] != '1') {
			echo '								<tr>' . "\r\n" . '								';
		}
		else {
			echo '								<tr class="td_red">' . "\r\n" . '								';
		}

		echo '							';
	}
	else {
		echo '								';

		if ($media['major'] != '1') {
			echo '								<tr class="td_back">' . "\r\n" . '								';
		}
		else {
			echo '								<tr class="td_back td_red">' . "\r\n" . '								';
		}

		echo '							';
	}

	echo '								<td>' . "\r\n" . '									<span class="check_span">' . "\r\n" . '								    	<input type="checkbox"  class="ipt-hide"  value="';
	echo $media['id'];
	echo '">' . "\r\n" . '								        <label class="checkbox"></label>';
	echo $i;
	echo '								    </span>' . "\r\n" . '								</td>' . "\r\n" . '								<td>' . "\r\n" . '									<span class="action_span">' . "\r\n" . '										<a class="a_view" date="';
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $media['id'].'&sql='.$sql);
	echo '" style="cursor:pointer;color:blue">查看</a>' . "\r\n" .'									' . "\r\n" .'<a class="a_down" href="';
	echo Zhimin::buildUrl('', '', '', 'action=media_down&id=' . $media['id']);
	echo '" target="_blank" style="cursor:pointer;color:blue">下载</a>' . "\r\n" . '										';
	//echo '<a class="a_file" href="#" date="' . $media['filename'] . '.' . $media['filetype'] . '" style="cursor:pointer;color:blue">文件</a>';
	echo '</span>' . "\r\n" . '								</td>' . "\r\n" . '								';
	echo '<td><span alt="' . $media['bfilename'] . '" title="' . $media['bfilename'] . '">' . cut_str($media['bfilename'], 22) . '</span></td>';
	echo '<td>';
	if ($media['note'] != ''){
		echo '<div class="data_note">' . cut_str($media['note'], 32) . '</div>';
	}
	else{
		echo '无';
	}
	echo '</td>' . "\r\n";
	echo '<td>' . $media['hostname'] . ' ( ' . $media['hostcode'] . ' )';
	echo '</td>' . "\r\n" . '								<td>';
	echo $media['dname'];
	echo '</td>' . "\r\n" . '								<td>';
	//modify
	//echo $media['createdate'] . ' ( ' . getfiletime($media['playtime']) . ' ) ';
	echo $media['createdate'] . ' ( ' .  MediaAction::changeTimeType($media['playtime']) . ' ) ';
	echo '</td>' . "\r\n" . '								<td>';
	echo $media['hostbody'];
	echo '</td>' . "\r\n" . '								<td>';
	echo $filetypename;
	echo '</td>' . "\r\n" . '								<td>';
	echo $media['biaozhu_location'] == '0' ? '未标注' : ($media['biaozhu_location'] == '1' ? '执法仪标注' : '后台标注');
	echo '</td>' . "\r\n" . '								<td>';
	echo $media['is_flg'] == '1' ? '已标注' : '未标注';
	echo '</td>' . "\r\n" . '							</tr>' . "\r\n" . '							' . "\r\n" . '							';
	$i++;
}

echo '							' . "\r\n" . '						</tbody>' . "\r\n" . '					</table>' . "\r\n" . '				</div>	' . "\r\n" . '				<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 16, $page['total'], $page['page'], 4);
echo '				</div>' . "\r\n" . '				' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '				' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定批量删除？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_btn_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '	<div class="layer_notice lay_confirm_down">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定批量下载？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_btn_down">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '	<!-- 警告提示框 -->' . "\r\n" . '	<div class="layer_notice lay_add">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>请至少勾选一个选项！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>操作成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>操作失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>' . "\r\n" . '' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function (){' . "\r\n" . '	var searchtype  = \'';
echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');
echo '\';' . "\r\n" . '	if(searchtype != \'1\')' . "\r\n" . '	{' . "\r\n" . '		$(".conditon_hidden").hide();' . "\r\n" . '	}' . "\r\n" . '	//此处的js主要是为了解决当时间范围为【一段时间】时，展开时间段框' . "\r\n";
echo '	var date_time = \'' . Zhimin::request('date_time') . '\';' . "\r\n";
echo '	if(date_time == 3){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '	}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '' . "\r\n";
echo '	var update_date_time = \'' . Zhimin::request('update_date_time') . '\';' . "\r\n";
echo '	if(update_date_time == 3){' . "\r\n" . '		$(".update_condi_time").show();' . "\r\n" . '	}else{' . "\r\n" . '		$(".update_condi_time").hide();' . "\r\n" . '	}' . "\r\n" . '' . "\r\n";

echo '	$(".action_div span:not(:last)").click(function(){' . "\r\n" . '		$(this).siblings().removeClass("span_on");' . "\r\n" . '		$(this).addClass("span_on");' . "\r\n" . '	});' . "\r\n" . '	$(".action_div span:not(:last)").hover(function(){' . "\r\n" . '		$(this).addClass("span_hover");' . "\r\n" . '	},function(){' . "\r\n" . '		$(this).removeClass("span_hover");' . "\r\n" . '	});' . "\r\n" . '' . "\r\n" . '	$("#easyui_search").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_search").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});  /*search list tree end*/ ' . "\r\n" . '	/*add tree*/' . "\r\n" . '	$("#easyui_add").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_add").combotree(\'setValues\', [\'\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});/*add tree end*/' . "\r\n" . '' . "\r\n";
echo '	var n=\'' . Zhimin::request('date_time') . '\';' . "\r\n";
echo '	if(n==\'3\'){' . "\r\n" . '		$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".condi_time").hide();' . "\r\n" . '	}' . "\r\n";

echo '	var m=\'' . Zhimin::request('update_date_time') . '\';' . "\r\n";
echo '	if(m==\'3\'){' . "\r\n" . '		$(".update_condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '		$(".update_condi_time").hide();' . "\r\n" . '	}' . "\r\n";

echo '	$(".easyui-combotree").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=unitsyscode&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$(".easyui-combotree").combotree(\'setValues\', [\'';
echo Zhimin::request('danwei');
echo '\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});' . "\r\n" . '	$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});' . "\r\n";
echo '	$(\'.easy_se\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (n,o) {' . "\r\n" . '		if(n==\'3\'){' . "\r\n" . '			$(".condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'.easy_se\').combobox(\'setValue\',[\'' . Zhimin::request('date_time') . '\']);' . "\r\n" . '	}' . "\r\n" . '	});' . "\r\n\r\n";

echo '	$(\'#update_date_time\').combobox({panelHeight:\'80px\',selectOnNavigation:true,editable:false,labelPosition:\'top\',' . "\r\n" . '	onChange: function (m,o) {' . "\r\n" . '		if(m==\'3\'){' . "\r\n" . '			$(".update_condi_time").show();' . "\r\n" . '		}else{' . "\r\n" . '			$(".update_condi_time").hide();' . "\r\n" . '		}' . "\r\n" . '	},' . "\r\n" . '	onLoadSuccess:function(data){ ' . "\r\n" . '		$(\'#update_date_time\').combobox(\'setValue\',[\'' . Zhimin::request('update_date_time') . '\']);' . "\r\n" . '	}' . "\r\n" . '	});' . "\r\n";


echo '	' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '';

?>

<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>详情页</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/chart.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/echarts.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/line.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/line_zhou.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '<body>' . "\r\n" . '	<div class="layer_iframe layer_iframe_r">' . "\r\n" . '		<div class="iframe_top"><span style="display: inline-block;width:15px;"></span>监督考评：';
echo $unitname;
echo '  ';

if ($type == '1') {
	echo '摄录时长 ';
}
else if ($type == '2') {
	echo '摄录时长低于90%';
}
else {
	echo '上传时间晚于24小时';
}

echo '考评  ';
echo Zhimin::request('st') . '-' . Zhimin::request('ed');
echo ' <span class="close close_btn"><img alt="" src="./images/close.png"></span></div>' . "\r\n" . '		<div class="iframe_body">' . "\r\n" . '			<div class="iframe_map">' . "\r\n" . '				<ul class="tab_ul">' . "\r\n" . '					<li class="active">详细信息</li>' . "\r\n" . '					<li class="li_after li_1" id="li_after_zhou" value="';
echo $unitcode;
echo '">周同比图</li>' . "\r\n" . '					<li class="li_after li_2" id="li_after_yue" value="';
echo $unitcode;
echo '">月同比图</li>' . "\r\n" . '					<li class="li_after li_3" id="li_after_nian" value="';
echo $unitcode;
echo '">年同比图</li>' . "\r\n" . '					<li class="li_after li_4" id="li_after_qushi" value="';
echo $type;
echo '">趋势图</li>' . "\r\n" . '				</ul>' . "\r\n" . '				<div class="map_iframe_top"></div>' . "\r\n" . '				<div class="map_iframe_body">' . "\r\n" . '					<div class="tab_wrap" style="display: block;">					' . "\r\n" . '						<div class="table_height">			' . "\r\n" . '							<table class="table_detail">' . "\r\n" . '								<thead>' . "\r\n" . '									<tr>' . "\r\n" . '										<th class="t_back" width="6%">序号</th>' . "\r\n" . '										<th width="13%">所属部门</th>' . "\r\n" . '										<th class="t_back" width="9%">' . $_SESSION['zfz_type'] . '姓名</th>' . "\r\n" . '										<th width="10%">' . $_SESSION['zfz_type'] . '编号</th>' . "\r\n" . '										<th class="t_back" width="20%">日期</th>' . "\r\n" . '										';

if ($type == '3') {
	echo '											<th width="20%">文件总数</th>' . "\r\n" . '											<th class="t_back" width="11%">晚上传数</th>' . "\r\n" . '											<th>比例(%)</th>' . "\r\n" . '										';
}
else {
	echo '											<th width="20%">出勤时间(分钟)</th>' . "\r\n" . '											<th class="t_back" width="11%">视频时长(分钟)</th>' . "\r\n" . '											<th>出勤比例(%)</th>' . "\r\n" . '										';
}

echo '									</tr>' . "\r\n" . '								</thead>' . "\r\n" . '								<tbody>' . "\r\n" . '								' . "\r\n" . '									';
$i = 0;

foreach ($datas as $k => $data ) {
	if (($i % 2) == '0') {
		echo '										<tr>' . "\r\n" . '									';
	}
	else {
		echo '										<tr class="td_back">' . "\r\n" . '									';
	}

	echo '										<td>';
	echo $i + 1;
	echo '</td>' . "\r\n" . '										<td>';
	echo $data['dname'];
	echo '</td>' . "\r\n" . '										<td>';
	echo $host_temp[$data['hostcode']];
	echo '</td>' . "\r\n" . '										<td>';
	echo $data['hostcode'];
	echo '</td>' . "\r\n" . '										<td>';
	echo $data['statdate'];
	echo '</td>' . "\r\n" . '										';

	if ($type == '3') {
		echo '											<td>';
		echo $data['val1'];
		echo '</td>' . "\r\n" . '											<td>';
		echo $data['val2'];
		echo '</td>' . "\r\n" . '											<td>';
		echo round(($data['val2'] / $data['val1']) * 100, 2);
		echo '</td>' . "\r\n" . '										';
	}
	else {
		echo '											<td>';
		echo $onworktime;
		echo '</td>' . "\r\n" . '											<td>';
		echo round($data['val2'] / 60);
		echo '</td>' . "\r\n" . '											<td>';
		echo round((round($data['val2'] / 60) / $onworktime) * 100, 2);
		echo '</td>' . "\r\n" . '										';
	}

	echo '									';
	$i++;
}

echo '									<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->' . "\r\n" . '									';

if (empty($datas)) {
	echo '									<!-- 没有记录时输出 -->' . "\r\n" . '									<tr class="td_back">' . "\r\n" . '										<td colspan="8">暂无记录</td>' . "\r\n" . '									</tr>' . "\r\n" . '									';
}

echo '						' . "\r\n" . '								</tbody>' . "\r\n" . '							</table>' . "\r\n" . '						</div>' . "\r\n" . '				<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 16, $page['total'], $page['page'], 4);
echo '				</div>' . "\r\n" . '				' . "\r\n" . '					</div>' . "\r\n" . '					<div class="tab_wrap" style="display:none;">' . "\r\n" . '						<div class="map_left">	' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">周同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>上周 <span class="span_last"></span></p>' . "\r\n" . '									<p>本周 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas1" style="height:300px;width:355px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="map_right">' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">趋势周同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>上周 <span class="span_last"></span></p>' . "\r\n" . '									<p>本周 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas2" style="height:300px;width:420px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="tab_wrap" style="display:none;">' . "\r\n" . '						<div class="map_left">	' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">月同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>上月 <span class="span_last"></span></p>' . "\r\n" . '									<p>本月 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas3" style="height:320px;width:355px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="map_right1">' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">本月趋势同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>上月 <span class="span_last"></span></p>' . "\r\n" . '									<p>本月 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas4" style="height:300px;width:440px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="tab_wrap" style="display:none;">' . "\r\n" . '						<div class="map_left">	' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">年同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>去年 <span class="span_last"></span></p>' . "\r\n" . '									<p>今年 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas5" style="height:300px;width:355px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="map_right">' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">本年趋势同比图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '								<div class="map_top_r">' . "\r\n" . '									<p>去年 <span class="span_last"></span></p>' . "\r\n" . '									<p>今年 <span class="span_now"></span></p>' . "\r\n" . '								</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas6" style="height:300px;width:420px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="tab_wrap" style="display:none;">' . "\r\n" . '						<div class="map_year">' . "\r\n" . '							<div class="map_top">' . "\r\n" . '								<div class="map_top_l">趋势图（单位：';

if ($type == '1') {
	echo '小时';
}
else if ($type == '2') {
	echo '天';
}
else {
	echo '个';
}

echo '）</div>' . "\r\n" . '							</div>' . "\r\n" . '							<div class="map_box">' . "\r\n" . '								<div id="canvas7" style="height:360px;width:850px;"></div>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>				' . "\r\n" . '				</div>' . "\r\n" . '				<div class="map_iframe_foot"></div>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="iframe_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 警告提示框 -->' . "\r\n" . '	<div class="layer_notice lay_add">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>标注信息不能为空......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '' . "\r\n" . '</html>';

?>

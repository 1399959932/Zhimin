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
echo 'style/global.css" />' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '	<style>' . "\r\n" . '	.letter_top .close{ position:absolute; right:35px;top:15px;}' . "\r\n" . '	.atten_top .close {' . "\r\n" . '    line-height: normal;' . "\r\n" . '    right: 15px;' . "\r\n" . '}' . "\r\n" . '	</style>' . "\r\n" . '	<![endif]-->' . "\r\n" . '' . "\r\n" . '<body style="width:760px;">' . "\r\n" . '	<div class="layer_iframe">' . "\r\n" . '		<div class="iframe_top letter_top"><span class="letter_t">站內短信</span><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body letter_body">' . "\r\n" . '			<div class="letter_wrap">' . "\r\n" . '				<div class="letter_button">' . "\r\n" . '					<a href="';
echo Zhimin::buildUrl('messageadd', 'other');
echo '">写信息</a>' . "\r\n" . '					<span>未读</span>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="table_height letter_table">			' . "\r\n" . '					<table class="table_detail">' . "\r\n" . '						<thead>' . "\r\n" . '							<tr>' . "\r\n" . '								<th class="t_back" width="115">发信人</th>' . "\r\n" . '								<th width="255">标题</th>' . "\r\n" . '								<th class="t_back" width="200">发信时间</th>' . "\r\n" . '								<th>操作</th>							' . "\r\n" . '							</tr>' . "\r\n" . '						</thead>' . "\r\n" . '						<tbody class="tbody_atten">' . "\r\n" . '							<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->' . "\r\n" . '							' . "\r\n" . '								';

foreach ($messages as $k => $v ) {
	if ($v['is_new'] == 1) {
		echo '								<tr class="td_back td_red">' . "\r\n" . '								<td>' . "\r\n" . '									';
		echo $v['username'];
		echo '								</td>' . "\r\n" . '								<td><a href="';
		echo Zhimin::buildUrl('messageview', 'other', 'index', 'msgid=' . $v['msgid']);
		echo '">';
		echo $v['title'];
		echo '</a></td>' . "\r\n" . '								<td>';
		echo date('Y.m.d', $v['in_time']);
		echo '</td>' . "\r\n" . '								<td><a class="letter_a" href="javascript:void(0)" date="';
		echo $v['msgid'];
		echo '"></a></td>' . "\r\n" . '								</tr>' . "\r\n" . '								';
	}
	else {
		echo '	' . "\r\n" . '								<tr>						' . "\r\n" . '								<td>' . "\r\n" . '									';
		echo $v['username'];
		echo '								</td>' . "\r\n" . '								<td><a href="';
		echo Zhimin::buildUrl('messageview', 'other', 'index', 'msgid=' . $v['msgid']);
		echo '">';
		echo $v['title'];
		echo '</a></td>' . "\r\n" . '								<td>';
		echo date('Y.m.d', $v['in_time']);
		echo '</td>' . "\r\n" . '								<td><a class="letter_replay" href="';
		echo Zhimin::buildUrl('messageadd', 'other', 'index', 'msgid=' . $v['msgid']);
		echo '&action=sendmsg"></a>&nbsp;&nbsp; <a class="letter_a" href="javascript:void(0)" date="';
		echo $v['msgid'];
		echo '"></a></td>' . "\r\n" . '								</tr>' . "\r\n" . '							';
	}
}

echo '							<!-- 没有记录时输出 -->' . "\r\n" . '							';

if (empty($messages)) {
	echo '							<tr class="td_back">' . "\r\n" . '								<td colspan="4">暂无记录</td>' . "\r\n" . '							</tr>' . "\r\n" . '							';
}

echo '						' . "\r\n" . '						</tbody>' . "\r\n" . '					</table>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '					<div class="page_link">' . "\r\n" . '					';
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);
echo '				</div>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="iframe_foot letter_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除本条站内信？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span letter_sure">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

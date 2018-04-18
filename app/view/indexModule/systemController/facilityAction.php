<?php
// var_dump($_SESSION['zfz_type']);
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
echo 'js/configAction.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	' . "\r\n" . '</head>' . "\r\n" . '' . "\r\n" . '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
echo '	' . "\r\n" . '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="table_box surpervision">' . "\r\n" . '				<form id="myform" action="';
echo Zhimin::buildUrl('facility', 'system');
echo '" method="post" enctype="multipart/form-data">' . "\r\n" . '				<table class="sys_base">' . "\r\n" . '				' . "\r\n" . '				';
//设备设置填写start
		echo '<tr>' . "\r\n" . '';
			echo '				            <td class="sys_black01" width="14%" name="';
			echo 'facility';
			echo '">';
			echo '设备数量上限';
			echo '</td>' . "\r\n" . '				            ';	
		echo '<td>' . "\r\n" . '';
			echo '<input type="text" id="';
			echo 'facility';
			echo '" value="';
			echo $val[0]['db_value'];
			echo '" name="';
			echo 'facility';
			echo '"/>' . "\r\n" . '';
		echo '</td>' . "\r\n" . '</tr>' . "\r\n" . '';
//设备设置填写end

echo '	' . "\r\n" . '					<tr>' . "\r\n" . '						<td class="sys_black01" width="14%"></td>' . "\r\n" . '						<td>														' . "\r\n" . '							<div class="condition_top" style="*width:269px;">' . "\r\n" . '								<div class="condition_260 condition_s ">						' . "\r\n" . '									<div class="select_260 select_div select_in selec_text">								' . "\r\n" . '										<input type="submit" class="sure_add form_sub" id="form_submit" value="确 定">' . "\r\n" . '										<input type="hidden" name="submit_config" value="config">' . "\r\n" . '										<input type="reset" class="sure_cancle close_btn form_reset" value="取 消">' . "\r\n" . '									</div>' . "\r\n" . '								</div>' . "\r\n" . '								<div class="clear"></div>' . "\r\n" . '							</div>			' . "\r\n" . '						</td>' . "\r\n" . '					</tr>' . "\r\n" . '				</table>' . "\r\n" . '				</form>' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	' . "\r\n" . '' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '' . "\r\n" . '' . "\r\n" . '</html>' . "\r\n" . '' . "\r\n" . '';

?>

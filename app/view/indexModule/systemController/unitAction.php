<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>部门管理</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/unit.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
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
echo 'js/jquery.easyui.min.js"></script>' . "\r\n" . '	<style>		' . "\r\n" . '		.condition_c > span {' . "\r\n" . '		    width: 78px;' . "\r\n" . '		}' . "\r\n" . '		.select_180{width: 259px;}' . "\r\n" . '		.ul_show .li_child ul{display: block;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
echo '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box surpervision">' . "\r\n" . '				<div class="action_div action_state">' . "\r\n" . '					<span class="addlevel_s add on">添 加</span>' . "\r\n" . '					<!-- <span class="addlevel_s edit_a">修 改</span>' . "\r\n" . '					<span class="addlevel_s action_del">删除</span> -->' . "\r\n" . '				</div>' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<div class="div_band">' . "\r\n" . '						<!-- 上层展开、关闭按钮 -->' . "\r\n" . '						<div class="ul_button">' . "\r\n" . '							<span class="ul_open"></span>' . "\r\n" . '							<span class="ul_close"></span>' . "\r\n" . '							<div class="clear"></div>' . "\r\n" . '							<span class="part_title"><img src="./images/part_title_bg.png" width="70" alt="" /></span>' . "\r\n" . '						</div><!-- 上层展开、关闭按钮 结束 -->' . "\r\n" . '						<ul class="ul_band ul_show" style="width:700px;">' . "\r\n" . '							';
$optionsStr = '';
HTMLUtils::options_stair_unitpage($optionsStr, $datas, 'bh', 'name', 'child');
echo $optionsStr;
echo '						</ul>' . "\r\n" . '					</div>' . "\r\n" . '				</div>' . "\r\n" . '				' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 添加弹框 -->' . "\r\n" . '	<div class="layer_notice atten_add">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form action="';
echo Zhimin::buildUrl();
echo '&action=add" method="post" name="unit_add_form" id="unit_add_form"> ' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位编号：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" name="bh" class="input_error" value="" />' . "\r\n" . '							<span class="error_msg">请填写单位编号</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位名称：</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in">								' . "\r\n" . '							<input type="text" name="zuming" class="input_error" value="" />' . "\r\n" . '							<span class="error_msg">请填写单位名称</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">上级单位：</span>' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '						<div class="select_260 select_div">' . "\r\n" . '							<input class="easyui-combotree" name="xsbh" data-options="" style="width:100%;" id="easyui_add"/>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top sys_con">' . "\r\n" . '					<div class="condition_345 condition_s condition_c">' . "\r\n" . '						<span class="condition_title">排序：</span>' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '						<div class="select_180 select_div select_in select_config">								' . "\r\n" . '							<input type="text" name="orderby" value="1" />' . "\r\n" . '							<div class="sign">' . "\r\n" . '								<span class="plus"></span>' . "\r\n" . '								<span class="minus"></span>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">备注：</span>' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '						<!-- <div class="select_260 select_div select_days textarea_in">								' . "\r\n" . '							<textarea name="beizhu"></textarea>' . "\r\n" . '						</div> -->' . "\r\n" . '						<textarea name="beizhu" style="width:250px;height:76px; float:right; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;"></textarea>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<span class="sure_add" id="add_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 修改弹框 -->' . "\r\n" . '	<div class="layer_notice atten_edit">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>编辑<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form  method="post" name="unit_edit_form" id="unit_edit_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">单位编号：</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in selec_text">								' . "\r\n" . '							 <p id="edit_bh"></p>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">上级单位：</span>' . "\r\n" . '						<font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_relative select_in selec_text">								' . "\r\n" . '							<p id="edit_parent"></p>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">单位名称：</span>' . "\r\n" . '                        <font class="sign_d sign_star">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_relative select_in">' . "\r\n" . '                            <input type="text" name="zuming" id="edit_dname" class="input_error1" value="" />' . "\r\n" . '                            <span class="error_msg">请填写单位名称</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '				<div class="condition_top sys_con">' . "\r\n" . '					<div class="condition_345 condition_s condition_c">' . "\r\n" . '						<span class="condition_title">排序：</span>' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '						<div class="select_180 select_div select_in select_config">								' . "\r\n" . '							<input type="text" name="orderby" id="edit_orderby" value="" />' . "\r\n" . '							<div class="sign">' . "\r\n" . '								<span class="plus"></span>' . "\r\n" . '								<span class="minus"></span>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_346 condition_s condition_textarea condition_height">' . "\r\n" . '						<span class="condition_title">备注：</span>' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '						<div class="select_260 select_div select_days textarea_in">								' . "\r\n" . '							<textarea name="beizhu" id="edit_beizhu"></textarea>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">' . "\r\n" . '						<font class="sign_d sign_star" style="color:#fff;">*</font>						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '                        	<input type="hidden" name="id" id="edit_id" value="" />' . "\r\n" . '							<span class="sure_add" id="edit_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除此条记录？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<input type="hidden" id="confirm_del_bh" value="" />' . "\r\n" . '				<span class="sure_span sure_one_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div> ' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '$(document).ready(function(){' . "\r\n" . '	/*add tree*/' . "\r\n" . '	$("#easyui_add").combotree({url:\'';
echo Zhimin::buildUrl('unitjson', 'other') . '&id=id&text=dname';
echo '\',method:\'get\',labelPosition:\'top\',panelWidth:\'500px\',' . "\r\n" . '	// 设置选中项' . "\r\n" . '	onLoadSuccess:function(node,data){' . "\r\n" . '		$("#easyui_add").combotree(\'setValues\', [\'\']);  ' . "\r\n" . '    }  ' . "\r\n" . '	});/*add tree end*/' . "\r\n" . '	/*add tree*/' . "\r\n" . '})' . "\r\n" . '</script>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

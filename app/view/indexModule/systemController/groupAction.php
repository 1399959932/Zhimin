<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>角色管理</title>	' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/group.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	<style>' . "\r\n" . '		.check_span{float: left;display: block;}' . "\r\n" . '		.li_child ul{clear:both;}' . "\r\n" . '		.ul_wrap .ul_band li{clear:both;}' . "\r\n" . '	</style>' . "\r\n" . '	<!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '</head>' . "\r\n" . '<body class="main_body">' . "\r\n" . '	<div class="detail">' . "\r\n" . '		';
include_once ('menu.php');
$auth = Zhimin::getComponent('auth');
echo '	' . "\r\n" . '		<div class="detail_top">' . "\r\n" . '			<img src="./images/main_detail_tbg.png" width="100%" alt="" />' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_body">' . "\r\n" . '			<div class="tabel_box surpervision">' . "\r\n" . '				<div class="action_div action_state">' . "\r\n" . '					<span class="addlevel_s add on">添&nbsp;&nbsp;加</span>' . "\r\n" . '					';

if (!empty($groups)) {
	echo '					<span class="addlevel_s edit_a on">编&nbsp;&nbsp;辑</span>' . "\r\n" . '					<span class="addlevel_s action_del on">删&nbsp;&nbsp;除</span>' . "\r\n" . '					<span class="addlevel_s save_button on">保&nbsp;&nbsp;存</span>' . "\r\n" . '					';
}

echo '				</div>' . "\r\n" . '				<div class="table_height">			' . "\r\n" . '					<div class="role_l ">' . "\r\n" . '						<ul>' . "\r\n" . '							<li class="li_top">角色列表</li>' . "\r\n" . '							';

if (!empty($groups)) {
	foreach ($groups as $k => $v ) {
		if ($v['id'] == $data['id']) {
			echo '<li class="li_con li_active" date="' . $v['id'] . '">' . $v['gname'] . '</li>';
		}
		else {
			echo '<li class="li_con" date="' . $v['id'] . '">' . $v['gname'] . '</li>';
		}
	}
}

echo '						</ul>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="role_weight">' . "\r\n" . '						<ul>' . "\r\n" . '							<li class="li_top">权重</li>' . "\r\n" . '							';

if (!empty($groups)) {
	foreach ($groups as $k => $v ) {
		if ($v['id'] == $data['id']) {
			echo '<li class="li_con li_active">' . $v['sort'] . '</li>';
		}
		else {
			echo '<li class="li_con">' . $v['sort'] . '</li>';
		}
	}
}

echo '						</ul>' . "\r\n" . '					</div>' . "\r\n" . '					<form id="form_group" name="form_group" method="post" action="';
echo Zhimin::buildUrl();
echo '&action=popedom" >' . "\r\n" . '					<div class="role_r">' . "\r\n" . '						<div class="div_top" id="group_title">权限控制：（';
echo $data['gname'] . '，编号：' . $data['bh'] . '';
echo '）</div>' . "\r\n" . '						<input type="hidden" name="id" value="';
echo $data['id'];
echo '" />' . "\r\n" . '						<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '						<div class="ul_wrap" >' . "\r\n" . '							<ul class="ul_band">' . "\r\n" . '								<li class="li_child li_on" date="1">' . "\r\n" . '									<!-- 全部功能开始 -->' . "\r\n" . '									<span></span>' . "\r\n" . '									<p class="check_span">' . "\r\n" . '								    	<input type="checkbox" class="ipt-hide" value="1" name="qx_all" />' . "\r\n" . '								        <label class="checkbox check_new"></label>全部功能' . "\r\n" . '								    </p><!-- 全部功能结束 -->' . "\r\n" . '									<ul>' . "\r\n" . '										<!-- 允许查看下属单位开始 -->' . "\r\n" . '										<li date="2">' . "\r\n" . '											<span></span>' . "\r\n" . '											<div class="check_span">' . "\r\n" . '												';

if ($auth->checkValBackdoor($data['qx_only'])) {
	echo '<input type="checkbox" class="ipt-hide" name="qx_only[]" value="1" checked="checked" />';
	echo ' <label class="checkbox check_new cur" ></label>允许查看下属单位';
}
else {
	echo '<input type="checkbox" class="ipt-hide" name="qx_only[]" value="1" />';
	echo ' <label class="checkbox check_new" ></label>允许查看下属单位';
}

echo '										       ' . "\r\n" . '										    </div>' . "\r\n" . '										</li><!-- 允许查看下属单位结束 -->' . "\r\n" . '										<!-- 其它正常模块开始 -->' . "\r\n" . '										';

if (is_array($modules)) {
	foreach ($modules as $module ) {
		echo '										<li class="li_child li_on li_on" date="">' . "\r\n" . '											<span></span>' . "\r\n" . '											<p class="check_span">' . "\r\n" . '												';

		if ($auth->checkValView($module['fvalue'])) {
			if ($auth->checkValView($data[$module['note']])) {
				echo '<input type="checkbox" name="' . $module['note'] . '[]" class="ipt-hide" value="1" checked';
				echo ' />';
				echo '<label class="checkbox check_new cur"></label>' . $module['mname'];
			}
			else {
				echo '<input type="checkbox" name="' . $module['note'] . '[]" class="ipt-hide" value="1" ';
				echo ' />';
				echo '<label class="checkbox check_new"></label>' . $module['mname'];
			}
		}

		echo '										    </p>' . "\r\n" . '										    ' . "\r\n" . '											<ul>' . "\r\n" . '											<!-- 第二层小模块开始 -->' . "\r\n" . '										    ';

		if (isset($module['child'])) {
			foreach ($module['child'] as $mod ) {
				$f = $mod['fvalue'];
				$m = $mod['note'];
				echo '												<li date="">' . "\r\n" . '													<span></span>' . "\r\n" . '													<div class="check_span">' . "\r\n" . '														';

				if ($auth->checkValView($f)) {
					if ($auth->checkValView($data[$m])) {
						echo '<input type="checkbox" class="ipt-hide" value="1" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $mod['mname'];
					}
					else {
						echo '<input type="checkbox" class="ipt-hide" value="1" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $mod['mname'];
					}
				}

				echo '												        <div class="rol_div">' . "\r\n" . '												        	';

				if ($auth->checkValView($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValView($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getViewVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getViewName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getViewVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getViewName();
					}

					echo '</p>';
				}

				if ($auth->checkValAdd($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValAdd($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getAddVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getAddName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getAddVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getAddName();
					}

					echo '</p>';
				}

				if ($auth->checkValEdit($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValEdit($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getEditVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getEditName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getEditVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getEditName();
					}

					echo '</p>';
				}

				if ($auth->checkValDel($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValDel($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getDelVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getDelName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getDelVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getDelName();
					}

					echo '</p>';
				}

				if ($auth->checkValPlay($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValPlay($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getPlayVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getPlayName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getPlayVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getPlayName();
					}

					echo '</p>';
				}

				if ($auth->checkValDown($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValDown($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getDownVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getDownName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getDownVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getDownName();
					}

					echo '</p>';
				}

				if ($auth->checkValOk($f)) {
					echo '<p class="check_span check_p">';

					if ($auth->checkValOk($data[$m])) {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getOkVal() . '" checked';
						echo ' />';
						echo '<label class="checkbox check_new cur"></label>' . $auth->getOkName();
					}
					else {
						echo '<input type="checkbox" name="' . $m . '[]" class="ipt-hide" value="' . $auth->getOkVal() . '" ';
						echo ' />';
						echo '<label class="checkbox check_new"></label>' . $auth->getOkName();
					}

					echo '</p>';
				}

				echo '    ' . "\r\n" . '													    </div>' . "\r\n" . '												    </div>' . "\r\n" . '												</li>';
			}
		}

		echo '<!-- 第二层小模块结束 -->							' . "\r\n" . '											</ul>' . "\r\n" . '										</li>' . "\r\n" . '										';
	}
}

echo '										<!-- 其它正常模块结束-->' . "\r\n" . '									</ul><!-- 和全部功能并列结束 -->' . "\r\n" . '								</li>' . "\r\n" . '							</ul><!-- 最外层的ul结束 -->' . "\r\n" . '						</div>						' . "\r\n" . '					</div><!-- form -->' . "\r\n" . '					</form>' . "\r\n" . '				</div>' . "\r\n" . '			</div>			' . "\r\n" . '		</div>' . "\r\n" . '		<div class="detail_foot">' . "\r\n" . '			<img src="./images/main_detail_fbg.png" width="100%" alt="" />' . "\r\n" . '		</div>		' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 添加弹框 -->' . "\r\n" . '	<div class="layer_notice atten_add">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form action="';
echo Zhimin::buildUrl();
echo '&action=add" method="post" name="group_add_form" id="group_add_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">角色名称：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="gname" value="" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">权重：</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in select_config">	' . "\r\n" . '							<input type="text" name="sort" value="10" id="add_sort"/>' . "\r\n" . '							<div class="sign">' . "\r\n" . '								<span class="plus"></span>' . "\r\n" . '								<span class="minus"></span>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<span class="sure_add sure_role" id="add_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 编辑弹框 -->' . "\r\n" . '	<div class="layer_notice atten_edit">' . "\r\n" . '		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>编辑<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form action="';
echo Zhimin::buildUrl();
echo '&action=edit" method="post" name="group_edit_form" id="group_edit_form">' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">角色名称：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="gname" id="edit_gname" value="';
echo $data['gname'];
echo '" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">权重：</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in select_config">	' . "\r\n" . '							<input type="text" name="sort" id="edit_sort" value="';
echo empty($data['sort']) ? '10' : $data['sort'];
echo '"/>' . "\r\n" . '							<div class="sign">' . "\r\n" . '								<span class="plus"></span>' . "\r\n" . '								<span class="minus"></span>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '                        	<input type="hidden" name="id" id="edit_id" value="';
echo $data['id'];
echo '" />' . "\r\n" . '							<span class="sure_add sure_role" id="edit_submit">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 修改密码弹框 -->' . "\r\n" . '	<div class="layer_notice password_change">' . "\r\n" . '		<div class="notice_top atten_top">添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<form>' . "\r\n" . '			<div class="con_atten_wrap recorder_notice">' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">用户名：</span>' . "\r\n" . '						<div class="select_260 select_div select_no">								' . "\r\n" . '							李三四' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">旧密码：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="number" value="11123511" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">新密码：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="number" value="11123511" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s">' . "\r\n" . '						<span class="condition_title">确认密码：</span>' . "\r\n" . '						<font class="sign_d sign_star">*</font>' . "\r\n" . '						<div class="select_260 select_div select_in">								' . "\r\n" . '							<input type="text" name="number" value="11123511" />' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="condition_top">' . "\r\n" . '					<div class="condition_345 condition_s ">						' . "\r\n" . '						<div class="select_260 select_div select_in selec_text">' . "\r\n" . '							<span class="sure_add">确 定</span>' . "\r\n" . '							<span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="clear"></div>' . "\r\n" . '				</div>' . "\r\n" . '			</div>				' . "\r\n" . '			</form>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 确认提示框 -->' . "\r\n" . '	<div class="layer_notice lay_confirm_del">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/del_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>确定删除此条记录？</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="sure_span sure_one_del">确 定</span>' . "\r\n" . '				<span class="cancle_span close_btn">取 消</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 保存成功提示框 -->' . "\r\n" . '	<div class="layer_notice save_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>保存成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 保存失败提示框 -->' . "\r\n" . '	<div class="layer_notice save_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>保存失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

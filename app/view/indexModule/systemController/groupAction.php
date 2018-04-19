<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>角色管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/group.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<style>		
	.check_span{float: left;display: block;}		
	.li_child ul{clear:both;}		
	.ul_wrap .ul_band li{clear:both;}	
</style>	
<!--[if IE 7]>
<style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}
</style>
<![endif]-->
</head>
<body class="main_body">	
	<div class="detail">		
<?php include_once ('menu.php');
$auth = Zhimin::getComponent('auth');?>
			
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box surpervision">				
		<div class="action_div action_state">					
	<span class="addlevel_s add on">添&nbsp;&nbsp;加
	</span>					

<?php if (!empty($groups)) {?>
						
	<span class="addlevel_s edit_a on">编&nbsp;&nbsp;辑
	</span>					
	<span class="addlevel_s action_del on">删&nbsp;&nbsp;除
	</span>					
	<span class="addlevel_s save_button on">保&nbsp;&nbsp;存
	</span>					
<?php }?>

				
</div>				
<div class="table_height">								
	<div class="role_l ">						
		<ul>							
	<li class="li_top">角色列表
	</li>							

<?php if (!empty($groups)) {
	foreach ($groups as $k => $v ) {
		if ($v['id'] == $data['id']) {?>
			
			<li class="li_con li_active" date="'<?php echo $v['id'];?>"><?php echo $v['gname'];?>
			</li>
		<?php }
		else {?>
			
			<li class="li_con" date="'<?php echo $v['id'];?>"><?php echo $v['gname'];?>
			</li>
		<?php }
	}
}?>

						
</ul>					
</div>					
<div class="role_weight">						
	<ul>							
	<li class="li_top">权重
	</li>							

<?php if (!empty($groups)) {
	foreach ($groups as $k => $v ) {
		if ($v['id'] == $data['id']) {?>
			
			<li class="li_con li_active"><?php echo $v['sort'];?>
			</li>
		<?php }
		else {?>
			
			<li class="li_con"><?php echo $v['sort'];?>
			</li>
		<?php }
	}
}?>

						
</ul>					
</div>					
<form id="form_group" name="form_group" method="post" action="<?php echo Zhimin::buildUrl();?>
&action=popedom" >					
<div class="role_r">						
	<div class="div_top" id="group_title">权限控制：（<?php echo $data['gname'];?>编号：<?php echo $data['bh'];?>
）
</div>						
<input type="hidden" name="id" value="<?php echo $data['id'];?>" />						
<input type="hidden" name="saveflag" value="1" />						
<div class="ul_wrap" >							
	<ul class="ul_band">								
		<li class="li_child li_on" date="1">									
		<!-- 全部功能开始 -->									
<span>
</span>									
<p class="check_span">								    	
	<input type="checkbox" class="ipt-hide" value="1" name="qx_all" />								        
<label class="checkbox check_new">
</label>全部功能								    
</p>
<!-- 全部功能结束 -->									
<ul>										
	<!-- 允许查看下属单位开始 -->										
	<li date="2">											
	<span>
	</span>											
<div class="check_span">												

<?php if ($auth->checkValBackdoor($data['qx_only'])) {?>
	
	<input type="checkbox" class="ipt-hide" name="qx_only[]" value="1" checked="checked" />
	 
	<label class="checkbox check_new cur" >
	</label>允许查看下属单位
<?php }
else {?>
	
	<input type="checkbox" class="ipt-hide" name="qx_only[]" value="1" />
	 
	<label class="checkbox check_new" >
	</label>允许查看下属单位
<?php }?>

										       										    
</div>										
</li>
<!-- 允许查看下属单位结束 -->										
<!-- 其它正常模块开始 -->										

<?php if (is_array($modules)) {
	foreach ($modules as $module ) {?>
												
		<li class="li_child li_on li_on" date="">											
			<span>
			</span>											
		<p class="check_span">												

		<?php if ($auth->checkValView($module['fvalue'])) {
			if ($auth->checkValView($data[$module['note']])) {?>
				
				<input type="checkbox" name="<?php echo $module['note'];?>[]" class="ipt-hide" value="1" checked
				 />
				
				<label class="checkbox check_new cur">
				</label><?php echo $module['mname'];?>
			<?php }
			else {?>
				
				<input type="checkbox" name="<?php echo $module['note'];?>[]" class="ipt-hide" value="1" 
				 />
				
				<label class="checkbox check_new">
				</label><?php echo $module['mname'];
			}
		}?>

												    
	</p>										    											
	<ul>											
			<!-- 第二层小模块开始 -->										    

		<?php if (isset($module['child'])) {
			foreach ($module['child'] as $mod ) {
				$f = $mod['fvalue'];
				$m = $mod['note'];?>
																
				<li date="">													
					<span>
					</span>													
				<div class="check_span">														

				<?php if ($auth->checkValView($f)) {
					if ($auth->checkValView($data[$m])) {?>
						
						<input type="checkbox" class="ipt-hide" value="1" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $mod['mname'];
					}
					else {?>
						
						<input type="checkbox" class="ipt-hide" value="1" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $mod['mname'];
					}
				}?>

																        
				<div class="rol_div">												        	

				<?php if ($auth->checkValView($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValView($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo  $m; ?>[]" class="ipt-hide" value="<?php echo $auth->getViewVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getViewName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m; ?>[]" class="ipt-hide" value="<?php echo  $auth->getViewVal(); ?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo  $auth->getViewName();
					}?>

					
				</p>
				<?php }

				if ($auth->checkValAdd($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValAdd($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo $m; ?>[]" class="ipt-hide" value="<?php echo $auth->getAddVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo  $auth->getAddName();
					}
					else {
						?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getAddVal() ?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getAddName();
					}
					?>
					
				</p>
				<?php }

				if ($auth->checkValEdit($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValEdit($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo  $m ;?>[]" class="ipt-hide" value="<?php echo $auth->getEditVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getEditName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m ;?>[]" class="ipt-hide" value="<?php echo  $auth->getEditVal();?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getEditName();
					}?>

					
				</p>
				<?php }

				if ($auth->checkValDel($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValDel($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getDelVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getDelName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m; ?>[]" class="ipt-hide" value="<?php echo $auth->getDelVal();?>'" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getDelName();
					}?>

					
				</p>
				<?php }

				if ($auth->checkValPlay($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValPlay($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getPlayVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getPlayName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getPlayVal();?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getPlayName();
					}
					?>
					
				</p>
				<?php }

				if ($auth->checkValDown($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValDown($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getDownVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getDownName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getDownVal();?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getDownName();
					}
					?>
					
				</p>
				<?php }

				if ($auth->checkValOk($f)) {?>
					
					<p class="check_span check_p">

					<?php if ($auth->checkValOk($data[$m])) {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getOkVal();?>" checked
						 />
						
						<label class="checkbox check_new cur">
						</label><?php echo $auth->getOkName();
					}
					else {?>
						
						<input type="checkbox" name="<?php echo $m;?>[]" class="ipt-hide" value="<?php echo $auth->getOkVal();?>" 
						 />
						
						<label class="checkbox check_new">
						</label><?php echo $auth->getOkName();
					}
					?>
					
				</p>
				<?php }?>

				    													    
			</div>												    
		</div>												
			</li>
			<?php }
		}?>

		
		<!-- 第二层小模块结束 -->																		
	</ul>										
</li>										
	<?php }
}?>

										
<!-- 其它正常模块结束-->									
</ul>
<!-- 和全部功能并列结束 -->								
</li>							
</ul>
<!-- 最外层的ul结束 -->						
</div>											
</div>
<!-- form -->					
</form>				
</div>			
</div>					
</div>		
<div class="detail_foot">			
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
</div>			
</div>	
<!-- 添加弹框 -->	
<div class="layer_notice atten_add">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>添加
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="group_add_form" id="group_add_form">			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
		<div class="condition_345 condition_s">						
	<span class="condition_title">角色名称：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<input type="text" name="gname" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">权重：
	</span>                        
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_in select_config">								
	<input type="text" name="sort" value="10" id="add_sort"/>							
	<div class="sign">								
	<span class="plus">
	</span>								
<span class="minus">
</span>							
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="clear">
	</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">												
		<div class="select_260 select_div select_in selec_text">							
	<span class="sure_add sure_role" id="add_submit">确 定
	</span>							
<span class="sure_cancle close_btn">取 消
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>							
</div>							
</form>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 编辑弹框 -->	
<div class="layer_notice atten_edit">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>编辑
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form action="<?php echo Zhimin::buildUrl();?>&action=edit" method="post" name="group_edit_form" id="group_edit_form">			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
		<div class="condition_345 condition_s">						
	<span class="condition_title">角色名称：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<input type="text" name="gname" id="edit_gname" value="<?php echo $data['gname'];?>" />			
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">权重：
	</span>                        
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_in select_config">								
	<input type="text" name="sort" id="edit_sort" value="<?php echo empty($data['sort']) ? '10' : $data['sort'];?>"/>							
<div class="sign">								
	<span class="plus">
	</span>								
<span class="minus">
</span>							
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="clear">
	</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">												
		<div class="select_260 select_div select_in selec_text">							
		<input type="hidden" name="saveflag" value="1" />                        	
<input type="hidden" name="id" id="edit_id" value="<?php echo $data['id'];?>" />							
<span class="sure_add sure_role" id="edit_submit">确 定
</span>							
<span class="sure_cancle close_btn">取 消
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>			
</div>							
</form>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 修改密码弹框 -->	
<div class="layer_notice password_change">		
	<div class="notice_top atten_top">添加
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form>			
		<div class="con_atten_wrap recorder_notice">				
		<div class="condition_top">					
		<div class="condition_345 condition_s">						
	<span class="condition_title">用户名：
	</span>						
<div class="select_260 select_div select_no">															李三四						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">旧密码：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<input type="text" name="number" value="11123511" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">新密码：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<input type="text" name="number" value="11123511" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">确认密码：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<input type="text" name="number" value="11123511" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">												
		<div class="select_260 select_div select_in selec_text">							
	<span class="sure_add">确 定
	</span>							
<span class="sure_cancle close_btn">取 消
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>			
</div>							
</form>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm_del">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/del_bg.png">			
</div>			
<div class="n_right">				
	<p>确定删除此条记录？
	</p>				
<div class="clear">
</div>				
<span class="sure_span sure_one_del">确 定
</span>				
<span class="cancle_span close_btn">取 消
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 成功提示框 -->	
<div class="layer_notice lay_success">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/success_bg.png">			
</div>			
<div class="n_right">				
	<p id="success_flg">删除成功......
	<font>3
</font>秒钟后返回页面！
</p>				
<div class="clear">
</div>				
<span class="cancle_span close_btn">确 定
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 失败提示框 -->	
<div class="layer_notice lay_wrong">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/notice_bg.png">			
</div>			
<div class="n_right">				
	<p id="fail_flg">删除失败......
	<font>3
</font>秒钟后返回页面！
</p>				
<div class="clear">
</div>				
<span class="cancle_span close_btn_self">确 定
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 保存成功提示框 -->	
<div class="layer_notice save_success">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/success_bg.png">			
</div>			
<div class="n_right">				
	<p>保存成功......
	<font>3
</font>秒钟后返回页面！
</p>				
<div class="clear">
</div>				
<span class="cancle_span close_btn">确 定
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 保存失败提示框 -->	
<div class="layer_notice save_wrong">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/notice_bg.png">			
</div>			
<div class="n_right">				
	<p>保存失败......
	<font>3
</font>秒钟后返回页面！
</p>				
<div class="clear">
</div>				
<span class="cancle_span close_btn">确 定
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>
</body>
</html>


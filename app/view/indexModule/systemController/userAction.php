<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>用户管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<!-- update at 20160905 by star -->	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/user.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>	
<!--[if IE 7]>
<style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}
</style>
<![endif]-->
</head>
<body class="main_body">	
	<div class="detail">		
<?php include_once ('menu.php');?>
		
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box surpervision">				
	<form action="<?php echo Zhimin::buildUrl();?>&action=search" method="post">					
<div class="condition_top">						
	<div class="condition_240 condition_s">							
	<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>						
</div>						
<div class="condition_165 condition_s">							
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>姓名：
</span>							
<div class="select_100 select_div select_in">								
	<input type="text" value="<?php echo Zhimin::request('hostname');?>" name="hostname" />							
</div>						
</div>						
<div class="condition_165 condition_s">							
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>							
<div class="select_100 select_div select_in">								
	<input type="text" value="<?php echo Zhimin::request('hostcode');?>" name="hostcode" />		
</div>						
</div>						
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<div class="action_div action_state">					
	<form action="<?php echo Zhimin::buildUrl('user', 'system')?>action=execl" method="post" enctype="multipart/form-data">					

<?php if ($user_auth['add'] == 1) {?>
	
	<span class="addlevel_s add on">添加新用户
	</span>
<?php }

if ($user_auth['edit'] == 1) {?>
	
	<span class="addlevel_s edit_a">编辑
	</span>
	
	<span class="addlevel_s password_btn">重置密码
	</span>
<?php }

if ($user_auth['ok'] == 1) {?>
	<span class="addlevel_s scope_btn">管理范围
	</span>
<?php }

if ($user_auth['edit'] == 1) {?>
	
	<span class="addlevel_s stop_btn_s">停 用
	</span>
	
	<span class="addlevel_s up_btn_s">启 用
	</span>
<?php }

if ($user_auth['del'] == 1) {?>
	
	<span class="addlevel_s action_del" id="user_del_but">删 除
	</span>
<?php}

 if ($user_auth['admin'] == 1) {?>
	
	<span class="addlevel_s on" id="excel_demo">模板下载
	</span>
	
	<span class="addlevel_s on" id="excel_input">导入
	</span>
<?php }?>

					
</form>				
</div>								
<div class="table_height">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th class="t_back" width="6%">序号
</th>								
<th width="8%"><?php echo $_SESSION['zfz_type'];?>姓名
</th>								
<th class="t_back" width="8%"><?php echo $_SESSION['zfz_type'];?>编号
</th>																
<th width="19%">单位
</th>								
<th class="t_back" width="11%">用户名
</th>								
<th width="9%">状态
</th>								
<th class="t_back" width="11%">角色
</th>																
<th width="15%">上次登录时间
</th>								
<th class="t_back">上次登录IP
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten">							
	<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->							

<?php if (empty($datas)) {?>
								
	<tr class="td_back">								
		<td colspan="9">暂无记录
	</td>							
</tr>							
<?php }
else {
	foreach ($datas as $k => $v ) {?>
									
		<tr date="
		<?php echo $v['id'];?>
		" 

		<?php if (($k % 2) == 1) {?>
			class="td_back"
		<?php }?>

		>								
		<td>									
		<?php echo $k + 1;?>
										
	</td>								
		<td>									
		<?php echo $v['realname'] == '' ? '--' : $v['realname'];?>
										
	</td>								
		<td>
		<?php echo $v['hostcode'];?>
		
	</td>								
		<td>									
		<?php echo $v['unitname'];?>
										
	</td>								
		<td>
		<?php echo $v['username'];?>
		
	</td>																
		<td>
		<?php echo $v['ispass'] == 1 ? '正常' : '停用';?>
		
	</td>																
		<td>
		<?php echo $v['ifadmin'] == 1 ? '系统管理员' : $v['groupname'];?>
		
	</td>																
		<td>
		<?php echo empty($v['logintime']) ? '' : date('Y-m-d H:i', $v['logintime']);?>
		
	</td>																
		<td>
		<?php echo $v['loginip'];?>
		
	</td>															
	</tr>							
	<?php }
}?>

											
</tbody>					
</table>				
</div>				
<div class="page_link">					
<?php $page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
				
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
	<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="user_add_form" id="user_add_form">			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">用户名：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text"  class="input_error" name="username" value="" />							
<span class="error_msg">请填写用户名
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">密码：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="password" class="input_error" name="password1" value="" />							
<span class="error_msg">请填写密码
</span>						
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
<div class="select_260 select_div select_relative select_in">															
	<input type="password" class="input_error" name="password2" value="" />							
<span class="error_msg">请填写确认密码
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>姓名：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" class="input_error" name="realname" value="" />							
<span class="error_msg">请填写<?php echo $_SESSION['zfz_type'];?>姓名
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>						 
<font class="sign_d sign_star sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" class="input_error" name="hostcode" value="" />							
<!-- 
<span class="error_msg">请选填写' . $_SESSION['zfz_type'] . '编号
</span> -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div">							
	<input class="easyui-combotree" name="danwei_add" data-options="" style="width:100%;" id="easyui_add"/>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">角色：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div">							
	<select class="easy_u" name="group" style="width:100%;">								
	<option value="">-请选择-
</option>								

<?php foreach ($user_groups as $k => $v ) {?>
	
	<option value="<?php echo $v['bh'];?>"
	><?php echo $v['gname'];?>
</option>
<?php }?>

							
</select>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">排序：
</span>						
<font class="sign_d sign_star sign_star1">&nbsp;
</font>						
<div class="select_260 select_div select_in select_config">															
	<input type="text" name="sort" value="1" />							
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
	<font class="sign_d sign_star">&nbsp;
</font>												
<div class="select_260 select_div select_in selec_text">							
	<span class="sure_add" id="add_submit">确 定
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
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>修改密码
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body" id="notice_user_body">			
	<form name="change_pwd_form" id="change_pwd_form">			
	<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">用户名：
</span>						
<div class="select_260 select_div select_no" id="pwd_change_username">
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
<div class="select_260 select_div select_relative select_in">															
	<input type="password" name="old_pwd" class="input_error" value="" />							
<span class="error_msg">请选填写旧密码
</span>						
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
<div class="select_260 select_div select_relative select_in">															
	<input type="password" name="new_pwd" class="input_error" value="" />							
<span class="error_msg">请选填写新密码
</span>						
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
<div class="select_260 select_div select_relative select_in">															
	<input type="password" name="confim_pwd" class="input_error" value="" />							
<span class="error_msg">请选填写确认密码
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">						
	<font class="sign_d sign_star">&nbsp;
</font>												
<div class="select_260 select_div select_in selec_text">							
	<input type="hidden" name="user_id" id="pwd_change_id" value="" />							
<span class="sure_add" id="change_pwd_submit">确 定
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
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm_reset">		
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
	<p>确定重置密码？
</p>				
<div class="clear">
</div>				
<span class="sure_span sure_one_reset">确 定
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
<div class="notice_body">			
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
<div class="notice_body">			
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
<!-- 停用确认提示框 -->	
<div class="layer_notice lay_confirm_stop">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
	<img src="./images/scrp.png">			
</div>			
<div class="n_right">				
	<p>确定停用？
</p>				
<div class="clear">
</div>				
<span class="sure_span stop_btn">确 定
</span>				
<span class="cancle_span close_btn">取 消
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 停用成功提示框 -->	
<div class="layer_notice stop_success">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<div class="n_left">				
	<img src="./images/success_bg.png">			
</div>			
<div class="n_right">				
	<p>停用成功......
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
<!-- 停用失败提示框 -->	
<div class="layer_notice stop_wrong">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<div class="n_left">				
	<img src="./images/notice_bg.png">			
</div>			
<div class="n_right">				
	<p>停用失败......
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
<!-- 启用确认提示框 -->	
<div class="layer_notice lay_confirm_up">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
	<img src="./images/confirm_bg.png">			
</div>			
<div class="n_right">				
	<p>确定启用？
</p>				
<div class="clear">
</div>				
<span class="sure_span up_btn">确 定
</span>				
<span class="cancle_span close_btn">取 消
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 启用成功提示框 -->	
<div class="layer_notice up_success">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<div class="n_left">				
	<img src="./images/success_bg.png">			
</div>			
<div class="n_right">				
	<p>启用成功......
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
<!-- 启用失败提示框 -->	
<div class="layer_notice up_wrong">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<div class="n_left">				
	<img src="./images/notice_bg.png">			
</div>			
<div class="n_right">				
	<p>启用失败......
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
<!-- 导入Excel提示框 -->	
<div class="layer_notice input_form">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<form action="<?php echo Zhimin::buildUrl();?>&action=excel" method="post" enctype="multipart/form-data" name="excel_form" id="excel_form">		
<div class="notice_body action_state">			
	<input type="file" name="inputExcel" />			
<span class="addlevel_s on" id="excel_input_form">导入
</span>		
</div>		
</form>		
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
	<form action="<?php echo Zhimin::buildUrl();?>&action=edit" method="post" name="user_edit_form" id="user_edit_form">			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">用户名：
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in selec_text">															 
	<p id="edit_username">
</p>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>姓名：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															 
	<input type="text" class="input_error input_error1" name="realname" id="edit_realname" value="" />							
<span class="error_msg">请选填写<?php echo $_SESSION['zfz_type'];?>姓名
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															 
	<input type="text" class="input_error1" name="hostcode" id="edit_hostcode" value="" />							
<span class="error_msg">请选填写<?php echo $_SESSION['zfz_type'];?>编号
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div">							
	<input class="easyui-combotree" name="danwei_edit" data-options="" style="width:100%;" id="easyui_edit"/>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">角色：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div">							
	<select class="easy_u" name="group" id="edit_group" style="width:100%;">								
	<option value="">-请选择-
</option>								

<?php foreach ($user_groups as $k => $v ) {?>
	
	<option value="<?php echo $v['bh'];?>"
	><?php echo $v['gname'];?>
</option>
<?php }?>

							
</select>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">排序：
</span>                        
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_in select_config">								
	<input type="text" name="sort" value="" id="edit_sort"/>							
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
	<font class="sign_d sign_star1">*
</font>												
<div class="select_260 select_div select_in selec_text">							
	<input type="hidden" name="saveflag" value="1" />                        	
<input type="hidden" name="id" id="edit_id" value="" />							
<span class="sure_add" id="edit_submit">确 定
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
<!-- 管理范围弹框 -->	
<div class="layer_notice scope">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>设置管理范围
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body scope_body">			
	<form method="post" name="manager_edit_form" id="manager_edit_form">			
	<div class="con_atten_wrap scope_wrap">								
	<div class="condition_top">					
	<ul class="ul_band" id="manager_unit_ul">					
<?php $optionsStr = '';
HTMLUtils::options_stair_userpage($optionsStr, $units_array, 'id', 'text', 'children', $manager_array);
echo $optionsStr;?>
					
</ul>					
<div class="clear">
</div>				
</div>							
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s ">											
	<div class="select_260 select_div select_in selec_text">						
	<input type="hidden" name="saveflag" value="1" />						
<input type="hidden" name="id" id="manager_unit_id" value="99" />						
<span class="sure_add" id="manager_submit">确 定
</span>						
<span class="sure_cancle close_btn">取 消
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>							
</form>		
</div>		
<div class="notice_foot">
</div>	
</div>
<script type="text/javascript">
	$(document).ready(function(){
	/*search list tree*/
	$("#easyui_search").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
		method:'get',labelPosition:'top',panelWidth:'500px',
	// 设置选中项
	onLoadSuccess:function(node,data){
		$("#easyui_search").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);  
    }  
	});  
	/*search list tree end*/ 
	/*add tree*/
	$("#easyui_add").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
		method:'get',labelPosition:'top',panelWidth:'500px',
	// 设置选中项
	onLoadSuccess:function(node,data){
		$("#easyui_add").combotree('setValues', ['']);  
    }  
	});/*add tree end*/
	$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});
	//管理范围里面的样式
	$(".ul_band li:not('.li_child')").children("span").css("background","url('./images/icon_select02.png') scroll 0 8px no-repeat");
})
</script>
</body>
</html>
</body>
</html>

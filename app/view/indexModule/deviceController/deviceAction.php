<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>执法记录仪管理</title>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js"></script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js"></script>

<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js"></script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/device.php"></script>
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js"></script>
<style type="text/css">	
.table_detail tbody td{*border-right:none;}
</style>
<!--[if IE 7]><style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}</style><![endif]-->
</head>
<body class="main_body">
<div class="detail">
<?php include_once ('menu.php');?>
<div class="detail_top">		
<img src="./images/main_detail_tbg.png" width="100%" alt="" />	
</div>	
<div class="detail_body">		
<div class="tabel_box surpervision">			
<form action="<?php echo Zhimin::buildUrl();?>
&action=search" method="post">			
<div class="condition_top con_zindex_1">					
<div class="condition_280 condition_s">						
<span class="condition_title">单位：</span>						
<div class="select_200 select_div">							
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>				
</div>					
</div>					
<div class="condition_165 condition_s">						
<span class="condition_title">配发<?php echo $_SESSION['zfz_type']?>：</span>						
<div class="select_100 select_div select_in">							
<input type="text" name="hostname" value="<?php echo Zhimin::request('hostname');?>">						
</div>					
</div>					
<div class="condition_165 condition_s">						
<span class="condition_title">
<?php echo $_SESSION['zfz_type']?>编号：
</span>						
<div class="select_100 select_div select_in">							
	<input type="text" value="<?php Zhimin::request('hostcode');?>" name="hostcode">						
</div>					
</div>					
<div class="clear"></div>				
</div>				
<div class="condition_top">					
<div class="condition_280 condition_s">						
<span class="condition_title">记录仪编号：</span>						
<div class="select_200 select_div select_in">															
<input type="text" value="<?php Zhimin::request('hostbody');?>" name="hostbody">						
</div>					
</div>					
<div class="condition_s sub">													
<input type="submit" value="" />					
</div>					
<div class="clear"></div>				
</div>			
</form>			
<div class="action_div action_state">

<?php if ($device_auth['add'] == 1) {?>
	<?php echo '<span class="addlevel_s ';
	echo $is_facility==0 ? 'addFacility' : 'add';
	echo ' on">添加</span>';?>
<?php }?>
<?php if ($device_auth['edit'] == 1) {?>
<span class="addlevel_s edit_a">编辑</span>
<span class="addlevel_s action_warning">报障</span>
<span class="addlevel_s action_scrap">报废</span>
<span class="addlevel_s action_up">启用</span>
<?php }?>

<?php if ($device_auth['del'] == 1) {?>
<span class="addlevel_s action_del" id="user_del_but">删 除</span>
<?php }?>
<?php if ($device_auth['admin'] == 1) {?>
<?php echo '<span class="addlevel_s ';
	echo $is_facility==0 ? 'updateFacility' : 'update';
	echo ' on"';
	echo $is_facility==0 ? '' : 'id = "admin_update"';?>
>更新设备</span>
<?php }?>

</div>			
<div class="table_height">							
<table class="table_detail" cellspacing="0" style="width:124%;">					
<thead>						
<tr>							
<th class="t_back" width="5%">序号</th>							
<th width="8%">配发<?php echo $_SESSION['zfz_type'] ?></th>							
<th class="t_back" width="8%"><?php echo $_SESSION['zfz_type']?>编号</th>					
<th width="18%">单位</th>							
<th class="t_back" width="11%">记录仪编号</th>							
<th width="8%">设备状态</th>							
<th class="t_back" width="14%">上次使用时间</th>							
<th  width="6%">产品名称</th>							
<th width="6%" class="t_back">厂商</th>							
<th  width="6%">容量（MB）</th>							
<th width="14%" class="t_back">注册时间</th>						
</tr>					
</thead>					
<tbody class="tbody_atten">						
<!-- 这里有两个效果，一个隔行换色td_back-->						

<?php if (empty($datas)) {?>
<tr class="td_back">							
<td colspan="12">暂无记录</td>						
</tr>							
<?php } else {?>
<?php foreach ($datas as $k => $v ) {?>
<tr date="<?php $v['id'];?>" class="tr_p 
<?php if (($k % 2) == 1) {?>
td_back
<?php }?>">							
<td>
<?php echo $k + 1;?>
</td>							<td>
<?php echo $v['hostname'];?>
</td>							<td>
<?php echo $v['hostcode'];?>
</td>							<td>
<?php echo $v['unitname'];?>
</td>							<td>
<?php echo $v['hostbody'];?>
</td>							<td>
<?php echo $device_state[$v['state']];?>
</td>							<td>
<?php echo $v['last_date'];?>
</td>																<td>
<?php echo $v['product_name'];?>
</td>															<td>
<?php echo $v['product_firm'];?>
</td>															<td>
<?php echo $v['capacity'];?>
</td>							<td>
<?php echo empty($v['creatertime']) ? '' : date('Y-m-d H:i:s', $v['creatertime']);?>
</td>						
</tr>						
<?php }?>
<?php }?>


</tbody>				
</table>			
</div>			
<div class="page_link">				
<?php echo $page_m = Zhimin::getComponent('page');?>
<?php echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
</div>		
</div>				
</div>	
<div class="detail_foot">		
<img src="./images/main_detail_fbg.png" width="100%" alt="" />	</div>		
</div>
<!-- 添加弹框 -->
<div class="layer_notice atten_add">	
<div class="notice_top atten_top">
<span style="display: inline-block;width:20px;"></span>添加<span class="close close_btn">
<img src="./images/close.png" alt="" /></span>
</div>	
<div class="notice_body">		
<form action="<?php Zhimin::buildUrl();?>&action=add" method="post" name="device_add_form" id="device_add_form">		
<div class="con_atten_wrap recorder_notice">			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title num_po"><?php echo $_SESSION['zfz_type']?>编号&nbsp;:</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" class="input_error" name="hostcode" value="" />						
<span class="error_msg">请填写<?php echo $_SESSION['zfz_type'] ?>编号</span>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title name_po">配发<?php echo $_SESSION['zfz_type'] ?>&nbsp;:</span>					<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" class="input_error" name="hostname" value="" />						
<span class="error_msg">请填写配发<?php echo $_SESSION['zfz_type']?></span>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">&nbsp;:</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div">						
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_add"/>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title grapher">记录仪编号&nbsp;:</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" class="input_error" name="hostbody" value="" />						
<span class="error_msg">请填写记录仪编号</span>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title productRange">产品名称&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" name="product_name" value="" />					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title manufacture">厂商&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" name="product_firm" value="" />					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title volume">容量(ML)&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" name="capacity" value="" />					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s ">					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in selec_text">						
<span class="sure_add" id="add_submit">确 定</span>						
<span class="sure_cancle close_btn">取 消</span>					
</div>				
</div>				
<div class="clear"></div>			
</div>		
</div>						
</form>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 编辑弹框 -->
<div class="layer_notice atten_edit">	
<div class="notice_top atten_top">
<span style="display: inline-block;width:20px;"></span>编辑<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span></div>	
<div class="notice_body">		
<form action="<?php Zhimin::buildUrl();?>&action=edit" method="post" name="device_edit_form" id="device_edit_form">		
<div class="con_atten_wrap recorder_notice">			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">记录仪编号:</span>					
<div class="select_260 select_div select_in selec_text">														
<p id="edit_hostbody"></p>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title"><?php echo $_SESSION['zfz_type'] ?>编号：</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div select_in">						
<input type="text" name="hostcode" id="edit_hostcode" value=""  class="input_error input_error1 num_po"/>                            
<span class="error_msg">请选填写<?php echo $_SESSION['zfz_type'] ?>编号</span>													
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">配发<?php echo $_SESSION['zfz_type'] ?>：</span>					
<font class="sign_d sign_star">*</font>                        
<div class="select_260 select_div select_in">                            
<input type="text" name="hostname" id="edit_hostname" value=""  class="input_error input_error1 name_po"/>                           
<span class="error_msg">请选填写<?php  echo $_SESSION['zfz_type'] ?>姓名</span>                        
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">单位：</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div">						
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_edit"/>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">产品名称：</span>					
<font class="sign_d sign_star1">*</font>                        
<div class="select_260 select_div select_in">                           
<input type="text" name="product_name" id="edit_product_name" value="" />                        
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">厂商：</span>					
<font class="sign_d sign_star1">*</font>                        
<div class="select_260 select_div select_in">                           
<input type="text" name="product_firm" id="edit_product_firm" value="" />                        
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">容量(MB)：</span>					
<font class="sign_d sign_star1">*</font>                        
<div class="select_260 select_div select_in">                            
<input type="text" name="capacity" id="edit_capacity" value="" />                        
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s ">											
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in selec_text">						
<input type="hidden" name="saveflag" value="1" />                        	
<input type="hidden" name="id" id="edit_id" value="" />														
<span class="sure_add" id="edit_submit">确 定</span>						<span class="sure_cancle close_btn">取 消</span>					
</div>				
</div>				
<div class="clear">

</div>			
</div>		
</div>						
</form>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 报障弹框 -->
<div class="layer_notice atten_warning">	
<div class="notice_top atten_top">
<span style="display: inline-block;width:20px;"></span>报障<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		 
<form method="post" name="device_warning_form" id="device_warning_form">		
<div class="con_atten_wrap recorder_notice">			
<div class="condition_top">				
<div class="condition_346 condition_s">					
<span class="condition_title">报障人&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														
<input type="text" name="report_user" value="<?php echo $_SESSION['realname'] == '' ? $_SESSION['username'] : $_SESSION['realname'];?>
" />					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">故障类型&nbsp;:</span>					
<font class="sign_d sign_star">*</font>					
<div class="select_260 select_div">						
<select class="easy_u" name="type" id="edit_type" style="width:100%;">							
<option value="">-请选择-</option>							

<?php foreach ($device_repair_array as $k => $v ) {?>
<option value="<?php $v['confcode']?>"
>{echo $v['confname']}</option>
<?php }?>
</select>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_346 condition_s">					
<span class="condition_title">故障时间&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														<div class="select_235 sele_c select_in select_time_i">							
<input type="text" id="report_date" name="report_date" value="" />						
</div>						
<div class="select_time condition_end" onclick="laydate({elem: '#report_date',istime: true,format: 'YYYY-MM-DD'});">

</div>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_346 condition_s">					
<span class="condition_title">预计启用时间&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in">														
<div class="select_235 sele_c select_in select_time_i">							
<input type="text" id="e_startup_time" name="e_startup_time" value="" />						
</div>						
<div class="select_time condition_end" onclick="laydate({elem: '#e_startup_time',istime: true,format: 'YYYY-MM-DD'});">

</div>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_346 condition_s condition_textarea condition_height">					
<span class="condition_title">故障原因&nbsp;:</span>					<font class="sign_d sign_star1">*</font>					<!-- <div class="select_260 select_div select_days textarea_in">														<textarea name="reason"></textarea>					</div> -->					
<textarea name="reason" style="width:260px; height:80px;border:1px solid #aeaeae;float:right;resize:none;">

</textarea>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_346 condition_s condition_textarea condition_height">					
<span class="condition_title">故障备注&nbsp;:</span>					<font class="sign_d sign_star1">*</font>					<!--<div class="select_260 select_div select_days textarea_in">														<textarea name="remark"></textarea>					</div>-->					
<textarea name="remark" style="width:260px; height:80px;border:1px solid #aeaeae;float:right;resize:none;">

</textarea>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_346 condition_s ">					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in selec_text">						
<span class="sure_add" id="atten_warning_submit">确 定</span>						
<span class="sure_cancle close_btn">取 消</span>					
</div>				
</div>				
<div class="clear"></div>			
</div>											
</div>						
</form> 	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 记录仪合并 -->
<div class="layer_notice atten_merge">	
<div class="notice_top atten_top">合并<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
<form name="atten_merge_form" id="atten_merge_form">		
<div class="con_atten_wrap recorder_notice">			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title" id="atten_merge_hostbody">当前设备号&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title" id="atten_merge_hostname">配发<?php echo $_SESSION['zfz_type']?>&nbsp;:</span>					
<font class="sign_d sign_star1">*</font>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s">					
<span class="condition_title">请输入替换当前设备的新设备编号&nbsp;:</span>					<font class="sign_d sign_star1">*</font>					
<div class="select_145 select_div select_in">														
<input type="text" name="hostbody" value="" id="hostbody_new"/>					
</div>				
</div>				
<div class="clear"></div>			
</div>			
<div class="condition_top">				
<div class="condition_345 condition_s ">					
<font class="sign_d sign_star1">*</font>					
<div class="select_260 select_div select_in selec_text">							
<input type="hidden" name="hostbody_old" id="hostbody_old" value="" />													
<span class="sure_add" id="atten_merge_submit">确 定</span>						
<span class="sure_cancle close_btn">取 消</span>					
</div>				
</div>				
<div class="clear"></div>			
</div>		
</div>						
</form>	
</div>	
<div class="notice_foot"></div>
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
<p>确定删除此设备？</p>			
<div class="clear"></div>			
<span class="sure_span sure_one_del">确 定</span>			
<span class="cancle_span close_btn">取 消</span>		
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
<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>			
<div class="clear"></div>			
<span class="cancle_span close_btn">确 定</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 失败提示框 -->
<div class="layer_notice lay_wrong">	
<div class="notice_top"><span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body1">		
<div class="n_left">			
<img src="./images/notice_bg.png">		
</div>		
<div class="n_right">			
<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>			
<div class="clear"></div>			
<span class="cancle_span close_btn_self">确 定</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 更新成功提示框 -->
<div class="layer_notice update_success">	
<div class="notice_top"><span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	

<div class="notice_body">		
<div class="n_left">			
<img src="./images/scrp1.png">		
</div>		
<div class="n_right">			
<p>更新成功......<font>3</font>秒钟后返回页面！</p>			
<div class="clear"></div>			
<span class="cancle_span close_btn">确 定</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 报废确认提示框 -->
<div class="layer_notice lay_scrp">	
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
<p>确定报废此设备？</p>			
<div class="clear"></div>			
<span class="sure_span sure_scrp">确 定</span>			
<span class="cancle_span close_btn">取 消</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 启用确认提示框 -->
<div class="layer_notice lay_up">	
<div class="notice_top">
<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body1">		
<div class="n_left">			
<img src="./images/scrp1.png">		
</div>		
<div class="n_right">			
<p>确定启用此设备？</p>			
<div class="clear"></div>			
<span class="sure_span sure_up">确 定</span>			
<span class="cancle_span close_btn">取 消</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 报废成功提示框 -->
<div class="layer_notice scrp_success">	
<div class="notice_top">
<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body4">		
<div class="n_left">			
<img src="./images/success_bg.png">		
</div>		
<div class="n_right">			
	<p>报废成功......<font>3</font>秒钟后返回页面！</p>			
	<div class="clear"></div>			
	<span class="cancle_span close_btn">确 定</span>		
	</div>	
	</div>	
	<div class="notice_foot"></div>
	</div>
	<!-- 报废失败提示框 -->
<div class="layer_notice scrp_wrong">	
	<div class="notice_top"><span class="close close_btn">
		<img src="./images/close.png" alt="" /></span>
		</div>	
<div class="notice_body">		
<div class="n_left">			
<img src="./images/notice_bg.png">		
</div>		
<div class="n_right">			
<p>报废失败......<font>3</font>秒钟后返回页面！</p>			
<div class="clear"></div>			
<span class="cancle_span close_btn">确 定</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 更新设备确认提示框 -->
<div class="layer_notice lay_scrp_update">	
<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span>
</div>	
<div class="notice_body1">		
<div class="n_left">			
<img src="./images/scrp1.png">		
</div>		
<div class="n_right">			
<p>确定更新所有设备？</p>			
<div class="clear"></div>			
<span class="sure_span sure_scrp_update">确 定</span>			
<span class="cancle_span close_btn">取 消</span>		
</div>	
</div>	
<div class="notice_foot"></div>
</div>

<script type="text/javascript">
$(document).ready(function(){	
	/*search list tree*/	
	$("#easyui_search").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
		method:'get',labelPosition:'top',panelWidth:'500px',
			// 设置选中项	
			onLoadSuccess:function(node,data){		
				$("#easyui_search").combotree('setValues', ["<?php echo Zhimin::request('danwei');?>"]);      
			}  	
		});  
	/*search list tree end*/ 	
	/*add tree*/	
	$("#easyui_add").combotree({
		url:"<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname",
		method:'get',labelPosition:'top',panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$("#easyui_add").combotree('setValues', ['']);      
				}  	
		});
		/*add tree end*/	
	$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});	
})
</script>
</body>
</html>
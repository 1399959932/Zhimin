<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>部门管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/unit.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>	
<style>				
.condition_c > span {		    width: 78px;		}		
.select_180{width: 259px;}		
.ul_show .li_child ul{display: block;}	
</style>	
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
	<div class="action_div action_state">					
	<span class="addlevel_s add on">添 加
</span>					
<!-- 
<span class="addlevel_s edit_a">修 改
</span>					
<span class="addlevel_s action_del">删除
</span> -->				
</div>				
<div class="table_height">								
	<div class="div_band">						
	<!-- 上层展开、关闭按钮 -->						
<div class="ul_button">							
	<span class="ul_open">
</span>							
<span class="ul_close">
</span>							
<div class="clear">
</div>							
<span class="part_title">
	<img src="./images/part_title_bg.png" width="70" alt="" />
</span>						
</div>
<!-- 上层展开、关闭按钮 结束 -->						
<ul class="ul_band ul_show" style="width:700px;">							
<?php $optionsStr = '';
HTMLUtils::options_stair_unitpage($optionsStr, $datas, 'bh', 'name', 'child');
echo $optionsStr;	?>					
</ul>					
</div>				
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
<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="unit_add_form" id="unit_add_form"> 			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位编号：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" name="bh" class="input_error" value="" />							
<span class="error_msg">请填写单位编号
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位名称：
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" name="zuming" class="input_error" value="" />							
<span class="error_msg">请填写单位名称
</span>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">上级单位：
</span>						
<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<div class="select_260 select_div">							
	<input class="easyui-combotree" name="xsbh" data-options="" style="width:100%;" id="easyui_add"/>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top sys_con">					
	<div class="condition_345 condition_s condition_c">						
	<span class="condition_title">排序：
</span>						
<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<div class="select_180 select_div select_in select_config">															
	<input type="text" name="orderby" value="1" />							
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
	<div class="condition_345 condition_s condition_textarea condition_height">						
	<span class="condition_title">备注：
</span>						
<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<!-- 
<div class="select_260 select_div select_days textarea_in">															
<textarea name="beizhu">
</textarea>						
</div> -->						
<textarea name="beizhu" style="width:250px;height:76px; float:right; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">
</textarea>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">						
	<font class="sign_d sign_star" style="color:#fff;">*
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
<!-- 修改弹框 -->	
<div class="layer_notice atten_edit">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>编辑
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form  method="post" name="unit_edit_form" id="unit_edit_form">			
	<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位编号：
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in selec_text">															 
	<p id="edit_bh">
</p>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">上级单位：
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in selec_text">															
	<p id="edit_parent">
</p>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">                    
	<div class="condition_345 condition_s">                        
	<span class="condition_title">单位名称：
</span>                        
<font class="sign_d sign_star">*
</font>                        
<div class="select_260 select_div select_relative select_in">                            
	<input type="text" name="zuming" id="edit_dname" class="input_error1" value="" />                            
<span class="error_msg">请填写单位名称
</span>                        
</div>                    
</div>                    
<div class="clear">
</div>                
</div>				
<div class="condition_top sys_con">					
	<div class="condition_345 condition_s condition_c">						
	<span class="condition_title">排序：
</span>						
<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<div class="select_180 select_div select_in select_config">															
	<input type="text" name="orderby" id="edit_orderby" value="" />							
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
	<div class="condition_346 condition_s condition_textarea condition_height">						
	<span class="condition_title">备注：
</span>						
<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<div class="select_260 select_div select_days textarea_in">															
	<textarea name="beizhu" id="edit_beizhu">
</textarea>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">						
	<font class="sign_d sign_star" style="color:#fff;">*
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
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm_del">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<div class="n_left">				
	<img src="./images/del_bg.png">			
</div>			
<div class="n_right">				
	<p>确定删除此条记录？
</p>				
<div class="clear">
</div>				
<input type="hidden" id="confirm_del_bh" value="" />				
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
<script type="text/javascript">
	$(document).ready(function(){	
	/*add tree*/	
	$("#easyui_add").combotree({
	url:'<?php echo Zhimin::buildUrl('unitjson', 'other');?>&id=id&text=dname',
	method:'get',
	labelPosition:'top',
	panelWidth:'500px',	
	// 设置选中项	
	onLoadSuccess:function(node,data){		
		$("#easyui_add").combotree('setValues', ['']);     
	}  	
	});
/*add tree end*/	
/*add tree*/
})
</script>
</body>
</html>

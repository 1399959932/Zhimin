<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>系统配置项
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/sysconf.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>	
<style>		.condition_textarea .textarea_in textarea{*height: 79px;}	
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
	<form action="<?php echo Zhimin::buildUrl();?>&action=search" method="post">					
<div class="condition_top">						
	<div class="condition_240 condition_s">							
	<span class="condition_title">类别：
	</span>							
<div class="select_200 select_div">								
	<select class="easy_u" id="type" name="type" style="width:100%;">								
	<option value="">不限
	</option>								

<?php foreach ($config_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"

	<?php if (Zhimin::request('type') == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>

								
</select>							
</div>						
</div>						
<div class="condition_s sub">														
	<input type="submit" value=""/>						
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<div class="action_div action_state">								
<span class="addlevel_s add on">添加
</span>
<span class="addlevel_s edit_a">修改
</span>
<span class="addlevel_s action_del" >删 除
</span>				
</div>				
<div class="table_height">								
	<table class="table_detail">						
		<thead>							
		<tr>								
	<th width="6%" class="t_back">序号
	</th>								
<th width="11%">类别
</th>								
<th width="30%" class="t_back">配置名称
</th>								
<th width="16%">配置值
</th>								
<th width="15%" class="t_back">备注
</th>																
<th>
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten">							
	<!-- 这里有两个效果，一个隔行换色td_back-->							
<?php if ($sysconfs) {
	foreach ($sysconfs as $key => $value ) {
		if ($value['type'] == '1') {
			$value['type'] = '文件类型';
		}
		else if ($value['type'] == '2') {
			$value['type'] = '案件类型';
		}
		else if ($value['type'] == '3') {
			$value['type'] = '标注类型';
		}
		else if ($value['type'] == '4') {
			$value['type'] = '故障类型';
		}
		//modify
		else if ($value['type'] == '5') {
			$value['type'] = '号码类型';
		}
		else if ($value['type'] == '6') {
			$value['type'] = '警情来源';
		}
		else if ($value['type'] == '7') {
			$value['type'] = '采集设备来源';
		}
		//
		else {
			$value['type'] = '';
		}

		if (($key % 2) == 1) {?>
			<tr class='tr_p td_back' date='<?php echo $value['id'] ;?>'>
		<?php }
		else {?>
			<tr class='tr_p' date='<?php echo $value['id'] ;?>'>
		<?php }?>

		<td><?php echo ($key + 1) ;?></td>
		<td><?php echo $value['type'] ;?></td>
		<td><?php echo $value['confname'];?></td>
		<td><?php echo  $value['confvalue'] ;?></td>
		<td><?php echo $value['note'];?></td>
		<?php echo $val;
	}
}
else {?>
	<tr class='td_back'><td colspan='8'>暂无记录</td></tr>
<?php }
?>

											
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
	<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="sysconf_add_form" id="sysconf_add_form">			
<div class="con_atten_wrap recorder_notice">					
	<div class="condition_top">						
		<div class="condition_345 condition_s">							
	<span class="condition_title">类别：
	</span>							
<font class="sign_d sign_star">*
</font>							
<div class="select_260 select_div">								
	<select class="easy_u" name="type" style="width:100%;">								
	<option value="">不限
	</option>								

<?php foreach ($config_types as $k => $v ) {?>
	
	<option value="<?php echo $k ;?>"

	<?php if (Zhimin::request('type') == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
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
	<span class="condition_title">配置名称：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" class="input_error" name="confname" value="" />				
<!-- 			
<span class="error_msg">请填写配置名称
</span>	 -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">配置值：
	</span>						
<font class="sign_d sign_star sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" class="input_error" name="confvalue" value="" />				
<!-- 			
<span class="error_msg">请填写配置值
</span>	 -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s condition_textarea condition_height">						
	<span class="condition_title">备注：
	</span>						
<font class="sign_d sign_star sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_days textarea_in">															
	<textarea class="input_error" name="note">
	</textarea>					
<!-- 		
<span class="error_msg">请填写备注
</span>	 -->						
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
	<span class="sure_add" id="add_sure">确 定
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
</span>修改
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form action="" method="post" name="sysconf_edit_form" id="sysconf_edit_form">			
		<div class="con_atten_wrap recorder_notice">					
		<div class="condition_top">						
		<div class="condition_345 condition_s">							
	<span class="condition_title">类别：
	</span>							
<font class="sign_d sign_star">*
</font>							
<div class="select_260 select_div">								
	<select class="easy_u" id="edit_type" name="type" style="width:100%;">								
	<option value="">不限
	</option>								

<?php foreach ($config_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"
	><?php echo $v;?>
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
	<span class="condition_title">配置名称：
	</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" id="edit_confname" class="input_error" name="confname" value="" />				
<!-- 			
<span class="error_msg">请填写配置名称
</span>	 -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">配置值：
	</span>						
<font class="sign_d sign_star sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_in">															
	<input type="text" id="edit_confvalue" class="input_error" name="confvalue" value="" />				
<!-- 			
<span class="error_msg">请填写配置值
</span>	 -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s condition_textarea condition_height">						
	<span class="condition_title">备注：
	</span>						
<font class="sign_d sign_star sign_star1">*
</font>						
<div class="select_260 select_div select_relative select_days textarea_in">															
	<textarea class="input_error" id="edit_note" name="note">
	</textarea>					
<!-- 		
<span class="error_msg">请填写备注
</span>	 -->						
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
<div class="notice_body1">			
	<div class="n_left">				
		<img src="./images/del_bg.png">			
</div>			
<div class="n_right">				
	<p>确定删除此条信息？
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
<!-- 编辑弹框 -->
<!-- 编辑弹框 取消在此页面 新建sysconfedit模板-->
<script type="text/javascript">
	$(document).ready(function(){	
		typeval=$("").val();	
		var n='<?php echo Zhimin::request('date_time');?>';
	if(n=='3'){		
		$(".condi_time").show();
	}else{
		$(".condi_time").hide();
	}	
		$(".easyui-combotree").combotree({
			url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>';      
	 });	
		$('.easy_u').combobox({
			panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'
		});	
		$('.easy_se').combobox({
			panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',	
			onChange: function (n,o) {		
				if(n=='3'){			
					$(".condi_time").show();		
				}else{			
					$(".condi_time").hide();		
				}	
			},	
			onLoadSuccess:function(data){ 		
				$('.easy_se').combobox('setValue',['<?php echo Zhimin::request('date_time');?>']);	
			}}
		);
		})
</script>
</body>
</html>

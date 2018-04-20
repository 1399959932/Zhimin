<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>考勤管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/workforce.js">
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
	<div class="condition_263 condition_s">							
	<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>						
</div>						
<div class="condition_175 condition_s">							
	<span class="condition_title">时间范围：
</span>							
<div class="select_112 select_div">								
	<select class="easy_se" name="date_time" style="width:100%;">									
	<option value="1" 
	<?php if (Zhimin::request('date_time') == '1') {?>
 selected
<?php }?>
>本周
</option>									
<option value="2" 


<?php if (Zhimin::request('date_time') == '2') {?>
 selected
 <?php }?>
>本月
</option>									
<option value="3" 


<?php if (Zhimin::request('date_time') == '3') {?>
 selected
 <?php 
}?>
>一段时间
</option>								
</select>							
</div>						
</div>						
<div class="condition_144 condition_s condition_t condi_time">							
	<span>至
</span>							
<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="sdate" name="sdate" value="<?php echo Zhimin::request('sdate');?>"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#sdate',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="edate" name="edate" value="<?php echo Zhimin::request('edate');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#edate',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>						
<div class="button_wrap">														
	<div class="button_excel" onclick="location.href='<?php 
echo Zhimin::buildUrl();?>&action=excel&danwei=<?php 
echo Zhimin::request('danwei');?>&sdate=<?php 
echo Zhimin::request('sdate');?>&edate=<?php 
echo Zhimin::request('edate');?>&classid=<?php 
echo Zhimin::request('classid');?>&date_time=<?php 
echo Zhimin::request('date_time');?>&usename=<?php 
echo Zhimin::request('usename');?>'">
</div>													
</div>						
<div class="clear">
</div>					
</div>					
<div class="condition_top">						
	<div class="condition_263 condition_s">							
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>姓名：
</span>							
<div class="select_200 select_div select_in">								
	<input type="text" id="usename" value="<?php echo Zhimin::request('usename');?>" name="usename" />							
</div>						
</div>						
<div class="condition_175 condition_s">							
	<span class="condition_title">状态：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="classid" style="width:100%;">								
	<option value="">不限
</option>								

<?php foreach ($classids as $k => $v ) {?>

	<option value="<?php echo $k ;?>"
	
	<?php if (Zhimin::request('classid') == $k) {?>
	 selected 
	<?php }?>

><?php echo  $v;?>
</option>
<?php }?>
								
</select>							
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
<!-- 	
<span class="edit">编辑
</span>					
<span class="delete">删除
</span>					
<span class="add">添加
</span>					
<span class="import">导入
</span>					
<span class="down_modul">下载模板
</span> -->					
<?php 
if ($user_auth['edit'] == 1) {?>

	<span class="edit">编  辑
	</span><?php 
}

if ($user_auth['delete'] == 1) {?>

	<span class="delete">删  除
	</span><?php 
}

if ($user_auth['add'] == 1) {?>

	<span class="add on">添  加
	</span><?php 
}

if ($user_auth['import'] == 1) {?>

	<span class="import on" id="excel_input">导  入
	</span><?php 
}

if ($user_auth['down_modul'] == 1) {?>

	<span class="down_modul on" >下载模板
	</span><?php 
}?>
				
</div>				
<div class="table_height">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th class="t_back" width="6%">序号
</th>								
<th width="11%"><?php echo  $_SESSION['zfz_type']; ?>（<?php echo  $_SESSION['zfz_type'];?>编号）
</th>								
<th class="t_back" width="17%">单位
</th>								
<th width="15%">考勤日期
</th>								
<th class="t_back" width="15%">开始时间
</th>								
<th width="15%">结束时间
</th>								
<th class="t_back" width="15%">时长
</th>								
<th>状态
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten tbody_on">							
	<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red 这里的date是数据库里对应的id之类的 -->							
<?php if ($workforces) {
	foreach ($workforces as $key => $value ) {
		$workforce_m = new WorkforceModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$workforce = $workforce_m->data_by_id($value['id']);
		$user_a = $user_m->get_by_name($workforce['creater']);
		$unit_a = $unit_m->get_by_sn($user_a['dbh']);
		$unit_c = $unit_m->get_by_sn($workforce['unitcode']);
		$workforce['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
		$workforce['unit_receive'] = ($workforce['unitcode'] == '' ? '所有单位' : $unit_c['dname']);
		$hour = floor(((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400) / 3600);

		if (0 < $hour) {
			$hour = ($hour < 10 ? '0' . $hour : $hour);
		}
		else {
			$hour = '00';
		}

		$minute = floor((((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400) / 60) % 60);

		if (0 < $minute) {
			$minute = ($minute < 10 ? '0' . $minute : $minute);
		}
		else {
			$minute = '00';
		}

		$second = floor((strtotime($value['endtime']) - strtotime($value['stattime'])) % 86400 % 60);

		if (0 < $second) {
			$second = ($second < 10 ? '0' . $second : $second);
		}
		else {
			$second = '00';
		}

		$workforce['time'] = $hour . ':' . $minute . ':' . $second;

		if ($value['classid'] == 1) {
			$value['classid'] = '休班/假';
		}
		else if ($value['classid'] == 2) {
			$value['classid'] = '上班';
		}
		else if ($value['classid'] == 3) {
			$value['classid'] = '会议';
		}
		else if ($value['classid'] == 4) {
			$value['classid'] = '公出';
		}

		if (($key % 2) == 1) {
			$val = '<tr class=\'tr_p td_back\' date=\'' . $value['id'] . '\'>';
		}
		else {
			$val = '<tr class=\'tr_p\' date=\'' . $value['id'] . '\'>';
		}

		$val .= '<td>' . ($key + 1) . '</td>';
		$val .= '<td>' . $value['usename'] . '(' . $value['usecode'] . ')</td>';
		$val .= '<td>' . $workforce['unit_receive'] . '</td>';
		$val .= '<td>' . $value['statdate'] . '</td>';
		$val .= '<td>' . $value['stattime'] . '</td>';
		$val .= '<td>' . $value['endtime'] . '</td>';
		$val .= '<td>' . $workforce['time'] . '</td>';
		$val .= '<td>' . $value['classid'] . '</td>';
		echo $val;
	}
}
else {
	echo '<tr class=\'td_back\'><td colspan=\'8\'>暂无记录</td></tr>';
}?>
										
</tbody>					
</table>				
</div>				
<div class="page_link">					
<?php 
$page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);	?>			
</div>			
</div>					
</div>		
<div class="detail_foot">			
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
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
	<p>确定删除？
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
<!-- 添加弹框 -->	
<div class="layer_notice atten_add">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>考勤添加
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="workforce_add_form" id="workforce_add_form">			
<div class="con_atten_wrap">				
	<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">								
	<input id="usecode" type="text" name="usecode" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">姓名：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">							
	<input id="usename" type="text" name="usename" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">单位：
</span>						
<font class="sign_d sign_star">*
</font>							
<div class="select_260 select_div">								
	<input id="danwei" class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">状态：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div">							
	<select class="easy_u" name="classid" style="width:100%;">							
	<option value="">不限
</option>							
<?php 
foreach ($classids as $k => $v ) {?>

	<option value="<?php echo $k;?>"

	<?php if (Zhimin::request('classid') == $k) {?>
	 selected
	<?php }?>

><?php echo $v; ?>
</option><?php 
}?>
							
</select>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">考勤日期：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_235 sele_c select_in select_time_i">								
	<input type="text" value="" name="statdate" id="statdate">							
</div>							
<div onclick="laydate({elem: '#statdate',istime: true,format: 'YYYY-MM-DD'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">开始时间：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_235 sele_c select_in select_time_i">								
	<input type="text" value="" name="stattime" id="stattime">							
</div>							
<div onclick="laydate({elem: '#stattime',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s">						
	<span class="condition_title">结束时间：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_235 sele_c select_in select_time_i">								
	<input type="text" value="" name="endtime" id="endtime">							
</div>							
<div onclick="laydate({elem: '#endtime',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_335 condition_s ">							
	<font class="sign_d sign_star">&nbsp;&nbsp;
</font>											
<div class="select_260 select_div select_in selec_text">							
	<input type="hidden" name="saveflag" value="">													
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
</span>编辑
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">			
	<form name="workforce_edit_form" id="workforce_edit_form">            
	<div class="con_atten_wrap recorder_notice">               
	<div class="condition_top">                    
	<div class="condition_345 condition_s">                        
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>                        
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">								
	<input type="text" id="edit_usecode" class="usecode" name="usecode" value="" />						
</div>                    
</div>                    
<div class="clear">
</div>                
</div>                
<div class="condition_top">                    
	<div class="condition_345 condition_s">                        
	<span class="condition_title">姓名：
</span>                        
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_in">							
	<input type="text" id="edit_usename" class="usename" name="usename" value="" />						
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
<div class="select_260 select_div select_in">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_edit"/>							
</div>                    
</div>                    
<div class="clear">
</div>                
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">状态：
</span>						
<font class="sign_d sign_star">*
</font>							
<div class="select_260 select_div">							
	<select class="easy_u" id="classid" name="classid" style="width:100%;">							
	<option value="">不限
</option>								
<?php 
foreach ($classids as $k => $v ) {?>

	<option value="<?php echo $k;?>" 
><?php echo $v;?>
</option><?php 
}?>
							
</select>						
</div>							
<span class="error_msg">请选择状态
</span>					
</div>					
<div class="clear">
</div>				
</div>                
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">考勤日期：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_238 sele_c select_in select_time_i">								
	<input type="text" value="" name="statdate" id="edit_statdate">							
</div>							
<div onclick="laydate({elem: '#edit_statdate',istime: true,format: 'YYYY-MM-DD'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">开始时间：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_238 sele_c select_in select_time_i">								
	<input type="text" value="" name="stattime" id="edit_stattime">							
</div>							
<div onclick="laydate({elem: '#edit_stattime',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">结束时间：
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_in">															
	<div class="select_238 sele_c select_in select_time_i">								
	<input type="text" value="" name="endtime" id="edit_endtime">							
</div>							
<div onclick="laydate({elem: '#edit_endtime',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});" class="select_time condition_end">
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>                
<div class="condition_top">                    
	<div class="condition_345 condition_s ">                        
	<font class="sign_d sign_star1">*
</font>                        
<div class="select_260 select_div select_in selec_text">                        	
	<input type="hidden" name="saveflag" value="saveflag" />                        	
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
<!-- 导入Excel提示框 -->	
<div class="layer_notice input_form">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<form action="<?php echo Zhimin::buildUrl();?>&action=import" method="post" enctype="multipart/form-data" name="excel_form" id="excel_form">		
<div class="notice_body action_state">			
	<input type="file" name="inputExcel" />			
<span class="addlevel_s on" id="excel_input_form">导入
</span>		
</div>		
</form>		
<div class="notice_foot">
</div>	
</div>	
<!-- 警告提示框 -->	
<div class="layer_notice lay_add">		
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
	<p>请勾选要删除的选项？
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
<!-- 成功提示框 -->	
<div class="layer_notice lay_success">		
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
		var n='<?php echo Zhimin::request('date_time');?>';	
		if(n=='3'){		
			$(".condi_time").show();		
		}else{		
			$(".condi_time").hide();	
		}	
		$(".easyui-combotree").combotree({
			url:'<?php echo Zhimin::buildUrl('unitjson', 'other');?>&id=bh&text=dname',
			method:'get',
			labelPosition:'top',
			panelWidth:'500px',	
			// 设置选中项	
			onLoadSuccess:function(node,data){		
				$(".easyui-combotree").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);      
			}  	
		});	
		$('.easy_u').combobox({
			panelHeight:'120px',
			selectOnNavigation:true,
			editable:false,
			labelPosition:'top'
		});	
		$('.easy_se').combobox({
			panelHeight:'80px',
			selectOnNavigation:true,
			editable:false,
			labelPosition:'top',	
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

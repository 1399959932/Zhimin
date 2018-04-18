<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>案件专题
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/case.js">
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
.tab_button{*margin-bottom: -6px;}	
</style>
</head>
<body class="main_body">	
<div class="detail">	
<?php include_once ('menu.php');?>

<div class="detail_top">			
<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
<div class="tabel_box">				
<form action="<?php echo Zhimin::buildUrl('casetopic', 'case', 'index');?>&action=search" method="post">					
<div class="condition_top con_zindex_1">						
<div class="condition_250 condition_s">							
<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" />							
</div>						
</div>											
<div class="condition_175 condition_s">							
<span class="condition_title">时间：
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
<?php }?>

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
<input type="text" id="start" name="start_date" value="<?php echo Zhimin::request('start_date');?>"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#start',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
<div class="select_130 select_div">								
<div class="select_105 sele_c select_in">									
<input id="end" type="text" name="end_date" value="<?php echo Zhimin::request('end_date');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>						
<div class="clear">
</div>					
</div>					
<div class="condition_top con_zindex_2">						
<div class="condition_250 condition_s">							
<span class="condition_title">关键字：
</span>							
<div class="select_200 select_div select_in">																
<input type="text" name="key" class="search_in"

<?php if (Zhimin::request('key') != '') {?>
style="color:#000" 
<?php }?>

value="<?php echo Zhimin::request('key') == '' ? '主题、简要警情' : Zhimin::request('key');?>"/>							
</div>						
</div>						
<div class="condition_175 condition_s conditon_hidden">							
<span class="condition_title">案件类型：
</span>							
<div class="select_112 select_div">								
<select class="easy_u" name="sort" style="width:100%;">								
<option value="">不限
</option>								

<?php foreach ($casetaxon as $k => $v ) {?>

<option value="<?php echo $k;?>"

<?php if (Zhimin::request('sort') == $k) {?>
	selected
<?php }?>

><?php echo $v;?>
</option>
<?php }?>


</select>							
</div>						
</div>						
<div class="condition_165 condition_s">							
<span class="condition_title">接警单号：
</span>							
<div class="select_100 select_div select_in">								
<input type="text" value="<?php echo Zhimin::request('odd_num');?>" name="odd_num">							
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

<?php if ($user_auth['add'] == 1) {?>

<span class="add_s on" date="<?php echo Zhimin::buildUrl('caseadd');?>">添&nbsp;&nbsp;加
</span>				
<?php }?>

<?php if ($user_auth['edit'] == 1) {?>

<span class="edit_s" date="<?php echo Zhimin::buildUrl('caseedit');?>">修&nbsp;&nbsp;改
</span>			
<?php }?>

<?php if ($user_auth['del'] == 1) {?>

<span class="del_s">删&nbsp;&nbsp;除
</span>
<?php }?>


</div>				
<div class="table_height">								
<table class="table_detail">						
<thead>							
<tr>								
<th class="t_back" width="6%">序号
</th>								
<th width="12%">接警单号
</th>								
<th class="t_back" width="17%">单位
</th>								
<th width="11%">主题
</th>								
<th class="t_back" width="12%">案件类型
</th>								
<th width="12%">发生时间
</th>								
<th class="t_back">
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten">							
<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->

<?php foreach ($datas as $k => $v ) {
if (($k % 2) == 0) {
?>

<tr date="<?php echo $v['id'];?>">								
<td>
<?php echo $k + 1;?>

</td>								
<td>
<?php echo $v['pnumber'];?>

</td>								
<td>
<?php echo $v['unitname'];?>

</td>								
<td>
<?php echo $v['title'];?>

</td>								
<td>
<?php echo $v['confname'];?>

</td>								
<td>
<?php echo date('Y-m-d', $v['occurtime']);?>

</td>								
<td>
</td>							
</tr>							
<?php 
}
else {
?>
<tr class="td_back" date="<?php echo $v['id'];?>
">								
<td>									
<?php echo $k + 1;?>

</td>								
<td>
<?php echo $v['pnumber'];?>

</td>								
<td>
<?php echo $v['unitname'];?>

</td>								
<td>
<?php echo $v['title'];?>

</td>								
<td>
<?php echo $v['confname'];?>

</td>								
<td>
<?php echo date('Y-m-d', $v['occurtime']);?>

</td>								
<td>
</td>							
</tr>
<?php }
}?>


<!-- 没有记录时输出 -->							

<?php if (empty($datas)) {?>

<tr class="td_back">								
<td colspan="7">暂无记录
</td>							
</tr>							
<?php }?>

		
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
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm lay_confirm_del">		
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
<span class="sure_span sure_btn_del">确 定
</span>				
<span class="cancle_span close_btn">取 消
</span>			
</div>		
</div>		
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
<div class="notice_body1">			
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
<span class="cancle_span close_btn">确 定
</span>			
</div>		
</div>		
<div class="notice_foot">
</div>	
</div>	
<!-- 修改框 -->	
<div class="lay_edit" style="display:none">	
<div class="iframe_top">
<span style="display: inline-block;width:15px;">
</span>修改
<span class="close close_btn">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="iframe_body iframe_body01">		
<div class="addCase_wrap">			
<form id="caseadd_edit">			
<div class="condition_top con_zindex_1">				
<div class="condition_357 condition_s case_conditon">					
<span class="condition_title">接警单号：
</span>					
<font>
</font>					
<div class="select_280 select_div select_relative select_in">														
<input type="text" id="edit_pnum" class="input_error" name="pnumber" value="" />						
<span class="error_msg">请填写接警单号
</span>					
</div>										
</div>				
<div class="condition_350 condition_s case_conditon">					
<span class="condition_title">接警<?php echo $_SESSION['zfz_type']; ?>：
</span>					
<div class="select_280 select_div select_in select_relative">														
<input type="text" class="input_error" name="brains" id="edit_brain" value="" />					
</div>										
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top con_zindex_2">				
<div class="condition_357 condition_s case_conditon">					
<span class="condition_title">主题：
</span>					
<font>
</font>					
<div class="select_280 select_div select_relative select_in">														
<input type="text" class="input_error" name="ptitle" id="edit_title" value="" />						
<span class="error_msg">请填写主题
</span>					
</div>										
</div>				
<div class="condition_357 condition_s case_conditon">					
<span class="condition_title">单位：
</span>					
<font>
</font>					
<div class="select_280 select_div">						
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_edit" />						
<span class="error_msg">请选择单位
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top con_zindex_3">				
<div class="condition_357 condition_s case_conditon">					
<span class="condition_title">案件类型：
</span>					
<font>
</font>						
<div class="select_280 select_div">							
<select class="easy_u" id="edit_group" name="casetaxon" style="width:100%;">							
<option value="">请选择
</option>						

<?php foreach ($casetaxon as $k => $v ) {?>

<option value="<?php echo $k ;?>"

<?php if (Zhimin::request('sort') == $k) {?>
	selected
<?php }?>

><?php echo $v;?>
</option>
<?php }?>


</select>							
<span class="error_msg">请选择案件类型
</span>						
</div>										
</div>					
<div class="condition_357 condition_s case_conditon">						
<span class="condition_title">发生时间&nbsp;:
</span>						
<font>
</font>						
<div class="select_280 select_div select_in">							
<div class="select_260 sele_c select_in select_time_i">								
<input class="select_235" type="text" id="e_startup_time" name="occurtime" value="" />							
</div>							
<div class="select_time condition_end" onclick="laydate({elem: '#e_startup_time',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});">
</div>						
</div>					
</div>					
<div class="clear">
</div>							
</div>			
<div class="condition_top">				
<div class="condition_350 condition_s case_conditon">					
<span class="condition_title">简要警情：
</span>					
<div class="select_280 select_div select_in">														
<input type="text" id="edit_subject" name="subject" value="" />					
</div>										
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
<div class="condition_723 condition_s case_conditon">					
<span class="condition_title">案件描述：
</span>					
<div class="select_653 select_div select_in">														
<textarea name="note" id="edit_note" cols="30" rows="10">
</textarea>					
</div>										
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
<div class="condition_350 condition_s case_conditon">					
<span class="condition_title">相关视频：
</span>					
<div class="select_280 select_div select_in selec_text">														
<span class="video_add" id="edit_video_add" date="">
</span>					
</div>										
</div>				
<div class="clear">
</div>			
</div>			
<div class="table_height case_table_h">							
<table class="table_detail">					
<thead>						
<tr>							
<th class="t_back" width="6%">序号
</th>							
<th width="10%">操作
</th>							
<th class="t_back" width="16%">发布<?php echo $_SESSION['zfz_type'];?>（<?php echo $_SESSION['zfz_type']; ?>编号）
</th>							
<th width="19%">单位
</th>							
<th class="t_back" width="12%">记录仪编号
</th>							
<th width="23%">摄录时间（摄录时长）
</th>														
</tr>					
</thead>					
<tbody id="video_edit_body">						
<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->										
</tbody>				
</table>			
</div>			
<div class="button_case">				
<input type="hidden" name="id" id="edit_id" value="" />				
<span class="sure_add" id="sure_edit_case">确 定
</span>				
<span class="sure_cancle close_btn">取 消
</span>			
</div>			
</form>		
</div>	
</div>	
<div class="iframe_foot iframe_foot01">
</div>	
</div>	
<!-- 修改相关视频框 -->	
<div class="lay_video" style="display:none;">	
<div class="iframe_top">
<span style="display: inline-block;width:15px;">
</span>添加相关视频
<span class="close close_btns">
<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="iframe_body iframe_body01">		
<div class="addCase_wrap">			
<form id="form_v_edit">			
<div class="condition_top">				
<div class="condition_240 condition_s case_conditon">					
<span class="condition_title">单位：
</span>					
<div class="select_200 select_div">						
<input class="easyui-combotree" id="danwei_insert" name="danwei" data-options="" style="width:100%;" />					
</div>				
</div>				
<div class="condition_s">					
<span class="condition_title">时间：
</span>				
</div>				
<div class="condition_144 condition_s condition_t">					
<span>至
</span>					
<div class="select_130 select_div">						
<div class="select_105 sele_c select_in">							
<input type="text" id="starts" name="sdate" value="<?php echo Zhimin::request('sdate');?>"  />						
</div>						
<div class="select_time condition_start" onclick="laydate({elem: '#starts',format: 'YYYY-MM-DD'});">
</div>					
</div>											
</div>								
<div class="condition_130 condition_s">												
<div class="select_130 select_div">						
<div class="select_105 sele_c select_in">							
<input id="ends" type="text" name="edate" value="<?php echo Zhimin::request('edate');?>" />						
</div>						
<div class="select_time condition_end" onclick="laydate({elem: '#ends',format: 'YYYY-MM-DD'});">
</div>					
</div>				
</div>				
<div class="button_wrap sub">												
<!--  
<input type="submit" id="button_look" value="">-->					
<input type="button" id="edit_look" value="" />				
</div>				
<div class="clear">
</div>			
</div>			
</form>			
<form id="vid_form" action="" method="post">			
<div class="table_height case_table_add">							
<table class="table_detail">					
<thead>						
<tr>							
<th class="t_back" width="6%">序号
</th>							
<th width="11%">操作
</th>							
<th class="t_back" width="14%">发布<?php echo $_SESSION['zfz_type']; ?>（<?php echo $_SESSION['zfz_type'];?>编号）
</th>							
<th width="19%">单位
</th>							
<th class="t_back" width="12%">记录仪编号
</th>							
<th width="24%">摄录时间（摄录时长）
</th>														
</tr>					
</thead>					
<tbody id="edit_vi_form">					
<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->					
</tbody>				
</table>			
</div>			
<div id="pagecount">
</div> 			
<div class="button_case" style="margin:auto !important;">				
<span class="sure_add" id="edit_video_submit">确 定
</span>				
<span class="sure_cancle close_btns">取 消
</span>			
</div>			
</form>		
</div>	
</div>	
<div class="iframe_foot iframe_foot01">
</div>	
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var n='<?php $date_time;?>';
		if(n=='3'){	
			$(".condi_time").show();	
	}else{	
		$(".condi_time").hide();
	}
	$(".easyui-combotree").combotree({
		url:"<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname",
		method:'get',labelPosition:'top',panelWidth:'500px',
		// 设置选中项
		onLoadSuccess:function(node,data){	
			$(".easyui-combotree").combotree('setValues', ['<?php echo $danwei_default;?>']);      
		}  
	});
	$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});
	$('.easy_se').combobox({panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',
		onChange: function (n,o) {	
			if(n=='3'){		
				$(".condi_time").show();	
			}else{		
				$(".condi_time").hide();	
			}
		},
		onLoadSuccess:function(data){ 	
			$('.easy_se').combobox('setValue',[n]);
		}}
	);
})
</script>

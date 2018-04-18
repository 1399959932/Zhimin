<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>趋势对比图
</title>		
<script >	
	var datas = eval( '(' + '<?php echo $datas;?>' + ')' );	
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/echarts.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/line4.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />		
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>	
<style>	.addlevel_s{width: auto;padding:0 5px;}	
</style>
</head>
<?php $arr_date = array('1' => '最近一周', '2' => '最近一月', '3' => '最近一年');
$arr_stattype = array('1' => '文件总个数', '2' => '视频总时长');
?>
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
<div class="condition_175 condition_s">							
	<span class="condition_title">类别：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="querytype" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('querytype') == '1') {?>
	 selected
<?php }?>

>文件总个数
</option>									
<option value="2" 

<?php if (Zhimin::request('querytype') == '2') {?>
	 selected
<?php }?>

>视频总时长
</option>								
</select>							
</div>						
</div>						
<div class="condition_175 condition_s">							
	<span class="condition_title">查询类别：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="date_time" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('date_time') == '1') {?>
	 selected
<?php }?>

>最近一周
</option>									
<option value="2" 

<?php if (Zhimin::request('date_time') == '2') {?>
	 selected
<?php }?>

>最近一月
</option>									
<option value="3" 

<?php if (Zhimin::request('date_time') == '3') {?>
	 selected
<?php }?>

>最近一年
</option>								
</select>							
</div>						
</div>												
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>						
<div class="button_wrap">														
<!-- 
<div class="button_excel" onclick="location.href='#'">
</div>														
<div class="button_help" date="./help.php">
</div>	 -->												
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<!-- 
<div class="action_div">					
<span class="addlevel_s">文件总个数
</span>					
<span class="addlevel_s">视频总时长
</span>					
<span class="addlevel_s">抽查总个数
</span>					
<span class="addlevel_s">抽查总时长
</span>					
<span class="addlevel_s">抽查个数比例
</span>					
<span class="addlevel_s">标注总个数
</span>					
<span class="addlevel_s">标注总时长
</span>					
<span class="addlevel_s">标注个数比例
</span>				
</div> -->				
<div class="">								
	<div id="canvas10" style="height:450px;width:100%;">
</div>				
</div>			
</div>					
</div>		
<div class="detail_foot">			
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
</div>			
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function (){
		$("#easyui_search").combotree({
			url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=unitsyscode&text=dname',
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
	});
	/*add tree end*/	
	$('.easy_u').combobox({
		panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'
	});			
})
</script>
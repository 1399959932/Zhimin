<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>资产统计
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
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
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>						
<div class="button_wrap">														
	<div class="button_excel" onclick="location.href='<?php echo Zhimin::buildUrl();?>&action=search&danwei=<?php echo Zhimin::request('danwei');?>&excel=yes'"></div>
</div>														
<!-- 
<div class="button_help" date="./help.php">
</div>	 -->												
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<div class="table_height" style="overflow: hidden;">					
	<table class="table_detail table_diff">						
	<thead>							
	<tr>								
	<th class="t_back" width="6%">序号
</th>								
<th width="17%">部门
</th>								
<th class="t_back" width="7%"><?php echo $_SESSION['zfz_type'] ;?>人数
</th>								
<th width="7%">工作站台数
</th>								
<th class="t_back" width="7%">执法仪个数
</th>								
<th width="11%">采集工作站容量
</th>								
<th class="t_back" width="8%">采集站已使用容量
</th>								
<th width="10%">记录仪保修
</th>								
<th class="t_back" width="10%">记录仪报废
</th>							
</tr>						
</thead>						
<tbody>	
<?php $i = 1;

foreach ($datas as $k => $data ) {?>
									
	<tr class="tr_bg0<?php echo $data['jibie'];?>">								
	<td>
	<?php echo $i;?>
</td>									
	<td>
	<?php echo $data['unitname'];?>	
</td>									
	<td>
	<?php echo $data['usernum'];?>
</td>									
	<td>
	<?php echo $data['stationnum'];?>
</td>									
	<td>
	<?php echo $data['bodynum'];?>
</td>									
	<td>
	<?php echo round($data['stationtotsize'] / 1024, 2) . ' G';?>
</td>									
	<td>
	<?php echo round(($data['stationtotsize'] - $data['stationfreesize']) / 1024, 2) ;?> G
</td>									
	<td>
	<?php echo $data['bodyzhangnum'];?>
</td>									
	<td>
	<?php echo $data['bodyfeinum'];?>
</td>								
</tr>				
	<?php $i++;
}


if (empty($datas)) {?>
								
	<!-- 没有记录时输出 -->							
	<tr class="td_back">								
		<td colspan="11">暂无记录
	</td>							
</tr>							
<?php }?>

												
</tbody>					
</table>				
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
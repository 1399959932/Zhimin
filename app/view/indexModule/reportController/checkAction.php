<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>基本数据统计
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
<style>	.condition_s{*margin-right: 11px;}	
</style>
</head>
<?php $arr_date = array('1' => '本周', '2' => '本月', '3' => '一段时间');
$arr_stattype = array('1' => '单位', '2' => '个人');?>
<body class="main_body">	
	<div class="detail">		
<?php include_once ('menu.php');?>				
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box surpervision">				
	<form action="<?php echo Zhimin::buildUrl();?>&action=search" method="post">					
<div class="condition_top con_zindex_1">						
	<div class="condition_263 condition_s">							
	<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>						
</div>												
<div class="condition_175 condition_s">							
	<span class="condition_title">统计类别：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="stattype" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('stattype') == '1') {?>
 selected
<?php }?>
>单位
</option>									
<option value="2" 

<?php if (Zhimin::request('stattype') == '2') {?>
 selected
<?php }?>
>个人
</option>								
</select>							
</div>						
</div>												
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>															
<div class="button_wrap">														
	<div class="button_excel" onclick="location.href='<?php echo Zhimin::buildUrl();?>&action=search&danwei=<?php echo Zhimin::request('danwei');?>&stattype=<?php echo Zhimin::request('stattype');?>&date_time=<?php echo Zhimin::request('date_time');?>&enddate=<?php echo Zhimin::request('enddate');?>&startdate=<?php echo Zhimin::request('startdate');?>&excel=yes'">
	</div>														 
<!-- 
<div class="button_help" date="Zhimin::buildUrl('help', 'report', 'index');">
</div> 	 -->											
</div>						
<div class="clear">
</div>					
</div>					
<div class="condition_top">						
	<div class="condition_175 condition_s">							
	<span class="condition_title">时间范围：
</span>							
<div class="select_112 select_div">								
	<select class="easy_se" name="date_time" style="width:100%;">									
	<option value="1" 
<?php if ((Zhimin::request('date_time') == '1') || ($date_time == '1')) {?>
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
	<input type="text" id="start" name="startdate" value="<?php echo Zhimin::request('startdate');?>"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#start', format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input id="end" type="text" name="enddate" value="<?php echo Zhimin::request('enddate');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end', format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>												
<div class="clear">
</div>					
</div>				
</form>				
<div class="table_height">								

<?php if (Zhimin::request('stattype') == '2') {?>
					
	<table class="table_detail table_diff">						
		<thead>							
		<tr>								
		<th class="t_back" width="6%">序号
	</th>								
	<th width="17%">部门名称
	</th>								
	<th class="t_back" width="17%"><?php echo $_SESSION['zfz_type'];?>姓名(<?php echo $_SESSION['zfz_type'] ;?>编号)
	</th>								
	<th width="7%">视频个数
	</th>								
	<th class="t_back" width="7%">音频个数
	</th>								
	<th width="7%">图片个数
	</th>								
	<th class="t_back" width="10%">视频总时长(小时)
	</th>								
	<th width="7%">视频总容量(G)
	</th>								
	<th width="10%" class="t_back">音频总容量(G)
	</th>								
	<th>图片总容量(G)
	</th>							
</tr>						
</thead>						
	<tbody>												
	<?php $i = 0;

	foreach ($datas as $k => $data ) {
		if (($i % 2) == 0) {?>
									
			<tr class="tr_p">						
		<?php }
		else {?>
									
			<tr class="tr_p td_back">						
		<?php }?>

									
		<td>
		<?php echo $i + 1;?>
	
	</td>																
		<td>									
		<?php echo $data['dname'];?>
									
	</td>								
		<td>
		<?php echo $userarray[$data['usecode']];?>(<?php echo $data['usecode'];?>);?>
	
	</td>																
		<td>
		<?php echo $data['vedionum'];?>
	
	</td>																
		<td>
		<?php echo $data['audionum'];?>
	
	</td>																
		<td>
		<?php echo $data['photonum'];?>
	
	</td>																
		<td>
		<?php echo round($data['videotime'] / 3600, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['vediosize'] / 1024, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['audiosize'] / 1024, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['photosize'] / 1024, 4);?>
	
	</td>											
	</tr>							
		<?php $i++;
	}

														

	if (empty($datas)) {?>
	 							
		<tr class="td_back">								
			<td colspan="14">暂无记录
		</td>							
	</tr>								
	<?php }?>

																	
</tbody>					
</table>								
<?php }
else {?>
												
	<table class="table_detail">						
		<thead>							
		<tr>								
		<th class="t_back" width="6%">序号
	</th>								
	<th width="17%">部门/<?php echo $_SESSION['zfz_type']?>姓名
	</th>								
	<th class="t_back" width="7%">工作站个数
	</th>								
	<th width="7%"><?php echo $_SESSION['zfz_type']?>人数
	</th>								
	<th class="t_back" width="7%">执法仪个数/启用率
	</th>								
	<th width="7%">视频个数
	</th>								
	<th class="t_back" width="7%">音频个数
	</th>								
	<th width="7%">图片个数
	</th>								
	<th class="t_back" width="10%">视频总时长(小时)
	</th>								
	<th width="7%">视频总容量(G)
	</th>								
	<th width="10%" class="t_back">音频总容量(G)
	</th>								
	<th>图片总容量(G)
	</th>							
</tr>						
</thead>						
	<tbody>												
	<?php $i = 0;

	foreach ($datas as $k => $data ) {
		if ($data['parenttype'] == '0') {?>
									
			<tr class="td_child">						
		<?php }
		else if (($i % 2) == 0) {?>
									
			<tr class="tr_p">						
		<?php }
		else {?>
									
			<tr class="tr_p td_back">						
		<?php }?>

									
		<td>									
		<?php echo $i + 1;?>
									
	</td>								
		<td>									

		<?php if ($data['parenttype'] == '0') {?>
												
			<span class="tr_span">									
		<?php }
		else {?>
												
			<span class="tr_parent tr_span">									
		<?php }?>

										
		<i>
		</i>
		<?php echo $data['unitname'];?>
	
	</span>								
	</td>								
		<td>									
		<?php echo $data['stationnum'];?>
									
	</td>								
		<td>
		<?php echo $data['usernum'];?>
	
	</td>																
		<td>

		<?php if(!empty($data['usebodynum'])){?>
			<?php echo $data['bodynum'];  ?> '/'
			<?php echo round(
				($data['usebodynum'] / $data['bodynum']*100), 
				2).'%';?>
				
			

		<?php }else{ ?>
			<?php echo $data['bodynum'] . '/0%';?>
		<?php }?>
		
	
	</td>																
		<td>
		<?php echo $data['videonum'];?>
	
	</td>																
		<td>
		<?php echo $data['audionum'];?>
	
	</td>																
		<td>
		<?php echo $data['photonum'];?>
	
	</td>																
		<td>
		<?php echo round($data['videotime'] / 3600, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['videosize'] / 1024, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['audiosize'] / 1024, 3);?>
	
	</td>																
		<td>
		<?php echo round($data['photosize'] / 1024, 4);?>
	
	</td>														
	</tr>							
		<?php $i++;
	}

														

	if (empty($datas)) {?>
	 							
		<tr class="td_back">								
			<td colspan="14">暂无记录
		</td>							
	</tr>								
	<?php }?>

																						
</tbody>					
</table>					
<?php }?>
				
</div>							
</div>					
</div>		
<div class="detail_foot">			
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
</div>			
</div>
</body>
</html>

<!-- 第三个js -->
<script type="text/javascript">
$(document).ready(function (){	
	//此处的js主要是为了解决当时间范围为【一段时间】时，展开时间段框	
	var date_time = '<?php echo Zhimin::request('date_time');?>';	
	if(date_time == 3){		
		$(".condi_time").show();	
	}else{		
		$(".condi_time").hide();	
	}	
	$("#easyui_search").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=unitsyscode&text=dname',
		method:'get',
		labelPosition:'top',
		panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$("#easyui_search").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);      
		}  
	});  
	/*search list tree end*/ 	
	/*add tree*/	
	$("#easyui_add").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=unitsyscode&text=dname',
		method:'get',
		labelPosition:'top',
		panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$("#easyui_add").combotree('setValues', ['']);      
		}  	
	});
	/*add tree end*/	
	$('.easy_u').combobox({
		panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'
	});	
	var n='<?php echo $date_time;?>';	
	if(n=='3'){		
		$(".condi_time").show();		
	}else{		
		$(".condi_time").hide();	
	}	
	$(".easyui-combotree").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=unitsyscode&text=dname',
		method:'get',
		labelPosition:'top',
		panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$(".easyui-combotree").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>'
			]);      
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
			$('.easy_se').combobox('setValue',[n]);	
		}	
	});
})
</script>
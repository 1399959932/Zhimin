<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>监督考评
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
<div class="condition_top">						
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
	<input type="text" id="start" name="startdate" value="<?php echo Zhimin::request('startdate');?>"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#start',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
		<div class="select_105 sele_c select_in">									
	<input id="end" type="text" name="enddate" value="<?php echo Zhimin::request('enddate');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>												
<div class="clear">
</div>					
</div>				
</form>				
<div class="table_height">									

<?php if (Zhimin::request('stattype') == '2') {?>
					
	<table class="table_detail">						
		<thead>							
			<tr>								
		<th class="t_back" rowspan="2" width="18%">单位名称
		</th>								
	<th width="8%" rowspan="2"><?php echo $_SESSION['zfz_type'];?>姓名
	</th>								
	<th class="t_back" width="18%" colspan="3">摄录天数
	</th>								
	<th width="19%" colspan="3">摄录时长(小时)
	</th>								
	<th class="t_back" width="19%" colspan="3">摄录时长低于90%
	</th>								
	<th colspan="3">晚于24小时上传
	</th>							
</tr>							
<tr>								
		<th class="t_color1">摄录天数
		</th>								
	<th class="t_color2">总天数
	</th>								
	<th class="t_color3">天数比率
	</th>								
	<th class="t_color4">摄录时长
	</th>								
	<th class="t_color5">总时长
	</th>								
	<th class="t_color6">时长比率
	</th>								
	<th class="t_color1">天数
	</th>								
	<th class="t_color2">总天数
	</th>								
	<th class="t_color3">天数比率
	</th>								
	<th class="t_color4">视频数
	</th>								
	<th class="t_color5">总视频数
	</th>								
	<th class="t_color6">上传比率
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
		<?php echo $data['dname'];?>
									
	</td>								
		<td>
		<?php echo $userarray[$data['hostcode']];?>(<?php echo  $data['hostcode'];?>)
	
	</td>																
		<td>
		<?php echo $data['num1'];?>
	
	</td>																
		<td>
		<?php echo $days;?>
	
	</td>																
		<td>
		<?php echo round(($data['num1'] / $days) * 100, 2) . '%';?>
	
	</td>																
		<td class="">
		<?php echo round($data['vtl'], 2);?>
	
	</td>								
		<td>
		<?php echo $days * 8;?>
	
	</td>																
		<td>
		<?php echo round(($data['vtl'] / ($days * 8)) * 100, 2) . '%';?>
	
	</td>																
		<td>
		<?php echo $data['diyu90'];?>
	
	</td>								
		<td>
		<?php echo $days;?>
	
	</td>								
		<td>
		<?php echo round(($data['diyu90'] / $days) * 100, 2) . '%';?>
	
	</td>																
		<td>
		<?php echo $data['wvn'];?>

	</td>								
		<td>
		<?php echo $data['vtn'];?>
	
	</td>								
		<td>
		<?php echo round(($data['wvn'] / $data['vtn']) * 100, 2) . '%';?>
	
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
		<th class="t_back" rowspan="2" width="18%">部门<?php echo $_SESSION['zfz_type'];?>/姓名
		</th>								
	<th width="8%" rowspan="2">记录仪台数
	</th>								
	<th class="t_back" width="18%" colspan="3">摄录天数
	</th>								
	<th width="19%" colspan="3">摄录时长(小时)
	</th>								
	<th class="t_back" width="19%" colspan="3">摄录时长低于90%
	</th>								
	<th colspan="3">晚于24小时上传
	</th>							
</tr>							
<tr>								
		<th class="t_color1">摄录天数
		</th>								
	<th class="t_color2">总天数
	</th>								
	<th class="t_color3">天数比率
	</th>								
	<th class="t_color4">摄录时长
	</th>								
	<th class="t_color5">总时长
	</th>								
	<th class="t_color6">时长比率
	</th>								
	<th class="t_color1">天数
	</th>								
	<th class="t_color2">总天数
	</th>								
	<th class="t_color3">天数比率
	</th>								
	<th class="t_color4">视频数
	</th>								
	<th class="t_color5">总视频数
	</th>								
	<th class="t_color6">上传比率
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
		<?php echo $data['bodynum'];?>
									
	</td>								
		<td>
		<?php echo $data['videoday'];?>
	
	</td>																
		<td>
		<?php echo $data['totalday'] * $data['bodynum'];?>
	
	</td>																
		<td>
		<?php echo round(($data['videoday'] / $data['totalday'] / $data['bodynum']) * 100, 2) . '%';?>
	
	</td>																
		<td>
			<a  class="td_corsur">
			<span class="trends_map" date="<?php 
		echo Zhimin::buildUrl('supchat', 'sup', 'index', 'type=1&unitcode=' . $k . '&st=' . $startdate . '&ed=' . $enddate);?>
	">
		<?php echo round($data['videotime'], 2);?>
	
	</span>
	</a>
</td>								
		<td>
		<?php echo $data['totaltime'] * $data['bodynum'];?>
	
	</td>								
		<td>
		<?php echo round(($data['videotime'] / $data['totaltime'] / $data['bodynum']) * 100, 2) . '%';?>
	
	</td>																
		<td>
			<a  class="td_corsur">
			<span class="trends_map" date="<?php 
		echo Zhimin::buildUrl('supchat', 'sup', 'index', 'type=2&unitcode=' . $k . '&st=' . $startdate . '&ed=' . $enddate);?>
	">
		<?php echo $data['diyu90day'];?>
	
	</span>
	</a>
</td>								
		<td>
		<?php echo $data['totalday'] * $data['bodynum'];?>
	
	</td>																
		<td>
		<?php echo round(($data['diyu90day'] / $data['totalday'] / $data['bodynum']) * 100, 2) . '%';?>
	
	</td>																
		<td>
			<a class="td_corsur">
			<span class="trends_map" date="<?php 
		echo Zhimin::buildUrl('supchat', 'sup', 'index', 'type=3&unitcode=' . $k . '&st=' . $startdate . '&ed=' . $enddate);?>
	">
		<?php echo $data['wanyu24num'];?>
	
	</span>
	</a>
</td>								
		<td>
		<?php echo $data['totalnum'];?>
	
	</td>																
		<td>
		<?php echo round(($data['wanyu24num'] / $data['totalnum']) * 100, 2) . '%';?>
	
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


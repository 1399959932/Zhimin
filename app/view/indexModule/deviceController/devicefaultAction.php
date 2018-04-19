<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
	
<title>报障记录
</title>		
	
<script type="text/javascript" src="
<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
	
<script type="text/javascript" src="
<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
	
<script type="text/javascript" src="
<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
	
<script type="text/javascript" src="
<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
	
<link rel="stylesheet" type="text/css" href="
<?php Zhimin::g('assets_uri');?>style/reset.css" />	
	
<link rel="stylesheet" type="text/css" href="
<?php Zhimin::g('assets_uri');?>style/global.css" />	
	
<link rel="stylesheet" type="text/css" href="
<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
	
<link rel="stylesheet" type="text/css" href="
<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
	
<link rel="stylesheet" type="text/css" href="
<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
	
<script type="text/javascript" src="
<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">

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

<form action="
<?php Zhimin::buildUrl();?>" method="post">					

<div class="condition_top con_zindex_1">						

<div class="condition_250 condition_s">							

<span class="condition_title">单位：
</span>							

<div class="select_200 select_div">								

<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							

</div>						

</div>						

<div class="condition_175 condition_s">							

<span class="condition_title">配发<?php echo $_SESSION['zfz_type']?>：
</span>	
<div class="select_100 select_div select_in">								

<input type="text" name="hostname" value="<?php Zhimin::request('hostname');?>">							

</div>						

</div>												

<div class="condition_s" style="width:65px;margin-right:0;">							

<span class="condition_title">报障时间：
</span>						

</div>						

<div class="condition_s condition_t condition_144">							
<span>至
</span>							

<div class="select_130 select_div">								

<div class="select_105 sele_c select_in">									

<input type="text" value="
<?php Zhimin::request('sdate');?>" name="sdate" id="sdate">								

</div>								

<div onclick="laydate({elem: '#sdate',format: 'YYYY-MM-DD'});" class="select_time condition_start">
</div>							

</div>													

</div>						

<div class="condition_130 condition_s" style="display: block;">														
	
<div class="select_130 select_div">								
		
<div class="select_105 sele_c select_in">									
			
<input type="text" value="
<?php Zhimin::request('edate');?>" name="edate" id="edate">								
			
</div>								
			
<div onclick="laydate({elem: '#edate',format: 'YYYY-MM-DD'});" class="select_time condition_end">
</div>	
</div>						
			
</div>		
			
<div class="clear">
</div>					
			
</div>					
			
<div class="condition_top">						
				
<div class="condition_250 condition_s">							
					
<span class="condition_title">关键字：
</span>							
					
<div class="select_200 select_div select_in">								
						
<input type="text" value="
<?php Zhimin::request('reason');?>" name="reason">
					
</div>						
					
</div>						
					
<div class="condition_175 condition_s">							
						
<span class="condition_title">记录仪编号：</span>							
						
<div class="select_100 select_div select_in">												
	<input type="text" value="<?php Zhimin::request('hostbody');?>" name="hostbody">		
</div>						
					
</div>						
					
<div class="condition_s sub">														
						
<input type="submit" value="" />						
					
</div>						
					
<div class="clear">
</div>					

</div>				
</form>				
<div class="table_height">								
<table class="table_detail" style="width:100%;">						
<thead>							
<tr>								
<th class="t_back" width="5%">序号
</th>								
<th width="8%">报障人
</th>								
<th class="t_back" width="8%">配发<?php echo $_SESSION['zfz_type']?>
</th>								
<th width="17%">所属单位
</th>								
<th class="t_back" width="8%">记录仪编号
</th>								
<th width="8%">故障类型
</th>								
<th class="t_back" width="8%">报障时间
</th>								
<th width="8%">故障原因
</th>								
<th class="t_back" width="8%">预计启用时间
</th>								
<th width="11%">启用时间
</th>								
<th class="t_back" width="11%">备注
</th>			
</tr>						
</thead>						
<tbody>							
<!-- 这里有两个效果，一个隔行换色td_back-->							
<?php
if ($devicefaults) {
	foreach ($devicefaults as $key => $value ) {
		$device_m = new DeviceModel();
		$devicefault_m = new DevicerepairModel();
		$unit_m = new UnitModel();
		$sysconf_m = new SysconfModel();
		$devicefault = $devicefault_m->data_by_id($value['id']);
		$unit_a = $unit_m->get_by_sn($devicefault['unit_no']);
		$type = $sysconf_m->get_by_no($value['type']);
		$devicefault['unit_receive'] = ($devicefault['unit_no'] == '' ? '--' : $unit_a['dname']);
		$value['startup_time'] = ($value['startup_time'] == '' ? '' : $value['startup_time']);
		$value['startup_time'] = ($value['startup_time'] == '' ? '' : $value['startup_time']);

		if (($key % 2) == 1) {
			$val = '<tr class=\'tr_p td_back\' date=\'' . $value['id'] . '\'>';
		}
		else {
			$val = '<tr class=\'tr_p\' date=\'' . $value['id'] . '\'>';
		}

		$val .= '<td>' . ($key + 1) . '</td>';
		$val .= '<td>' . $value['report_user'] . '</td>';
		$val .= '<td>' . $value['hostname'] . '</td>';
		$val .= '<td>' . $devicefault['unit_receive'] . '</td>';
		$val .= '<td>' . $value['hostbody'] . '</td>';
		$val .= '<td>' . $type['confname'] . '</td>';
		$val .= '<td>' . date('Y-m-d', $value['report_date']) . '</td>';
		$val .= '<td>' . $value['reason'] . '</td>';
		$val .= '<td>' . date('Y-m-d', $value['e_startup_time']) . '</td>';
		$val .= '<td>' . date('Y-m-d H:i:s', $value['startup_time']) . '</td>';
		$val .= '<td>' . $value['remark'] . '</td>';
		echo $val;
	}
}
else {
	echo '<tr class=\'td_back\'><td colspan=\'10\'>暂无记录</td></tr>';
}
?>


</tbody>					
</table>				
</div>				
<div class="page_link">					
<?php echo $page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>

</div>	
</div>					
</div>		
<div class="detail_foot">			
<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
</div>			
</div>
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
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>	
<title>系统日志
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>
	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>/js/datamgr_syslog.js">
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
<div class="condition_top con_zindex_1">						
	<div class="condition_263 condition_s">							
	<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" />							
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
	<input type="text" id="sdate" name="sdate" value="<?php Zhimin::request('sdate');?>"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#sdate',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="edate" name="edate" value="<?php Zhimin::request('edate');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#edate',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>						
<div class="clear">
</div>					
</div>					
<div class="condition_top">						
	<div class="condition_263 condition_s">							
	<span class="condition_title">操作类型：
</span>							
<div class="select_200 select_div">								
	<select class="easy_u" name="sort" style="width:100%;">								
	<option value="">不限
</option>								

<?php foreach ($log_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"

	<?php if (Zhimin::request('sort') == $k) {?>
		 selected
	<?php }?>

	><?php echo  $v ?>
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
				
				<div class="action_div">
					
					<span class="select_all">全 选
					</span>
					
					<span class="delete_all">批量删除
					</span>
					
					<span class="down_all">批量导出
					</span>					
				
				</div>
				
<div class="table_height">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th class="t_back" width="5%">序号
</th>								
<th width="15%">所属单位
</th>								
<th class="t_back" width="10%"><?php echo $_SESSION['zfz_type'] ;?>姓名
	<br>（<?php echo $_SESSION['zfz_type'];?>编号）
</th>								
<th width="10%">操作类型
</th>								
<th class="t_back" width="10%">操作IP
</th>								
<th width="10%">操作时间
</th>								
<th class="t_back" width="30%">描述
</th>								
<th width="10%">文件信息
</th>															
</tr>						
</thead>						
<tbody>							

<?php if (empty($logs)) {?>
								
	<tr class="td_back">								
		<td colspan="8">暂无记录
	</td>							
</tr>							
<?php }
else {
	foreach ($logs as $k => $v ) {?>
									
		<tr class="tr_p 

		<?php if (($k % 2) == 1) {?>
			td_back
		<?php }?>

		">								
		<td>

		<!-- //modify -->
		
		<span class="check_span">								    	
			<input type="checkbox"  class="ipt-hide"  value="<?php echo $v['id'];?>">								        
		<label class="checkbox">
		</label>
		<?php echo $k + 1;?>
		
	</span>

		<!-- //echo $k + 1; -->
		
	</td>								
		<td>
		<?php echo $v['dname'];?>
		
	</td>								
		<td>
		<?php echo $v['realname'] == '' ? $v['username'] : $v['realname'];?>
		（
		<?php echo $v['hostcode'];?>
		）
	</td>																
		<td>
		<?php echo $log_types[$v['sort']];?>
		
	</td>																
		<td>
		<?php echo $v['net_ip'];?>
		
	</td>																
		<td>
		<?php echo date('Y-m-d H:i:s', $v['logtime']);
		?>
	</td>								
		<td>
		<?php echo $v['context'];?>
		
	</td>																
		<td>
		<?php echo $v['filename'];?>
		
	</td>															
	</tr>							
	<?php }
}?>

											
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

<!-- //modify -->

<!-- 确认提示框 -->
	
	<div class="layer_notice lay_confirm">
		
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
				
				<p>确定批量删除？
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
	
	
	<div class="layer_notice lay_confirm_down">
		
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
				
				<p>确定批量导出？
				</p>
				
				<div class="clear">
				</div>
				
				<span class="sure_span sure_btn_down">确 定
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
				
				<p>请至少勾选一个选项！
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
		
		<div class="notice_body">
			
			<div class="n_left">
				
				<img src="./images/success_bg.png">
			
			</div>
			
			<div class="n_right">
				
				<p>操作成功......
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
				
				<p>操作失败......
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
<!-- // -->


<script type="text/javascript">
	$(document).ready(function(){	
		var n="<?php echo $date_time;?>";	
		if(n=='3'){		
			$(".condi_time").show();		
		}else{		
			$(".condi_time").hide();	
		}	
		$(".easyui-combotree").combotree({
			url:"<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname",
			method:'get',
			labelPosition:'top',
			panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$(".easyui-combotree").combotree('setValues', ["<?php echo $danwei_default;?>"]);      
		}  	
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
	$('.easy_se').combobox('setValue',[n]);	}
});
})
</script>
</body>
</html>


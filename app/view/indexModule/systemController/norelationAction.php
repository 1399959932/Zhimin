<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>未关联文件
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/norelation.js">
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
<?php $media_types = Zhimin::g('media_type');?>
	
<div class="detail">		
<?php include_once ('menu.php');?>
		
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box">				
	<form id="search_form" name="search_form" method="post" action="<?php echo Zhimin::buildUrl('norelation', 'system', 'index');?>
&action=search">					
<div class="condition_top">							
	<div class="condition_s">							
<!-- 
<span class="check_span">						    	
<input type="checkbox" checked name="selid1" value="0000" class="ipt-hide"> 						        单位为空 
<label class="checkbox" checked>
</label>						    
</span> -->						    
<span class="check_span">						    	
	<lable for="danwei">单位为空
</lable>						    	
<input id="danwei" type="checkbox" 

<?php if (Zhimin::request('selid1')) {?>
	checked
<?php }?>

 name="selid1" value="0000"/>						    
</span>						
</div>							
<div class="condition_s">
<!-- 							
	<span class="check_span"> -->
<!-- 						    	
	<input type="checkbox" name="selid2" value="0000" class="ipt-hide" checked > -->
<!-- 						        ' . $_SESSION['zfz_type'] . '编号为空 
<label class="checkbox">
</label> -->
<!-- 						    
</span> -->						     
<span class="check_span">						    	
	<lable for="jinghao"><?php echo  $_SESSION['zfz_type'];?>编号为空
</lable>						    	
<input id="jinghao" type="checkbox" 

<?php if (Zhimin::request('selid2')) {?>
	checked
<?php }?>

 name="selid2" value="0000"/>						    
</span>						
</div>															
<div class="condition_175 condition_s">							
	<span class="condition_title">拍摄日期：
</span>							
<div class="select_112 select_div">								
	<select class="easy_se" name="date_time" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('date_time') == '1') {?>
	 selected
<?php }
?>
>本年
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
<div id="condi_time1" class="condition_144 condition_s condition_t condi_time">							
	<span>至
</span>							
<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="start" name="start_date" value="<?php echo Zhimin::request('start_date');?>
"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#start',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div id="condi_time2" class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input id="end" type="text" name="end_date" value="<?php echo Zhimin::request('end_date');?>
" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>						
<div class="condition_s sub">														
	<input type="submit" value="" id="submit">						
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<div class="action_div action_state">					

<?php if ($user_auth['edit_a'] == 1) {?>
	
	<span class="addlevel_s edit_a">关联
	</span>
<?php }?>

				
</div>				
<div class="table_height">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th class="t_back" width="6%">序号
</th>								
<th width="11%">操作
</th>								
<th class="t_back" width="14%">发布<?php echo $_SESSION['zfz_type'] ;?>（<?php echo  $_SESSION['zfz_type'];?>编号）
</th>								
<th width="19%">单位
</th>								
<th class="t_back" width="12%">记录仪编号
</th>								
<th width="24%">摄录时间（摄录时长）
</th>								
<th class="t_back" width="8%">媒体类型
</th>								
<th>
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten">							
	<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->							

<?php if (!empty($devices)) {
	foreach ($devices as $k => $v ) {
		$filetype = strtolower($v['filetype']);

		if (in_array($filetype, $media_types['video'])) {
			$filetypename = '视频';
		}
		else if (in_array($filetype, $media_types['audio'])) {
			$filetypename = '音频';
		}
		else if (in_array($filetype, $media_typies['photo'])) {
			$filetypename = '图片';
		}
		else {
			$filetypename = '其他';
		}

		if ($v['major'] != '1') {?>
										
			<tr date="
			<?php echo $v['id'];?>
			" 

			<?php if (($k % 2) == 1) {?>
				class="td_back"
			<?php }?>

			>								
			<td>									
			<?php echo $k + 1;?>
											
		</td>								
			<td>									
				<span class="action_span">										
				<a class="a_view" date="<?php
			echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $v['id']);?>
			">查看
		</a>										
		</span>								
		</td>								
			<td>
			<?php echo $v['hostname'] ?> ( <?php echo $v['hostcode'] ?> )
			
		</td>								
			<td>
			<?php echo $v['dname'];?>
			
		</td>								
			<td>
			<?php echo $v['hostbody'];?>
			
		</td>								
			<td>
			<?php echo $v['createdate']?> ( <?php echo getfiletime($v['playtime']) ?> ) 
			
		</td>								
			<td>
			<?php echo $filetypename;?>
			
		</td>								
			<td>
			</td>							
		</tr>							
		<?php }
		else {?>
										
			<tr class="td_back td_red" date="
			<?php echo $v['id'];?>
			" 

			<?php if (($k % 2) == 1) {?>
				class="td_back"
			<?php }?>

			>								
			<td>									
			<?php echo $k + 1;?>
											
		</td>								
			<td>									
				<span class="action_span">										
				<a class="a_view" date="<?php
			echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $v['id']);?>
			">查看
		</a>										
		</span>								
		</td>								
			<td>
			<?php echo $v['hostname']?> (<?php echo $v['hostcode']?> )
			
		</td>								
			<td>
			<?php echo $v['dname'];?>
			
		</td>								
			<td>
			<?php echo $v['hostbody'];?>
			
		</td>								
			<td>
			<?php echo $v['createdate']; ?> ( <?php echo getfiletime($v['playtime']); ?> ) 
			
		</td>								
			<td>
			<?php echo $filetypename;?>
			
		</td>								
			<td>
			</td>							
		</tr>							
		<?php }
	}
}
else {?>
													
	<!-- 没有记录时输出 -->							
	<tr class="td_back">								
		<td colspan="8">暂无记录
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
<!-- 关联弹框 -->	
<div class="layer_notice atten_add">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>关联
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body">		
	<form name="relation_form" id="relation_form">			
	<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">记录仪编号：
</span>						
<div class="select_260 select_div select_no">						
	<p id="devicenum">
</p>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>						
<div class="select_260 select_div select_in">															
	<input type="text" name="number" id="usecode" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title"><?php echo  $_SESSION['zfz_type'];?>姓名：
</span>						
<div class="select_260 select_div select_in">															
	<input type="text" name="policename" id="usename" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">单位编号：
</span>						
<div class="select_260 select_div select_in">															
	<input type="text" name="danweinumber" id="danwei" value="" />						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">												
	<div class="select_260 select_div select_in selec_text">							
	<!-- id -->							
<input type="hidden" name="media_id" id="mediaid" value="">							
<input type="hidden" name="hostbody" id="hostbody" value="">							
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
	<p id="success_flg_1">删除成功......
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
</body>
</html>	
<script type="text/javascript">
	$(document).ready(function(){
	var n='<?php echo Zhimin::request('date_time');?>';
	if(n=='3'){
		$(".condi_time").show();
		}else{
		$(".condi_time").hide();
	}
	$('.easy_se').combobox({panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',
	onChange: function (n,o) {
		if(n=='3'){
			$(".condi_time").show();
		}else{
			$(".condi_time").hide();
		}
	},
	onLoadSuccess:function(data){ 
		$('.easy_se').combobox('setValue',['<?php echo Zhimin::request('date_time');?>']);
	}
});
	})
</script>
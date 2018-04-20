<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>	
<title>数据管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/datamgr.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>
<style>#layui-layer-iframe1{position:relative;}
</style>	
</head>
<?php $media_typies = Zhimin::g('media_type');
$arr_zhouqi = array('0' => '不限', '1' => '本周', '2' => '本月', '3' => '一段时间');
$arr_zhongyao = array('-1' => '不限', '0' => '否', '1' => '是');
$arr_leixing = array('0' => '不限', '1' => '视频', '2' => '音频', '3' => '图片');
$arr_biaozhu = array('-1' => '不限', '0' => '未标注', '1' => '已标注');
?>
<body class="main_body">	
	<div class="detail">		
<!-- 
<div class="tab_button">			信息标注		
</div> -->		
<?php include_once ('menu.php');?>
		
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box">				
	<form action="<?php echo Zhimin::buildUrl();?>&action=search" method="post">					
<div class="condition_top">						
	<div class="condition_250 condition_s">							
	<span class="condition_title a_view">单位：
</span>							
<div class="select_200 select_div">								
	<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>						
</div>						
<div class="condition_165 condition_s">							
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>姓名：
</span>							
<div class="select_100 select_div select_in">								
<input type="text" name="hostname" value="<?php echo Zhimin::request('hostname');?>
" />							
</div>						
</div>												
<div class="condition_175 condition_s">							
	<span class="condition_title">拍摄时间：
</span>							
<div class="select_112 select_div">								
	<select class="easy_se" name="date_time" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('date_time') == '1') {?>
	 selected
<?php }
?>
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
	<input id="end" type="text" name="enddate" value="<?php echo Zhimin::request('enddate');?>
" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>					
<div class="clear">
</div>					
</div>					
<div class="condition_top conditon_hidden">						
	<div class="condition_250 condition_s">							
	<span class="condition_title"><?php echo $_SESSION['zfz_type'];?>编号：
</span>							
<div class="select_200 select_div select_in">																
<input type="text" name="hostcode" value="<?php echo Zhimin::request('hostcode');?>
" />							
</div>						
</div>												
<div class="condition_165 condition_s">							
	<span class="condition_title">设备编号：
</span>							
<div class="select_100 select_div select_in">								
<input type="text" name="hostbody" value="<?php echo Zhimin::request('hostbody');?>
" />							
</div>						
</div>						

<!-- /*上传时间*/ -->
						
<div class="condition_175 condition_s">							
	<span class="condition_title">上传时间：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="update_date_time" id="update_date_time" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('update_date_time') == '1') {?>
	 selected
<?php }?>

>本周
</option>									
<option value="2" 

<?php if (Zhimin::request('update_date_time') == '2') {?>
	 selected
<?php }?>

>本月
</option>									
<option value="3" 

<?php if (Zhimin::request('update_date_time') == '3') {?>
	 selected
<?php }?>

>一段时间
</option>								
</select>							
</div>						
</div>						
<div class="condition_144 condition_s condition_t update_condi_time">							
	<span>至
</span>							
<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="update_start" name="update_startdate" value="<?php echo Zhimin::request('update_startdate');?>
"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#update_start',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s update_condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input id="update_end" type="text" name="update_enddate" value="<?php echo Zhimin::request('update_enddate');?>
" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#update_end',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>							


<!-- /**/ -->

						
<div class="clear">
</div>					
</div>					
<div class="condition_top">						
	<div class="condition_250 condition_s">							
	<span class="condition_title">关键字：
</span>							
<div class="select_200 select_div select_in">																
	<input id="guanjianzi" type="text" name="key" class="search_in" 

<?php if (Zhimin::request('key') != '') {?>
	style="color:#000" 
<?php }?>

 value="<?php echo Zhimin::request('key') == '' ? '文件名称、文件描述' : Zhimin::request('key');?>
" />							
</div>						
</div>												
<div class="condition_165 condition_s">							
	<span class="condition_title">数据标注：
</span>							
<div class="select_100 select_div select_in">								
	<select class="easy_u" name="biaozhu" style="width:100%;">									
	<option value="-1" 

<?php if (Zhimin::request('biaozhu') == '1') {?>
	 selected
<?php }?>

>不限
</option>									
<option value="1" 

<?php if (Zhimin::request('biaozhu') == '1') {?>
	 selected
<?php }?>

>已标注
</option>									
<option value="0" 

<?php if (Zhimin::request('biaozhu') == '0') {?>
	 selected
<?php }?>

>未标注
</option>								
</select>							
</div>						
</div>												
<div class="condition_175 condition_s">							
	<span class="condition_title">标注类型：
</span>							
<div class="select_112 select_div">								
	<select class="easy_u" name="biaozhutype" style="width:100%;">								
	<option value="">不限
</option>								

<?php foreach ($biaozhu_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"

	<?php if (Zhimin::request('biaozhutype') == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>

								
</select>							
</div>						
</div>

<!-- /**/ -->
							
<div class="condition_175 condition_s">							
	<span class="condition_title">媒体质量：
</span>						
<div class="select_100 select_div select_in">								
	<select class="easy_u" name="biaozhu" style="width:100%;">									
	<option value="-1" 


<?php if (Zhimin::request('biaozhu') == '1') {?>
	 selected
<?php }?>

>不限
</option>									
<option value="0" 

<?php if (Zhimin::request('biaozhu') == '0') {?>
	 selected
<?php }?>

>标清
</option>									
<option value="1" 

<?php if (Zhimin::request('biaozhu') == '1') {?>
	 selected
<?php }?>

>高清
</option>								
</select>							
</div>						
</div>						

<!-- /**/ -->

<div class="clear">
</div>
</div>		
<div class="condition_top">
						
<div class="condition_250 condition_s">							
	<span class="condition_title">媒体类型：
</span>							
<div class="select_200 select_div">								
	<select class="easy_u" name="main_media" style="width:100%;">									
	<option value="0" 

<?php if (Zhimin::request('main_media') == '0') {?>
	 selected
<?php }?>

>不限
</option>									
<option value="1" 

<?php if (Zhimin::request('main_media') == '1') {?>
	 selected
<?php }?>

>视频
</option>									
<option value="2" 

<?php if (Zhimin::request('main_media') == '2') {?>
	 selected
<?php }?>

>音频
</option>									
<option value="3" 

<?php if (Zhimin::request('main_media') == '3') {?>
	 selected
<?php }?>

>图片
</option>								
</select>							
</div>						
</div>																		
<div class="condition_165 condition_s">							
	<span class="condition_title">文件类型：
</span>							
<div class="select_100 select_div select_in">								
	<select class="easy_u" name="filetype" style="width:100%;">								
	<option value="">不限
</option>								

<?php foreach ($file_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"

	<?php if (Zhimin::request('filetype') == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>

								
</select>							
</div>						
</div>				
						
<div class="condition_175 condition_s">							
	<span class="condition_title">重要视频：
</span>							
<div class="select_112 select_div ">								
	<select class="easy_u" name="main_video" style="width:100%;">									
	<option value="-1" 

<?php if (Zhimin::request('main_video') == '-1') {?>
	 selected
<?php }?>

>不限
</option>									
<option value="0" 

<?php if (Zhimin::request('main_video') == '0') {?>
	 selected
<?php }?>

>否
</option>									
<option value="1" 

<?php if (Zhimin::request('main_video') == '1') {?>
	 selected
<?php }?>

>是
</option>								
</select>							
</div>						
</div>						
						
<!-- /*标注位置start*/ -->
						
<div class="condition_175 condition_s">							
	<span class="condition_title">标注位置：
</span>							
<div class="select_112 select_div ">								
	<select class="easy_u" name="biaozhu_location" style="width:100%;">									
	<option value="-1" 
<?php if (Zhimin::request('biaozhu_location') == '-1') {?>
	 selected
<?php }?>

>不限
</option>									
<option value="0" 

<?php if (Zhimin::request('biaozhu_location') == '0') {?>
	 selected
<?php }?>

>未标注
</option>									
<option value="1" 

<?php if (Zhimin::request('biaozhu_location') == '1') {?>
	 selected
<?php }?>

>执法仪标注
</option>									
<option value="2" 

<?php if (Zhimin::request('biaozhu_location') == '2') {?>
	 selected
<?php }?>

>后台标注
</option>								
</select>							
</div>						
</div>						
						
<!-- /*标注位置end*/ -->
						
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>
						
<div class="button_wrap" style="width:270px; background:#0f0;">									
	<div>
</div>							
<div class="button_wrap_n" >								
<div class="button_list" onclick="location.href='<?php echo Zhimin::buildUrl('mediatuwen', 'media', 'index');?>'">
</div>								
<!-- 1是高级搜索，2是快速搜索，由js控制 -->								
<div class="button_search 

<?php if (Zhimin::request('search_type') == '2') {?>
	quick_search
<?php }?>

">
<input type="hidden" id="search_type" name="search_type" value="<?php echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type');?>
" />							
</div>											
</div>						
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
<span class="down_all">批量下载
</span>
<!--
<span class="upload_file" date="./?_a=uploadfile&_c=media&_m=index">上传文件
</span>
<img src="/images/uploadfile.jpg" border="0" id="uploadfile" date="./?_a=uploadfile&_c=media&_m=index" align="absmiddle" style="cursor:pointer" />-->					
<span class="span_red">
</span>重要视频				
</div>				
<div class="table_height">								
	<table class="table_detail" style="width:110%;">						
	<thead>							
	<tr>								
	<th class="t_back">序号
</th>								
<th >操作
</th>							
<th class="t_back">文件名
</th>
<th>文件描述
</th>								
<th class="t_back">发布<?php echo $_SESSION['zfz_type'];?>（<?php echo $_SESSION['zfz_type'];?>编号）
</th>								
<th>单位
</th>								
<th class="t_back">摄录时间（摄录时长）
</th>								
<th>记录仪编号
</th>								
<th class="t_back">媒体类型
</th>								
<th>标注位置
</th>								
<th class="t_back">标注情况
</th>							
</tr>						
</thead>						
<tbody>					
<?php $i = 1;

foreach ($medias as $media ) {
	$filetype = strtolower($media['filetype']);

	if (in_array($filetype, $media_typies['video'])) {
		$filetypename = '视频';
	}
	else if (in_array($filetype, $media_typies['audio'])) {
		$filetypename = '音频';
	}
	else if (in_array($filetype, $media_typies['photo'])) {
		$filetypename = '图片';
	}
	else {
		$filetypename = '其他';
	}

								

	if (($i % 2) == 0) {
										

		if ($media['major'] != '1') {?>
											
			<tr>								
		<?php }
		else {?>
											
			<tr class="td_red">								
		<?php }

									
	}
	else {
										

		if ($media['major'] != '1') {?>
											
			<tr class="td_back">								
		<?php }
		else {?>
											
			<tr class="td_back td_red">								
		<?php }

									
	}?>

									
	<td>									
		<span class="check_span">								    	
		<input type="checkbox"  class="ipt-hide"  value="
	<?php echo $media['id'];?>
	">								        
	<label class="checkbox">
	</label>
	<?php echo $i;?>
									    
</span>								
</td>								
	<td>									
		<span class="action_span">										
		<a class="a_view" date="
	<?php echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $media['id'].'&sql='.$sql);?>
	" style="cursor:pointer;color:blue">查看
</a>
	<a class="a_down" href="
	<?php echo Zhimin::buildUrl('', '', '', 'action=media_down&id=' . $media['id']);?>
	" target="_blank" style="cursor:pointer;color:blue">下载
</a>										

	<!-- <a class="a_file" href="#" date="<?php echo $media['filename'] . $media['filetype'] ;?>" style="cursor:pointer;color:blue">文件
	</a> -->
	
</span>								
</td>								
	
	<td>
		<span alt="<?php echo  $media['bfilename'] ;?>" title="<?php echo  $media['bfilename'];?>"> <?php echo cut_str($media['bfilename'], 22);?>
	</span>
</td>
	
	<td>
	<?php if ($media['note'] != ''){?>
		
		<div class="data_note"><?php echo cut_str($media['note'], 32);?>
		</div>
	<?php }
	else{?>
		无
	<?php }?>
	
</td>
	
	<td><?php echo $media['hostname'];?> (<?php echo $media['hostcode'];?> )
	
</td>								
	<td>
	<?php echo $media['dname'];?>
	
</td>								
	<td>
	<?php //modify
	//echo $media['createdate'] . ' ( ' . getfiletime($media['playtime']) . ' ) ?>
	<?php echo $media['createdate'];?> (<?php echo MediaAction::changeTimeType($media['playtime']);?> ) 
</td>								
	<td>
	<?php echo $media['hostbody'];?>
	
</td>								
	<td>
	<?php echo $filetypename;?>
	
</td>								
	<td>
	<?php echo $media['biaozhu_location'] == '0' ? '未标注' : ($media['biaozhu_location'] == '1' ? '执法仪标注' : '后台标注');?>
</td>								
	<td>
	<?php echo $media['is_flg'] == '1' ? '已标注' : '未标注';?>
	
</td>							
</tr>														
	<?php $i++;
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
	<p>确定批量下载？
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
</body>
</html>
<script type="text/javascript">
	$(document).ready(function (){	
		var searchtype  = '<?php echo Zhimin::request('search_type') == '' ? '1' : Zhimin::request('search_type')?>';
	if(searchtype != '1')	{		
		$(".conditon_hidden").hide();	
	}	
	//此处的js主要是为了解决当时间范围为【一段时间】时，展开时间段框
	var date_time = '<?php echo Zhimin::request('date_time');?>';
	if(date_time == 3){		
		$(".condi_time").show();	
	}else{		
		$(".condi_time").hide();	
	}
	var update_date_time = '<?php echo Zhimin::request('update_date_time');?>';
	if(update_date_time == 3){		
		$(".update_condi_time").show();	}else{		
			$(".update_condi_time").hide();	}

	$(".action_div span:not(:last)").click(function(){		
		$(this).siblings().removeClass("span_on");		
		$(this).addClass("span_on");	
	});	
	$(".action_div span:not(:last)").hover(function(){		
		$(this).addClass("span_hover");	},function(){		
			$(this).removeClass("span_hover");	
		});	
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
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other');?>&id=unitsyscode&text=dname',
		method:'get',labelPosition:'top',panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$("#easyui_add").combotree('setValues', ['']);      
		}  	
	});
	/*add tree end*/
	var n='<?php echo Zhimin::request('date_time');?>';
	if(n=='3'){		
		$(".condi_time").show();		
	}else{		
		$(".condi_time").hide();	
	}

	var m='<?php echo Zhimin::request('update_date_time')?>';
	if(m=='3'){		
		$(".update_condi_time").show();		
	}else{		
		$(".update_condi_time").hide();	
	}

	$(".easyui-combotree").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other');?>&id=unitsyscode&text=dname',
		method:'get',labelPosition:'top',panelWidth:'500px',	
		// 设置选中项	
		onLoadSuccess:function(node,data){		
			$(".easyui-combotree").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);      
		}  	
	});	
	$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});
	$('.easy_se').combobox({panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',	onChange: function (n,o) {		
		if(n=='3'){			
			$(".condi_time").show();		
		}else{			
			$(".condi_time").hide();		
		}	
	},	onLoadSuccess:function(data){ 		
		$('.easy_se').combobox('setValue',['<?php echo Zhimin::request('date_time');?>']);	
	}	
});

	$('#update_date_time').combobox({
		panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',	
		onChange: function (m,o) {		
			if(m=='3'){			
				$(".update_condi_time").show();		
			}else{			
				$(".update_condi_time").hide();		
			}	
		},	
		onLoadSuccess:function(data){ 		
			$('#update_date_time').combobox('setValue',['<?php echo Zhimin::request('update_date_time');?>']);	
		}	
	});
	})
</script>

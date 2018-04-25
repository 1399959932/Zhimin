<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>视频播放详情页
</title>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>
js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>
js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>
js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>
js/global.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>
style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>
style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>
js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>
js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>
style/re_easyui.css">
	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/jquery.easyui.min.js">
</script>
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/viewfile.css" />	
<style type="text/css">	
.gps_a{ color: #0e7fd3; }	
.pos{position: relative;top: -222px;left: 0;}	
</style>	
<!--[if IE 7]>
<style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}
</style>
<![endif]-->
</head>
<?php $media_cfg = Zhimin::g('media_type');
$filetype = strtolower($medias['filetype']);?>

<body>	
	<div class="layer_iframe">		
	<div class="iframe_top">
	<span style="display: inline-block;width:15px;">
</span>正在查看

<?php if (in_array($filetype, $media_cfg['video'])) {?>
	视频
<?php }
else if (in_array($filetype, $media_cfg['audio'])) {?>
	音频
<?php }
else {?>
	图片
<?php }?>

：
<?php echo $medias['bfilename'];?>

<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="iframe_body">			
	<div class="iframe_left">				
	<div class="cont_iframe_top">
	</div>				
<div class="cont_iframe_body">					
	<div class="video_wrap">					

<?php if (in_array($filetype, $media_cfg['video'])) {?>
								  
	<object id="peplayer" classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" 
	codebase = "http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" 
	width="450" height="420">						  	
		<param name="Mode" value="1" />						  	
		<param name="AutoLoop" value="1" />						  	
		<param name="AutoPlay" value="1" />						  	
		<param name="showdisplay" value="1" />						  
</object>	
						  					
<?php }
else if (in_array($filetype, $media_cfg['audio'])) {?>
								
	<object id="MediaPlayer" width="440" height="380"
	classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"								
	type="application/x-oleobject">								
		<param name="AutoStart" value="0" />								
		<param name="PlayCount" value="1" />								
		<param name="EnableContextMenu" value="0" />								
		<param name="Volume" value="100" />								
		<embed src="<?php echo $playurl;?>" name="MediaPlayer" 
		type="video/x-ms-wmv" width="400" height="68" autostart="1"	
		showcontrols="1" allowscan="1" playcount="100" enablecontextmenu="0">
</embed>							
</object>							
<script language="JavaScript">								
	var isFF=(navigator.userAgent.toLowerCase().indexOf("firefox")!=-1);						
	var objPlayer = document.getElementById("MediaPlayer");								
	if(isFF){objPlayer=document.MediaPlayer;}								
	var strFile33 = "$playurl";								
	objPlayer.url = strFile33;								
	objPlayer.src = strFile33;							
</script>					
<?php }
else {?>
									
	<a title="点击查看大图" target="_blank" href="<?php 
	echo $playurl;?>
	"> 
	<img border="0" onload="DrawImage(this,640,480);" src="<?php 
	echo $playurl;?>
	" width="640" height="360" />							
</a>					
<?php }?>

											  
<!--
	<img src="./images/video_img.jpg" width="450" height="420" alt="" />-->											
	<div class="video_action">						
	<span>文件大小：
<?php echo round($medias['filelen'], 2);?>
M
</span>						
<span class="span_awrap">							
	<a class="video_span_a video_down" target="_blank" href="<?php echo Zhimin::buildUrl('media', 'media', 'index', 'action=media_down&id=' . $medias['id']);?>
">
</a>|							
<a href="

<?php if (!empty($pre_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $pre_id.'&sql='.$sqlList);
}
else {?>
	#
<?php }?>
" class="video_span_a video_prev" >
</a>|							
<a href="

<?php if (!empty($next_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $next_id.'&sql='.$sqlList);
}
else {?>
	#
<?php }?>

" class="video_span_a video_next">
</a>						
</span>											
<span class="video_type">标  清
</span>						

<?php if ($gps_flg == '1') {?>
							
	<span class="map_span1" date="
	<?php echo Zhimin::buildUrl('map', 'media', 'index', 'filename=' . $medias['filename']);?>
	">
	<a class="gps_a" href="
	<?php echo Zhimin::buildUrl('map', 'media', 'index', 'filename=' . $medias['filename']);?>
	">GPS轨迹
</a>
</span>						
<?php }
else {?>
							
	<span class="map_span" date="#">GPS轨迹
	</span>						
<?php }?>

						
<div class="video_typelist">							 
	<ul>								
	<li>
	<a href="#">标  清
</a>
</li>								
<li>
	<a href="#">高  清
</a>
</li>								
<li>
	<a href="#">流  畅
</a>
</li>							
</ul>						
</div>					
</div>					
<div class="video_notice">						如无法播放视频，请下载并安装播放器插件 
	<a href="images/player/prPlayer.exe">点击下载
	</a>					
</div>				
</div>				
</div>				
<div class="cont_iframe_foot">
</div>			
</div>			
<div class="iframe_right">				
	<ul class="tab_ul">					
	<li class="active">基本信息
	</li>					
<li class="li_after li_1">标注类型
</li>				
</ul>				
<div class="right_iframe_top">
</div>				
<div class="right_iframe_body">					
	<div class="tab_wrap tab_base" style="display: block;">						
	<form id="media_flg_form_1" action="<?php echo Zhimin::buildUrl();?>
&action=edit" method="post">						
<div class="condition_335 condition_s">							
	<span class="condition_title">姓名（<?php echo $_SESSION['zfz_type'];?>编号）：
<?php echo $medias['hostname'];?>(<?php echo $medias['hostcode'];?> )

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">上传站点：
<?php echo $medias['creater'];?>（<?php echo $hostip;?>）

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">拍摄时间：
<?php echo $medias['createdate'];?>

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">上传时间：
<?php echo $medias['uploaddate'];?>

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">所属单位：
<?php echo $media_danwei;?>

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">下载次数：
<?php echo $medias['downloads'];?>
次
</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">播放次数：
<?php echo $medias['opens'];?>
次
</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">热点视频：
<?php echo $medias['hot'];?>

</span>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">重要视频：
	</span>							
<div class="select_270 select_div select_radio">								
	<label for="radio_yes">									是									
	<input type="radio" id="radio_yes" name="main_video" 

<?php if ($medias['major'] == '1') {?>
	checked
<?php }?>

 value="1"/>								
</label>								
<label for="radio_no">									否									
	<input type="radio" id="radio_no" name="main_video" 

<?php if ($medias['major'] == '0') {?>
	checked
<?php }?>

 value="0"/>								
</label>							
</div>						
</div>
						
<div class="condition_335 condition_s">
							
							<span class="condition_title">标注位置：
<?php if ($medias['biaozhu_location'] == '0') {?>
	未标注
<?php }
if ($medias['biaozhu_location'] == '1') {?>
	执法仪标注
<?php }
if ($medias['biaozhu_location'] == '2') {?>
	后台标注
<?php }?>

</span>
	
	</div>
						
<div class="condition_213 condition_s">							
	<span class="condition_title">文件类型：
	</span>							
<div class="select_150 select_div">								
	<select class="easy_u" name="filetype" style="width:100%;">								
	<option value="">不限
	</option>								

<?php foreach ($file_types as $k => $v ) {?>
	
	<option value="<?php echo $k;?>"

	<?php if ($medias['sort'] == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>

								
</select>							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">存储天数：
	</span>							
<div class="select_150 select_div select_days">								
	<select class="easy_u" name="save_day" style="width:100%;">									
	<option value="1" 

<?php if ($medias['save_date'] == '1' || $res == '90') {?>
	 selected
<?php }?>

>三个月
</option>									
<option value="2" 

<?php if ($medias['save_date'] == '2' || $res == '180') {?>
	 selected
<?php }?>

>六个月
</option>									
<option value="3" 

<?php if ($medias['save_date'] == '3' || $res == '365') {?>
	 selected
<?php }?>

>十二个月
</option>									
<option value="4" 

<?php //modify
if ($medias['save_date'] == '4') {?>
	 selected
<?php }?>

>永久
</option>								
</select>							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">文件名称：
	</span>							
<div class="select_260 select_div select_in floLeft">																
	<input type="text" value="
<?php //?>

<?php echo $medias['bfilename'];?>
" id="bfilename" name="bfilename" />							
</div>						
</div>						
<div class="condition_335 condition_s condition_textarea condition_height">							
	<span class="condition_title">文件描述：
	</span>							
<!-- 
<div class="select_260 select_div select_days textarea_in">																
<textarea id="media_note">
echo $medias['note'];

</textarea>							
</div> -->							
<textarea id="media_note" name="media_note" style="width:250px;height:76px; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">
<?php echo $medias['note'];?>

</textarea>						
</div>						
<input type="hidden" id="biaozhu_location" name="biaozhu_location" value="<?php echo $medias['biaozhu_location'];?>">
<input type="hidden" id="major_old" name="major_old" value="' . $medias['major'] . '">
<input type="hidden" id="fileid" name="fileid" value="
echo $medias['id'];
" >						
<div class="condition_335 condition_s condition_v">							
<!-- 
	<input type="submit" class="v_sub" value="保 存" /> -->							
	<input type="button" class="v_sub" id="v_sub_save" value="保 存" />						
</div>						
</form>					
</div>					
<div class="tab_wrap" style="display:none;">						
	<form id="media_flg_form" action="#" method="post">						
		<div class="condition_335 condition_s">							
	<span class="condition_title">标注类型：
	</span>							
<div class="select_260 select_div">								
	<select class="easy_u" name="biaozhutype" style="width:100%;">									
	<option value="">请选择标注类型
	</option>									
<?php 
$val_sel = '';
$val_sel_name = '';
if (($video_flg['type'] != '') && ($biaozhu_types[$video_flg['type']] != '')) {
	$val_sel = $video_flg['type'];
	$val_sel_name = $biaozhu_types[$video_flg['type']];
}

foreach ($biaozhu_types as $k => $v ) {?>
										
	<option value="<?php echo $k;?>"

	<?php if ($video_flg['type'] == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>

								
</select>							
</div>							
						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">数据编号：
	</span>							
<div class="select_260 select_div select_in">																
	<input type="text" name="data_no" name="data_no" value="<?php 
echo $video_flg['data_no'];?>
" />							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">采集地点：
	</span>							
<div class="select_260 select_div select_in">																
	<input type="text" name="data_location" name="data_location" value="<?php 
echo $video_flg['data_location'];

//modify?>
" />							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">号码类型：
	</span>							
<div class="select_260 select_div">								
	<select class="easy_u" name="codetype" style="width:100%;">									
	<option value="">请选择号码类型
	</option>									
<?php $val_sel = '';
$val_sel_name = '';
if (($video_flg['codetype'] != '') && ($code_types[$video_flg['codetype']] != '')) {
	$val_sel = $video_flg['codetype'];
	$val_sel_name = $code_types[$video_flg['codetype']];
}

foreach ($code_types as $k => $v ) {?>
										
	<option value="<?php echo $k;?>"

	<?php if ($video_flg['codetype'] == $k) {?>
		 selected
	<?php }?>

	><?php echo $v;?>
</option>
<?php }?>
								
</select>							
</div>							
<?php //?>

						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">号码内容：
	</span>							
<div class="select_260 select_div select_in">																
	<input type="text" name="car_no" name="car_no" value="
<?php echo $video_flg['car_no'];?>
" />							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">采集时间：
	</span>							
<div class="select_260 select_div select_in">																
	<div class="select_235 sele_c select_in select_time_i">									
	<input id="end" type="text" name="caijidate" value="
<?php echo $video_flg['cjsj'] == '' ? $medias['createdate'] : $video_flg['cjsj'];?>
" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#end',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});">
</div>							
</div>						
</div>						
<div class="condition_335 condition_s">							
	<span class="condition_title">当事人：
	</span>							
<div class="select_260 select_div select_in">																
	<input type="text" name="client" name="client" value="<?php 
echo $video_flg['client'];?>
" />							
</div>						
</div>						
<div class="condition_335 condition_s condition_textarea">							
	<span class="condition_title">标注描述：
	</span>							
<!-- 
<div class="select_260 select_div textarea_in">																
<textarea id="remark" name="remark">
echo $video_flg['remark'];

</textarea>							
</div> -->							
<textarea id="remark" name="remark" style="width:260px;height:170px; float: right; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">
<?php echo $video_flg['remark'];?>

</textarea>						
</div>						
<input type="hidden" id="fileid" name="fileid" value="
echo $medias['id'];
" >						
<div class="condition_335 condition_s condition_v">							
<!-- 
	<input type="submit" class="v_sub" value="保 存" /> -->							
	<input type="button" class="v_sub" id="v_sub_save_biaozhu" value="保 存" />						
</div>						
</form>					
</div>									
</div>				
<div class="right_iframe_foot">
</div>			
</div>	
</div>		
<div class="iframe_foot">
</div>	
<!-- 警告提示框 -->	
<div style="position:relative;">	
	<div class="layer_notice lay_add" style="width:449px;height:222px;z-index:9999;">		
	<iframe id='iframebar1' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;">
	</iframe>		
<div class="notice_top pos">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body pos">			
	<div class="n_left">				
		<img src="./images/notice_bg.png">			
</div>			
<div class="n_right">				
	<p>标注信息不能为空......
	<font>3
</font>秒钟后返回页面！
</p>				
<div class="clear">
</div>				
<span class="cancle_span close_btn">确 定
</span>			
</div>		
</div>		
<div class="notice_foot pos">
</div>	
</div>	
</div>	
<!-- 成功提示框 -->	
<div style="position:relative;">		
	<div class="layer_notice lay_success" style="width:449px;height:222px;z-index:9999;">			
	<iframe id='iframebar2' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;background: none;">
	</iframe>  			
<div class="notice_top pos">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>			
<div class="notice_body1 pos">				
	<div class="n_left">					
		<img src="./images/success_bg.png">				
</div>				
<div class="n_right">					
	<p>保存成功......
	<font>3
</font>秒钟后返回页面！
</p>					
<div class="clear">
</div>					
<span class="cancle_span close_btn">确 定
</span>				
</div>			
</div>			
<div class="notice_foot pos">
</div>		
</div>	
</div>	
<!-- 失败提示框 -->	
<div style="position:relative;">		
	<div class="layer_notice lay_wrong" style="width:449px;height:222px;z-index:9999;">			
	<iframe id='iframebar3' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;">
	</iframe>			
<div class="notice_top pos">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>			
<div class="notice_body4 pos">				
	<div class="n_left">					
		<img src="./images/notice_bg.png">				
</div>				
<div class="n_right">					
	<p>信息不全,保存失败......
	<font>3
</font>秒钟后返回页面！
</p>					
<div class="clear">
</div>					
<span class="cancle_span close_btn">确 定
</span>				
</div>			
</div>			
<div class="notice_foot pos">
</div>		
</div>	
</div>	
<!-- 视频版本提示框 -->	
<div style="position:relative;">		
	<div class="layer_notice lay_wrong1" style="width:449px;height:222px;z-index:9999;">			
	<iframe id='iframebar3' src="about:blank" frameBorder=0  marginHeight=0 marginWidth=0 style="position:relative;visibility:inherit; top:0px;left:0px;height:222px;width:449px;z-index:-1;">
	</iframe>			
<div class="notice_top pos">
	<span id="videoClose" class="close close_btn2">
	<img src="./images/close.png" alt="" />
</span>
</div>			
<div class="notice_body1 pos">				
	<div class="n_left">					
		<img src="./images/notice_bg.png">				
</div>				
<div class="n_right">					
	<p>请安装最新播放器插件！
	</p>					
<div class="clear">
</div>					
<span class="cancle_span close_btn2">确 定
</span>				
</div>			
</div>			
<div class="notice_foot pos">
</div>		
</div>	
</div>
</body>
</html>

<?php if (in_array($filetype, $media_cfg['video'])) {?>
	
<script language="javascript" for="peplayer" event="TimeChanged(time)">	
$(function(){		
/*if(time > 0)		{			
if(time - g_presecond >= 1)			
{				
	//g_presecond = time;				
	//PlayTimeNotify(time);			
}					
} */	
});      
</script>	
<script language="javascript" for="peplayer" event="Playover()">	        
	</script>
	<script type="text/javascript">
	$(function(){		 	
		var g_presecond = 0;	
		/*		time: MillSeconds	*/	
		function onTimeEvent(time)	{			
			if(time > 0)		
			{			
				if(time - g_presecond >= 1)			
				{				
					g_presecond = time;				
					//PlayTimeNotify(time);			
				}					
			}	
		}		
		function onPlayoverEvent()	{			
		}		
		function SetGis(ax){		
			//object css里面定义了就不用写 		
			ax.style.width = "450px";		
			ax.style.height = "420px";				
			//调用activex的方法 1：gis播放UI，0：常规播放UI		
			ax.setmode(1);				
			//普通模式		
			//ax.style.width = "640px";		
			//ax.style.height = "480px";		
			//ax.setmode(0);	
		} 		
		function PlayVideo(url)	{				
			var activex = document.getElementById("peplayer");		
			if( activex )		
			{						
				/*try{				
				if(document.all.ocx.object == null) 				
				{					
				alert('some activex is not installed!');				
				}			
				}catch(e){}*/						
				//测试activeX是否有 playurl 函数 判断是否安装了播放器插件。			
				/*try{			
				//activex.setmode(1);			
				//GIS模式可以关联时间事件 			
				activex.attachEvent ("TimeChanged", onTimeEvent);			
				//播放完成事件			
				activex.attachEvent ("Playover", onPlayoverEvent);			
				}catch(e){}*/			
				//切换 GIS 模式UI			
				//SetGis(activex);			
			if(typeof(activex.playurl) == 'undefined'){				
				//alert('请安装最新播放器插件.');				
				layer.open({					
				type: 1,					
				title: false,					
				closeBtn: 0,					
				// shadeClose: true,					
				area: '449px',					
				time: 4000, 
				//3s后自动关闭					
				content: $('.lay_wrong1')				
			});				
			return;			
			}			
	activex.playurl(url);		
	}	
}			
setTimeout(function()	{		
	var url = "$playurl;";		
PlayVideo(url);	}, 	1000); 	
/*window.onbeforeunload = window.onunload = function()	{ 		
try{		
var activex = document.getElementById("peplayer");		
if( activex )		
{			
activex.detachEvent ("TimeChanged", onTimeEvent);			
activex.detachEvent ("Playover", onPlayoverEvent);		
}		
}catch(e){}	}*/
});	
</script>
<?php }?>


<script type="text/javascript">
$(function(){	
function DrawImage(ImgD,iwidth,iheight){        
//参数(图片,允许的宽度,允许的高度)   
 var minWidth  = 640;    
 var minHeight = 360;        
 var image=new Image();        
 image.src=ImgD.src;        
 if(image.width>0 && image.height>0){          
 	if(image.width/image.height>= iwidth/iheight){      	  
 		if(image.width==iwidth){    		  
 			ImgD.width=image.width;                    
 			ImgD.height=image.height;    	  
 		} else{                    
 			ImgD.width=iwidth;                  
 			ImgD.height=(image.height*iwidth)/image.width;              
 		}          
 	}else{              
 		if(image.height==iheight){                 
 		 ImgD.width=image.width;                    
 		 ImgD.height=image.height;                    
 		}else{                       
 			ImgD.height=iheight;                  
 			ImgD.width=(image.width*iheight)/image.height;             
 		}          
 	}        
 }      
 }});
</script>
<script>
	$(function(){	
		$("body").on('click', ".close_btn2",
			function(){    	
				layer.close();    
			});	
		window.onerror=function(){
			return false;
		}	
		$(".video_down").click(function(){	
			$(this).css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action_on.jpg') 0 -2px no-repeat");	
			$(".video_prev").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') -41px -2px no-repeat");	
			$(".video_next").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') -80px -2px no-repeat");});
		$(".video_prev").click(function(){	
			$(this).css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action_on.jpg') -41px -2px no-repeat");	
			$(".video_down").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') 0px -2px no-repeat");	
			$(".video_next").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') -80px -2px no-repeat")});
		$(".video_next").click(function(){	
			$(this).css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action_on.jpg') -80px -2px no-repeat");	
			$(".video_down").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') 0px -2px no-repeat");	
			$(".video_prev").css("background","url('<?php echo Zhimin::g('assets_uri');?>images/video_action.jpg') -41px -2px no-repeat");});
			$("#v_sub_save").click(function(){	
			var save_day = $("input[name='save_day']").val();	
			var note = $("#media_note").val();	
			var main_video = $('input[name="main_video"]:checked').val();	
			var fileid = $("#fileid").val();	
			$.ajax({		
				type:"POST",		
				url: "./?_a=mediaview&_c=media&_m=index&action=media_edit",		
				data: $('#media_flg_form_1').serialize(),		
				dataType:"json",		
				success:function(data){			
				if(data == 0){				
					layer.open({					
					type: 1,					
					title: false,					
					closeBtn: 0,					
					shadeClose: true,					
					area: '449px',					 
					time: 3000, 
					//3s后自动关闭					
					content: $('.lay_success')				
					});			
					}else{				
						layer.open({					
						type: 1,					
						title: false,					
						closeBtn: 0,					
						shadeClose: true,					
						area: '449px',					
						time: 3000, 
						//3s后自动关闭					
						content: $('.lay_wrong')				
						});			
						}		
						}	
						});
						});
						$("#v_sub_save_biaozhu").click(function(){				
						$.ajax({			
						type:"POST",			
						url: "./?_a=mediaview&_c=media&_m=index&action=mediaflg_edit",			
						data: $('#media_flg_form').serialize(),			
						dataType:"json",			
						success:function(data){				
						if(data == 0){					
						layer.open({						
						type: 1,						
						title: false,						
						closeBtn: 0,						
						shadeClose: true,						
						area: '449px',						
						time: 2000, 
						//3s后自动关闭						
						content: $('.lay_success')					
						});				
						}else{					
						layer.open({						
						type: 1,						
						title: false,						
						closeBtn: 0,						
						shadeClose: true,						
						area: '449px',						
						time: 3000, 
						//3s后自动关闭						
						content: $('.lay_wrong')					
					});				
					}			
				}		
			});
					});;
						/*add tree end*/
						$('.easy_u').combobox({
							panelHeight:'120px',
							selectOnNavigation:true,
							editable:false,
							labelPosition:'top'});
					});
</script>

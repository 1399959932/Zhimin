<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>	
<title>数据存储
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/uploadfileAction.js">
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


<body class="main_body">

<div class="detail">

<?php
include_once ('menu.php');
?>

<!--文件上传-->

<link href="<?php Zhimin::g('assets_uri');?>/js/jquery.uploadify-v2.1.4/uploadify.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>/js/jquery.uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js">
</script>

<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>/js/jquery.uploadify-v2.1.4/swfobject.js">
</script>

<script src="<?php Zhimin::g('assets_uri');?>/js/uploadify_file.js" type="text/javascript">
</script>

<!---->

<div class="detail_top">

<img src="./images/main_detail_tbg.png" width="100%" alt="" />

</div>

<div class="detail_body">

<div class="table_box surpervision">

<form id="myform" action="/?_a=uploadfile&_c=media&_m=index" method="post" enctype="multipart/form-data">

<table class="sys_base">

<tr>

<td class="sys_black01" width="14%" name="site">
<span class="condition_title">拍摄时间
</span>
</td>

<td>

<input type="text" class="laydate-icon" style="width:220px" id="createdate" name="createdate" value="" onClick="laydate({elem: '#createdate',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});">								

</td>

</tr>


<tr>

<td class="sys_black" width="14%" name="admin_mail">
<span class="condition_title">接警序号
</span>
</td>

<td>

<input type="text" style="width:240px" id="pnumber" value="" name="pnumber"/>

</td>

</tr>


<tr>

<td class="sys_black01" width="14%" name="mail_host">
<span class="condition_title">所属单位
</span>
</td>

<td>

<?php echo $_SESSION['unitname'];?>

</td>

</tr>


<tr>

<td class="sys_black" width="14%" name="mail_password">
<span class="condition_title">姓名（
<?php echo  $_SESSION['zfz_type']?>编号）
</span>
</td>

<td>
<span class="condition_title">
<?php echo $_SESSION['realname']?> (<?php echo $_SESSION['hostcode']; ?>)
</span>
</td>

</tr>

<tr>

<td class="sys_black" name="mail_password">
<span class="condition_title">记录仪编号
</span>
</td>

<td>
<input type="text" style="width:240px" id="hostbody" value="" name="hostbody"/>
</td>

</tr>


<tr>

<td class="sys_black01" width="14%" name="mail_post">
<span class="condition_title">警情来源
</span>
</td>

<td>


<select class="easy_u" name="jqly" id="jqly">									
<option value="">请选择...
</option>									'
<?php $val_sel = '';
$val_sel_name = '';
if (($video_flg['type'] != '') && ($jqly_types[$video_flg['type']] != '')) {
$val_sel = $video_flg['type'];
$val_sel_name = $jqly_types[$video_flg['type']];
}
foreach ($jqly_types as $k => $v ) {?>

<option value="<?php echo $k;?>"

<?php if ($video_flg['type'] == $k) {?>
selected
<?php }?>

><?php echo $v;?>
</option>
<?php }	?>							
</select>

</td>

</tr>


<tr>

<td class="sys_black" width="14%" name="telephone">
<span class="condition_title">采集设备来源
</span>
</td>

<td>

<select class="easy_u" name="cjsbly" id="cjsbly">									
<option value="">请选择...
</option>
<?php					
$val_sel = '';
$val_sel_name = '';
if (($video_flg['type'] != '') && ($cjsbly_types[$video_flg['type']] != '')) {
$val_sel = $video_flg['type'];
$val_sel_name = $cjsbly_types[$video_flg['type']];
}
foreach ($cjsbly_types as $k => $v ) {
?>

<option value="<?php echo $k;?>"

<?php if ($video_flg['type'] == $k) {?>
	selected
<?php }?>

><?php echo  $v;?>
</option>
<?php }?>								
</select>

</td>

</tr>



<tr>

<td class="sys_black01" width="14%" name="zfz_type">
<span class="condition_title">文件类型
</span>
</td>

<td>

<select class="easy_u" name="sort" id="sort">';//
<option value="">不限
</option>

<?php foreach ($file_types as $k => $v ) {?>

<option value="<?php echo $k; ?>"

<?php if ($medias['sort'] == $k) {?>
	selected
<?php }?>

><?php echo $v;?>"
</option>
<?php }?>

</select>


</td>

</tr>


<tr>

<td width="14%" height="100" class="sys_black" name="disk_size">
<span class="condition_title">文件描述
</span>
</td>

<td>

<textarea id="media_note" name="media_note" style="width:240px;height:76px; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;">
</textarea>

</td>

</tr>


<tr>

<td class="sys_black01" width="14%" name="safecode">
<span class="condition_title">重要视频
</span>
</td>

<td>

<label for="radio_yes"> 

<input type="radio" id="radio_yes" name="main_video" style="width:15px;height:15px;" value="1"/>是

</label>&nbsp;&nbsp;

<label for="radio_no">

<input type="radio" id="radio_no" name="main_video" style="width:15px;height:15px;" checked value="0"/>否

</label>

</td>

</tr>


<tr>

<td height="50" class="sys_black" width="14%" name="onworktime">
<span class="condition_title">上传文件
<br>（支持MP4、JPG、WAV格式，一次最多上传6个文件）
</span>
</td>

<td>
<div style="margin-left:5px; float:left">

<div id="ShowFileUpload" style="width:480px;height:auto;margin:5px;">
</div>

<div style="clear:both;font-size:1%;line-height:1%;height:0;">
</div>

<div style="width:480px;padding-top:15px">

<input type="file" name="uploadify" id="uploadify" />

</div>

</div>
<div style="margin-left:10px; float:left">
<div id="imglist">
</div>
</div>

<input type="hidden" name="hfFilelist" id="hfFilelist" />
<input type="hidden" name="hfNewFilelist" id="hfNewFilelist" />
</td>

</tr>				

<tr>

<td class="sys_black01" width="14%">
</td>

<td>														

<div class="condition_top" style="*width:269px;">

<div class="condition_260 condition_s ">						

<div class="select_260 select_div select_in selec_text">								

<input type="submit" class="sure_add form_sub" id="form_submit" value="确 定">

<input type="hidden" name="action" value="upload">

<input type="reset" class="sure_cancle close_btn form_reset" value="取 消">

</div>

</div>

<div class="clear">
</div>

</div>			

</td>

</tr>

</table>

</form>

</div>			

</div>

<div class="detail_foot">
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

<div class="notice_foot">
</div>

</div>

</body>

</html>
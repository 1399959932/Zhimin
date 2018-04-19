<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>基本资料管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/configAction.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
</head>
<body class="main_body">	
	<div class="detail">		
<?php include_once ('menu.php');?>
			
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="table_box surpervision">				
	<form id="myform" action="<?php echo Zhimin::buildUrl('config', 'system');?>
" method="post" enctype="multipart/form-data">				
<table class="sys_base">								
<?php $k = 1;

foreach ($configs as $v ) {
	if (($v['type'] == 'input') && ($v['db_config'] != version)) {
		$k++;?>
						            <tr>				            

		<?php if (($k % 2) == 0) {?>
							            <td class="sys_black01" width="14%" name="
			<?php echo $v['db_config'];?>
			">
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }
		else {?>
							            <td class="sys_black" width="14%" name="
			<?php echo $v['db_config'];?>
			">
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }?>

						            <td>				            

		<?php if ($v['db_config'] == version) {?>
												<input type="text" id="
			<?php echo $v['db_config'];?>
			" value="
			<?php echo $v['db_value'];?>
			" disabled name="
			<?php echo $v[db_config];?>
			"/>							
		<?php }
		else {?>
			<?php echo '									<input type="text" id="';
			echo $v['db_config'];
			echo '" value="';
			echo $v['db_value'];
			echo '" name="';
			echo $v[db_config];
			//echo '"/>	
			//modify
			echo '"/>' . $v['note'] . '							';
			//
		}	?>

						            </td>				            </tr>					
	<?php }
	else if ($v['type'] == 'checkbox') {
		$k++;
	?>
						            <tr>				            

		<?php if (($k % 2) == 0) {?>
							            <td class="sys_black01" width="14%" name="
			<?php echo $v['db_config'];?>
			">
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }
		else {?>
							            <td class="sys_black" width="14%" name="
			<?php echo $v['db_config'];?>
			"> 
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }?>

						            <td>									<input class="sys_c" type="checkbox" name="
		<?php echo $v['db_config'];?>
		" value="1"										

		<?php if ($v['db_value'] == 1) {?>
			checked
		<?php }?>

		/>				            </td>				            </tr>				    
	<?php }
	else if ($v['type'] == 'file') {
		$k++;?>
						            <tr>							

		<?php if (($k % 2) == 0) {?>
							            <td class="sys_black01" width="14%" name="
			<?php echo $v['db_config'];?>
			">
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }
		else {?>
							            <td class="sys_black" width="14%" name="
			<?php echo $v['db_config'];?>
			">
			<?php echo $v['db_name'];?>
			</td>				            
		<?php }?>

									<td>							
		<?php if (($v['db_value'] != '') && file_exists($document_root . 'upload/zm_config/' . $v['db_value'])) {?>
										<input class="sys_c" type="checkbox" name="remove_
			<?php echo $v['db_config'];?>
			" id="remove_
			<?php echo $v['db_config'];?>
			" value="true" />							<label for="remove_
			<?php echo $v['db_config'];?>
			">删除</label>							<a href=
			<?php echo Zhimin::g('assets_uri');?>
			upload/zm_config/
			<?php echo $v['db_value'];?>
			 target=_blank>下载</a>							<br />							
		<?php }?>

									<input type="file" id="
		<?php echo $v['db_config'];?>
		" name="
		<?php echo $v['db_config'];?>
		" />							</td>							</tr>				    
	<?php }?>

									
<?php }?>

						
<tr>						
	<td class="sys_black01" width="14%">
</td>						
<td>																					
	<div class="condition_top" style="*width:269px;">								
	<div class="condition_260 condition_s ">															
	<div class="select_260 select_div select_in selec_text">																		
	<input type="submit" class="sure_add form_sub" id="form_submit" value="确 定">										
<input type="hidden" name="submit_config" value="config">										
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
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
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
	<p>删除成功......
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
	<p>删除失败......
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
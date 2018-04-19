<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>站內信
</title>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/home.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<!--[if IE 7]>	
<style>	.letter_top .close{ position:absolute; right:35px;top:15px;}	.atten_top .close {    line-height: normal;    right: 15px;}	
</style>	
<![endif]-->
<body style="width:760px;">	
	<div class="layer_iframe">		
	<div class="iframe_top letter_top">
	<span class="letter_t">站內短信
</span>
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="iframe_body letter_body">			
	<div class="letter_wrap">				
	<div class="letter_button">					
	<a href="<?php echo Zhimin::buildUrl('messageadd', 'other');?>
">写信息
</a>					
<span>未读
</span>				
</div>				
<div class="table_height letter_table">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th class="t_back" width="115">发信人
</th>								
<th width="255">标题
</th>								
<th class="t_back" width="200">发信时间
</th>								
<th>操作
</th>														
</tr>						
</thead>						
<tbody class="tbody_atten">							
	<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->															

<?php foreach ($messages as $k => $v ) {
	if ($v['is_new'] == 1) {?>
										
		<tr class="td_back td_red">								
			<td>									
		<?php echo $v['username'];?>
										
	</td>								
		<td>
			<a href="<?php echo Zhimin::buildUrl('messageview', 'other', 'index', 'msgid=' . $v['msgid']);?>">
				<?php echo $v['title'];?>
			</a>
	</td>								
		<td>
		<?php echo date('Y.m.d', $v['in_time']);?>
		
	</td>								
		<td>
			<a class="letter_a" href="javascript:void(0)" date="
		<?php echo $v['msgid'];?>
		">
	</a>
	</td>								
	</tr>								
	<?php }
	else {?>
											
		<tr>														
			<td>									
		<?php echo $v['username'];?>
										
	</td>								
		<td>
			<a href="
		<?php echo Zhimin::buildUrl('messageview', 'other', 'index', 'msgid=' . $v['msgid']);?>
		">
		<?php echo $v['title'];?>
		
	</a>
	</td>								
		<td>
		<?php echo date('Y.m.d', $v['in_time']);?>
		
	</td>								
		<td>
			<a class="letter_replay" href="
		<?php echo Zhimin::buildUrl('messageadd', 'other', 'index', 'msgid=' . $v['msgid']);?>
		&action=sendmsg">
	</a>&nbsp;&nbsp; 
		<a class="letter_a" href="javascript:void(0)" date="
		<?php echo $v['msgid'];?>
		">
	</a>
	</td>								
	</tr>							
	<?php }
}?>

							
<!-- 没有记录时输出 -->							

<?php if (empty($messages)) {?>
								
	<tr class="td_back">								
		<td colspan="4">暂无记录
	</td>							
</tr>							
<?php }?>

												
</tbody>					
</table>				
</div>			
</div>					
<div class="page_link">					
<?php $page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
				
</div>			
</div>		
</div>		
<div class="iframe_foot letter_foot">
</div>	
</div>	
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm_del">		
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
	<p>确定删除本条站内信？
</p>				
<div class="clear">
</div>				
<span class="sure_span letter_sure">确 定
</span>				
<span class="cancle_span close_btn">取 消
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
<div class="notice_body1">			
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
<div class="notice_body1">			
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
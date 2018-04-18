<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>	
<title>头部</title>	
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
</head>
<body class="body_header">	
	<div class="header_left">		
		<span>			
	<img src="<?php echo $data['logo'];?>" width="100%" alt="" />		
</span>		
<?php echo $data['title'];?>	
	</div>	
	<div class="header_right">		
		<span class="photo_box">			
		<img src="<?php echo Zhimin::g('assets_uri');?>images/photo.png" width="100%">		
</span>		
<span class="user_message">&nbsp;&nbsp;<?php echo $data['realname'];?>

</span>|		
<span class="user_message"><?php echo $data['groupname'];?>

</span>|		
<span class="user_message"><?php echo $data['unit_name'];?>

</span>|		
<a href="javascript:void(0)" class="message" date="<?php echo Zhimin::buildUrl('message', 'other');?>
" title="短消息">
<i><?php echo $data['message_count'];?>

</i>
</a>|		
<a href="javascript:void(0)" class="lock" title="修改密码">
</a>|		
<a href="javascript:void(0)" class="run_out" title="注销">
</a>	
</div>
</body>
</html>
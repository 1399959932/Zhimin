<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>左边导航
	</title>
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
	</script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
	</script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
	</script>

</head>

<body class="nav_body">
<ul class="nav_left">	
<li class="active">		
<a href="<?php echo Zhimin::buildUrl('main');?>" target="main">			
<span class="icon_left">
</span>			系统首页			
<span class="icon_right">
</span>		
</a>	
</li>	
<li>		
<a href="<?php echo Zhimin::buildUrl('index', 'media');?>" target="main">			
<span class="icon_left icon_mess">
</span>			数据管理			
<span class="icon_right">
</span>		
</a>	
</li>

<?php if (mudule_left_view('1002')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'sup')?>&bh=1002" target="main">			
<span class="icon_left icon_loyal">
</span>			执法监督			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1005')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'report')?>&bh=1005" target="main">			
<span class="icon_left icon_count">
</span>			统计分析			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1003')) {?>
		
		<li>		
		<!-- 
		<a href="';
	echo Zhimin::buildUrl('develop', 'index');
" target="main"> -->		
<a href="<?php echo Zhimin::buildUrl('index', 'case')?>&bh=1003" target="main">			
<span class="icon_left icon_case">
</span>			案件专题			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1004')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'access')?>&bh=1004" target="main">			
<span class="icon_left icon_read">
</span>			同级调阅			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (issuperadmin()) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'log');?>" target="main">			
<span class="icon_left icon_log">
</span>			日志管理			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1006')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'device')?>&bh=1006" target="main">			
<span class="icon_left icon_device">
</span>			设备管理			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1007')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'host')?>&bh=1007" target="main">			
<span class="icon_left icon_operation">
</span>			运维管理			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }

if (mudule_left_view('1008')) {?>
		
		<li>		
		<a href="<?php echo Zhimin::buildUrl('index', 'system')?>&bh=1008" target="main">			
<span class="icon_left icon_sys">
</span>			系统管理			
<span class="icon_right">
</span>		
</a>	
</li>
<?php }?>
	
	</ul>

</body>

</html>


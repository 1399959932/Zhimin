<div class="tab_button_wrap">	
	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->

<?php if (issuperadmin()) {?>
	<div class="tab_button <?php echo ismenuhot('log', 'log') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('log', 'log');?>'">系统日志</div>	
	<div class="tab_button <?php echo ismenuhot('devicelog', 'log') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('devicelog', 'log');?>'">记录仪日志
</div>	
	<div class="tab_button <?php echo ismenuhot('stationlog', 'log') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('stationlog', 'log');?>'">工作站日志
</div>
<?php }?>

</div>

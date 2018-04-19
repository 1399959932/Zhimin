<!-- //系统管理，基本资料设置页面 -->
<div class="tab_button_wrap">	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->	
<!-- //判断是不是有该权限的管理员 -->
<?php if (issuperadmin()) {?>
		<div class="tab_button <?php echo ismenuhot('unit', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('unit', 'system');?>'">部门管理</div>	
		<div class="tab_button <?php echo ismenuhot('group', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('group', 'system');?>'">角色管理</div>	
<?php }

$bh = 1008;
$tab_array = mudule_view_array($bh);

if (!empty($tab_array)) {
	foreach ($tab_array as $k => $v ) {?>
				<div class="tab_button <?php echo ismenuhot($v['filename'], 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl($v['filename'], 'system');?>'">
		<?php echo $v['mname'];?>
		</div>	
	<?php }
}

	

if (issuperadmin()) {?>
		<div class="tab_button <?php echo ismenuhot('sysconf', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('sysconf', 'system');?>'">系统配置项</div>	
		<div class="tab_button <?php echo ismenuhot('config', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('config', 'system');?>'">基本资料设置</div>	<div class="tab_button <?php echo ismenuhot('norelation', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('norelation', 'system');?>'">未关联文件</div>	

	<?php if ($_SESSION['username'] == 'manager') {?>
		<div class="tab_button <?php echo ismenuhot('pollcode', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('pollcode', 'system');?>'">注册码管理</div>	

				<div class="tab_button <?php echo ismenuhot('facility', 'system') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl('facility', 'system');?>'">设备管理</div>	
	<?php }
}?>

</div>

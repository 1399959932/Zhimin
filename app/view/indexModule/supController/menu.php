<div class="tab_button_wrap">
	<!-- 此页面首先也要判断一下，是否有浏览的权限 -->
<?php $bh = 1002;
$tab_array = mudule_view_array($bh);

if (!empty($tab_array)) {
	foreach ($tab_array as $k => $v ) {?>
		<div class="tab_button <?php echo ismenuhot($v['filename'], 'sup') ? 'active' : '';?>" onclick="location.href='<?php echo Zhimin::buildUrl($v['filename'], 'sup');?>'">
		<?php echo $v['mname'];?>
		</div>
	<?php }
}?>

</div>

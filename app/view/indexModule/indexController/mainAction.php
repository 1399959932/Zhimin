<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9;IE=8;" />
	<title>主页</title>	

	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/laydate/laydate.js"></script>
	<script type="text/javascript" src="/js/layer/layer.js"></script>
	<script type="text/javascript" src="/js/echarts.js"></script>
	<script type="text/javascript" src="/js/global.js"></script>
	<script type="text/javascript" src="/js/line4.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/js/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/js/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/style/re_easyui.css">
	<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>

	<script type="text/javascript" src="/js/ba-resize.js"></script>
	<link rel="stylesheet" type="text/css" href="/style/reset.css" />
	<link rel="stylesheet" type="text/css" href="/style/global.css" />

<script >	
	var datas = eval( '(' + '<?php echo $datas?>' + ')' );	
</script>

</head>
<body class="main_body">
  <div class="body_top">
    <div class="body_title1">欢迎登录<?php echo $data['title']; ?>！</div><div class="body_title2">上次登陆时间：<?php echo $data['lastlogtime']; ?></div><div class="body_title3">上次登陆IP：<?php echo $data['logip']; ?></div><div class="body_title4">本月您共上传了<span class="body_top_font"><?php echo $person_num; ?></span>个文件</div>
  </div>
  <div style="clear:both"></div>
  <div class="body_tj">
	<a href="/?_a=index&_c=media&_m=index">
	  <div class="body_tj1_0 cursor"></div>
	  <div class="body_tj1_1 cursor"><span class="body_tj_tt1"><?php echo $data['data_count']; ?></span><p class="pcs"><span class="body_tj_tt2">数据统计</span></p></div>
	</a>
	<a href="/?_a=user&_c=system&_m=index">
	  <div class="body_tj2_0 body_tj1_left cursor"></div>
	  <div class="body_tj1_1 cursor"><span class="body_tj_tt1"><?php echo $data['user_count']; ?></span><p class="pcs"><span class="body_tj_tt2">用户统计</span></p></div>
	</a>
	<a href="/?_a=index&_c=device&_m=index&bh=1006">
	  <div class="body_tj3_0 body_tj1_left cursor"></div>
	  <div class="body_tj1_1 cursor"><span class="body_tj_tt1"><?php echo $data['device_count']; ?></span><p class="pcs"><span class="body_tj_tt2">设备统计</span></p></div>
	</a>
	<a href="/?_a=unit&_c=system&_m=index">
	  <div class="body_tj4_0 body_tj1_left cursor"></div>
	  <div class="body_tj1_1 cursor"><span class="body_tj_tt1"><?php echo $data['danwei_count']; ?></span><p class="pcs"><span class="body_tj_tt2">单位统计</span></p></div>
	</a>
  </div>
  <div style="clear:both"></div>
  <div class="body_table">
  <div class="body_table_gg">
	  <div class="body_table_gg_0">最新公告</div>
	  <div class="body_table_gg_1">
	    <ul class="body_table_gg_ul">
	<?php
	if (empty($announces)) {
		echo '';
	}
	else {
		foreach ($announces as $k => $v ) {?>
			<li>
				<span class="lispan1">
					<?php echo date('Y-m-d', $v['createtime']);?>
				</span>
				<span class="view_a cursor" date="<?php echo Zhimin::buildUrl('announce', 'system');?>&action=view&id=<?php echo $v['id'];?>">
					<a class="tr_active"><?php echo $v['subject'];?></a>
				</span>
			</li>
		<?php }
	}?>
		</ul>
	  </div>
	</div>
  <!--统计表：根据当前用户显示不同报表-->
    <div class="body_table_chart">
	<div id="canvas10" style="height:350px;width:100%;"></div>
	</div>
  <!---->
    
  </div>

<div class="layer_notice atten_view" style="top: 53px;left: 252px;">
	<div class="notice_top atten_top" style="width:600px;background: url(../images/notice_top1.png) 0 0 no-repeat;"><span style="display:inline-block;width:20px;"></span>查看公告<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
	<div class="notice_body" id="notice_body" style="width:600px"><!-- html come from ajax --></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	// 加载执行判断有无紧急公告
	$.ajax({
            type: "POST",
            url: '/?_a=announce&_c=system&_m=index&action=select',
            dataType: "json",
            success: function(data){
            	if(data.status==1){
	                var post_url='/?_a=announce&_c=system&_m=index&action=view&id='+data.id;
					$.ajax({
			            type: "POST",
			            url: post_url,
			            dataType: "html",
			            success: function(data){
			                   html=data;
			                   $("#notice_body").html(html);
			                   layer.open({
			       				type: 1,
			       				title: false,
			       				closeBtn: 0,
			       				// shadeClose: true,
			       				area: '600px',
			       				content: $('.atten_view')
			       			});
			            }
			    	});
            	}
            }
    });
	// 查看
	$(".view_a").click(function(){
		var post_url=$(this).attr('date');
		$.ajax({
            type: "POST",
            url: post_url,
            dataType: "html",
            success: function(data){
                   html=data;
                   $("#notice_body").html(html);
                   layer.open({
       				type: 1,
       				title: false,
       				closeBtn: 0,
       				// shadeClose: true,
       				area: '600px',
       				content: $('.atten_view')
       			});
            }
    	});
	});
	$('.detail_body').bind('resize', function(e){
		$('.table_detail').show(10);		
	});
});

</script>
</body>
</html>
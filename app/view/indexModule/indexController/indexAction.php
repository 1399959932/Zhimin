<?php $settings = Zhimin::a()->getData('settings');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
<meta http-equiv="cache-control" content="no-cache">	
<title>
<?php echo $settings['site'];?>
</title>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
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
<style>	.notice_top .close{position: absolute;float: right;margin-right: 0px;display: inline-block;margin-top: 0px;}	.letter_top .close{position: absolute;float: right;margin-right: 0px;display: inline-block;margin-top: 0px;}	.atten_top .close {    line-height: normal;    right: 15px;}	
</style>	
<![endif]-->
</head>
<body onload="changeFrameWidth('v_o')">	
	<div class="top" style="height:62px;">		
	<iframe src="<?php echo Zhimin::buildUrl('top');?>" width="100%" height="62px" scrolling="no" frameborder="0">
</iframe>	
</div>	
<div class="wrap_iframe" style="position:relative;width:100%;">		
	<div class="left" style="width:175px;float:left;">			
	<iframe src="<?php echo Zhimin::buildUrl('left');?>" width="100%" height="100%" scrolling="no" id="iframe_left" onload="changeBodyHeight('iframe_left')" frameborder="0">
</iframe>		
</div>		
<div class="right_o" id="v_o" style="width:80%;float:left;">			
	<iframe style="" src="<?php echo Zhimin::buildUrl('main');?>" name="main" width="100%" height="100%" scrolling="no" id="iframe_right" onload="changeBodyHeight('iframe_right')" frameborder="0">
</iframe>		
</div>	
</div>
<!-- 退出确认提示框 --> 
<div class="layer_notice lay_confirm">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="<?php echo Zhimin::g('assets_uri');?>images/close.png" alt="" />
</span>
</div>	
<div class="notice_body1">		
	<div class="n_left">			
	<img src="<?php echo Zhimin::g('assets_uri');?>images/notice_bg.png" />		
</div>		
<div class="n_right">			
	<p>确定退出？
</p>			
<div class="clear">
</div>			
<span class="sure_span sure_out_login">确 定
</span>			
<span class="cancle_span close_btn">取 消
</span>		
</div>	
</div>	
<div class="notice_foot">
</div>
</div> 
<!-- 
<div class="layer_notice lay_confirm">	
<div class="notice_top">
<span style="margin-left:417px;height:50px;line-height:50px;">
<img src="< Zhimin::g('assets_uri');?>images/close.png">
</span>
</div>	
<div class="notice_body1">		
<div class="n_left">			
<img src=" Zhimin::g('assets_uri');?>images/notice_bg.png" />		
</div>		
<div class="n_right">			
<p>确定退出？
</p>			
<div class="clear">
</div>			
<div class="btn">				
<span>确定
</span>
<span style="display:inline-block;width:20px;background:#fff;border:none;">
</span>
<span>取消
</span>			
</div>		
</div>	
</div>	
<div class="notice_foot">
</div>
</div> -->
<!-- 修改密码弹框 -->
<div class="layer_notice password_change">	
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>修改密码
<span class="close close_btn">
	<img src="<?php echo Zhimin::g('assets_uri');?>images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
	<form id="change_pwd_form" action="<?php echo Zhimin::buildUrl('user', 'other');?>" method="post">		
<div class="con_atten_wrap recorder_notice">			
	<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">用户名：
</span>					
<div class="select_260 select_div select_in selec_text">														
	<?php $uusersn =  $_SESSION['username'];?>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">旧密码：
</span>					
<div class="select_260 select_div select_in">														
	<input class="input_text_p" type="password" name="number" value="" isright="0"/>						
<span class="error_msg">密码格式不正确
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">新密码：
</span>					
<div class="select_260 select_div select_in">														
	<input class="input_text_p pwd1" type="password" name="newnumber" value="" isright="0"/>						
<span class="error_msg">密码格式不正确
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">确认密码：
</span>					
<div class="select_260 select_div select_in">														
	<input class="input_text_p pwd2" type="password" name="againnumber" value="" isright="0" />						
<span class="error_msg">新密码和确认密码不一致
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s ">											
	<div class="select_260 select_div select_in selec_text">														
	<span id="btn_submit" class="sure_add sure_change_submit">确 定
</span>						
<span class="sure_cancle close_btn">取 消
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>		
</div>						
</form>	
</div>	
<div class="notice_foot">
</div>
</div>
<!-- 确认提示框 -->
<div class="layer_notice home_prompt">	
	<div class="notice_top">
	<span class="close close_btn">
	<img src="<?php echo Zhimin::g('assets_uri');?>images/close.png" alt="" />
</span>
</div>	
<div class="notice_body1">		
	<div class="n_left">			
	<img src="<?php echo Zhimin::g('assets_uri');?>images/password.png" />		
</div>		
<div class="n_right">			
	<p>确定修改吗？
</p>			
<div class="clear">
</div>			
<span class="sure_span sure_home">确 定
</span>			
<span class="cancle_span close_home">取 消
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
	<img src="<?php echo Zhimin::g('assets_uri');?>images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
	<div class="n_left">			
	<img src="<?php echo Zhimin::g('assets_uri');?>images/success_bg.png" />		
</div>		
<div class="n_right">			
	<p id="success_flg">删除成功......
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
	<img src="<?php echo Zhimin::g('assets_uri');?>images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
	<div class="n_left">			
	<img src="<?php echo Zhimin::g('assets_uri');?>images/notice_bg.png" />		
</div>		
<div class="n_right">			
	<p id="fail_flg">删除失败......
	<font>3
</font>秒钟后返回页面！
</p>			
<div class="clear">
</div>			
<span class="cancle_span close_btn_self">确 定
</span>		
</div>	
</div>	
<div class="notice_foot">
</div>
</div>
<script type="text/javascript">	
if (window!=top) // 判断当前的window对象是否是top对象		
	top.location.href =window.location.href; // 如果不是，将top对象的网址自动导向被嵌入网页的网址
	$('.input_text_p').bind({		
		focus:function(){			
			if (this.value == this.defaultValue){				
				this.value="";			
			}			
			$(this).siblings(".error_msg").animate({right:'-110px',opacity:'0',filter:'alpha(opacity=0)'},"slow");	
		},		
		blur:function(){			
			var len=$(this).val().length;			
			if (this.value == ""){				
				this.value = this.defaultValue;				
				$(this).siblings(".error_msg").animate({right:'5px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
			}			
				if(len < 6 ||len > 12){				
					$(this).siblings(".error_msg").animate({right:'5px',opacity:'1',filter:'alpha(opacity=100)'},"slow");			
				}			
				// 后期做ajax验证处理		
		}	
	});
</script>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	
	<title>
		<?php echo Zhimin::a()->title;?>--登录
</title>
	
	<link rel="stylesheet" type="text/css" href="
	<?php Zhimin::g('assets_uri');?>style/reset.css" />
	
	<link rel="stylesheet" type="text/css" href="
	<?php Zhimin::g('assets_uri');?>style/global.css" />
	
	<script type="text/javascript" src="
	<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>
	
	<script type="text/javascript" src="
	<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>
	
	<script type="text/javascript" src="
	<?php Zhimin::g('assets_uri');?>js/global.js">
</script>
	
	<script type="text/javascript" src="
	<?php Zhimin::g('assets_uri');?>js/loginAction.js">
</script>
	
	<style>
		.layui-layer-border{border: 0;}
	
	</style>

</head>

<body class="body_wrap">
	
	<div class="login_wrap">
		
		<div class="loging_logo">
			
			<span>
				
				<img src="
				<?php echo $logo;?>" width="100%" alt="" />
			
			</span>

			<?php echo $settings['site'];?>
		
		</div>
		
		</div>
		
		<div class="login_main">
			<div class="login_computer">    
			<img src="
		<?php echo Zhimin::g('assets_uri');?>images/computer.png" />  
	</div>		
		<div class="login_content">
	
	<div class="login_title">用户登录
	</div>

<form id="loginForm" action="<?php echo Zhimin::buildUrl('login');?>" name="login_form" method="post">

<div class="input-group">
			    
			    <div class="input-kuan">
			    <span class="input-span input-user">
			    </span>
			    </div>
			    
			    <input class="form-control" type="text" name="username" id="username" value="用户名" isright="0">
				
				<span class="error_msg_login" id="error_username">请输入用户名
				</span>
			  
			  </div>
			  
			  <div class="input-group">
			    
			    <div class="input-kuan">
			    <span class="input-span input-pwd">
			    </span>
			    </div>
					
					<input class="form-control" type="password" name="password" id="password" value="请输入密码" isright="0">
					
					<span class="error_msg_login" id="error_pwd">请输入密码
					</span>
			  
			  </div>

<?php if (isset($settings['safecode']) && ($settings['safecode'] == '1')) {?>
	
	<div class="input-group">
			    
			    <div class="input-kuan">
			    <span class="input-span input-verify">
			    </span>
			    </div>
						
						<input class="form-control form-control-verify" type="text" name="verify" id="verify" value="验证码" isright="0">
						
						<span class="error_msg_verify" id="error_verify">验证码为空
						</span>
			    
			    <div class="verify-img">
			    <img id='checkcode' src="<?php echo Zhimin::g('assets_uri')?>?_a=captcha" onClick="this.src="<?php echo Zhimin::g('assets_uri')?>?_a=captcha&nocache='+Math.random()" alt='换张图片' style="cursor:pointer;" width="100%"/>
						
						</div>
					
					</div>
					
<?php }?>


<div class="input-group-button">
					
					<input class="login-button" type="button" name="login_button" id="login_button" value="" />
					
					<input type="hidden" name="action" value="login_in" />
					
					<input type="hidden" name="formstatus" value="submit" />
				
				</div>

<?php if ($help_file != '') {?>
	
	<div class="input-group-button">
					
					<a href="#" id="help_file_download">
					<img src="<?php echo Zhimin::g('assets_uri');?>	images/down_load.png" width="278">
						
						</a>
					
					</div>
					
<?php }?>

			
			</form>
	
	</div>
	
	</div>
	<div class="copy_right" style="padding-top: 90px;">
		&copy;2016北京智敏科技发展有限公司·版权所有 &nbsp;|&nbsp; 服务热线：
		<?php $settings['telephone'];?>
  &nbsp;|&nbsp; 版本号：
  <?php $version . '&nbsp;&nbsp;' . $zhimintype;?>
	
	</div>

<script type="text/javascript">
	$(document).ready(function(){

	if (window!=top) // 判断当前的window对象是否是top对象
		top.location.href =window.location.href; // 如果不是，将top对象的网址自动导向被嵌入网页的网址

	 //正式提交的时候验证
   $("#login_button").click(function(){
	    $('input').blur();
        var flg_username = $("#username").attr('isright');
        var flg_pwd = $("#password").attr('isright');
        //var flg_verify = $("#verify").attr('isright');
        var password = $('#password').val();
        if(flg_username == '0'){  //验证用户名
            $("#error_username").html('用户名错误');
            $("#error_username").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
            return false;
        }
        if(flg_pwd == '0'){  //验证密码
			//此处有一个BUG，当密码不失焦时，程序不会主动判断flg_pwd的值，需要重新验证一次，update at 20160930 by star
        	//验证为空
            if(password == '' || password == '请输入您密码'){
                $('#password').siblings(".error_msg_login").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                $('#password').attr('isright',0);   //写标记，提交时有用
                return false;
            }else{
            	//验证密码长度，长度大于等于6，小于等于12
                var pwd_len = $('#password').val().length;
                if(pwd_len 
                	< 6){
                    $("#error_pwd").html('密码长度不能小于6位');
                    $("#error_pwd").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                    $('#password').attr('isright',0);
                    return false;
                }
                if(pwd_len > 12){
                    $("#error_pwd").html('密码长度不能大于12位');
                    $("#error_pwd").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                    $('#password').attr('isright',0);
                    return false;
                }
                //验证用户名和密码是否正确
                var username = $('#username').val();
                var url = "./?_a=login&_c=index&_m=index";
                var flag_t=false;                
                $.post(url, { "action": "check_user", "username": username, "password": password },
                    function(data){
                        if(data.state == 'success'){
                        	 $('#password').attr('isright',1);
                        	 $('#password').css("color","#000");
                        	 flag_t=true;
                        }else{
                            $("#error_pwd").html('用户名或密码错误');
                            $("#error_pwd").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                            $('#password').attr('isright',0);
                            return false;
                        }
                },'json');  //ajax取值结束
            } //验证为非空结束

            // $("#error_pwd").html('密码错误');
            if(flag_t){
            	$("#error_pwd").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");	


            return false;
            }
        }
        $('#loginForm').submit();
        return false;
    });
   $(document).keypress(function(e){
   	if(e.which==13){
		$('#username').blur();
		$('#password').blur();
		$('#verify').blur();
   		setTimeout("$('#login_button').click()",1000);
   		;
   	}
   })
	})

</script>

</body>

</html>
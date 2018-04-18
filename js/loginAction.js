$(document).ready(function (){
	// 手册下载
    $('#help_file_download').click(function(event){
    	window.open('./?_a=login&_c=index&_m=index&action=help_file','_blank');
    });// 模板下载结束
    //判断username,搜索框获取焦点和失去焦点效果
    $('#username').bind({
        focus:function(){
            if (this.value == this.defaultValue){
                this.value="";
            }
            $(this).parent(".input_div").addClass("input_focus");
            //动画变透明
$(this).siblings(".error_msg_login").animate({right:'-110px',opacity:'0',filter:'alpha(opacity=0)'},"slow");
        },
        blur:function(){
            if (this.value == ""){
                this.value = this.defaultValue;
            }
            $(this).parent(".input_div").removeClass("input_focus");

            //验证为空
            if(this.value == this.defaultValue){
                $(this).siblings(".error_msg_login").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                $('#username').attr('isright',0);
                return false;
            }else{
            	//验证用户名是否存在
            	var username = $('#username').val();
                var url = './?_a=login&_c=index&_m=index';
                $.post(url, { "action": "check_username", "username": username },
                    function(data){
                        if(data.state == 'success'){
                            $('#username').attr('isright',1);
                            $('#username').css("color","#000");
                        }else{
                            $("#error_username").html('用户名不存在');
                            $("#error_username").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                            $('#username').attr('isright',0);
                            return false;
                        }
                },'json');  //ajax取值结束
            } //验证为非空结束
        }//blur结束
    });
    //判断password,搜索框获取焦点和失去焦点效果
    $('#password').bind({
        focus:function(){
            if (this.value == this.defaultValue){
                this.value="";
            }
            $(this).parent(".input_div").addClass("input_focus");
            //动画变透明
            $(this).siblings(".error_msg_login").animate({right:'-115px',opacity:'0',filter:'alpha(opacity=0)'},"slow");
        },
        blur:function(){
            if (this.value == ""){
                this.value = this.defaultValue;
            }
            $(this).parent(".input_div").removeClass("input_focus");

            //验证为空
            if(this.value == this.defaultValue){
                $(this).siblings(".error_msg_login").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                $('#password').attr('isright',0);   //写标记，提交时有用
                return false;
            }else{
            	//验证密码长度，长度大于等于6，小于等于12
                var pwd_len = $('#password').val().length;
                if(pwd_len < 6){
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
                var password = $('#password').val();
                var url = "./?_a=login&_c=index&_m=index";
                $.post(url, { "action": "check_user", "username": username, "password": password },
                    function(data){
                        if(data.state == 'success'){
                        	 $('#password').attr('isright',1);
                        	 $('#password').css("color","#000");
                        }else{
                            $("#error_pwd").html('用户名或密码错误');
                            $("#error_pwd").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                            $('#password').attr('isright',0);
                            return false;
                        }
                },'json');  //ajax取值结束
            } //验证为非空结束
        }//blur结束
    })
    //判断verify,搜索框获取焦点和失去焦点效果
    $('#verify').bind({
        focus:function(){
            if (this.value == this.defaultValue){
                this.value="";
            }
            $(this).parent(".input_div").addClass("input_focus");
            //动画变透明
            $(this).siblings(".error_msg_verify").animate({right:'-110px',opacity:'0',filter:'alpha(opacity=0)'},"slow");
        },
        blur:function(){
            if (this.value == ""){
                this.value = this.defaultValue;
            }
            $(this).parent(".input_div").removeClass("input_focus");

            //验证为空
            if(this.value == this.defaultValue){
                $(this).siblings(".error_msg_verify").animate({right:'90px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                $('#verify').attr('isright',0);
                return false;
            }else{
            	//验证验证码是否正确
                var verify = $('#verify').val();
                var url = "./?_a=login&_c=index&_m=index";
                $.post(url, { "action": "check_verify", "verify": verify},
                    function(data){
                        if(data.state == 'success'){
                        	$('#verify').attr('isright',1);
                        	$('#verify').css("color","#000");
                        }else{
                            $("#error_verify").html('验证码错误');
                            $("#error_verify").animate({right:'90px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
                            $('#verify').attr('isright',0);
                            return false;
                        }
                },'json');  //ajax取值结束
            } //验证为非空结束
        }//blur结束
    })
});


    $(document).ready(function(){
        //验证只能输入中文
        $("#site").blur(function(){
            if($("#site").val()==''){
                var $parent = $(this).parent();
                $parent.find(".formtips").remove();
                $parent.append('<span class="formtips onError"><font color="red">不能为空！</font></span>');
            }
        });

        //验证图片格式
        $("#main_file_logo").blur(function(){
            var filepath=$("#main_file_logo").val();
            var extStart=filepath.lastIndexOf(".");
            var ext=filepath.substring(extStart,filepath.length).toUpperCase();
            var $parent = $(this).parent();
            $parent.find(".formtips").remove();
            if(ext!=".BMP"&&ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
                $parent.append('<span class="formtips onError"><font color="red">图片限于bmp,png,gif,jpeg,jpg格式!</font></span>');

                return false;
            }else{
                $parent.val("");
            }
        });
        //验证邮箱格式
        $("#admin_mail").blur(function(){
            var $parent = $(this).parent();
            $parent.find(".formtips").remove();
            if(this.value=="" || ( this.value!="" && !/.+@.+\.[a-zA-Z]{2,4}$/.test(this.value) )){
                $parent.append('<span class="formtips onError"><font color="red">邮箱格式不正确!</font></span>');
                //$parent.animate({right:'15px',opacity:'0',filter:'alpha(opacity=1)'},"slow");
                return false;
            }else{
                $parent.val("");
            }
        });

        //验证联系电话
        $("#telephone").blur(function(){
            var $parent = $(this).parent();
            $parent.find(".formtips").remove();
            if(this.value=="" || ( !/^\d{3,4}-?\d{7,9}$/.test(this.value)||/^(?:13\d|15\d)\d{5}(\d{3}|\*{3})$/.test(this.value))){
                $parent.append('<span class="formtips onError"><font color="red">电话号码格式不正确!</font></span>');
                return false;
            }else{
                $parent.val("");
            }
        });
        //验证数字为整数
        $("#auto_del_gps,#auto_del_hostip_log,#onworktime,#auto_del_file,#auto_del_log,#auto_del_device_log,#onworkday").blur(function(){
            var ex = /^\d+$/;
            var $parent = $(this).parent();
            $parent.find(".formtips").remove();
            if (!ex.test(this.value)) {
                $parent.append('<span class="formtips onError"><font color="red">必须为整数!</font></span>');
                return false;
            }else{
                $parent.val("");
            }
        });

        $('#form_submit').click(function(){
            $("form").trigger('blur');
            var numError = $('form .onError').length;
            if(numError){
                return false;
            }
        });
    });


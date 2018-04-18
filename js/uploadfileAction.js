

    $(document).ready(function(){
        $("#pnumber").blur(function(){
            if($("#pnumber").val()==''){
                var $parent = $(this).parent();
                $parent.find(".formtips").remove();
                $parent.append('<span class="formtips onError"><font color="red">不能为空！</font></span>');
            }
        });
        $("#hostbody").blur(function(){
            if($("#hostbody").val()==''){
                var $parent = $(this).parent();
                $parent.find(".formtips").remove();
                $parent.append('<span class="formtips onError"><font color="red">不能为空！</font></span>');
            }
        });

        $('#form_submit').click(function(){
            if($("#pnumber").val()==''){
                var $parent = $("#pnumber").parent();
                $parent.find(".formtips").remove();
                $parent.append('<span class="formtips onError"><font color="red">不能为空！</font></span>');
            }
            if($("#hostbody").val()==''){
                var $parent = $("#hostbody").parent();
                $parent.find(".formtips").remove();
                $parent.append('<span class="formtips onError"><font color="red">不能为空！</font></span>');
            }
            $("form").trigger('blur');
            var numError = $('form .onError').length;
            if(numError){
                return false;
            }
        });
    });


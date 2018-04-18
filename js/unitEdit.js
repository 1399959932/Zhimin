/**
 * Created by 11 on 2016/9/9.
 */
$(function(){
    $(".layer_iframe1 .close_btn").click(function(){
        parent.layer.closeAll();
    })
    $(".close_btn").click(function(){
        layer.closeAll();
    });
  //编辑保存
    $("#edit_submit").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=unitedit&_c=system&_m=index&action=edit',
 			method: 'post',
 			data: $('#unit_edit_form').serialize(),
 			dataType: 'json',
 			success: function(data) {
 				if(data.state == 'fail'){   //如果失败
 					var message = data.msg;
 					message += '......<font>3</font>秒钟后返回页面！';
 					$('#fail_flg').html(message);
 					index_layer = layer.open({
     					type: 1,
     					title: false,
     					closeBtn: 0,
     					shadeClose: true,
     					area: '449px',
     					time: 3000, //3s后自动关闭
     					content: $('.lay_wrong')
     				});
 				}else if(data.state == 'success'){ //如果成功
 					var message = data.msg;
 					message += '......<font>3</font>秒钟后返回页面！';
 					$('#success_flg').html(message);
 					layer.open({
     					type: 1,
     					title: false,
     					closeBtn: 0,
     					shadeClose: true,
     					area: '449px',
     					time: 3000, //3s后自动关闭
     					content: $('.lay_success')
     				});
 					setTimeout("location.reload()",3000);
 				}
 				return fasle;
 			}			
 		});

    });
    //此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });

    //搜索框获取焦点和失去焦点效果
    /*$('.input_error1').bind({
        focus:function(){
            if (this.value == this.defaultValue){
                this.value="";
            }
            $(this).siblings(".error_msg").animate({right:'-85px',opacity:'0',filter:'alpha(opacity=0)'},"slow");
        },
        blur:function(){
            if (this.value == ""){
                this.value = "";
            }
            // $(this).parent(".input_div").removeClass("input_focus");
            // 后期做ajax验证处理
            $(this).siblings(".error_msg").animate({right:'2px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
        }
    })*/
});

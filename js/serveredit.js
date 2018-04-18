$(function(){
	var index_layer;
    $(".layer_iframe1 .close_btn").click(function(){
        parent.layer.closeAll();
    })
    $(".close_btn").click(function(){
        layer.closeAll();
    });
    $(".lay_success_edit .close_btn").click(function(){
    	parent.layer.closeAll();
    });
    
  //编辑保存
    $(".edit_submit").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=serveredit&_c=host&_m=index&action=edit',
 			method: 'post',
 			data: $('#server_edit_form').serialize(),
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
     					content: $('.lay_wrong_edit')
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
     					content: $('.lay_success_edit')
     				});
 					setTimeout("parent.layer.closeAll();",3000);
 				}
 				return false;
 			}			
 		});
    });
  //此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
});
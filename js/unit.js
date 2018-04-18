//修改框
function sendEdit(bh){
	var index_layer;
	$.ajax({
        type: "POST",
        url: './?_a=unit&_c=system&_m=index&action=edit',
        data: {bh:bh},
        dataType: "json",
        success: function(data){
        	if(data.state == 'fail'){   //获取数据如果失败
					var message = data.msg;
					message += '......<font>3</font>秒钟后返回页面！';
					index_layer = $('#fail_flg').html(message);
						index_layer = layer.open({
						type: 1,
						title: false,
						closeBtn: 0,
						shadeClose: true,
						area: '449px',
						time: 3000, //3s后自动关闭
						content: $('.lay_wrong')
					});
				}else if(data.state == 'success'){ //如果成功，设置值成功后，显示编辑页面
					//alert(data.username);return false;
					if(data.sort == '' || data.sort == null){
						data.sort = 1;
					}
					$('#edit_bh').html(data.bh);
					$('#edit_parent').html(data.p_name);
					$('#edit_dname').val(data.dname);
					$('#edit_orderby').val(data.sort);
					$('#edit_beizhu').val(data.note);
					$('#edit_id').val(data.id);
					layer.open({
						type: 1,
						title: false,
						closeBtn: 0,
						// shadeClose: true,
						area: '449px',
						content: $('.atten_edit')
					}); 
				}  //获取数据如果失败
        } //第一层ajax，调用成功结束
	}); //第一层ajax结束
}
function sendDel(bh){
	$("#confirm_del_bh").attr("value",bh);//填充内容
	lay_open=layer.open({
		type: 1,
		title: false,
		closeBtn: 0,
		// shadeClose: true,
		area: '449px',
		content: $('.lay_confirm_del')
	});    	
}

$(document).ready(function(){
	var index_layer;
	//添加单位,提交Form
	$('#add_submit').click(function(){
		$.ajax({
				url: './?_a=unit&_c=system&_m=index&action=add',
				method: 'post',
				data: $('#unit_add_form').serialize(),
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
						setTimeout("location.reload()",3000);  //刷新
					}
					return false;
				}			
		});
	});
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
	// 删除确定后的操作
	$(".sure_one_del").click(function(){    	
	     layer.closeAll(); 
	     var bh=$("#confirm_del_bh").val();   //得到记录bh
	     $.ajax({
				url: './?_a=unit&_c=system&_m=index&action=del',
				method: 'post',
				data: {bh:bh},
				dataType: 'json',
				success: function(data) {
					if(data.state == 'success'){
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
						setTimeout("location.reload()",3000);  //刷新
					}else{
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
					}
					return false;
				}			
	     }); 
	 })   // 删除确定后的操作，结束
	 //编辑保存
    $("#edit_submit").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=unit&_c=system&_m=index&action=edit',
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
 				return false;
 			}			
 		});
    });  ////修改密码提交Form处理结束
})//最外层function

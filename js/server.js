$(document).ready(function(){
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
	});
	
	//添加
	$(".condition_top #add_sure").click(function(){
		$.ajax({
			url: './?_a=server&_c=host&_m=index&action=add',
			method: 'post',
			data: $('#server_add_form').serialize(),
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
					setTimeout("location.reload()",3000);  //3秒后刷新页面
				}
				return false;
			}			
		});
		
	});	
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
    //修改框开始
	/*$('.edit_a').on('click', function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var url='./?_a=serveredit&_c=host&_m=index&action=edit&id='+id;
			layer.open({   //打开新的Form
	            type: 2,
	            title: false,
	            closeBtn: 0,
	            // shadeClose: true,
	            area: ['470px','410px'],
	            content:[url,'no']
	        });
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    });//修改框结束*/
	
	//修改框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=server&_c=host&_m=index&action=edit',
	            data: {id:id},
	            dataType: "json",
	            success: function(data){
	            	if(data.state == 'fail'){   //获取数据如果失败
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
     				}else if(data.state == 'success'){ //如果成功，设置值成功后，显示编辑页面
     					//alert(data.username);return false;
     					$('#edit_servername').val(data.servername);
     					$('#edit_serverip').val(data.serverip);
     					$('#edit_ftpusername').val(data.ftpusername);
     					$('#edit_pwd').val(data.pwd);
     					$('#edit_port').val(data.port);
     					$('#edit_path').val(data.path);
     					$('#edit_flag').html(data.flag);
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
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
	});//修改框结束
	//编辑保存
    $("#edit_submit").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=server&_c=host&_m=index&action=edit',
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
    
})

<?php session_start(); ?>

$(document).ready(function(){
	//定义一个全局变量，保存打开的
	var index_layer;
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
		$(".action_state .action_merge").addClass("on");
		$(".action_state .action_warning").addClass("on");
		$(".action_state .action_scrap").addClass("on");
		$(".action_state .action_del").addClass("on");
		$(".action_state .action_up").addClass("on");
		$("#admin_update").addClass("on");
	});
	//添加用户,提交Form
	$('#add_submit').click(function(){
		$.ajax({
				url: './?_a=device&_c=device&_m=index&action=add',
				method: 'post',
				data: $('#device_add_form').serialize(),
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
						setTimeout("location.reload()",3000);  //刷新页面
					}
					return false;
				}			
		});
	});
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
	// 删除单条信息
	$('.action_del').on('click', function(){
		if($('.action_del').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			lay_open=layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_confirm_del')
			}); 
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
    })
	 // 删除确定后的操作
   $(".sure_one_del").click(function(){
        layer.closeAll(); 
        var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
        $.ajax({
			url: './?_a=device&_c=device&_m=index&action=del',
			method: 'post',
			data: {id:id},
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
					setTimeout("location.reload()",3000);  //刷新页面
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
    //执行报废操作
    $(".action_scrap").click(function(){
    	if($('.action_scrap').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_scrp')
			});
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}
    })//执行报废操作,end
	// 报废弹框，确定后的操作
	$(".sure_scrp").click(function(){
		layer.closeAll(); 
        var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
        $.ajax({
			url: './?_a=device&_c=device&_m=index&action=scrap',
			method: 'post',
			data: {id:id},
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
					setTimeout("location.reload()",3000);  //刷新页面
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
	})// 报废弹框，确定后的操作，结束
	// 合并设备开始
	$('.action_merge').on('click', function(){
		if($('.action_merge').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$('#hostbody_new').val('');
			$.ajax({
	            type: "POST",
	            url: './?_a=device&_c=device&_m=index&action=merge_device',
	            data: {id:id},
	            dataType: "json",
	            success: function(data){
	                 $("#atten_merge_hostbody").html("当前设备号："+data.hostbody);
	                 $("#atten_merge_hostname").html("配发<?php echo $_SESSION['zfz_type'] ?>："+data.hostname);
	                 $("#hostbody_old").val(data.hostbody);
	                 layer.open({
	       				type: 1,
	       				title: false,
	       				closeBtn: 0,
	       				// shadeClose: true,
	       				area: '470px',
	       				content: $('.atten_merge')
	       			});
	            } //第一层ajax，调用成功结束
	    	}); //第一层ajax结束
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    })//合并设备结束
	//合并设备提交Form处理
	$('#atten_merge_submit').on('click', function(){
	     $.ajax({
	          url: './?_a=device&_c=device&_m=index&action=merge_device&saveflag=1',
	          method: 'post',
	          data: $('#atten_merge_form').serialize(),
	          dataType: 'json',
	          success: function(data2) {
	          if(data2.state == 'fail'){   //如果失败
	             	var message = data2.msg;
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
	           }else if(data2.state == 'success'){ //如果成功
	             	var message = data2.msg;
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
	             	setTimeout("location.reload()",3000);  //刷新页面
	           }
	           return false;
	      }			
	   });
	});  ////修改密码提交Form处理结束

	//修改框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=device&_c=device&_m=index&action=edit',
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
     					var dbh = data.danwei;
     					$('#edit_hostbody').html(data.hostbody);
     					$('#edit_hostcode').val(data.hostcode);
     					$('#edit_hostname').val(data.hostname);
     					$('#edit_product_name').val(data.product_name);
     					$('#edit_product_firm').val(data.product_firm);
     					$('#edit_capacity').val(data.capacity);
     					$('#edit_id').val(data.id);
     					/*search list tree*/
     					//$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
						//modify
     					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname&type=1',method:'get',labelPosition:'top',panelWidth:'500px',
						//
     					// 设置选中项
     					onLoadSuccess:function(node,data){
     						$("#easyui_edit").combotree('setValues', [dbh]);  
     				    } 
     					});  /*search list tree end*/
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
 			url: './?_a=device&_c=device&_m=index&action=edit',
 			method: 'post',
 			data: $('#device_edit_form').serialize(),
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
    
	// 报障设备
	$('.action_warning').on('click', function(){
		if($('.action_warning').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.atten_warning')
			});    	
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    	
    })
    //报障设备提交Form处理
	$('#atten_warning_submit').on('click', function(){
		 var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
	     $.ajax({
	          url: './?_a=device&_c=device&_m=index&action=warning_device&id='+id,
	          method: 'post',
	          data: $('#device_warning_form').serialize(),
	          dataType: 'json',
	          success: function(data2) {
	          if(data2.state == 'fail'){   //如果失败
	             	var message = data2.msg;
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
	           }else if(data2.state == 'success'){ //如果成功
	             	var message = data2.msg;
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
	             	setTimeout("location.reload()",3000);  //刷新页面
	           }
	           return false;
	      }			
	   });
	});  ////报障设备提交Form处理结束
	//执行启用操作
    $(".action_up").click(function(){
    	if($('.action_up').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_up')
			});
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}
    })//执行报废操作,end
	// 报废弹框，确定后的操作
	$(".sure_up").click(function(){
		layer.closeAll(); 
        var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
        $.ajax({
			url: './?_a=device&_c=device&_m=index&action=up',
			method: 'post',
			data: {id:id},
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
					setTimeout("location.reload()",3000);  //刷新页面
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
	})// 报废弹框，确定后的操作，结束
    // 更新设备
    $(".update").click(function(){
    	layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			time: 3000, //3s后自动关闭
			content: $('.update_success')
		});
    })
    
    // 更新设备弹出框
	$('#admin_update').on('click', function(){
		lay_open=layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			content: $('.lay_scrp_update')
		}); 
    })
	 // 删除确定后的操作
   $(".sure_scrp_update").click(function(){
        layer.closeAll(); 
        $.ajax({
			url: './?_a=device&_c=device&_m=index&action=update',
			method: 'post',
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
					setTimeout("location.reload()",3000);  //刷新页面
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
})//最外层function

$(document).ready(function(){
	//定义一个全局变量，保存打开的
	var index_layer;
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
		$(".action_state .password_btn").addClass("on");
		$(".action_state .scope_btn").addClass("on");
		$(".action_state .stop_btn_s").addClass("on");
		$(".action_state .up_btn_s").addClass("on");
		$(".action_state .action_del").addClass("on");
	});
	//添加用户,提交Form
	$('#add_submit').click(function(){
		$.ajax({
				url: './?_a=user&_c=system&_m=index&action=add',
				method: 'post',
				data: $('#user_add_form').serialize(),
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
        					// time: 3000, //3s后自动关闭
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
        					// time: 3000, //3s后自动关闭
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
			url: './?_a=user&_c=system&_m=index&action=deluser',
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
    
    // 停用弹框
	$(".stop_btn_s").click(function(){
		if($('.stop_btn_s').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_confirm_stop')
			});
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}
	})
	// 停用弹框，确定后的操作
	$(".stop_btn").click(function(){
		layer.closeAll(); 
        var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
        $.ajax({
			url: './?_a=user&_c=system&_m=index&action=unpass',
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
	})// 停用弹框，确定后的操作，结束
	// 启用弹框
	$(".up_btn_s").click(function(){
		if($('.up_btn_s').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_confirm_up')
			}); 
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
	})
	// 启用弹框，点击 确认
	$(".up_btn").click(function(){
		layer.closeAll(); 
        var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
        $.ajax({
			url: './?_a=user&_c=system&_m=index&action=pass',
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
	})  //启用弹框，点击确认后结束
	// 重置密码确认信息
	$('.password_btn').on('click', function(){
		if($('.password_btn').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			lay_open=layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_confirm_reset')
			}); 
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
    })
	//重置密码
	$(".sure_one_reset").click(function(){
		layer.closeAll(); 
		var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
		$.ajax({
            type: "POST",
            url: './?_a=user&_c=system&_m=index&action=changepass',
            data: {id:id},
            dataType: "json",
            success: function(data){
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
    })
	/*修改密码改为重置密码
	//修改密码弹框
	$(".password_btn").click(function(){
		if($('.password_btn').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=user&_c=system&_m=index&action=changepass',
	            data: {id:id},
	            dataType: "json",
	            success: function(data){
	              
	            	$('#pwd_change_username').html(data.username);
 					$('#pwd_change_id').val(data.id);
	                 layer.open({
	       				type: 1,
	       				title: false,
	       				closeBtn: 0,
	       				// shadeClose: true,
	       				area: '449px',
	       				content: $('.password_change')
	       			});
	            } //第一层ajax，调用成功结束
	    	}); //第一层ajax结束
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
	}) //修改密码弹框结束
	//修改密码提交Form处理
	 $('#change_pwd_submit').on('click', function(){
		 $.ajax({
			url: './?_a=user&_c=system&_m=index&action=changepass&saveflag=1',
			method: 'post',
			data: $('#change_pwd_form').serialize(),
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
	 });  ////修改密码提交Form处理结束*/
	//修改框,以下是用iframe的方式来处理的，现在修正为在本页弹出层
	/*$('.edit_a').on('click', function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var url='./?_a=useredit&_c=system&_m=index&action=edit&id='+id;
			layer.open({   //打开新的Form
	            type: 2,
	            title: false,
	            closeBtn: 0,
	            // shadeClose: true,
	            area: ['460px','382px'],
	            content:[url,'no']
	        });
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    });*///修改框结束
	
	//修改框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=user&_c=system&_m=index&action=edit',
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
     					var dbh = data.dbh;
     					var gid = data.gid;
     					if(data.sort == '' || data.sort == null){
     						data.sort = 1;
     					}
     					$('#edit_username').html(data.username);
     					$('#edit_hostcode').val(data.hostcode);
     					$('#edit_realname').val(data.realname);
     					$('#edit_sort').val(data.sort);
     					$('#edit_id').val(data.id);
     					/*search list tree*/
     					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
     					// 设置选中项
     					onLoadSuccess:function(node,data){
     						$("#easyui_edit").combotree('setValues', [dbh]);  
     				    } 
     					});  /*search list tree end*/
 						$('#edit_group').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top',
 							onLoadSuccess:function(data){ 
 								$('#edit_group').combobox('setValue',[gid]);
 							}	
 						});
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
 			url: './?_a=user&_c=system&_m=index&action=edit',
 			method: 'post',
 			data: $('#user_edit_form').serialize(),
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
	// 模板下载
    $('#excel_demo').click(function(event){
    	window.open('./?_a=user&_c=system&_m=index&action=excel_demo','_blank');
    });// 模板下载结束
    
    $('#excel_input').click(function(){
    	layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			shadeClose: true,
			area: '449px',
			//time: 3000, //3s后自动关闭
			content: $('.input_form')
		});
    });// 模板下载结束
    $('#excel_input_form').click(function(){
    	layer.closeAll();
    	$('#excel_form').submit();
    	return false;
    });
    //管理范围开始
    $('.scope_btn').click(function(){
    	if($('.scope_btn').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			//先将页面的checkbox的状态清空
			$('.checkbox').removeClass('cur');
		    $('.checkbox').siblings("input[type='checkbox']").prop('checked',false);
			$.ajax({
	            type: "POST",
	            url: './?_a=user&_c=system&_m=index&action=manager',
	            data: {id:id},
	            dataType: "json",
	            success: function(data){
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
	 					var unit = data.msg;
	 					var user_id = data.id;
	 					if(unit != ''){
	 						$(unit.split(",")).each(function (i,dom){
	 					        $(":checkbox[id='manager_unit_"+dom+"']").prop('checked',true);
	 					        $(":checkbox[id='manager_unit_"+dom+"']").siblings('.checkbox').addClass('cur');
	 					    });
	 					}
	 					$('#manager_unit_id').val(user_id);
	 					layer.open({
	 						type: 1,
	 						title: false,
	 						closeBtn: 0,
	 						// shadeClose: true,
	 						area: '449px',
	 						content: $('.scope')
	 					});
	 				}
	 				return false;
	            } //第一层ajax，调用成功结束
	    	}); //第一层ajax结束
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}
    });//管理范围结束
    //管理范围点击确定后
	$("#manager_submit").click(function(){
		var id = $('#manager_unit_id').val();
		/*var result = new Array();
        $('input[type="checkbox"]:checked').each(function(){//遍历每一个名字为interest的复选框，其中选中的执行函数    
        	result.push($(this).attr("date"));//将选中的值添加到数组chk_value中    
        });
        alert(result.join(","));return false;*/
		//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=user&_c=system&_m=index&action=manager',
 			method: 'post',
 			data: $('#manager_edit_form').serialize(),
 			dataType: 'json',
 			success: function(data) {
 				if(data.state == 'fail'){   //如果失败
 					var message = data.msg;
 					message += '...<br /><font>3</font>秒钟后返回页面！';
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
 					message += '...<font>3</font>秒钟后返回页面！';
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
	})//管理范围点击确定后,结束
})//最外层function

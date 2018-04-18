//修改框
$(document).ready(function(){
	var index_layer;
	$(".layer_iframe1 .close_btn").click(function(){
        parent.layer.closeAll();
    })
    $(".close_btn").click(function(){
        layer.closeAll();
    });
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
		$(".action_state .action_del").addClass("on");
		$(".action_state .global_c_hostip").addClass("on");
	});
	//添加单位,提交Form
	$('#add_submit').click(function(){
		$.ajax({
				url: './?_a=hostip&_c=host&_m=index&action=add',
				method: 'post',
				data: $('#hostip_add_form').serialize(),
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
			url: './?_a=hostip&_c=host&_m=index&action=del',
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
    
    //修改框
	/*$('.edit_a').on('click', function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var url='./?_a=hostipedit&_c=host&_m=index&action=edit&id='+id;
			layer.open({   //打开新的Form
	            type: 2,
	            title: false,
	            closeBtn: 0,
	            // shadeClose: true,
	            area: ['470px','472px'],
	            content:[url,'no']
	        });
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    });*/ //修改框结束
	
	//修改框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=hostip&_c=host&_m=index&action=edit',
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
     					var dbh = data.unitcode;
     					$('#edit_hostname').html(data.hostname);
     					$('#edit_hostip').val(data.hostip);
     					$('#edit_contact').val(data.contact);
     					$('#edit_telephone').val(data.telephone);
     					$('#edit_address').val(data.address);
     					$('#edit_memo').val(data.memo);
     					$('#edit_id').val(data.id);
     					/*search list tree*/
     					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
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
 			url: './?_a=hostip&_c=host&_m=index&action=edit',
 			method: 'post',
 			data: $('#hostip_edit_form').serialize(),
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
    });//编辑保存结束 
    
    // 全局配置弹框
    $(".global_c").on('click', function(){
    	var url = './?_a=hostglobal&_c=host&_m=index&action=aglobal&exglobal=1';
    	layer.open({
			type: 2,
			title: false,
			// shadeClose: true,
			closeBtn: 0,
			area: ['470px','472px'],
			content: [url, 'no'] //iframe的url
		}); 
	});
    // 单个远程配置弹框
    $(".global_c_hostip").on('click', function(){
    	if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
    		var id = $(".tbody_atten tr.tr_on").attr("date");
    		var url = './?_a=hostglobal&_c=host&_m=index&action=oglobal&id='+id;
    		layer.open({
    			type: 2,
    			title: false,
    			// shadeClose: true,
    			closeBtn: 0,
    			area: ['470px','472px'],
    			content: [url, 'no'] //iframe的url
    		});
    	}
	});
})//最外层function

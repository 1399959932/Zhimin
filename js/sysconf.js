$(document).ready(function(){
	// 选中表格的行
	var gid="";
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
		$(".action_state .action_del").addClass("on");
		gid = $(this).attr("date");
	});
	
	//添加
	$(".condition_top #add_sure").click(function(){
		$.ajax({
			url: './?_a=sysconf&_c=system&_m=index&action=add',
			method: 'post',
			data: $('#sysconf_add_form').serialize(),
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
					setTimeout("location.reload()",3000);  //关闭所有的弹框
				}
				//return false;
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
			url: './?_a=sysconf&_c=system&_m=index&action=del',
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
					setTimeout("location.reload()",3000);  //3秒后刷新页面
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
			}			
        }); 
    })   // 删除确定后的操作，结束
	
    //修改框
	/*$('.edit_a').on('click', function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var url='./?_a=sysconfedit&_c=system&_m=index&action=edit&id='+id;
			layer.open({   //打开新的Form
	            type: 2,
	            title: false,
	            closeBtn: 0,
	            shadeClose: true,
	            area: ['460px','382px'],
	            content:[url,'no']
	        });
			return false;
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
	            url: './?_a=sysconf&_c=system&_m=index&action=edit',
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
     					var typeval=data.type;
     					$('#edit_confname').val(data.confname);
     					$('#edit_confvalue').val(data.confvalue);
     					$('#edit_note').val(data.note);
     					$('#edit_id').val(data.id);
     					$('#edit_type').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top',
     						onLoadSuccess:function(data){ 
     							$('#edit_type').combobox('setValue',[typeval]);
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
 			url: './?_a=sysconf&_c=system&_m=index&action=edit',
 			method: 'post',
 			data: $('#sysconf_edit_form').serialize(),
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

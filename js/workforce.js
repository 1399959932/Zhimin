$(document).ready(function(){
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit").addClass("on");
		$(".action_state .delete").addClass("on");
		$(".action_state .import").addClass("on");
	});
	
	//添加
	$(".condition_top #add_sure").click(function(){
		$.ajax({
			url: './?_a=workforce&_c=sup&_m=index&action=add',
			method: 'post',
			data: $('#workforce_add_form').serialize(),
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
	// 删除单条信息
	$('.delete').on('click', function(){
		if($('.delete').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
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
			url: './?_a=workforce&_c=sup&_m=index&action=delete',
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
    /*//修改框开始
	$('.edit').on('click', function(){
		if($('.edit').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var url='./?_a=workforcedit&_c=sup&_m=index&action=edit&id='+id;
			layer.open({   //打开新的Form
	            type: 2,
	            title: false,
	            closeBtn: 0,
	            // shadeClose: true,
	            area: ['470px','350px'],
	            content:[url,'no']
	        });
		}else{   //如果没有点亮，说明不能操作
			return false;
		} 
    });//修改框结束*/
    
    //修改框
	$(".edit").click(function(){
		if($('.edit').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=workforce&_c=sup&_m=index&action=edit',
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
     					var classid=data.classid;
     					var danwei=data.danwei;
     					$('#edit_usename').val(data.usename);
     					$('#edit_usecode').val(data.usecode);
     					$('#edit_statdate').val(data.statdate);
     					$('#edit_stattime').val(data.statdate+' '+data.stattime);
     					$('#edit_endtime').val(data.statdate+' '+data.endtime);
     					$('#edit_id').val(data.id);
     					$('#classid').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top',
     						onLoadSuccess:function(data){ 
     							$('#classid').combobox('setValue',[classid]);
     						}	
     					});
     					/*search list tree*/
     					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
     					// 设置选中项
     					onLoadSuccess:function(node,data){
     						$("#easyui_edit").combotree('setValues', [danwei]);  
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
 			url: './?_a=workforce&_c=sup&_m=index&action=edit',
 			method: 'post',
 			data: $('#workforce_edit_form').serialize(),
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
    });  
	
	// 模板下载
    $('.down_modul').click(function(event){
    	window.open('./?_a=workforce&_c=sup&_m=index&action=down_modul','_blank');
    });// 模板下载结束
    
    // Excel表格导入
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
    });// Excel表格导入结束
    $('#excel_input_form').click(function(){
    	layer.closeAll();
    	$('#excel_form').submit();
    	return false;
    });
    
    //添加自动加载警员，警号，单位
    $('.atten_add #usecode').blur(function(){
    	var usecode=$(".atten_add #usecode").val();
    	$.ajax({
			url: './?_a=workforce&_c=sup&_m=index&action=add',
			method: 'post',
			data: {usecode:usecode},
			dataType: 'json',
			success: function(data) {
				if(data.state == 'success'){
					var message = data.msg;
					var res=Array();
					res=message.split(",");
					$(".atten_add #usename").val(res[0]);
					//$(".atten_add #danwei").val(res[1]);
					$(".easyui-combotree").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
						// 设置选中项
						onLoadSuccess:function(node,data){
							$(".easyui-combotree").combotree('setValues', [res[1]]);  
					    }  
						}); 
					//setTimeout("location.reload()",3000);  //3秒后刷新页面
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
    });
    //添加自动加载警员，警号，单位
    $('.atten_add #usename').blur(function(){
    	var usename=$(".atten_add #usename").val();
    	$.ajax({
    		url: './?_a=workforce&_c=sup&_m=index&action=add',
    		method: 'post',
    		data: {usename:usename},
    		dataType: 'json',
    		success: function(data) {
    			if(data.state == 'success'){
    				var message = data.msg;
    				var res=Array();
    				res=message.split(",");
    				$(".atten_add #usecode").val(res[0]);
    				//$(".atten_add #danwei").val(res[1]);
    				$(".easyui-combotree").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
    					// 设置选中项
    					onLoadSuccess:function(node,data){
    						$(".easyui-combotree").combotree('setValues', [res[1]]);  
    					}  
    				}); 
    				//setTimeout("location.reload()",3000);  //3秒后刷新页面
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
    })
    //修改自动加载警员，警号，单位
    $('.atten_edit .usecode').blur(function(){
    	var usecode=$(".atten_edit .usecode").val();
    	$.ajax({
			url: './?_a=workforce&_c=sup&_m=index&action=edit',
			method: 'post',
			data: {usecode:usecode},
			dataType: 'json',
			success: function(data) {
				if(data.state == 'success'){
					var message = data.msg;
					var res=Array();
					res=message.split(",");
					$(".atten_edit .usename").val(res[0]);
					//$(".atten_add #danwei").val(res[1]);
					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
						// 设置选中项
						onLoadSuccess:function(node,data){
							$("#easyui_edit").combotree('setValues', [res[1]]);  
					    }  
						}); 
					//setTimeout("location.reload()",3000);  //3秒后刷新页面
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
    });
    //修改自动加载警员，警号，单位
    $('.atten_edit .usename').blur(function(){
    	var usename=$(".atten_edit .usename").val();
    	$.ajax({
    		url: './?_a=workforce&_c=sup&_m=index&action=edit',
    		method: 'post',
    		data: {usename:usename},
    		dataType: 'json',
    		success: function(data) {
    			if(data.state == 'success'){
    				var message = data.msg;
    				var res=Array();
    				res=message.split(",");
    				$(".atten_edit .usecode").val(res[0]);
    				//$(".atten_add #danwei").val(res[1]);
    				$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
    					// 设置选中项
    					onLoadSuccess:function(node,data){
    						$("#easyui_edit").combotree('setValues', [res[1]]);  
    					}  
    				}); 
    				//setTimeout("location.reload()",3000);  //3秒后刷新页面
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
    })
})

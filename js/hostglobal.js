$(function(){
	window.onerror=function(){return false;}
	var index_layer;
    $(".layer_iframe1 .close_btn").click(function(){
        parent.layer.closeAll();
    })
   // $(".close_btn").click(function(){
     //   layer.closeAll();
    //});
    
    
  //基本信息提交
    $("#basic_form .v_sub_basic").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	var flag=$("#basic_form .saveflag").val();
    	var hurl;
    	if(flag==1){
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=aglobal&saveflag=1&basic=1';
    	}else{
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=oglobal&flag=1&basic=1';
    	};
    	$.ajax({
 			url: hurl,
 			method: 'post',
 			data: $('#basic_form').serialize(),
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
 					//setTimeout("location.reload()",3000);
 				}
 				return false;
 			}			
 		});
    });
    
    //采集相关提交
    $("#collect_form .v_sub_collect").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	var flag=$("#collect_form .saveflag").val();
    	var hurl;
    	if(flag==1){
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=aglobal&saveflag=1&collect=1';
    	}else{
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=oglobal&flag=1&collect=1';
    	};
    	$.ajax({
    		url: hurl,
    		method: 'post',
    		data: $('#collect_form').serialize(),
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
    				//setTimeout("location.reload()",3000);
    			}
    			return false;
    		}			
    	});
    });
    
    //上传相关提交
    $("#upload_form .v_sub_upload").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	var flag=$("#upload_form .saveflag").val();
    	var hurl;
    	if(flag==1){
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=aglobal&saveflag=1&uploadfile=1';
    	}else{
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=oglobal&flag=1&uploadfile=1';
    	};
    	$.ajax({
    		url: hurl,
    		method: 'post',
    		data: $('#upload_form').serialize(),
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
    				//setTimeout("location.reload()",3000);
    			}
    			return false;
    		}			
    	});
    });
    
    //安全配置提交
    $("#safe_form .v_sub_safe").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	var flag=$("#safe_form .saveflag").val();
    	var hurl;
    	if(flag==1){
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=aglobal&saveflag=1&safe=1';
    	}else{
    		hurl= './?_a=hostglobal&_c=host&_m=index&action=oglobal&flag=1&safe=1';
    	};
    	$.ajax({
    		url: hurl,
    		method: 'post',
    		data: $('#safe_form').serialize(),
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
    				//setTimeout("location.reload()",3000);
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
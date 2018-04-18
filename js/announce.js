$(document).ready(function(){
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .view_a").addClass("on");
		$(".action_state .action_del").addClass("on");
	});
	
	//添加
	$(".condition_top .sure_add").click(function(){
		$.ajax({
			url: './?_a=announce&_c=system&_m=index&action=add',
			method: 'post',
			data: $('#announce_add_form').serialize(),
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
			url: './?_a=announce&_c=system&_m=index&action=del',
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
	
	// 查看
		$(".view_a").click(function(){
			if($('.view_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			//update at 20160830 by star
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			var sendUrl='./?_a=announce&_c=system&_m=index&action=view&id='+id;
			$.ajax({
	            type: "POST",
	            url: sendUrl,
	            dataType: "html",
	            success: function(data){
	                   html=data;
	                   $("#notice_body").html(html);
	                   layer.open({
	       				type: 1,
	       				title: false,
	       				closeBtn: 0,
	       				// shadeClose: true,
	       				area: '600px',
	       				content: $('.atten_view')
	       			});
	            }
	    	});
			return false;
			}else{   //如果没有点亮，说明不能操作
				return false;
			}
		})
})

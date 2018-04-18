/**
 * 
 */
$(document).ready(function(){
	//var index_layer;
	$(".tbody_atten  a").click(function(){
		$(".tbody_atten a").removeClass("tr_on");
		$(this).addClass("tr_on");
	});
		//添加同级调阅申请
		$("#add_submit").on('click', function(){
			$.ajax({
				url: './?_a=accessfrom&_c=access&_m=index&action=add',
				method: 'post',
				data: $('#saveAdd').serialize(),
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
				}
			});
		})//添加同级调阅申请结束
		//同级调阅查看框
		$(".view_a_look").on('click', function(){

			var id=$(".tbody_atten a.tr_on").attr("date");   //得到记录id
			$.ajax({
				url:'./?_a=accessfrom&_c=access&_m=index&action=view',
				method: 'post',
				data: {id:id},
				dataType: 'json',
				success: function(data) {
 					var username = data.username;
 					var unit = data.unit;
 					var createtime = data.createtime;
 					var status = data.status;
 					var apptime = data.apptime;
 					$('#danwei').html(unit);
 					$('#createtime').html(createtime);
 					$('#username').html(username);
 					$('#status').html(status);
 					$('#apptime').html(apptime);
					layer.open({
							type: 1,
							title: false,
							closeBtn: 0,
							// shadeClose: true,
							area: '470px',
							content: $('.level_view')
						});
				}
			});
		});

		//同级调阅确认删除
		$(".view_a_del").on('click',function(){
				lay_open=layer.open({
					type: 1,
					title: false,
					closeBtn: 0,
					// shadeClose: true,
					area: '449px',
					content: $('.lay_confirm_del')
				}); 
				return false;
		});
		//同级调阅删除
		$(".sure_from_del").on('click',function(){
			layer.closeAll(); 
			var id=$(".tbody_atten a.tr_on").attr("date");
			$.ajax({
				url:'./?_a=accessfrom&_c=access&_m=index&action=del',
				method: 'post',
				data:{id:id},
				dataType:'json',
				success:function(data){
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
     					setTimeout("location.reload()",3000);  //关闭所有的弹框
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
     				return fasle;
				}
			});
		});
		//审批确认删除
		$(".approve_del").on('click',function(){
				lay_open=layer.open({
					type: 1,
					title: false,
					closeBtn: 0,
					// shadeClose: true,
					area: '449px',
					content: $('.lay_confirm_del')
				}); 
				return false;
		});
		//审批删除
		$(".sure_to_del").on('click',function(){
			var id=$(".tbody_atten a.tr_on").attr("date");
			$.ajax({
				url:'./?_a=accessto&_c=access&_m=index&action=del',
				method: 'post',
				data:{id:id},
				dataType:'json',
				success:function(data){
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
     					setTimeout("location.reload()",3000);  //关闭所有的弹框
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
     				return fasle;
				}
			});
		});
		//审批框
		$("#app_form option").click(function(){
			$("#app_form option").removeClass("on");
			$(this).addClass("on");
		});
		$(".approve_look").on('click',function(){
			var id=$(".tbody_atten a.tr_on").attr("date");
			$.ajax({
				url:'./?_a=accessto&_c=access&_m=index&action=view',
				method: 'post',
				data: {id:id},
				dataType: 'json',
				success: function(data) {
					var id = data.id;
					var appunit = data.appunit;
 					var username = data.username;
 					var unit = data.unit;
 					var createtime = data.createtime;
 					var status = data.status;
 					var apptime = data.apptime;
 					$('#app_id').val(id);
					$('#appunit').html(appunit);
					$('#unit').html(unit);
					$('#createtime').html(createtime);
					$('#username').html(username);
					$('#app_no').val(data.noapp);//当状态为审批通过或拒绝审批时，用于提示不可再审批
					$('#apptime').html(apptime);
 					$('#edit_group').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top',
							onLoadSuccess:function(data){ 
								$('#edit_group').combobox('setValue',[status]);
							}	
						});
					layer.open({
							type: 1,
							title: false,
							closeBtn: 0,
							// shadeClose: true,
							area: '470px',
							content: $('.level_view')
						});
				    //审批提交Form处理
	                 $('#app_submit').on('click', function(){
	                	 $.ajax({
	             			url: './?_a=accessto&_c=access&_m=index&action=view&saveflag=1',
	             			method: 'post',
	             			data: $('#app_form').serialize(),
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
	             					setTimeout("location.reload()",3000);  //关闭所有的弹框
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
	             				return fasle;
	             			}			
	             		});
	                 });  //审批提交Form处理结束
				}//第一次ajax，success结束
			});//第一次ajax结束
		});
		//此函数用于关闭“提示失败”框
		$("body").on('click', ".close_btn_self",function(){
	    	layer.close(index_layer); //再执行关闭 
	    });	
	
		
})
	
	
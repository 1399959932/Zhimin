$(document).ready(function(){
	//定义一个全局变量，保存打开的
	var index_layer;
	
	// 隔行换色
	$(".li_con:odd").addClass("li_back");
	$(document).on("click",".role_l .li_con",function(){
		$(".role_l .li_con").removeClass("li_active");
		$(this).addClass("li_active");
		var ind=$(this).index();
		$(".role_weight .li_con").removeClass("li_active");
		$(".role_weight .li_con").eq(parseInt(ind)-1).addClass("li_active");
		/*var ind=$(this).index();
		$(".ul_wrap").hide();
		$(".ul_wrap").eq(parseInt(ind)-1).show();*/
	    //update at 20160924 by star,跳转页面
	    var id=$(".role_l li.li_active").attr("date");   //得到记录id
	    window.location = './?_a=group&_c=system&_m=index&action=search&id='+id;
	})
	// 权限选择
	$(".ul_wrap ul span").click(function(event){
		if($(this).parent().hasClass("li_child")){
			if($(this).parent().hasClass("li_on")){
				$(this).parent().removeClass("li_on");
			}else{
				$(this).parent().addClass("li_on");
			}			
			$(this).parent().children("ul").slideToggle("2000");
		}else{
			/*$(this).parent().parents(".sele_c").find("p").text($(this).parent().text());
			$(this).parent().parents(".sele_c").find("input").val($(this).parent().attr("date"));	*/	
		}	
		event.stopPropagation();    //  阻止事件冒泡	
	})
	// 角色全选切换
	$(document).on('click','.check_new',function(){
	    if($(this).siblings("input[type='checkbox']").prop('checked')){
	        $(this).parent().next("ul").find("input[type='checkbox']").prop('checked',true);
	        $(this).parent().next("ul").find(".checkbox").addClass('cur');
	        $(this).next("div").find("input[type='checkbox']").prop('checked',true);
	        $(this).next("div").find(".checkbox").addClass('cur');
	        
	    }else{
	        //$(this).parent().next("ul").find("input[type='checkbox']").removeAttr('checked');
	    	$(this).parent().next("ul").find("input[type='checkbox']").prop('checked',false);
	        $(this).parent().next("ul").find(".checkbox").removeClass('cur');
	        //$(this).next("div").find("input[type='checkbox']").removeAttr('checked');
	        $(this).next("div").find("input[type='checkbox']").prop('checked',false);
	        $(this).next("div").find(".checkbox").removeClass('cur');
	    } 
	});
	//角色添加确定
	/*$(".sure_role").click(function(){
		var v=$(this).parent().parent().parent().parent().find("input[name='role_input']").val();
		var html='<li class="li_con">'+v+'</li>';
		var html1='<li class="li_con"></li>';
		$(".role_l ul").append(html);
		$(".role_weight ul").append(html1);
		// 隔行换色
		$(".role_l .li_con:odd").addClass("li_back");
		$(".role_weight .li_con:odd").addClass("li_back");
	});*/
	//添加用户,提交Form
	$('#add_submit').click(function(){
		$.ajax({
				url: './?_a=group&_c=system&_m=index&action=add',
				method: 'post',
				data: $('#group_add_form').serialize(),
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
					return fasle;
				}			
		});
	});
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
	//修改框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			layer.open({    //此页面不同的地方在于，编辑的项在页面中已经显示出来了
					type: 1,
					title: false,
					closeBtn: 0,
					// shadeClose: true,
					area: '449px',
					content: $('.atten_edit')
			}); 
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
	});//修改框结束
	
	//编辑保存
    $("#edit_submit").click(function(){
    	//此处预留程序给前端处理js验证，如果验证不通过，return false;
    	$.ajax({
 			url: './?_a=group&_c=system&_m=index&action=edit',
 			method: 'post',
 			data: $('#group_edit_form').serialize(),
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
 				return fasle;
 			}			
 		});
    });  ////修改密码提交Form处理结束
    
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
    });
     // 删除确定后的操作
   $(".sure_one_del").click(function(){    	
        layer.closeAll(); 
        var id=$(".role_l li.li_active").attr("date");  //得到记录id
        $.ajax({
			url: './?_a=group&_c=system&_m=index&action=del',
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
					setTimeout("location.href='./?_a=group&_c=system&_m=index'",3000);  //刷新页面
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
    
    //保存相应的角色控制权限
    $(".save_button").click(function(){   
    	layer.closeAll(); 
        var id=$(".role_l li.li_active").attr("date");  //得到记录id
        var rec_url = './?_a=group&_c=system&_m=index&action=search&id='+id;
        $.ajax({
        	url: './?_a=group&_c=system&_m=index&action=popedom',
 			method: 'post',
 			data: $('#form_group').serialize(),
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
					setTimeout("location.href="+rec_url,3000);  //刷新页面
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
    })  //保存相应的角色控制权限，结束
    
})//最外层function

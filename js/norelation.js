
$(document).ready(function(){
	var index_layer;
	// 选中表格的行
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_a").addClass("on");
		//var id = $(".tr_on").attr("date");
	});
	//关联弹框
	$(".edit_a").click(function(){
		if($('.edit_a').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id
			$.ajax({
	            type: "POST",
	            url: './?_a=norelation&_c=system&_m=index&action=relation',
	            data: {id:id},
	            dataType: "json",
	            success: function(data){
	            	if(data.state == 'success'){
		            	$(".atten_add #devicenum").html(data.devicenum);
		            	$(".atten_add #mediaid").val(data.id);
		            	$(".atten_add #hostbody").val(data.devicenum);
		                 layer.open({
		       				type: 1,
		       				title: false,
		       				closeBtn: 0,
		       				// shadeClose: true,
		       				area: '470px',
		       				content: $('.atten_add')
		       			});
	            	}
	               //关联弹框提交Form处理
	                  $('#add_submit').on('click', function(){
	                	$.ajax({
	             			url: './?_a=norelation&_c=system&_m=index&action=relation&saveflag=1',
	             			method: 'post',
	             			data: $('#relation_form').serialize(),
	             			dataType: 'json',
	             			success: function(data) {
	             				//var name =document.getElementsByName("policename");
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
	             					$('#success_flg_1').html(message);
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
	                 });  ////关联提交Form处理结束
	            } //第一层ajax，调用成功结束
	    	}); //第一层ajax结束
			return false;
		}else{   //如果没有点亮，说明不能操作
			return false;
		}  	
	}) //关联弹框结束
	//添加自动加载警员，警号，单位
    $('.atten_add #usecode').blur(function(){
    	var usecode=$(".atten_add #usecode").val();
//    	alert(usecode);
    	$.ajax({
			url: './?_a=norelation&_c=system&_m=index&action=outo_relation',
			method: 'post',
			data: {usecode:usecode},
			dataType: 'json',
			success: function(data) {
				if(data.state == 'success'){
					var message = data.msg;
					var res=Array();
					res=message.split(",");
					$(".atten_add #usename").val(res[0]);
					$(".atten_add #danwei").val(res[1]);
				}else if(data.state == 'fail'){
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
    		url: './?_a=norelation&_c=system&_m=index&action=outo_relation',
    		method: 'post',
    		data: {usename:usename},
    		dataType: 'json',
    		success: function(data) {
    			if(data.state == 'success'){
    				var message = data.msg;
    				var res=Array();
    				res=message.split(",");
    				$(".atten_add #usecode").val(res[0]);
					$(".atten_add #danwei").val(res[1]);
//    				$(".atten_add #usecode").val(res[0]);
//    				//$(".atten_add #danwei").val(res[1]);
//    				$(".easyui-combotree").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
//    					// 设置选中项
//    					onLoadSuccess:function(node,data){
//    						$(".easyui-combotree").combotree('setValues', [res[1]]);  
//    					}  
//    				}); 
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
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(index_layer); //再执行关闭 
    });
});
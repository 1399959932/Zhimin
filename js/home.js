$(document).ready(function(){
	$(".sure_out_login").click(function(){
		location.href="./?_a=logout&_c=index&_m=index";
	});

    //确定修改密码吗
	   var home_out;
		 $('.sure_change_submit').on('click', function(){
			 $.ajax({
					url: './?_a=user&_c=other&_m=index&action=changepass&saveflag=1',
					method: 'post',
					data: $('#change_pwd_form').serialize(),
					dataType: 'json',
					success: function(data) {
						if(data.state == 'fail'){   //如果失败
							var message = data.msg;
							message += '......<font>3</font>秒钟后返回页面！';
							$('#fail_flg').html(message);
							home_out = layer.open({
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
						return fasle;
					}	
			 })
		 });
		 
	//此函数用于关闭“提示失败”框
	$("body").on('click', ".close_btn_self",function(){
    	layer.close(home_out); //再执行关闭 
    });		 
//    var home_out="";
//    $(".sure_change").click(function(){
//        home_out=layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '470px',
//            content: $('.home_prompt')
//        });
//    })
//    $(".close_home").click(function(){
//        layer.close(home_out);
//    })
//    $(".sure_home").click(function(){
//        layer.close(home_out);
//        //执行修改操作成功
//        layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '449px',
//            time: 3000, //3s后自动关闭
//            content: $('.lay_success')
//        });
//        // 失败
//        layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '449px',
//            time: 3000, //3s后自动关闭
//            content: $('.lay_wrong')
//        });
//    })
    // 删除站内信提示
    $(".letter_a").click(function(){
        var id=$(this).attr('date');
        var index=$(this).parent().parent().index();
        $(".letter_sure").attr('date',id+","+index);
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            area: '470px',
            content: $('.lay_confirm_del')
        });     
    })
    // 删除站内信
    $(".letter_sure").click(function(){
        layer.closeAll();
        var date=$(this).attr('date');
        date = date.split(",");
        var id=date[0];//数据id，提交给后台处理删除
        $.ajax({
        	url: './?_a=message&_c=other&_m=index&action=delmsg',
        	method: 'post',
 			data: {id:id},
 			dataType: 'json',
 			success: function(data) {
 				//执行修改操作成功
		        if(data.state == 'success'){ 
		        	 layer.open({
		                 type: 1,
		                 title: false,
		                 closeBtn: 0,
		                 shadeClose: true,
		                 area: '449px',
		                 time: 3000, //3s后自动关闭
		                 content: $('.lay_success')
		             });
		        	 setTimeout("location.reload()",3000);  //重新加载页面
		        }else{
		        	   layer.open({
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
      //  var index=date[1];//数据在页面上的索引，用于移除
        //执行修改操作成功
//        layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '449px',
//            time: 3000, //3s后自动关闭
//            content: $('.lay_success')
//        });
      //  $(".letter_table tbody tr").eq(index).remove();
        // 失败
//        layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '449px',
//            time: 3000, //3s后自动关闭
//            content: $('.lay_wrong')
//        });
    })
    // 发送站内信提示
//    $(".letter_sub").click(function(){
//        layer.open({
//            type: 1,
//            title: false,
//            closeBtn: 0,
//            shadeClose: true,
//            area: '470px',
//            content: $('.lay_confirm_del')
//        });     
//    })
    // 发送站内信
    $(".letter_sub").click(function(){
    	layer.closeAll();
    	var index_layer;
        $.ajax({
 			url: './?_a=messageadd&_c=other&_m=index&action=sendmsg&saveflag=1',
 			method: 'post',
 			data: $('#write_form').serialize(),
 			dataType: 'json',
 			success: function(data) {
 				//执行修改操作成功
		        if(data.state == 'success'){   //如果失败
 					var message = data.msg;
 					message += '......<font>3</font>秒钟后返回页面！';
 					$('#succseetip').html(message);
 					index_layer = layer.open({
     					type: 1,
     					title: false,
     					closeBtn: 0,
     					shadeClose: true,
     					area: '449px',
     					time: 3000, //3s后自动关闭
     					content: $('.lay_success')
     				});
		        }
		        // 失败
 				if(data.state == 'fail'){
 					var message = data.msg;
 					message += '......<font>3</font>秒钟后返回页面！';
 					$('#failtip').html(message);	
			        layer.open({
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
/*function changeFrameHeight(v){
    var ifm= document.getElementById(v); 
    ifm.height=document.documentElement.clientHeight;

}*/
function changeBodyHeight(){
    var h1=document.documentElement.clientHeight;
    var h2=$("#iframe_right").contents().find("body").height();
    if(h1>h2){
    	h=h1;
    }else{
    	h=h2
    }
    // h=parseInt(h)-62; 
    $("#iframe_right").attr("height",h);
    $("#iframe_left").attr("height",h);

}
function changeFrameWidth(v){
    width=document.documentElement.clientWidth-175;
    $("#"+v).css("width",width);

}
$(window).resize(function() {  
	changeBodyHeight('iframe_left');  
    changeBodyHeight('iframe_right'); 
    changeFrameWidth('v_o');


});  
// 退出函数
function lay_out(){
	layer.open({
		type: 1,
		title: false,
		closeBtn: 0,
		shadeClose: true,
		area: '449px',
		content: $('.lay_confirm')
	});
}
// 修改密码函数
function changePassword(){
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        shadeClose: true,
        area: '449px',
        content: $('.password_change')
    });
}
// 站內信函数
function message(url){    
    layer.open({
        type: 2,
        title: false,
        shadeClose: true,
        closeBtn: 0,
        area: ['760px','625px'],
        content: [url, 'no'] //iframe的url
    }); 
}
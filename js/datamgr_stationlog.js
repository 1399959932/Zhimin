
$(document).ready(function() {
	/*
	var guanjianzi_word='文件名称、文件描述';
    $("#guanjianzi").bind({
        focus:function(){
            if (this.value == guanjianzi_word){
                this.value="";
            }
        },blur:function(){
           if (this.value == ""){
                this.value = guanjianzi_word;
            } 
        }
    });
	*/

    // 批量删除
    var lay_open;
    $(".delete_all").click(function(){
    	 lay_open=layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			content: $('.lay_confirm')
		});    	
    });
    
    var lay_open2;
    $(".down_all").click(function(){
    	 lay_open2=layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			//shadeClose: true,
			area: '449px',
			content: $('.lay_confirm_down')
		});    	
    });
    var lay_open3;
    $(".action_del").click(function(){
    	 var fileid = $(this).attr("date");//alert(fileid);
    	 $('#sure_btn_onedel').val(fileid);
    	 lay_open3=layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			//shadeClose: true,
			area: '449px',
			content: $('.lay_confirm_onedel')
		});    	
    });

    // 删除确定后的操作
    $(".sure_btn_del").click(function(){
    	var len=0;
    	var idarray = '-1';

    	$(".ipt-hide").each(function() { 
            if ($(this).prop("checked")) {  
                len++;
                idarray = idarray + ',' + $(this).val();
            }  
        });
    	//alert(idarray);
        layer.closeAll(); 

        if(len>0)
        {
        	$.ajax({
        		type:"POST",
        		//url: "./?_a=media&_c=media&_m=index&action=patchdel",
        		url: "./?_a=stationlog&_c=log&_m=index&action=patchdel",
        		data:{"idarray":idarray},
        		dataType:"json",
        		success:function(data){
        			if(data == 0){
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
        				//window.location.reload();
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
        }else{
        	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				content: $('.lay_add')
			});
        }
    });
    
    // 删除确定后的操作
	/*
    $(".sure_btn_onedel").click(function(){
    	var fileid = $('#sure_btn_onedel').val();
        layer.closeAll();
        if(fileid != '')
        {
        	$.ajax({
        		type:"POST",
        		url: "./?_a=mediatuwen&_c=media&_m=index&action=onedel",
        		data:{"fileid":fileid},
        		dataType:"json",
        		success:function(data){
        			if(data == 0){
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
        }else{
        	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				content: $('.lay_add')
			});
        }
    });
	*/

    // 下载确定后的操作
    $(".sure_btn_down").click(function(){
    	var len=0;
    	var idarray = '-1';

    	$(".ipt-hide").each(function() { 
            if ($(this).prop("checked")) {  
                len++;
                idarray = idarray + ',' + $(this).val();
            }  
        });
        layer.closeAll(); 
        if(len>0)
        {
        	self.location.href = "./?_a=stationlog&_c=log&_m=index&action=patchdown&idarray="+idarray;
        }else{
        	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				content: $('.lay_add')
			});
        }
    });
    
    // 删除确定后的操作
    $(".sure_one_del").click(function(){    	
        layer.closeAll(); 
        	//执行删除操作成功
        	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_success')
			});
			// 失败
			layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_wrong')
			});
    })
    
})
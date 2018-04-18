$(document).ready(function () {
// alert(1)
	// 检测ie版本
	if(navigator.appName == "Microsoft Internet Explorer")
	{	
		if(navigator.appVersion.match(/6./i)=="6.")
		{
			getIE();
		}
	
	}
	
	$('.addFacility,.updateFacility').on('click',function(){
		alert('当前设备数量也超过上限！');
	});

	//弹窗关闭按钮鼠标划过效果
	$(".close img,.close1 img").hover(function(){
		$(this).attr("src","./images/close_on.png");
	},function(){
		$(this).attr("src","./images/close.png");
	});
	$(".close img,.close1 img").click(function(){
		$(this).attr("src","./images/close.png");
	});

	//搜索框获取焦点和失去焦点效果
	$('.search_in').bind({
		focus:function(){
			if (this.value == this.defaultValue){
				this.value="";
				$(this).addClass('searh_on');			
			}

		},
		blur:function(){
			if (this.value == ""){
				//this.value = this.defaultValue;	
				$(this).removeClass('searh_on');		
			}
		}
	})

	// 错误提示
	//搜索框获取焦点和失去焦点效果
	$('.input_error').bind({
		focus:function(){
			if (this.value == this.defaultValue){
				this.value="";			
			}
			$(this).siblings(".error_msg").animate({right:'-85px',opacity:'0',filter:'alpha(opacity=0)'},"slow");
		},
		blur:function(){
			if (this.value == ""){
				//this.value = this.defaultValue;
					$(this).siblings(".error_msg").animate({right:'10px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
							
			}
			// $(this).parent(".input_div").removeClass("input_focus");
			// 后期做ajax验证处理
		
		}
	})
	//二级导航栏的js效果
	$('.nav_left li').mouseover(function(){
		$('.nav_left li').removeClass('on');
		$(this).addClass('on');		
	})
	$('.nav_left li').mouseout(function(){
		$('.nav_left li').removeClass('on');	
	})
	$('.nav_left li').click(function(){
		$('.nav_left li').removeClass('active');
		$(this).addClass('active');
	})
	// 查看详情效果
	$(".detail_more").click(function(){
		if($(this).hasClass("detail_more_on")){
			$(this).removeClass('detail_more_on');
		}else{
			$(this).addClass('detail_more_on');
		}
		$(".table_hidden").slideToggle("1500",change_icon);
	});
	$(".sele_c>p").click(function(){
		$(this).parent().next(".select_button").click();
	})
	$(".slide_button").click(function(){
		$(".table_hidden").slideToggle("1500",change_icon);
	});
	function change_icon(){
		if($(".slide_button").hasClass("button_up")){
			$(".slide_button").removeClass('button_up');
			$('.detail_more').removeClass('detail_more_on');
		}else{
			$(".slide_button").addClass('button_up');
			$('.detail_more').addClass('detail_more_on');
		}
	}
	// 模拟下拉框
	$(".select_button").click(function(){
		$('.sele_c>ul').removeClass("t_select");
		$(this).parent().find(".sele_c>ul").addClass("t_select");
		$('.sele_c>ul').not(".t_select").slideUp("1500");
		$(this).parent().find(".sele_c>ul").slideToggle("1500");
	});
	$(".sele_c>ul").mouseleave(function(){
		$(this).slideUp("1500");
	});
	$(".sele_c ul li").click(function(event){
		/*if($(this).hasClass("li_child")){
			if($(this).hasClass("li_on")){
				$(this).removeClass("li_on");
			}else{
				$(this).addClass("li_on");
			}			
			$(this).children("ul").slideToggle("1500");
		}else{*/
			$(this).parents(".sele_c").find("p").text($(this).children("font").text());
			$(this).parents(".sele_c").find("input").val($(this).attr("date"));	
			$(this).parents(".sele_c").children('ul').slideUp("1500");	
		// }

		event.stopPropagation();    //  阻止事件冒泡	
	})
	$(".sele_c ul li span").click(function(event){
		if($(this).parent().hasClass("li_child")){
			if($(this).parent().hasClass("li_on")){
				$(this).parent().removeClass("li_on");
			}else{
				$(this).parent().addClass("li_on");
			}			
			$(this).parent().children("ul").slideToggle("1500");
		}/*else{
			$(this).parent().parents(".sele_c").find("p").text($(this).parent().text());
			$(this).parent().parents(".sele_c").find("input").val($(this).parent().attr("date"));		
		}*/	
		event.stopPropagation();    //  阻止事件冒泡	
	})
	//灰色三角
	//$(".sele_c ul li:not(:has('ul'))").children("span").addClass("lastchild");
	$(".scope_wrap ul span").click(function(event){
		if($(this).parent().hasClass("li_child")){
			if($(this).parent().hasClass("li_on")){
				$(this).parent().removeClass("li_on");
			}else{
				$(this).parent().addClass("li_on");
			}			
			$(this).parent().children("ul").slideToggle("1500");
		}else{
			$(this).parent().parents(".sele_c").find("p").text($(this).parent().text());
			$(this).parent().parents(".sele_c").find("input").val($(this).parent().attr("date"));		
		}	
		event.stopPropagation();    //  阻止事件冒泡	
	})	
	/*$(".sele_c ul .li_child").click(function(){
		$(this).children("ul").slideToggle("1500");		
	})*/
	// 时间选择器
	$(".select_time").mouseover(function(){
		$(this).addClass("select_t_on");
	})
	$(".select_time").mouseout(function(){
		$(this).removeClass("select_t_on");
	})
	// 控制时间的显示与隐藏
	$(".ul_time li").click(function(){
		if($(this).attr("date")=='3'){
			$(".condi_time").show();
		}else{
			$(".condi_time").hide();
		}
	})
	// 高级模式，列表模式切换
	$(".button_wrap_n>div").mouseover(function(){
		$(this).stop(true,true);
		$(this).animate({height:'44px'});
	})
	$(".button_wrap_n>div").mouseleave(function(){
		$(this).stop(true,true);
		$(this).animate({height:'22px'});
	})
	// 模拟checkbox
	$(document).on('click','.checkbox',function(){
		// alert($(this).prev("input[type='checkbox']").attr('checked'));
	    if($(this).siblings("input[type='checkbox']").prop('checked')){
	        $(this).removeClass('cur');
	        $(this).siblings("input[type='checkbox']").prop('checked',false);
	    }else{
	        $(this).addClass('cur');
	        $(this).siblings("input[type='checkbox']").prop('checked',true);
	    }    
	});
	// 搜索模式切换
    $(".button_search").click(function(){
    	if($(this).hasClass("quick_search")){
    		$(this).removeClass("quick_search");
    		$("input",this).val("1");//1是高级搜索
			$(".conditon_hidden").slideDown();
    	}else{
    		$(this).addClass("quick_search");
    		$("input",this).val("2");//2是快速搜索
			$(".conditon_hidden").slideUp();
    	}    	
    	//$(".conditon_hidden").toggle();
    })
    // 视屏清晰度切换
	$(".video_type").click(function(){
		$(".video_typelist").slideToggle("1500");
	});
	$(".video_typelist a").click(function(){
		$(".video_type").text($(this).text());
		$(".video_typelist").slideToggle("1500");
	});
	// 全选切换
    $(".select_all").click(function(){
    	if($(this).text()=='全 选'){
    		$(this).parent().next(".table_height").find("input[type='checkbox']").prop("checked", true);
    		$(this).parent().next(".table_height").find(".checkbox").removeClass('cur');
    		$(this).parent().next(".table_height").find(".checkbox").addClass('cur');
    		$(this).text("全不选");
    	}else{
    		$(this).parent().next(".table_height").find("input[type='checkbox']").prop('checked',false);
    		$(this).parent().next(".table_height").find(".checkbox").removeClass('cur');
    		$(this).text("全 选");
    	}
    })
    
    $("body").on('click', ".close_btn",function(){
    	layer.closeAll(); 
    });

    $(document).on("click",".a_view",function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['946px','630px'],
			content: [url, 'no'] //iframe的url
		}); 
    })

    $(document).on("click",".a_log",function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['946px','630px'],
			content: [url, 'no'] //iframe的url
		}); 
    })

    $(document).on("click",".a_file",function(){
		var file=$(this).attr('date');
		layer.open({
			title: '查看文件名',
			type: 1,
			skin: 'layui-layer-lan',
			area: ['300px', '100px'],
			content: '<br /><br /><div style="text-align:center">' + file + '</div>'
		});
    })
    $(".layer_iframe .close_btn").click(function(){
    	parent.layer.closeAll();
    })
    // tab切换
    $(".tab_ul li").click(function(){
    	var ind=$(this).index();
    	$(".tab_wrap").hide();
    	$(".tab_wrap").eq(ind).show();
    	$(".tab_ul li").removeClass("active");
    	$(this).addClass("active");
    })
    // 弹出地图  
   /* $('.map_span').on('click', function(){
    	var url=$(this).attr('date');
	    parent.layer.open({
			type: 2,
			title: false,
			// shadeClose: true,
			closeBtn: 0,
			area: ['946px','585px'],
			content: [url, 'no'] //iframe的url
		});
	});*/

	/*$(".map_span").click(function(){
		location.href="./?_a=map&_c=media&_m=index";
	});*/
	// 关闭地图
	$(".map_btn").click(function(){
		var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
		parent.layer.close(index);
	})
	// 保存提示
	/*
	$(".v_sub").click(function(){
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
		// 提示
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			time: 3000, //3s后自动关闭
			content: $('.lay_add')
		});
	})
	// 删除单条信息
	$('.action_del').on('click', function(){
		var id=$(this).attr('date');
    	lay_open=layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			content: $('.lay_confirm_del')
		});    	
    })*/

    // 考评监督中的子元素的显示
    $(".tr_parent").click(function(){    	
    	$(this).parent().parent().nextUntil(".tr_p").slideToggle("fast");
    	if($(this).hasClass("active")){
    		$(this).removeClass("active");
    	}else{
    		$(this).addClass("active");
    	}
    })
	// 弹出趋势图 
    $('.trends_map').on('click', function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
		    shadeClose: true,
			closeBtn: 0,
			area: ['946px','585px'],
			content: [url, 'no'] //iframe的url
		}); 
	});
	// 选中表格的行
	//update at 20160914，每个页面都有这样的一段Js,但页面还是不同
	/*$(".tbody_atten tr").click(function(){
		var id=$(this).attr("date");//拿到id后可以往后台传数据进行操作
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_s").addClass("on");
		$(".action_state .del_s").addClass("on");
	})*/
	//不仅仅是考勤添加,所有的添加按钮，都会弹出这样的框
	//此新增按钮是所有模块公用的，如果子模块有冲突，请修改子模块
	$(".add").click(function(){
		layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				content: $('.atten_add')
			});
	})
	$(".add_anno").click(function(){
		UE.getEditor('editor').setHeight(280);
		layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '600px',
				content: $('.atten_add')
			});
	})
	// 查看案件
	$(".view_case").on('click', function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['946px','585px'],
			content: [url, 'no'] //iframe的url
		}); 
	});
	// 添加案件
	$(".add_s").on('click', function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['946px','585px'],
			content: [url, 'no'] //iframe的url
		}); 
	});
//	// 修改案件
//	$(".edit_s").on('click', function(){
//    	var url=$(this).attr('date');
//    	layer.open({
//			type: 2,
//			title: false,
//			// shadeClose: true,
//			closeBtn: 0,
//			area: ['946px','585px'],
//			content: [url, 'no'] //iframe的url
//		}); 
//	});
//	// 相关视频的添加
//	$(".video_add").on('click', function(){
//    	var url=$(this).attr('date');
//    	layer.open({
//			type: 2,
//			title: false,
//			// shadeClose: true,
//			closeBtn: 0,
//			area: ['946px','585px'],
//			content: [url, 'no'] //iframe的url
//		}); 
//	});
	// 添加调阅
	$(".addlevel_b").on('click', function(){
    	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '470px',
				content: $('.level_l')
			});
	});
	// 查看调阅
//	$(".a_viewlevel").on('click', function(){
//    	layer.open({
//				type: 1,
//				title: false,
//				closeBtn: 0,
//				// shadeClose: true,
//				area: '470px',
//				content: $('.level_view')
//			});
//	});
	// 统计分析弹出框
	$(".staticTable td").on('click', function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['946px','585px'],
			content: [url, 'no'] //iframe的url
		}); 
	});
	// 帮助弹出框
	$(".button_help").on('click', function(){
    	var url=$(this).attr('date');
    	layer.open({
			type: 2,
			title: false,
			shadeClose: true,
			closeBtn: 0,
			area: ['729px','430px'],
			content: [url, 'no'] //iframe的url
		}); 
	});

	// 合并设备
/*	$('.action_merge').on('click', function(){
		var id=$(this).attr('date');
    	layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '470px',
			content: $('.atten_merge')
		});    	
    })
    
    // 报障设备
	$('.action_warning').on('click', function(){
		var id=$(this).attr('date');
    	layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '470px',
			content: $('.atten_warning')
		});    	
    })
    // 更新设备
    $(".update").click(function(){
    	layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			// shadeClose: true,
			area: '449px',
			time: 3000, //3s后自动关闭
			content: $('.update_success')
		});
    })
    $(".action_scrap").click(function(){
    	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				content: $('.lay_scrp')
			});
    })
    $(".sure_scrp").click(function(){
    	layer.closeAll(); 
       	//执行报废操作成功
    	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.scrp_success')
			});
    	//执行报废操作失败
    	layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.scrp_wrong')
			});
    })*/
    // 控制复选框是否可选
    $(".check_label").click(function(){    	
    	if($(this).hasClass("cur")){
    		$(this).parent().nextUntil(".check_div").find(".check_disable").removeClass("checkbox");
    		$(this).parent().nextUntil(".check_div").addClass("check_div_disable");
    	}else{
    		$(this).parent().nextUntil(".check_div").find(".check_disable").addClass("checkbox"); 	
    		$(this).parent().nextUntil(".check_div").removeClass("check_div_disable");	
    	}
    })
    // 数字增加
    $(".plus").click(function(){
    	var v=parseInt($(this).parent().prev("input").val());
    	$(this).parent().prev("input").val(v+1);
    })
    // 数字减少
    $(".minus").click(function(){
    	var v=parseInt($(this).parent().prev("input").val());
    	if(v>0){
    		$(this).parent().prev("input").val(v-1);
    	}    	
    })
    
	
	// 保存成功和失败
	$(".save_button").click(function(){
		// 启用成功
		layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.save_success')
			});
		// 启用失败
		layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				// shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.save_wrong')
			});
	})
	// 退出
	$(".run_out").click(function(){
		 parent.lay_out();		
	})
	// 修改密码
	$(".lock").click(function(){
		 parent.changePassword();		
	})
	// 站内信
	$(".message").click(function(){
		var url=$(this).attr('date');
		 parent.message(url);		
	})
	//部门管理js
	$(".div_band .ul_band li span").click(function(event){
		if($(this).parent().hasClass("li_child")){
			if($(this).parent().hasClass("li_on")){
				$(this).parent().removeClass("li_on");
			}else{
				$(this).parent().addClass("li_on");
			}			
			$(this).parent().children("ul").slideToggle("1500");
		}
		event.stopPropagation();    //  阻止事件冒泡	
	})
	// 展开全部
	$(".ul_open").click(function(){
		$(this).addClass("open_on");
		$(".ul_close").removeClass("close_on");
		$(".div_band .ul_band .li_child").addClass("li_on");
		$(".div_band .ul_band .li_child ul").show();
	})
	// 关闭全部
	$(".ul_close").click(function(){
		$(this).addClass("close_on");
		$(".ul_open").removeClass("open_on");
		$(".div_band .ul_band .li_child").removeClass("li_on");
		$(".div_band .ul_band .li_child ul").hide();
	})

});
// 表单验证
function checkform(frm)
{
	
	if(frm.username.value == ""||frm.username.value =="请输入您的用户名")
	{
		var ind=frm.username;
		// alert("用户名不能为空！");
		$(ind).next(".error_msg").text("用户名不能为空！").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
		// frm.username.focus();		
		return false;
	}
	else if(frm.password.value == ""||frm.password.value == "请输入您的密码")
	{
		var ind=frm.password;
		$(ind).next(".error_msg").text("密码不能为空！").animate({right:'15px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
		// alert("密码不能为空！");
		// frm.password.focus();		
		return false;
	}
	else if(frm.verify.value == ""||frm.verify.value == "请输入验证码")
	{
		var ind=frm.verify;
		$(ind).next(".error_msg").text("验证码不能为空！").animate({right:'5px',opacity:'1',filter:'alpha(opacity=100)'},"slow");
		/*alert("验证码不能为空！");
		frm.verify.focus();	*/	
		return false;
	}	
	return true;
}
// 判断IE浏览器版本
function getIE()
{
	if(navigator.appName == "Microsoft Internet Explorer")
	{	
		if(navigator.appVersion.match(/MSIE 6./i)=="MSIE 6.")
		{
			layer.open({
			  type: 2,
			  title: false,
			  closeBtn: false, //不显示关闭按钮
			  shade: 0,
			  area: ['305px', '132px'],
			  offset: 'rb', //右下角弹出
			  // time: 5000, //5秒后自动关闭
			  shift: 2,
			  content: ['./?_a=ie6', 'no'] //iframe的url，no代表不显示滚动条
			});
		}
	
	}
}
/*function checkem(email)
{
	var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/; 
    flag = pattern.test(email); 

	if(flag) 
	{ 
	return true; 
	} 
	else 
	{ 
	return false; 
	}     
}*/

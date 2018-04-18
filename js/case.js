/**
 * 
 */

 //时间兼容ie7
  function parseISO8601(dateStringInRange) {  
   var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,  
       date = new Date(NaN), month,  
       parts = isoExp.exec(dateStringInRange);  
  
   if(parts) {  
     month = +parts[2];  
     date.setFullYear(parts[1], month - 1, parts[3]);  
     if(month != date.getMonth() + 1) {  
       date.setTime(NaN);  
     }  
   }  
   return date;  
 }
function GetDateStr(date,AddDayCount) 
{
	date = parseISO8601(date);   //兼容ie7处理
	var dd = new Date(date);
	dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期 
	var y = dd.getFullYear();
	var m = (dd.getMonth()+1)<10?"0"+(dd.getMonth()+1):(dd.getMonth()+1);//获取当前月份的日期，不足10补0
	var d = dd.getDate()<10?"0"+dd.getDate():dd.getDate(); //获取当前几号，不足10补0
	return y+"-"+m+"-"+d; 
}
function formatSeconds(value) {
    var theTime = parseInt(value);// 秒
    var theTime1 = 0;// 分
    var theTime2 = 0;// 小时
    if(theTime > 60) {
        theTime1 = parseInt(theTime/60);
        theTime = parseInt(theTime%60);
            if(theTime1 > 60) {
            theTime2 = parseInt(theTime1/60);
            theTime1 = parseInt(theTime1%60);
            }
    }
        var result = ""+parseInt(theTime)+"秒";
        if(theTime1 > 0) {
        result = ""+parseInt(theTime1)+"分"+result;
        }
        if(theTime2 > 0) {
        result = ""+parseInt(theTime2)+"小时"+result;
        }
    return result;
}
$(document).ready(function(){
	var index_layer;
 	var result = new Array(); //用于添加相关视频是临时存储选择视频id
 	var flag = 1;  //用于只添加一次《添加一次相关视频》弹框
	$(".tbody_atten tr").click(function(){
		$(".tbody_atten tr").removeClass("tr_on");
		$(this).addClass("tr_on");
		$(".action_state .edit_s").addClass("on");
		$(".action_state .del_s").addClass("on");
	});
	
	var curPage = 1; //当前页码 
	var count,pageSize,totalPage; //总记录数，每页显示数，总页数 
	//获取分页条 
	function getPageBar(){
		var pageStr = '';
	    //页码大于最大页数 
	    if(curPage>totalPage){
			curPage=totalPage;
		}
	    //页码小于1 
	    if(curPage<1){
			curPage=1;
		} 
	    pageStr = "<div class='page_link' style='margin-top:0;'><span>共"+count+"条</span><span>"+curPage+"/"+totalPage+"</span>";
	    //如果是第一页 
	    if(curPage==1){
	        pageStr += "<span>首页</span><span>上一页</span>";
	    }else{
	        pageStr += "<span><a style='width:40px !important;' href='javascript:void(0)' target='_top' rel='1'>首页</a></span>" +
			"<span><a style='width:40px !important;' href='javascript:void(0)' target='_top' rel='"+(curPage-1)+"'>上一页</a></span>";
	    }
	    //如果是最后页
	    if(curPage>=totalPage){
	        pageStr += "<span>下一页</span><span>尾页</span></div>";
	    }else{
			pageStr += "<span><a style='width:40px;' target='_top' href='javascript:void(0)' rel='"+(parseInt(curPage)+1)+"'>下一页</a></span>" +
					"<span><a style='width:40px;' target='_top' href='javascript:void(0)' rel='"+totalPage+"'>尾页</a></span></div>";
	    }
	    $("#pagecount").html(pageStr);
	}
	
	$(document).on("click",".check_span",function(){
		
		$(this).addClass("check_box");
		if($('.check_box .checkbox ').hasClass("cur")){
			result.push($('.check_box .ipt-hide').attr("value"));
		}else{
			var temp = $('.check_box .ipt-hide').attr("value")
			if(result.indexOf(temp) > -1){
				for(var i=0;i<result.length;i++){
					if(result[i] ===  temp){
						result.splice(i,1);
						i--;
					}
						
				}
			}
		}
		$(".check_span").removeClass("check_box");
	});
	
	//添加 翻页实现
	$(document).on("click",'#pagecount span a',function(){	 
		var rel = $(this).attr("rel");
		var danweinum = $("#form_v .textbox-value").val();
		var sdate = $("#start").val();
		var edate = $("#end").val();
		if(rel && danweinum){		//&&danweinum是为了当《修改》翻页时，不执行getData
			getData(rel,danweinum,sdate,edate);
		}
	});
	//修改 翻页实现
	$(document).on("click",'#pagecount span a',function(){
		var rel = $(this).attr("rel");
		var danweinum = $("#caseadd_edit .textbox-value").val();
		var sdate = $("#starts").val();
		var edate = $("#ends").val();
		if(rel && danweinum){
			getData2(rel,danweinum,sdate,edate);
		}
	});
    function indexOf(arr, item) {
        return Array.prototype.indexOf ? Array.prototype.indexOf.call(arr, item) : function (arr, item) {
            for (var i = 0, len = arr.length; i < len; i++) {
                if (arr[i] === item) {
                    return i;
                }
            }
            return -1;
        }.call(arr, arr, item)
    }
	//ie兼容indexOf()
	if(!Array.indexOf)
{
    Array.prototype.indexOf = function(obj)
    {              
        for(var i=0; i<this.length; i++)
        {
            if(this[i]==obj)
            {
                return i;
            }
        }
        return -1;
    }
}
	//添加获取video数据
	function getData(page,danweinum,sdate,edate){
		$.ajax({
 			url: './?_a=caseadd&_c=case&_m=index&action=video',
			method: 'post',
			data:{'danwei':danweinum,'sdate':sdate,'edate':edate,'pageNum':(page-1)},
            dataType: "json",
            success:function(data){
				$("#vi_form").empty();//清空数据区 
	            count = data.count; //总记录数 
	            pageSize = data.pageSize; //每页显示条数 
	            curPage = page; //当前页 
	            totalPage = data.totalPage; //总页数 
            	var media_array = data.medias;
        		var html='';
        		if(count == 0){
                    html = '<tr class="td_back">'+
                        '<td colspan="6">暂无记录</td>'+
                        '</tr>';
        		}
				$.each(media_array,function(idx,item){
					if(item.major != 1){
						html += '<tr>';
					}else{
						html += '<tr class="td_red">';
					}
					if(result.indexOf(item.id) > -1){     //当item.id在数组result中
						idx = idx+1; 
						//modify
						//var urlplay = "./?_a=casedetail&_c=case&_m=index&id="+item.id;
						var urlplay = "./?_a=mediaview&_c=media&_m=index&id="+item.id;

						html += '<td>'+
							'<span class="check_span">'+
						    	'<input type="checkbox" name="ids[]" checked="true" class="ipt-hide" value="'+item.id+'">'+
						        '<label class="checkbox cur"></label>'+idx+
						    '</span>'+
						'</td>'+
						'<td>'+
							'<span class="action_span">'+
								'<a target="_blank" href="'+urlplay+'">查看</a>'+
							'</span>'+
						'</td>'+
						'<td>'+item.hostname+'('+item.hostcode+')</td>'+
						'<td>'+item.unitname+'</td>'+
						'<td>'+item.hostbody+'</td>'+
						'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
						'</tr>';
					}else{
						idx = idx+1; 
						//modify
						//var urlplay = "./?_a=casedetail&_c=case&_m=index&id="+item.id;
						var urlplay = "./?_a=mediaview&_c=media&_m=index&id="+item.id;

						html += '<td>'+
							'<span class="check_span">'+
						    	'<input type="checkbox" name="ids[]" class="ipt-hide" value="'+item.id+'">'+
						        '<label class="checkbox"></label>'+idx+
						    '</span>'+
						'</td>'+
						'<td>'+
							'<span class="action_span">'+
								'<a target="_blank" href="'+urlplay+'">查看</a>'+
							'</span>'+
						'</td>'+
						'<td>'+item.hostname+'('+item.hostcode+')</td>'+
						'<td>'+item.unitname+'</td>'+
						'<td>'+item.hostbody+'</td>'+
						'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
						'</tr>';
					}
				})
                $('#vi_form').html(html);
				getPageBar();
			},
		
			complete:function(){ //生成分页条
				if(flag == 1){
			 		flag = 0
//					layer.close(index_layer); 
					index_layer=layer.open({
						type: 1,
						title: false,
					    shadeClose: true,
						closeBtn: 0,
						area: ['946px','579px'],
						content: $('.lay_video')
					});
				}
			},
			
			error:function(){
				alert("数据加载失败");
				return false;
			}
 		})//ajax结束 

	}
	//修改获取video数据
	function getData2(page,danweinum,sdate,edate){
		$.ajax({
 			url: './?_a=casetopic&_c=case&_m=index&action=editvideo',
			method: 'post',
			data:{'danwei':danweinum,'sdate':sdate,'edate':edate,'pageNum':(page-1)},
            dataType: "json",
            success:function(data){
				$("#edit_vi_form").empty();//清空数据区 
	            count = data.count; //总记录数 
	            pageSize = data.pageSize; //每页显示条数 
	            curPage = page; //当前页 
	            totalPage = data.totalPage; //总页数 
            	var media_array = data.medias;
        		var html='';
        		if(count == 0){
                    html = '<tr class="td_back">'+
                        '<td colspan="6">暂无记录</td>'+
                        '</tr>';
        		}
				$.each(media_array,function(idx,item){ 
					if(item.major != 1){
						html += '<tr>';
					}else{
						html += '<tr class="td_red">';
					}
					if(result.indexOf(item.id) > -1){    //当item.id在数组result中
						idx = idx+1; 
						//modify
						//var urlplay = "./?_a=casedetail&_c=case&_m=index&id="+item.id;
						var urlplay = "./?_a=mediaview&_c=media&_m=index&id="+item.id;

						html += '<td>'+
							'<span class="check_span">'+
						    	'<input type="checkbox" name="ids[]" checked="true" class="ipt-hide" value="'+item.id+'">'+
						        '<label class="checkbox cur"></label>'+idx+
						    '</span>'+
						'</td>'+
						'<td>'+
							'<span class="action_span">'+
								'<a target="_blank" href="'+urlplay+'">查看</a>'+
							'</span>'+
						'</td>'+
						'<td>'+item.hostname+'('+item.hostcode+')</td>'+
						'<td>'+item.unitname+'</td>'+
						'<td>'+item.hostbody+'</td>'+
						'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
						'</tr>';
					}else{
						idx = idx+1; 
						//modify
						//var urlplay = "./?_a=casedetail&_c=case&_m=index&id="+item.id;
						var urlplay = "./?_a=mediaview&_c=media&_m=index&id="+item.id;

						html += '<td>'+
							'<span class="check_span">'+
						    	'<input type="checkbox" name="ids[]" class="ipt-hide" value="'+item.id+'">'+
						        '<label class="checkbox"></label>'+idx+
						    '</span>'+
						'</td>'+
						'<td>'+
							'<span class="action_span">'+
								'<a target="_blank" href="'+urlplay+'">查看</a>'+
							'</span>'+
						'</td>'+
						'<td>'+item.hostname+'('+item.hostcode+')</td>'+
						'<td>'+item.unitname+'</td>'+
						'<td>'+item.hostbody+'</td>'+
						'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
						'</tr>';
					}
				})
                $('#edit_vi_form').html(html);
				getPageBar();
			},
			complete:function(){ //生成分页条
				if(flag == 1){    //用于只添加一次《添加一次相关视频》弹框
			 		flag = 0
//					layer.close(index_layer); 
					index_layer=layer.open({
						type: 1,
						title: false,
					    shadeClose: true,
						closeBtn: 0,
						area: ['946px','579px'],
						content: $('.lay_video')
					});
				}
			},
			error:function(){
				alert("数据加载失败");
				return false;
			}
 		})//ajax结束 
	}
	//添加相关视频框的关闭与取消
	$(".lay_video .close_btns").click(function(){
		layer.close(index_layer); 
    });
	//video 添加提交
	$("#video_add").on('click', function(){
		flag = 1;   //用于只添加一次《添加一次相关视频》弹框
		var occurtime = $("#e_startup_time").val();
		var danweinum = $("#caseadd .textbox-value").val();
		if(danweinum == ''){
			$('#fail_flg').html('单位不能为空！');
			index_layer = layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_wrong')
			});
	   	 }else if(occurtime == ''){
	   		$('#fail_flg').html('发生时间不能为空！');
			index_layer = layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_wrong')
			});
	   	 }else{
	   		//根据发生时间获取时间段
	   		var date_temp = occurtime.substring(0,10);
	   		edate = GetDateStr(date_temp,3);
	   		sdate = GetDateStr(date_temp,-3);
	   		$("#danwei_insert").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
			// 设置选中项
			onLoadSuccess:function(node,data){
				$("#danwei_insert").combotree('setValues', [danweinum]);  
		    }
	   		});
	   		$("#start").val(sdate);
	   		$("#end").val(edate);
	   		getData(1,danweinum,sdate,edate);
	   	 }
	});
	
	//提交选择相关视频
    $('#form_video_submit').on('click', function(){
	    layer.close(index_layer); 
	   	 $.ajax({
				url: './?_a=caseadd&_c=case&_m=index&action=add&saveflag=1',
				method: 'post',
//				data: $('#vid_form').serialize(),
				data:{ids:result},
				dataType: 'html',
				success: function(data) {
					html=data;
	               $("#video_add_body").html(html);   //展示选择的相关视频
				}
	   	 });
    });
	//查询video
 	$("#button_look").on('click', function(){
 		var danweinum = $("#form_v .textbox-value").val();
		var sdate = $("#start").val();
		var edate = $("#end").val();
 		getData(1,danweinum,sdate,edate);
 	});	

	//添加案件专题
	$("#sure_add_case").on('click', function(){
		result = null;//添加结束临时存ID变量制空
		$.ajax({
			url: './?_a=caseadd&_c=case&_m=index&action=add',
			method: 'post',
			data: $('#caseadd').serialize(),
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
	})//添加结束
	
	// 打开修改案件框
	$(".edit_s").on('click', function(){
		if($('.edit_s').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
			var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id	
			$.ajax({
	            type: "POST",
	            url: './?_a=casetopic&_c=case&_m=index&action=edit',
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
     				}else if(data.state == 'success'){
     					var dbh = data.danwei;
     					var casetaxon = data.casetaxon;
     					var media_array = data.medias;
     					var html='';
     					$.each(media_array,function(idx,item){
     						result.push(item.id); 
     						idx = idx+1; 
							//modify
							//var urlplay = "./?_a=casedetail&_c=case&_m=index&id="+item.id;
							var urlplay = "./?_a=mediaview&_c=media&_m=index&id="+item.id;

	     		    	    if(item.major != '1'){
	     						html += '<tr>'+
								'<td>'+
								    	'<input name="medias[]" class="ipt-hide" value="'+item.id+'">'+
								        idx+
								'</td>'+
								'<td>'+
									'<span class="action_span">'+
										'<a target="_blank" href="'+urlplay+'">查看</a>'+
									'</span>'+
								'</td>'+
								'<td>'+item.hostname+'('+item.hostcode+')</td>'+
								'<td>'+item.unitname+'</td>'+
								'<td>'+item.hostbody+'</td>'+
								'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
							'</tr>';
	     		    	    }else{
	     		    	        html += "<tr class='td_red'>"+
									'<td>'+
									    	'<input name="medias[]" class="ipt-hide" value="'+item.id+'">'+
									        idx+
									'</td>'+
									'<td>'+
										'<span class="action_span">'+
											'<a target="_blank" href="'+urlplay+'">查看</a>'+
										'</span>'+
									'</td>'+
									'<td>'+item.hostname+'('+item.hostcode+')</td>'+
									'<td>'+item.unitname+'</td>'+
									'<td>'+item.hostbody+'</td>'+
									'<td>'+item.createdate+'('+formatSeconds(item.playtime/1000)+')</td>'+
	 	
								'</tr>';
	     		    	    }
     					})
     					$('#edit_id').val(data.id);
     					$('#edit_pnum').val(data.pnumber);
     					$('#edit_brain').val(data.brains);
     					$('#edit_title').val(data.title);
     					$('#e_startup_time').val(data.occurtime);
     					$('#edit_subject').val(data.subject);
     					$('#edit_note').val(data.note);
     					$('#video_edit_body').html(html);
     					
     					$("#easyui_edit").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
         					// 设置选中项
         					onLoadSuccess:function(node,data){
         						$("#easyui_edit").combotree('setValues', [dbh]);  
         				    } 
         					});  /*search list tree end*/
     						$('#edit_group').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top',
     							onLoadSuccess:function(data){ 
     								$('#edit_group').combobox('setValue',[casetaxon]);
     							}	
     						});
		            	layer.open({
		    			type: 1,
		    			title: false,
		    			// shadeClose: true,
		    			closeBtn: 0,
		    			area: ['946px','579px'],
		    			content: $('.lay_edit')
		            	}); 
	     			}
	            }//success结束
			});
		}    	
	});//打开修改案件框结束
	
	//修改video 添加提交
	$("#edit_video_add").on('click', function(){
		flag = 1;   //用于只添加一次《添加一次相关视频》弹框
		var occurtime = $("#e_startup_time").val();
		var danweinum = $("#caseadd_edit .textbox-value").val();
		if(danweinum == ''){
			$('#fail_flg').html('单位不能为空！');
			index_layer = layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_wrong')
			});
	   	 }else if(occurtime == ''){
	   		$('#fail_flg').html('发生时间不能为空！');
			index_layer = layer.open({
				type: 1,
				title: false,
				closeBtn: 0,
				shadeClose: true,
				area: '449px',
				time: 3000, //3s后自动关闭
				content: $('.lay_wrong')
			});
	   	 }else{
	   		//根据发生时间获取时间段
	   		var date_temp = occurtime.substring(0,10);
	   		edate = GetDateStr(date_temp,3);
	   		sdate = GetDateStr(date_temp,-3);
	   		
	   		$("#danwei_insert").combotree({url:'./?_a=unitjson&_c=other&_m=index&id=bh&text=dname',method:'get',labelPosition:'top',panelWidth:'500px',
			// 设置选中项
			onLoadSuccess:function(node,data){
				$("#danwei_insert").combotree('setValues', [danweinum]);  
		    }
	   		});
	   		$("#form_v_edit #starts").val(sdate);
	   		$("#form_v_edit #ends").val(edate);
	   		getData2(1,danweinum,sdate,edate);
	   	 }

	});
    //提交选择相关视频
    $('#edit_video_submit').on('click', function(){
	   	 layer.close(index_layer); 
	   	 $.ajax({
				url: './?_a=casetopic&_c=case&_m=index&action=add',
				method: 'post',
				data:{ids:result},
				dataType: 'html',
				success: function(data) {
					html=data;
	               $("#video_edit_body").html(html);   //展示选择的相关视频
				}
	   	 });
    });
	//修改查询video
 	$("#edit_look").on('click', function(){ 
 		var danweinum = $("#form_v_edit .textbox-value").val();
		var sdate = $("#form_v_edit #starts").val();
		var edate = $("#form_v_edit #ends").val();
 		getData2(1,danweinum,sdate,edate);
 	});
	//修改案件专题
	$("#sure_edit_case").on('click', function(){
		result = null;//修改结束临时存ID变量制空
		$.ajax({
			url: './?_a=casetopic&_c=case&_m=index&action=edit&saveflag=1',
			method: 'post',
			data: $('#caseadd_edit').serialize(),
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
	})//添加结束
	
 	//删除案件框
	//确定删除提示信息
	$('.del_s').on('click', function(){
		if($('.del_s').hasClass('on')){   //如果点亮，说明可以操作,则出现弹出框
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
    //确定删除成功后的操作
	$(".sure_btn_del").on('click', function(){
		layer.closeAll(); 
		var id=$(".tbody_atten tr.tr_on").attr("date");   //得到记录id

		$.ajax({
            type: "POST",
            url: './?_a=casetopic&_c=case&_m=index&action=del',
            data: {id:id},
            dataType: "json",
            success: function(data){
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
		})//ajax结束
	})//删除结束

})	
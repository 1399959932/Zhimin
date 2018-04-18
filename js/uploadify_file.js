		var upNum = 0;
        $(document).ready(function()
        {	
			//删除文件
			$(document).on("click", ".delfile", function()
			{
				$(this).parent().parent().remove();//删除文件所在div
				//alert($("#hfFilelist").val());
				//alert($("#hfYuanshiFilelist").val());
				//alert($(this).attr("tt1"));
				//alert($(this).attr("tt2"));
				var tt1 = $(this).attr("tt1") + "|";//获取已删除的文件路径（含文件名）
				//var tt2 = $(this).attr("tt2") + "|";//获取已删除的文件原始名
				//$("#imgfilelist").val($("#imgfilelist").val().replace(img, ""));//测试用，从列表中能够移除已删除文件的文件路径
				$("#hfFilelist").val($("#hfFilelist").val().replace(tt1, ""));//从列表中移除已删除文件的文件路径
				//$("#hfYuanshiFilelist").val($("#hfYuanshiFilelist").val().replace(tt2, ""));//从列表中移除已删除文件的文件路径
				//alert($("#hfFilelist").val());
				//alert($("#hfYuanshiFilelist").val());

				//调用ajax删除文件文件(ok，但为了防止误删，暂时禁用）
				//alert("tt1 is :" + $(this).attr("tt1"));
				$.get("/tools/DelFile1.php",{filename:$(this).attr("tt1")}, function(data){
					//alert("Data Loaded: " + data);
				});
			});
	
            $("#uploadify").uploadify({
                // 页面相关
                'uploader': '/js/jquery.uploadify-v2.1.4/uploadify.swf',//组件自带的flash，路径根据情况自行调整
                'buttonText':'选择文件', //浏览按钮的文本，默认值：BROWSE 
                'width':120, // 设置浏览按钮的宽度 ，默认值：110。 
                'height':50, // 设置浏览按钮的高度 ，默认值：30。
                //'buttonImg': 'button.png', //使用图片按钮
                'cancelImg': '/js/jquery.uploadify-v2.1.4/cancel.png',//取消上传文件的按钮图片
                'queueID': 'ShowFileUpload',//放置上传文件及上传进度的Html元素
                'queueSizeLimit' : 6, //一次最多选择多少个文件上传
                
                // 服务器脚本
                'script': '/tools/BatchUploadHandler1.php',//后台处理上传的action路径
                //'scriptData'     : {'userid': '', 'username': ''}, //自身业务需要向服务器端传递的数据  
                              
                // 传递给服务器参数
                'folder': '',//上传文件的目录，将作为'folder'参数传递给服务器
                //'fileDataName'   : 'photo', //它决定了最重要的两个上传参数名称，本例中将为文件'photo'和文件名'photoFileName'
                'fileExt':'*.mp4;*.wav;*.jpg',//允许的文件类型，在客户端约束用户的文件选择，并将作为'fileext'参数传递给服务器供校验用
                
                // 控制开关
                'auto': true,//是否选取文件后自动上传,建议关闭
                'multi': true, //多文件上传
                'removeCompleted': true, //完成上传后是否自动清除网页上的文件列表(如果需要预览上传后的图片，建议设为false)
                
                //其它
               'sizeLimit': 1024*1024*1024, //1024k，单个文件的最大尺寸（字节为单位）
               'simUploadLimit':1, //多文件上传时，同时上传文件数目限制
               'fileDesc': '请选择mp4、wav、jpg格式的文件', //显示在本地选择文件对话框的文件类型下拉框中。如果配置了'fileExt'属性，那么这个属性是必须的 
               
             'onSelect': function(event,queueID,fileObj){},//alert(fileObj.name)
              'onComplete':function(event,queueID,fileObj,response,data){
				  //alert(response);
				  //upNum++;
				  //if(upNum == 3)  alert("all upload");
					//alert((response));
					//返回的数据格式：文件相对地址,文件大小（如：2016/xjkdsfuiposdf.rar,382838）
					
					/*
					var astr = response.split(',');
					document.getElementById("hfFilename").value = response;
					document.getElementById("hlkMediaFile").href = document.getElementById("hfMediaPath").value + astr[0];
					document.getElementById("hlkMediaFile").innerHTML = '<img src=\"../images/down.gif\" align=\"absmiddle\" border=\"0\" />已上传的资源文件';
					*/
					//var tmp1 = response.split(',');
					//var newFileName = tmp1[0];
					//var yuanshiFileName = tmp1[1];
					//var tmp2 = rs1.split('/');
					//var rs2 = tmp2[1];
					var newFileName = response.replace("﻿", "");
					//document.getElementById("media_note").value = response.replace("﻿", "");

					document.getElementById("imglist").innerHTML += "<div class='uploadfile1'><div class='uploadfile2'><img src='/images/delete.png' border=0 title='删除文件' alt='删除文件' tt1='" + newFileName + "' tt2='" + newFileName + "' class=\"delfile\"><a href='/upload/temp/" + newFileName + "' target='_blank'>" + newFileName + "</a></div></div>";
					//document.getElementById("imgfilelist").value += response + "|";//测试用
					document.getElementById("hfFilelist").value += newFileName + "|";
					//document.getElementById("hfYuanshiFilelist").value += yuanshiFileName + "|";
					//alert("hfNewFilelist:"+document.getElementById("hfNewFilelist").value);alert("hfYuanshiFilelist:"+document.getElementById("hfYuanshiFilelist").value);
					
					//alert(document.getElementById("hlkMediaFile").href);
					//alert("hfFilename:"+document.getElementById("hfFilename").value);
               },
               'onError': function(event, queueID, fileObj)   
                {
                   alert("文件：" + fileObj.name + "  上传失败");
                } 
            });
            
            //$("#btnBegin").click(function(){$("#uploadify").uploadifyUpload();return false;});
        }); 
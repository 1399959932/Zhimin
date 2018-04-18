		var upNum = 0;
        $(document).ready(function()
        {	
			//删除图片
			$(document).on("click", ".delimg", function()
			{
				$(this).parent().parent().parent().remove();//删除图片所在div
				//alert($(this).attr("tt"));
				var img = $(this).attr("tt") + "|";//获取已删除的图片路径（含文件名）
				//$("#imgfilelist").val($("#imgfilelist").val().replace(img, ""));//测试用，从列表中能够移除已删除图片的图片路径
				$("#hfImgfilelist").val($("#hfImgfilelist").val().replace(img, ""));//从列表中移除已删除图片的图片路径
				//alert($("#hfImgfilelist").val());

				//调用ajax删除图片文件(ok，但为了防止误删，暂时禁用）
				$.get("/tools/DelImg1.ashx",{filename:$(this).attr("tt")}, function(data){
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
                'queueSizeLimit' : 3, //一次最多选择多少个文件上传
                
                // 服务器脚本
                'script': '/tools/BatchUploadHandler1.ashx?obj=bookbt',//后台处理上传的action路径
                //'scriptData'     : {'userid': '', 'username': ''}, //自身业务需要向服务器端传递的数据  
                              
                // 传递给服务器参数
                'folder': '',//上传文件的目录，将作为'folder'参数传递给服务器
                //'fileDataName'   : 'photo', //它决定了最重要的两个上传参数名称，本例中将为文件'photo'和文件名'photoFileName'
                'fileExt':'*.jpg;*.png',//允许的文件类型，在客户端约束用户的文件选择，并将作为'fileext'参数传递给服务器供校验用
                
                // 控制开关
                'auto': true,//是否选取文件后自动上传,建议关闭
                'multi': true, //多文件上传
                'removeCompleted': true, //完成上传后是否自动清除网页上的文件列表(如果需要预览上传后的图片，建议设为false)
                
                //其它
               'sizeLimit': 1*1024*1024, //1024k，单个文件的最大尺寸（字节为单位）
               'simUploadLimit':1, //多文件上传时，同时上传文件数目限制
               'fileDesc': '请选择jpg、png格式的文件', //显示在本地选择文件对话框的文件类型下拉框中。如果配置了'fileExt'属性，那么这个属性是必须的 
               
             'onSelect': function(event,queueID,fileObj){},//alert(fileObj.name)
              'onComplete':function(event,queueID,fileObj,response,data){
				  //alert(response);
				  //upNum++;
				  //if(upNum == 3)  alert("all upload");
					//alert(response);alert(document.getElementById("imglist").innerHTML);
					//document.getElementById("hfFilename").value = response;
					document.getElementById("imglist").innerHTML += "<div class='uploadimg1'><img src='/upload_images/product_img/" + response + "' width='100' height='80' /><div class='uploadimg2'><a href='javascript:void(0)'><img src='../images/icons/delete.png' border=0 title='删除图片' alt='删除图片' tt='" + response + "' align=\"absmiddle\" class=\"delimg\"></a></div></div>";
					//document.getElementById("imgfilelist").value += response + "|";//测试用
					document.getElementById("hfImgfilelist").value += response + "|";
					//alert("hfFilename:"+document.getElementById("hfFilename").value);
               },
               'onError': function(event, queueID, fileObj)   
                {
                   alert("文件：" + fileObj.name + "  上传失败");
                } 
            });
            
            //$("#btnBegin").click(function(){$("#uploadify").uploadifyUpload();return false;});
        }); 
<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '	<title>详情页</title>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '	<script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '	<link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '	<link href="';
echo Zhimin::g('assets_uri');
echo 'style/viewfile.css" rel="stylesheet" type="text/css" />' . "\r\n" . '	<style type="text/css">' . "\r\n" . '	.gps_a{ color: #0e7fd3; }' . "\r\n" . '	</style>' . "\r\n" . '' . "\r\n" . '';
$media_cfg = Zhimin::g('media_type');
$filetype = strtolower($medias['filetype']);
echo '<body>' . "\r\n" . '	<div class="layer_iframe">' . "\r\n" . '		<div class="iframe_top"><span style="display: inline-block;width:15px;"></span>正在查看';

if (in_array($filetype, $media_cfg['video'])) {
	echo '视频';
}
else if (in_array($filetype, $media_cfg['audio'])) {
	echo '音频';
}
else {
	echo '图片';
}

echo '：';
echo $medias['bfilename'];
echo '<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '		<div class="iframe_body">' . "\r\n" . '			<div class="iframe_left">' . "\r\n" . '				<div class="cont_iframe_top"></div>' . "\r\n" . '				<div class="cont_iframe_body">' . "\r\n" . '					<div class="video_wrap">' . "\r\n" . '					';

if (in_array($filetype, $media_cfg['video'])) {
	echo '	' . "\r\n" . '						  <object id="peplayer" classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" width="450" height="420">' . "\r\n" . '						  	<param name="Mode" value="1" />' . "\r\n" . '						  </object>' . "\r\n" . '						  ' . "\r\n" . '					';
}
else if (in_array($filetype, $media_cfg['audio'])) {
	echo '							<object id="MediaPlayer" width="440" height="380"' . "\r\n" . '								classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"' . "\r\n" . '								type="application/x-oleobject">' . "\r\n" . '								<param name="AutoStart" value="0" />' . "\r\n" . '								<param name="PlayCount" value="1" />' . "\r\n" . '								<param name="EnableContextMenu" value="0" />' . "\r\n" . '								<param name="Volume" value="100" />' . "\r\n" . '								<embed src="';
	echo $playurl;
	echo '" name="MediaPlayer" ' . "\r\n" . '									type="video/x-ms-wmv" width="400" height="68" autostart="1"' . "\r\n" . '									showcontrols="1" allowscan="1" playcount="100" enablecontextmenu="0"></embed>' . "\r\n" . '							</object>' . "\r\n" . '							<script language="JavaScript">' . "\r\n" . '								var isFF=(navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)' . "\r\n" . '								var objPlayer = document.getElementById("MediaPlayer");' . "\r\n" . '								if(isFF){objPlayer=document.MediaPlayer;}' . "\r\n" . '								var strFile33 = "';
	echo $playurl;
	echo '";' . "\r\n" . '								objPlayer.url = strFile33;' . "\r\n" . '								objPlayer.src = strFile33;' . "\r\n" . '							</script>' . "\r\n" . '					';
}
else {
	echo '	' . "\r\n" . '							<a title="点击查看大图" target="_blank" href="';
	echo $playurl;
	echo '"> <img' . "\r\n" . '								border="0" onload="DrawImage(this,640,480);" src="';
	echo $playurl;
	echo '" width="640" height="360" />' . "\r\n" . '							</a>' . "\r\n" . '					';
}

echo '					' . "\r\n" . '						  <!--<img src="./images/video_img.jpg" width="450" height="420" alt="" />-->' . "\r\n" . '						' . "\r\n" . '					<div class="video_action">' . "\r\n" . '						<span>文件大小：';
echo round($medias['filelen'], 2);
echo 'M</span>' . "\r\n" . '						<span class="span_awrap">' . "\r\n" . '							<a class="video_span_a video_down" target="_blank" href="';
echo Zhimin::buildUrl('media', 'media', 'index', 'action=media_down&id=' . $medias['id']);
echo '"></a>|' . "\r\n" . '							<a href="';

if (!empty($pre_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $pre_id);
}
else {
	echo '#';
}

echo '" class="video_span_a video_prev" ></a>|' . "\r\n" . '							<a href="';

if (!empty($next_id)) {
	echo Zhimin::buildUrl('mediaview', 'media', 'index', 'id=' . $next_id);
}
else {
	echo '#';
}

echo '" class="video_span_a video_next"></a>' . "\r\n" . '						</span>					' . "\r\n" . '						<span class="video_type">标  清</span>' . "\r\n" . '						' . "\r\n" . '						<div class="video_typelist">' . "\r\n" . '							 <ul>' . "\r\n" . '								<li><a href="#">标  清</a></li>' . "\r\n" . '								<li><a href="#">高  清</a></li>' . "\r\n" . '								<li><a href="#">流  畅</a></li>' . "\r\n" . '							</ul>' . "\r\n" . '						</div>' . "\r\n" . '					</div>' . "\r\n" . '					<div class="video_notice">' . "\r\n" . '						如无法播放视频，请下载并安装播放器插件 <a href="images/player/prPlayer.exe">点击下载</a>' . "\r\n" . '					</div>' . "\r\n" . '				</div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="cont_iframe_foot"></div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="iframe_right">' . "\r\n" . '				<div class="right_iframe_top"></div>' . "\r\n" . '				<div class="right_iframe_body">' . "\r\n" . '					<div class="tab_wrap tab_base" style="display: block;">' . "\r\n" . '						<form action="';
echo Zhimin::buildUrl();
echo '&action=edit" method="post">' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">姓名（' . $_SESSION['zfz_type'] . '编号）：';
echo $medias['hostname'] . ' ( ' . $medias['hostcode'] . ' )';
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传站点：';
echo $medias['creater'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">拍摄时间：';
echo $medias['createdate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">上传时间：';
echo $medias['uploaddate'];
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">所属单位：';
echo $media_danwei;
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '					' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">重要视频：';

if ($medias['major'] == '1') {
	echo '是';
}
else {
	echo '否';
}

echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s">' . "\r\n" . '							<span class="condition_title">存储天数：';

if ($medias['save_date'] == '1') {
	echo '三个月';
}
else if ($medias['save_date'] == '2') {
	echo '六个月';
}
else if ($medias['save_date'] == '3') {
	echo '十二个月';
}
//modify 
else {
	echo '永久';  // == '4'
}
//
echo '</span>' . "\r\n" . '						</div>' . "\r\n" . '						<div class="condition_335 condition_s condition_textarea condition_height">' . "\r\n" . '							<span class="condition_title">文件描述：</span>' . "\r\n" . '							<div class="select_260 select_div select_days textarea_in">								' . "\r\n" . '								<textarea id="media_note"  style = "background-color:#fff" disabled>';
echo $medias['note'];
echo '</textarea>' . "\r\n" . '							</div>' . "\r\n" . '						</div>' . "\r\n" . '						<input type="hidden" id="fileid" name="fileid" value="';
echo $medias['id'];
echo '" >' . "\r\n" . '						<div class="condition_335 condition_s condition_v">' . "\r\n" . '							<!-- <input type="submit" class="v_sub" value="保 存" /> -->' . "\r\n" . '							<!-- <input type="button" class="v_sub close_btn" value="关 闭" />  -->' . "\r\n" . '						</div>' . "\r\n" . '						</form>' . "\r\n" . '					</div>' . "\r\n" . '				</div>' . "\r\n" . '				<div class="right_iframe_foot"></div>' . "\r\n" . '			</div>' . "\r\n" . '	</div>' . "\r\n" . '		<div class="iframe_foot"></div>' . "\r\n" . '	<!-- 警告提示框 -->' . "\r\n" . '	<div class="layer_notice lay_add">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>标注信息不能为空......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 成功提示框 -->' . "\r\n" . '	<div class="layer_notice lay_success">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/success_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>保存成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '	<!-- 失败提示框 -->' . "\r\n" . '	<div class="layer_notice lay_wrong">' . "\r\n" . '		<div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '		<div class="notice_body1">' . "\r\n" . '			<div class="n_left">' . "\r\n" . '				<img src="./images/notice_bg.png">' . "\r\n" . '			</div>' . "\r\n" . '			<div class="n_right">' . "\r\n" . '				<p>信息不全,保存失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '				<div class="clear"></div>' . "\r\n" . '				<span class="cancle_span close_btn">确 定</span>' . "\r\n" . '			</div>' . "\r\n" . '		</div>' . "\r\n" . '		<div class="notice_foot"></div>' . "\r\n" . '	</div>' . "\r\n" . '</body>' . "\r\n" . '</html>' . "\r\n" . '' . "\r\n" . '';

if (in_array($filetype, $media_cfg['video'])) {
	echo '<script language="javascript" for="peplayer" event="TimeChanged(time)">' . "\r\n" . '	if(time > 0)' . "\r\n" . '	{' . "\r\n" . '		if(time - g_presecond >= 1)' . "\r\n" . '		{' . "\r\n" . '			g_presecond = time;' . "\r\n" . '			//PlayTimeNotify(time);' . "\r\n" . '		}			' . "\r\n" . '	}       ' . "\r\n" . '</script>	' . "\r\n" . '<script language="javascript" for="peplayer" event="Playover()">' . "\r\n" . '	        ' . "\r\n" . '</script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '	 ' . "\r\n" . '	var g_presecond = 0;' . "\r\n" . '	/*' . "\r\n" . '		time: MillSeconds' . "\r\n" . '	*/' . "\r\n" . '	function onTimeEvent(time)' . "\r\n" . '	{	' . "\r\n" . '		if(time > 0)' . "\r\n" . '		{' . "\r\n" . '			if(time - g_presecond >= 1)' . "\r\n" . '			{' . "\r\n" . '				g_presecond = time;' . "\r\n" . '				//PlayTimeNotify(time);' . "\r\n" . '			}			' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	function onPlayoverEvent()' . "\r\n" . '	{' . "\r\n" . '		' . "\r\n" . '	}' . "\r\n" . '	' . "\r\n" . '	function SetGis(ax){' . "\r\n" . '		//object css里面定义了就不用写 ' . "\r\n" . '		ax.style.width = "450px";' . "\r\n" . '		ax.style.height = "420px";' . "\r\n" . '		' . "\r\n" . '		//调用activex的方法 1：gis播放UI，0：常规播放UI' . "\r\n" . '		ax.setmode(1);' . "\r\n" . '		' . "\r\n" . '		//普通模式' . "\r\n" . '		//ax.style.width = "640px";' . "\r\n" . '		//ax.style.height = "480px";' . "\r\n" . '		//ax.setmode(0);' . "\r\n" . '	}' . "\r\n" . ' 	' . "\r\n" . '	function PlayVideo(url)' . "\r\n" . '	{		' . "\r\n" . '		var activex = document.getElementById("peplayer");' . "\r\n" . '		if( activex )' . "\r\n" . '		{			' . "\r\n" . '			/*try{' . "\r\n" . '				if(document.all.ocx.object == null) ' . "\r\n" . '				{' . "\r\n" . '					alert(\'some activex is not installed!\');' . "\r\n" . '				}' . "\r\n" . '			}catch(e){}*/' . "\r\n" . '			' . "\r\n" . '			//测试activeX是否有 playurl 函数 判断是否安装了播放器插件。' . "\r\n" . '' . "\r\n" . '			/*try{' . "\r\n" . '			//activex.setmode(1);' . "\r\n" . '			//GIS模式可以关联时间事件 ' . "\r\n" . '			activex.attachEvent ("TimeChanged", onTimeEvent);' . "\r\n" . '			//播放完成事件' . "\r\n" . '			activex.attachEvent ("Playover", onPlayoverEvent);' . "\r\n" . '			}catch(e){}*/' . "\r\n" . '			//切换 GIS 模式UI' . "\r\n" . '			//SetGis(activex);' . "\r\n" . '			 ' . "\r\n" . '			activex.playurl(url);' . "\r\n" . '		}' . "\r\n" . '	}	' . "\r\n" . '	' . "\r\n" . '	window.onload = function()' . "\r\n" . '	{	' . "\r\n" . '		setTimeout(function()' . "\r\n" . '		{' . "\r\n" . '			url = "';
	echo $playurl;
	echo '";' . "\r\n" . '			PlayVideo(url);' . "\r\n" . '		}, ' . "\r\n" . '		1000); ' . "\r\n" . '	}' . "\r\n" . '	/*window.onbeforeunload = window.onunload = function()' . "\r\n" . '	{ ' . "\r\n" . '		try{' . "\r\n" . '		var activex = document.getElementById("peplayer");' . "\r\n" . '		if( activex )' . "\r\n" . '		{' . "\r\n" . '			activex.detachEvent ("TimeChanged", onTimeEvent);' . "\r\n" . '			activex.detachEvent ("Playover", onPlayoverEvent);' . "\r\n" . '		}' . "\r\n" . '		}catch(e){}' . "\r\n" . '	}*/' . "\r\n" . '	' . "\r\n" . '</script>' . "\r\n" . '';
}

echo '' . "\r\n" . '<script type="text/javascript">' . "\r\n" . 'function DrawImage(ImgD,iwidth,iheight){    ' . "\r\n" . '    //参数(图片,允许的宽度,允许的高度)' . "\r\n" . '    var minWidth  = 640;' . "\r\n" . '    var minHeight = 360;    ' . "\r\n" . '    var image=new Image();    ' . "\r\n" . '    image.src=ImgD.src;    ' . "\r\n" . '    if(image.width>0 && image.height>0){    ' . "\r\n" . '      if(image.width/image.height>= iwidth/iheight){  ' . "\r\n" . '    	  if(image.width==iwidth){' . "\r\n" . '    		  ImgD.width=image.width;      ' . "\r\n" . '              ImgD.height=image.height;' . "\r\n" . '    	  } else{      ' . "\r\n" . '              ImgD.width=iwidth;    ' . "\r\n" . '              ImgD.height=(image.height*iwidth)/image.width;    ' . "\r\n" . '          }    ' . "\r\n" . '      }else{    ' . "\r\n" . '          if(image.height==iheight){    ' . "\r\n" . '              ImgD.width=image.width;      ' . "\r\n" . '              ImgD.height=image.height;          ' . "\r\n" . '          }else{         ' . "\r\n" . '              ImgD.height=iheight;    ' . "\r\n" . '              ImgD.width=(image.width*iheight)/image.height;   ' . "\r\n" . '          }    ' . "\r\n" . '      }    ' . "\r\n" . '    }    ' . "\r\n" . '}' . "\r\n" . '</script>' . "\r\n" . '' . "\r\n" . '<script>' . "\r\n" . '$(".video_down").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') 0 -2px no-repeat");' . "\r\n" . '	$(".video_prev").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -41px -2px no-repeat");' . "\r\n" . '	$(".video_next").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -80px -2px no-repeat");' . "\r\n" . '});' . "\r\n" . '$(".video_prev").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') -41px -2px no-repeat");' . "\r\n" . '	$(".video_down").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') 0px -2px no-repeat");' . "\r\n" . '	$(".video_next").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -80px -2px no-repeat")' . "\r\n" . '});' . "\r\n" . '$(".video_next").click(function(){' . "\r\n" . '	$(this).css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action_on.jpg\') -80px -2px no-repeat");' . "\r\n" . '	$(".video_down").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') 0px -2px no-repeat");' . "\r\n" . '	$(".video_prev").css("background","url(\'';
echo Zhimin::g('assets_uri');
echo 'images/video_action.jpg\') -41px -2px no-repeat");' . "\r\n" . '});' . "\r\n" . '' . "\r\n" . '</script>' . "\r\n" . '';

?>

<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\r\n" . '<head>' . "\r\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '<title>';
echo Zhimin::a()->title;
echo '</title>' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/base.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/stylesheet.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/163css.css" rel="stylesheet" type="text/css" />' . "\r\n" . '' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/ajax.js" type="text/javascript"></script>  ' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/common.js" type="text/javascript"></script>  ' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/function.js" type="text/javascript"></script>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.js" type="text/javascript"></script>' . "\r\n" . '<!-- <script src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery-1.4.2.min.js" type="text/javascript"></script>-->' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/scrol.js" type="text/javascript"></script>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/My97DatePicker/WdatePicker.js" type="text/javascript"></script>' . "\r\n" . '' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/Dialog/zDrag.js" type="text/javascript"></script>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/Dialog/zDialog.js" type="text/javascript"></script>' . "\r\n" . '<link href="';
echo Zhimin::g('assets_uri');
echo 'style/menutree.css" rel="stylesheet" type="text/css" />' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/menutree.js" type="text/javascript" language="javascript"></script>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/163css.js" type="text/javascript"></script>' . "\r\n" . '<!--[if IE 6]>' . "\r\n" . '<script src="';
echo Zhimin::g('assets_uri');
echo 'js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>' . "\r\n" . '<script type="text/javascript">' . "\r\n" . ' 	DD_belatedPNG.fix(\'div, ul, img, li, input , a\');' . "\r\n" . '</script>' . "\r\n" . '<![endif]-->' . "\r\n" . '<script type="text/javascript">' . "\r\n" . '' . "\r\n" . '$(document).ready(function (){' . "\r\n" . '	//公告滚动' . "\r\n" . '	$("#announce_list").Scroll({line:1,speed:500,timer:3000});' . "\r\n" . '	//重要视频' . "\r\n" . '	$(\'#import_button\').click(function(){' . "\r\n" . '		location.href = \'';
echo Zhimin::buildUrl('media', 'media', '', 'major=1');
echo '\';' . "\r\n" . '	});' . "\r\n" . '	//高级搜索的切换' . "\r\n" . '	/*' . "\r\n" . '	$(\'#high_close\').click(function(){' . "\r\n" . '		$(\'#highsearch\').slideUp("slow");' . "\r\n" . '	});*/' . "\r\n" . '	$(\'#highs_button\').click(function(){' . "\r\n" . '		' . "\r\n" . '		$(\'#time_highsearch\').hide();' . "\r\n" . '		$(\'#highsearch\').slideToggle("slow");' . "\r\n" . '		return false;' . "\r\n" . '	});' . "\r\n" . '	//高级搜索提交' . "\r\n" . '	$(\'#high_search_submit\').click(function(){' . "\r\n" . '		var centerlot= $("#centerlot");' . "\r\n" . '		var centerlat= $("#centerlat");' . "\r\n" . '		var centerrange= $("#centerrange");' . "\r\n" . '		var start_date = $("#start_date");' . "\r\n" . '		var end_date = $("#end_date");' . "\r\n" . '		if(centerlot.val()!=\'\' || centerlat.val()!=\'\'){' . "\r\n" . '			if(centerrange.val() == \'\'){' . "\r\n" . '				alert("距中心点周围的米数不能为空");' . "\r\n" . '				centerrange.focus();' . "\r\n" . '				return false;' . "\r\n" . '			}else{' . "\r\n" . '				var reg = /^\\d+(\\.\\d{1,2})?$/;' . "\r\n" . '				if(!reg.test(centerrange.val())){' . "\r\n" . '					alert("距中心点周围的米数必须是整数或带两个小数");' . "\r\n" . '					centerrange.focus();' . "\r\n" . '					return false;' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '		if(centerrange.val() != \'\'){' . "\r\n" . '			if(centerlot.val()==\'\' || centerlat.val()==\'\'){' . "\r\n" . '				alert("中心点的经度或纬度不能为空");' . "\r\n" . '				centerlot.focus();' . "\r\n" . '				return false;' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '		if(start_date.val()!=\'\'||end_date.val()!=\'\'){' . "\r\n" . '			if(start_date.val() > end_date.val()){' . "\r\n" . '				alert("开始时间不能大于结束时间");' . "\r\n" . '				start_date.focus();' . "\r\n" . '				return false;' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '		$(\'#highsearch_form\').submit();' . "\r\n" . '	});' . "\r\n" . '	//高级搜索重置' . "\r\n" . '	$(\'#high_search_cancel\').click(function(){' . "\r\n" . '		' . "\r\n" . '		$(\'#highsearch\').find(\'form\')[0].reset();' . "\r\n" . '	});' . "\r\n" . '	//精确时间搜索切换' . "\r\n" . '	/*' . "\r\n" . '	$(\'#time_search_cancel\').click(function(){' . "\r\n" . '		$(\'#time_highsearch\').slideUp("slow");' . "\r\n" . '	});*/' . "\r\n" . '	$(\'#time_button\').click(function(){' . "\r\n" . '		$(\'#highsearch\').hide();' . "\r\n" . '		$(\'#time_highsearch\').slideToggle("slow");' . "\r\n" . '		return false;' . "\r\n" . '	});' . "\r\n" . '	//精确时间搜索提交' . "\r\n" . '	$(\'#time_search_submit\').click(function(){' . "\r\n" . '		if(timesearch_form.start_date.value=="")' . "\r\n" . '		{' . "\r\n" . '			alert("拍摄精确时间不能为空！");' . "\r\n" . '			timesearch_form.start_date.focus();' . "\r\n" . '			return false;' . "\r\n" . '		}' . "\r\n" . '		$(\'#timesearch_form\').submit();' . "\r\n" . '	});' . "\r\n" . '	//精确时间搜索重置' . "\r\n" . '	$(\'#time_search_cancel\').click(function(){' . "\r\n" . '		' . "\r\n" . '		$(\'#time_highsearch\').find(\'form\')[0].reset();' . "\r\n" . '	});' . "\r\n" . '	//模糊搜索' . "\r\n" . '	$(\'#key_s\').click(function(){' . "\r\n" . '		';
$action = Zhimin::param('action', 'get');
$url = Zhimin::buildUrl('media', 'media') . '&action=search';

if ($action != 'highsearch') {
	$show = Zhimin::request('show');

	if (!empty($show)) {
		$url .= '&show=' . $show;
	}

	$caserank = Zhimin::param('major', 'get');

	if (!empty($major)) {
		$url .= '&major=' . urlencode($major);
	}
}

echo 'var base_url=\'' . $url . '\';' . "\n" . '';
echo '		var keyword = $(\'#key_search\').val();' . "\r\n" . '		location.href = base_url + \'&keyword=\'+encodeURIComponent(keyword);' . "\r\n" . '		return false;' . "\r\n" . '	});' . "\r\n" . '});' . "\r\n" . '' . "\r\n" . 'function user_edit(id){   //change password Diag' . "\r\n" . '	var diag = new Dialog();' . "\r\n" . '	diag.Modal = true;' . "\r\n" . '	diag.Title = \'用户信息\';' . "\r\n" . '	diag.URL = "';
echo Zhimin::buildUrl('user', 'user');
echo '&action=changepass&id="+id;' . "\r\n" . '	diag.show();' . "\r\n" . '' . "\r\n" . '	//return false;' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . 'function message(){       //The message list Diag' . "\r\n" . '	var diag = new Dialog();' . "\r\n" . '	diag.Modal = true;' . "\r\n" . '	diag.Title = \'站内短信\';' . "\r\n" . '	diag.Width = 600;' . "\r\n" . '	diag.Height = 400;' . "\r\n" . '	diag.URL = "';
echo Zhimin::buildUrl('message', 'user');
echo '&action=list";' . "\r\n" . '	diag.show();' . "\r\n" . '' . "\r\n" . '	//return false;' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . 'function show_announce(id){' . "\r\n" . '	var diag = new Dialog();' . "\r\n" . '	diag.Width = 600;' . "\r\n" . '	diag.Height = 600;' . "\r\n" . '	diag.Modal = true;' . "\r\n" . '	diag.URL = "';
echo Zhimin::buildUrl('announce', 'index');
echo '&action=show&position=main&id="+id;' . "\r\n" . '	diag.show();' . "\r\n" . '}' . "\r\n" . '/*' . "\r\n" . 'if (navigator.userAgent.indexOf("MSIE")>0){' . "\r\n" . '	window.onbeforeunload=function(){   ' . "\r\n" . '    	if( window.event.clientX>window.document.body.clientWidth && window.event.clientY<0 ||window.event.altKey){//非刷新时' . "\r\n" . '        	return "即将退出系统,您确定吗?";' . "\r\n" . '		}' . "\r\n" . '	} ' . "\r\n" . '	window.onunload=function(){' . "\r\n" . '    	if( event.clientX < 0 && event.clientY < 0 ){' . "\r\n" . '    		var ajaxobj=new AJAXRequest;   ' . "\r\n" . '    		ajaxobj.method="GET";' . "\r\n" . '    		ajaxobj.url="';
echo Zhimin::buildUrl('logout', 'index', 'index');
echo '" ' . "\r\n" . '    		ajaxobj.send();' . "\r\n" . '    	}' . "\r\n" . '	}' . "\r\n" . '}*/' . "\r\n" . '</script>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '<div id="wrapper">' . "\r\n" . '	<div id="container">' . "\r\n" . '		<div id="header">' . "\r\n" . '			<div id="title"><span>';
$settings = Zhimin::a()->getData('settings');
echo $settings['site'];
echo '</span></div>' . "\r\n" . '			<div id="logo">' . "\r\n" . '				<a href="';
echo Zhimin::g('assets_uri');
echo '">' . "\r\n" . '					';
if (($settings['main_file_logo'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['main_file_logo'])) {
	echo '<img src="' . Zhimin::g('assets_uri') . 'upload/zm_config/' . $settings['main_file_logo'] . '" alt="" width="131px"/>';
}
else {
	echo '<img src="images/logo/main_file_logo_' . Zhimin::g('rowcustertype') . '.png" alt="" />';
}

echo '					<!-- <img src="';
echo Zhimin::g('assets_uri');
echo 'upload/zm_config/';
echo $settings['main_file_logo'];
echo '" alt="" /> -->' . "\r\n" . '				</a>' . "\r\n" . '			</div>' . "\r\n" . '			<div id="top_menu">' . "\r\n" . '				<ul>' . "\r\n" . '				';

if (Zhimin::getComponent('auth')->isSuperAdmin()) {
	echo '					<li class="top_shezhi"><a href="';
	echo Zhimin::buildUrl('welcome', 'index', 'admin');
	echo '" >设置</a></li>' . "\r\n" . '				';
}
else {
	echo '					<li class="top_shezhi_1"><a ></a></li>	' . "\r\n" . '				';
}

echo '					<li class="top_user"><a href="javascript:user_edit(\'';
echo $_SESSION['userid'];
echo '\');" title="';
echo $_SESSION['username'];
echo '">';
echo $_SESSION['username'];
echo '</a></li>' . "\r\n" . '					<li class="top_message"><a href="javascript:message();" >消息</a></li>' . "\r\n" . '					<li class="top_logout"><a href="';
echo Zhimin::buildUrl('logout', 'index', 'index');
echo '" >退出</a></li>' . "\r\n" . '' . "\r\n" . '				</ul>' . "\r\n" . '				<div id="message_num">' . "\r\n" . '						<ul>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_left.gif" /></li>' . "\r\n" . '							<li class="message_count" style="width:17px;">' . "\r\n" . '								<span>';
echo Zhimin::g('message_count');
echo '</span>' . "\r\n" . '							</li>' . "\r\n" . '							<li><img src="';
echo Zhimin::g('assets_uri');
echo 'images/msg_num_right.gif" /></li>' . "\r\n" . '						</ul>' . "\r\n" . '					</div>' . "\r\n" . '			</div>' . "\r\n" . '			<!-- <div id="phone"><span>服务热线：';
echo $settings['telephone'];
echo '</span></div> -->' . "\r\n" . '			<div id="menu">' . "\r\n" . '				<div id="left_menu">' . "\r\n" . '				<ul>' . "\r\n" . '					<li class="menu_index" ';

if (Zhimin::param('show', 'get') == '') {
	echo 'id="current_index"';
}

echo '><a href="';
echo Zhimin::g('assets_uri');
echo '">首页</a></li>' . "\r\n" . '					<li class="menu_vedio" ';

if (Zhimin::param('show', 'get') == 'video') {
	echo 'id="current_vedio"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=video');
echo '" >视频</a></li>' . "\r\n" . '					<li class="menu_voice" ';

if (Zhimin::param('show', 'get') == 'audio') {
	echo 'id="current_voice"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=audio');
echo '" >音频</a></li>' . "\r\n" . '					<li class="menu_pic" ';

if (Zhimin::param('show', 'get') == 'photo') {
	echo 'id="current_pic"';
}

echo '><a href="';
echo Zhimin::buildUrl('media', 'media', '', 'show=photo');
echo '" >图片</a></li>' . "\r\n" . '				</ul>' . "\r\n" . '				</div>' . "\r\n" . '				<div id="right_menu">' . "\r\n" . '					<ul>' . "\r\n" . '						<li class="menu_user"><a href="';
echo Zhimin::buildUrl('judge', 'report', 'index');
echo '">考核统计</a></li>' . "\r\n" . '						<li class="menu_setting"><a href="';
echo Zhimin::buildUrl('recorder', 'device', 'index');
echo '" >设备台账</a></li>' . "\r\n" . '						<li class="menu_message"><a href="';
echo Zhimin::buildUrl('media', 'file', 'index');
echo '" >文件管理</a></li>' . "\r\n" . '						<li class="menu_quit"><a href="';
echo Zhimin::buildUrl('unit', 'userunit', 'index');
echo '" >用户管理</a></li>' . "\r\n" . '						' . "\r\n" . '					</ul>' . "\r\n" . '				</div>' . "\r\n" . '			</div>' . "\r\n" . '			<div class="clearfix"></div>		' . "\r\n" . '		</div>' . "\r\n" . '		<div id="main">' . "\r\n" . '			';
echo $main;
echo '	' . "\r\n" . '		</div>' . "\r\n" . '		<div class="clear"></div>' . "\r\n" . '		<div id="footer">' . "\r\n" . '			<p>技术支持&nbsp;&nbsp;北京智敏科技发展有限公司（版本号:';
echo $settings['version'];
echo '）</p>' . "\r\n" . '		</div>' . "\r\n" . '	</div>' . "\r\n" . '</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

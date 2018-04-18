<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>服务器管理
</title>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/jquery.min.js">
</script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/laydate/laydate.js">
</script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/layer/layer.js">
</script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/global.js">
</script>
<script type="text/javascript" src="<?php Zhimin::g('assets_uri')?>js/server.js">
</script>
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri')?>style/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri')?>style/global.css" />
<!--[if IE 7]>

<style>
.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}
.atten_top .close{line-height: normal;}

</style>

<![endif]-->

</head>

<body class="main_body">
	<div class="detail">	
<?php include_once('menu.php');?>
<div class="detail_top">		
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />	
</div>	
<div class="detail_body">		
	<div class="tabel_box surpervision">			
		<div class="action_div action_state">				
	<span class="addlevel_s add on">添&nbsp;&nbsp;加
</span>
<span class="addlevel_s edit_a">修&nbsp;&nbsp;改
</span>
</div>			
<div class="table_height">							
	<table class="table_detail">					
	<thead>						
	<tr>							
	<th class="t_back" width="6%">序号
</th>							
<th width="12%">服务器名称
</th>							
<th class="t_back" width="12%">服务器IP地址
</th>							
<th width="12%">登录用户
</th>							
<th class="t_back" width="12%">登录密码
</th>							
<th width="15%">端口
</th>							
<th class="t_back" width="15%">路径url
</th>							
<th width="10%">是否使用
</th>							
<th class="t_back">
</th>														
</tr>					
</thead>					
<tbody class="tbody_atten tbody_on">						
	<!-- 这里有两个效果，一个隔行换色td_back-->						

<?php if ($servers) {
	foreach ($servers as $key => $value ) {
		if ($value['flag'] == '1') {
			$value['flag'] = '是';
		}

		if ($value['flag'] == '0') {
			$value['flag'] = '否';
		}

		$repwd = '';

		for ($i = 0; $i < strlen($value['pwd']); $i++) {
			$repwd .= '*';
		}

		if (($key % 2) == 1) {
			$val = '<tr class=\'tr_p td_back\' date=\'' . $value['id'] . '\'>';
		}
		else {
			$val = '<tr class=\'tr_p\' date=\'' . $value['id'] . '\'>';
		}

		$val .= '<td>' . ($key + 1) . '</td>';
		$val .= '<td>' . $value['servername'] . '</td>';
		$val .= '<td>' . $value['serverip'] . '</td>';
		$val .= '<td>' . $value['ftpusername'] . '</td>';
		$val .= '<td>' . $repwd . '</td>';
		$val .= '<td>' . $value['port'] . '</td>';
		$val .= '<td>' . $value['path'] . '</td>';
		$val .= '<td>' . $value['flag'] . '</td>';
		echo $val;
	}
}
else {
	echo '<tr class=\'td_back\'><td colspan=\'8\'>暂无记录</td></tr>';
}?>
											
</tbody>				
</table>			
</div>			
<div class="page_link">				
<?php $page_m = Zhimin::getComponent('page');
echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
</div>		
</div>				
</div>	
<div class="detail_foot">		
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />	
</div>		
</div>
<!-- 添加弹框 -->
<div class="layer_notice atten_add">	
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>添加
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
	<form action="'Zhimin::buildUrl()'&action=add" method="post" name="server_add_form" id="server_add_form">		
	<div class="con_atten_wrap recorder_notice">			
	<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">服务器名称：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="servername" value="" />						
<span class="error_msg">请填写名称
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">服务IP地址：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="serverip" value="" />						
<span class="error_msg">请填写IP地址
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">登录用户名：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="ftpusername" value="" />						
<span class="error_msg">请填写登录用户名
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">登录密码：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="pwd" value="" />						
<span class="error_msg">请填写登录密码
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">端口：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="port" value="" />						
<span class="error_msg">请填写端口
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">路径url：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" class="input_error" name="path" value="" />						
<span class="error_msg">请填写路径url
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">是否使用：
</span>					
<div class="select_265 select_div select_radio select_no">						
	<label for="radio_yes">							是							
	<input type="radio" id="radio_yes" name="flag" value="1"/>						
</label>						
<label for="radio_no">							否							
	<input type="radio" id="radio_no" name="flag" checked value="0"/>						
</label>					
</div>				
</div>				
<div class="clear">
</div>			
</div>							
<div class="condition_top">				
	<div class="condition_345 condition_s">						
	<div class="select_260 select_div  select_  select_in selec_text">						
	<font class="sign_d sign_star" style="color:#fff;">*
</font>						
<span class="sure_add" id="add_sure">确 定
</span>						
<span class="sure_cancle close_btn">取 消
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>		
</div>						
</form>	
</div>	
<div class="notice_foot">
</div>
</div>
<!-- 修改弹框 -->
<div class="layer_notice atten_edit">	
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>修改
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>	
<div class="notice_body">		
	<form action="" method="post" name="server_edit_form" id="server_edit_form">		
	<div class="con_atten_wrap recorder_notice">			
	<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">服务器名称：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" id="edit_servername" name="servername" value="" />						
<span class="error_msg">请填写名称
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">服务IP地址：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" id="edit_serverip" name="serverip" value="" />						
<span class="error_msg">请填写IP地址
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">登录用户名：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" id="edit_ftpusername" name="ftpusername" value="" />						
<span class="error_msg">请填写登录用户名
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">登录密码：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="password" id="edit_pwd" name="pwd" value="" />						
<span class="error_msg">请填写登录密码
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">端口：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" id="edit_port" name="port" value="" />						
<span class="error_msg">请填写端口
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">路径url：
</span>					
<font class="sign_d sign_star">*
</font>					
<div class="select_260 select_div select_relative select_in">														
	<input type="text" id="edit_path" name="path" value="" />						
<span class="error_msg">请填写路径url
</span>					
</div>				
</div>				
<div class="clear">
</div>			
</div>			
<div class="condition_top">				
	<div class="condition_345 condition_s">					
	<span class="condition_title">是否使用：
</span>					
<div id="edit_flag" class="select_265 select_div select_radio select_no">						
<!--
<label for="radio_yes">							是							
<input type="radio" name="flag" id="radio_yes" value="1" checked="checked">						
</label>						
<label for="radio_no">							否							
<input type="radio" name="flag" id="radio_no" value="0" checked="checked">						
</label>  -->					
</div>				
</div>				
<div class="clear">
</div>			
</div>							
<!--
<div class="condition_top">				
<div class="condition_345 condition_s">						
<font class="sign_d sign_star" style="color:#fff;">*
</font>					
<input type="hidden" name="saveflag" value="1" />
                        
                        <input type="hidden" name="id" id="edit_id" value="" />						
                        <span class="sure_add" id="edit_submit">确 定
                        </span>					
                        <span class="sure_cancle close_btn">取 消
                        </span>				
                        </div>				
                        <div class="clear">
                        </div>			
                    </div>-->			
                        <div class="condition_top">				
                        	<div class="condition_345 condition_s">						
                        	<div class="select_260 select_div  select_  select_in selec_text">						
                        	<font class="sign_d sign_star" style="color:#fff;">*
                        </font>						
                        <input type="hidden" name="saveflag" value="1" />						
                        <input type="hidden" name="id" id="edit_id" value="" />							
                        <span class="sure_add" id="edit_submit">确 定
                        </span>						
                        <span class="sure_cancle close_btn">取 消
                        </span>					
                    </div>				
                    </div>				
                        <div class="clear">
                        </div>			
                    </div>		
                    </div>						
                    </form>	
                    </div>	
                        <div class="notice_foot">
                        </div>
                    </div>
                        <!-- 成功提示框 -->
                        <div class="layer_notice lay_success">	
                        	<div class="notice_top">
                        	<span class="close close_btn">
                        	<img src="./images/close.png" alt="" />
                    </span>
                    </div>	
                        <div class="notice_body">		
                        	<div class="n_left">			
                        	<img src="./images/success_bg.png">		
                    </div>		
                        <div class="n_right">			
                        	<p id="success_flg">删除成功......
                        	<font>3
                        </font>秒钟后返回页面！
                    </p>			
                        <div class="clear">
                        </div>			
                        <span class="cancle_span close_btn">确 定
                        </span>		
                    </div>	
                    </div>	
                        <div class="notice_foot">
                        </div>
                    </div>
                        <!-- 失败提示框 -->
                        <div class="layer_notice lay_wrong">	
                        	<div class="notice_top">
                        	<span class="close close_btn">
                        	<img src="./images/close.png" alt="" />
                    </span>
                    </div>	
                        <div class="notice_body">		
                        	<div class="n_left">			
                        	<img src="./images/notice_bg.png">		
                    </div>		
                        <div class="n_right">			
                        	<p id="fail_flg">删除失败......
                        	<font>3
                        </font>秒钟后返回页面！
                    </p>			
                        <div class="clear">
                        </div>			
                        <span class="cancle_span close_btn_self">确 定
                        </span>		
                    </div>	
                    </div>	
                        <div class="notice_foot">
                        </div>
                    </div>
                    
                    </body>

</html>

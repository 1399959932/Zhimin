<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
<title>工作站公告管理
</title>		
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js">
</script>	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/stnotify.js">
</script>	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js">
</script>	
<style>		.condition_textarea .textarea_in textarea{*height: 79px;}	
</style>	
<!--[if IE 7]>
<style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}
</style>
<![endif]-->
</head>
<body class="main_body">	
	<div class="detail">		
<?php include_once ('menu.php');?>
				
<div class="detail_top">			
	<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
</div>		
<div class="detail_body">			
	<div class="tabel_box surpervision">				
	<form action="<?php echo Zhimin::buildUrl();?>&action=search" method="post">					
<div class="condition_top">						
<!-- 
<div class="condition_240 condition_s">							
<span class="condition_title">单位：
</span>							
<div class="select_200 select_div">								
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>						
</div> -->												
<div class="condition_175 condition_s">							
	<span class="condition_title">时间范围：
</span>							
<div class="select_112 select_div">								
	<select class="easy_se" name="date_time" style="width:100%;">									
	<option value="1" 

<?php if (Zhimin::request('date_time') == '1') {?>
	 selected
<?php }?>

>本周
</option>									
<option value="2" 

<?php if (Zhimin::request('date_time') == '2') {?>
	 selected
<?php }?>

>本月
</option>									
<option value="3" 

<?php if (Zhimin::request('date_time') == '3') {?>
	 selected
<?php }?>

>一段时间
</option>								
</select>							
</div>						
</div>						
<div class="condition_144 condition_s condition_t condi_time">							
	<span>至
</span>							
<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="sdate" name="sdate" value="<?php echo Zhimin::request('sdate');?>
"  />								
</div>								
<div class="select_time condition_start" onclick="laydate({elem: '#sdate',format: 'YYYY-MM-DD'});">
</div>							
</div>													
</div>												
<div class="condition_130 condition_s condi_time">														
	<div class="select_130 select_div">								
	<div class="select_105 sele_c select_in">									
	<input type="text" id="edate" name="edate" value="<?php echo Zhimin::request('edate');?>" />								
</div>								
<div class="select_time condition_end" onclick="laydate({elem: '#edate',format: 'YYYY-MM-DD'});">
</div>							
</div>						
</div>						
<div class="condition_s sub">														
	<input type="submit" value="" />						
</div>						
<div class="clear">
</div>					
</div>				
</form>				
<div class="action_div action_state">								

<?php if ($user_auth['add'] == 1) {?>
	
	<span class="addlevel_s add on">添加
	</span>
<?php }?>

<?php if ($user_auth['check'] == 1) {?>
	
	<span class="addlevel_s view_a">查看
	</span>
<?php }?>

<?php if ($user_auth['del'] == 1) {?>
	
	<span class="addlevel_s action_del" >删 除
	</span>
<?php }?>

				
</div>				
<div class="table_height">								
	<table class="table_detail">						
	<thead>							
	<tr>								
	<th width="6%">序号
</th>								
<th width="11%" class="t_back">发布<?php echo $_SESSION['zfz_type'];?>（<?php echo $_SESSION['zfz_type'] ;?>编号）
</th>				     			
<th width="16%">单位
</th>									
<th width="24%" class="t_back">公告内容
</th>								
<th width="16%">是否发布
</th>								
<th width="15%" class="t_back">发布时间
</th>								
<th width="6%">顺序
</th>							
</tr>						
</thead>						
<tbody class="tbody_atten">							
	<!-- 这里有两个效果，一个隔行换色td_back-->							

<?php if ($stnotifys) {
	foreach ($stnotifys as $key => $value ) {
		$stnotify_m = new StnotifyModel();
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$stnotify = $stnotify_m->data_by_id($value['id']);
		$user_a = $user_m->get_by_name($stnotify['creater']);
		$unit_a = $unit_m->get_by_sn($user_a['dbh']);
		$unit_c = $unit_m->get_by_sn($stnotify['receiver']);
		$stnotify['unit_name'] = ($unit_a['dname'] == '' ? '--' : $unit_a['dname']);
		$stnotify['status'] = ($value['status'] == '0' ? '未发布' : '已发布');
		$stnotify['user_name'] = ($user_a['realname'] == '' ? $user_a['username'] : $user_a['realname']);
		$stnotify['hostcode'] = ($user_a['hostcode'] == '' ? '--' : $user_a['hostcode']);

		if (($key % 2) == 1) {?>
			<tr class='tr_p td_back' date='<?php echo $value['id'];?>'>
		<?php }
		else {?>
			<tr class='tr_p' date='<?php echo $value['id'];?>'>
		<?php }?>

		<td><?php echo ($key + 1);?></td>
		<td><?php echo $stnotify['user_name'];?>(<?php echo $stnotify['hostcode'];?>)</td>
		<td><?php echo $stnotify['unit_name'];?></td>
		<td><?php echo $value['content'];?></td>
		<td><?php echo $stnotify['status'];?></td>
		<td><?php echo $value['publishdate'];?></td>
		<td><?php echo $value['vieworder'];?></td>
		<?php $val;
	}
}
else 
{
?>
	<tr class='td_back'><td colspan='8'>暂无记录</td></tr>
<?php }?>

											
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
<form action="<?php echo Zhimin::buildUrl();?>&action=add" method="post" name="stnotify_add_form" id="stnotify_add_form">			
<div class="con_atten_wrap recorder_notice">				
	<div class="condition_top">					
	<div class="condition_345 condition_s condition_textarea condition_height">						
	<span class="condition_title">工作站公告&nbsp;:
</span>						
<font class="sign_d sign_star">*
</font>						
<div class="select_260 select_div select_relative select_days textarea_in">															
	<textarea class="input_error" name="content">
</textarea>					
<!-- 		
<span class="error_msg">请填写工作站公告内容
</span>	 -->						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">是否发布&nbsp;:
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_radio select_in selec_text">							
	<label for="radio_yes">								是								
	<input type="radio" id="radio_yes" name="status" value="1" checked="checked"/>							
</label>							
<label for="radio_no">								否								
	<input type="radio" id="radio_no" name="status" value="0"/>							
</label>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s">						
	<span class="condition_title">填写顺序&nbsp;:
</span>						
<font class="sign_d sign_star1">*
</font>						
<div class="select_260 select_div select_in select_config">															
	<input type="text" name="vieworder" value="1" />							
<div class="sign">								
	<span class="plus">
</span>								
<span class="minus">
</span>							
</div>						
</div>					
</div>					
<div class="clear">
</div>				
</div>				
<!-- 
<div class="condition_top con_zindex_1">					
<div class="condition_345 condition_s">						
<span class="condition_title">单位：
</span>						
<font class="sign_d sign_star">*
</font>							
<div class="select_260 select_div">								
<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>							
</div>					
</div>					
<div class="clear">
</div>				
</div> -->				
<div class="condition_top">					
	<div class="clear">
</div>				
</div>				
<div class="condition_top">					
	<div class="condition_345 condition_s ">						
	<font class="sign_d sign_star">&nbsp;
</font>												
<div class="select_260 select_div select_in selec_text">															
	<span class="sure_add">确 定
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
<!-- 确认提示框 -->	
<div class="layer_notice lay_confirm_del">		
	<div class="notice_top">
	<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body1">			
	<div class="n_left">				
	<img src="./images/del_bg.png">			
</div>			
<div class="n_right">				
	<p>确定删除此条信息？
</p>				
<div class="clear">
</div>				
<span class="sure_span sure_one_del">确 定
</span>				
<span class="cancle_span close_btn">取 消
</span>			
</div>		
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
<!-- 查看 -->	
<div class="layer_notice atten_view">		
	<div class="notice_top atten_top">
	<span style="display: inline-block;width:20px;">
</span>查看
<span class="close close_btn">
	<img src="./images/close.png" alt="" />
</span>
</div>		
<div class="notice_body" id="notice_body">		
</div>		
<div class="notice_foot">
</div>	
</div>
<script type="text/javascript">
	$(document).ready(function(){	
		/*search list tree*/	
		$("#easyui_search").combotree({
			url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
			method:'get',labelPosition:'top',panelWidth:'500px',	
			// 设置选中项	
			onLoadSuccess:function(node,data){		
				$("#easyui_search").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);  
			}  	
	});  
		/*search list tree end*/ 	
		/*add tree*/	
		$("#easyui_add").combotree({url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
			method:'get',labelPosition:'top',panelWidth:'500px',	
			// 设置选中项	
			onLoadSuccess:function(node,data){		
				$("#easyui_add").combotree('setValues', ['']);      
			}  	
		});
		/*add tree end*/	
		$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});	
	})</script>
	<script type="text/javascript">
$(document).ready(function(){	
	var n='<?php echo Zhimin::request('date_time');?>
		if(n=='3'){		
			$(".condi_time").show();		
		}else{		
			$(".condi_time").hide();	
		}	
		$(".easyui-combotree").combotree({
			url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
			method:'get',labelPosition:'top',panelWidth:'500px',	
			// 设置选中项	
			onLoadSuccess:function(node,data){		
				$(".easyui-combotree").combotree('setValues', ['<?php echo Zhimin::request('danwei');?>']);      
			}  	
		});	
		$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});	
		$('.easy_se').combobox({panelHeight:'80px',selectOnNavigation:true,editable:false,labelPosition:'top',	
			onChange: function (n,o) {		
				if(n=='3'){			
					$(".condi_time").show();		
				}else{			
					$(".condi_time").hide();		
				}	
			},	
			onLoadSuccess:function(data){ 		
				$('.easy_se').combobox('setValue',['<?php echo Zhimin::request('date_time');?>']);	
			}
		});
	})
</script>
</script>
</body>
</html>

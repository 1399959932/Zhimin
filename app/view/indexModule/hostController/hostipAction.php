<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>工作站管理</title>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/hostip.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js"></script>
	<!--[if IE 7]>
	<style>
.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}
.atten_top .close{line-height: normal;}
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
				<form action="<?php echo Zhimin::buildUrl();?>
&action=search" method="post">
					<div class="condition_top">
						<div class="condition_263 condition_s">
							<span class="condition_title">所属单位：</span>
							<div class="select_200 select_div">
								<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_search"/>
							</div>
						</div>
						<div class="condition_s sub">							
							<input type="submit" value="" />
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<div class="action_div action_state">
					

<?php if ($device_auth['add'] == 1) {?>
	<span class="addlevel_s add on">添&nbsp;&nbsp;加</span>
<?php }?>

<?php if ($device_auth['edit'] == 1) {?>
	<span class="addlevel_s edit_a">修&nbsp;&nbsp;改</span>
<?php }?>

<?php if ($device_auth['del'] == 1) {?>
	<span class="addlevel_s action_del" id="user_del_but">删 除</span>
<?php }?>

<?php if ($device_auth['admin'] == 1) {?>
	<!-- //modify
	//<span class="addlevel_s global_c_hostip" >远程配置</span>
	//<span class="addlevel_s global_c on" >全局配置</span>
 --><?php }?>
				</div>
				<div class="table_height">			
					<table class="table_detail" style="width:190%;">
						<thead>
							<tr>
								<th class="t_back" width="3%">序号</th>
								<th width="7%">名称</th>
								<th class="t_back" width="10%">所属单位</th>
								<th width="8%">主机地址</th>
								<th class="t_back" width="5%">工作状态</th>
								<th width="8%">上次心跳时间</th>
								<th class="t_back" width="8%">在线时长</th>
								<th width="5%">CPU(%)</th>
								<th class="t_back" width="5%">内存占用（%）</th>
								<th width="6%">网络（bps）</th>								
								<th class="t_back" width="6%">软件版本</th>
								<th width="4%">磁盘容量（GB）</th>
								<th class="t_back" width="4%">剩余空间（GB）</th>
								<th width="4%">负责人</th>
								<th class="t_back" width="5%">联系电话</th>
								<th width="10%">工作站地址</th>
							</tr>
						</thead>
						<tbody class="tbody_atten">
							<!-- 这里有两个效果，一个隔行换色td_back-->
							

<?php if (empty($datas)) {?>
								<tr class="td_back">
									<td colspan="16">暂无记录</td>
								</tr>	
								
<?php }
else {?>
	<?php foreach ($datas as $k => $v ) {?>
									<tr date="
		<?php echo $v['id']?>;
		" class="tr_p 

		<?php if (($k % 2) == 1) {?>
			td_back
		<?php }?>

		">
										<td>
		<?php echo $k + 1;?>
		</td>
										<td>
		<?php echo $v['hostname'];?>
		</td>
										<td>
		<?php echo $v['unitname'] == '' ? '--' : $v['unitname'];?>
		</td>
										<td>
		<?php echo $v['hostip'];?>
		</td>
										<td>
		<?php echo $v['online'] == 1 ? '在线' : '离线';?>
		</td>
										<td>
		<?php echo $v['modtime'];?>
		</td>	
										<td>
		<?php echo $v['activetime'];?>
		</td>															
										<td>
		<?php echo $v['cpu_rate'];?>
		</td>								
										<td>
		<?php echo $v['memory_rate'];?>
		</td>
										<td>
		<?php echo $v['web_rate'];?>
		</td>								
										<td>
		<?php echo $v['version'];?>
		</td>							
										<td>
		<?php echo number_format($v['totalspace'] / 1024, 0, '.', '');?>
		</td>								
										<td>
		<?php echo number_format($v['freespace'] / 1024, 0, '.', '');?>
		</td>								
										<td>
		<?php echo $v['contact'];?>
		</td>								
										<td>
		<?php echo $v['telephone'];?>
		</td>								
										<td>
		<?php echo $v['address'];?>
		</td>								
									</tr>
									
	<?php }?>
<?php }?>

						
						</tbody>
					</table>
				</div>
				<div class="page_link">
					
<?php $page_m = Zhimin::getComponent('page');?>
<?php echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
				</div>
			</div>			
		</div>
		<div class="detail_foot">
			<img src="./images/main_detail_fbg.png" width="100%" alt="" />
		</div>		
	</div>
	<!-- 添加弹框 -->
	<div class="layer_notice atten_add">
		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
		<div class="notice_body">
			<form action="<?php Zhimin::buildUrl();?>
&action=add" method="post" name="hostip_add_form" id="hostip_add_form">
			<div class="con_atten_wrap recorder_notice">
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">名称：</span>
						<font class="sign_d sign_star">*</font>
						<div class="select_260 select_div select_relative select_in">								
							<input type="text" class="input_error" name="hostname" value="" />
							<span class="error_msg">请填写名称</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">单位：</span>
						<font class="sign_d sign_star">*</font>
						<div class="select_260 select_div">
							<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" id="easyui_add"/>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">IP地址：</span>
						<font class="sign_d sign_star">*</font>
						<div class="select_260 select_div select_relative select_in">								
							<input type="text" class="input_error" name="hostip" value="" />
							<span class="error_msg">请填写主机地址</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">负责人：</span>
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_in">								
							<input type="text" name="contact" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">联系电话：</span>
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_in">								
							<input type="text" name="telephone" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">工作站地址：</span>
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_in">								
							<input type="text" name="address" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_346 condition_s condition_textarea condition_height">
						<span class="condition_title">备注：</span>
						<font class="sign_d sign_star1">*</font>
						<!-- <div class="select_260 select_div select_days textarea_in">								
							<textarea name="memo"></textarea>
						</div> -->
						<textarea name="memo" style="width:258px;height:78px; float:right; border:1px soli #aaa;resize: none;border:1px solid #aaa; overflow:auto;*margin-right:-5px;"></textarea>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s ">
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_in selec_text">
							<span class="sure_add" id="add_submit">确 定</span>
							<span class="sure_cancle close_btn">取 消</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>				
			</form>
		</div>
		<div class="notice_foot"></div>
	</div>
	<!-- 修改弹框 -->
	<div class="layer_notice atten_edit">
		<div class="notice_top atten_top"><span style="display: inline-block;width:20px;"></span>修改<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
		<div class="notice_body">
			<form method="post" name="hostip_edit_form" id="hostip_edit_form">
			<div class="con_atten_wrap recorder_notice">
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">名称：</span>
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_relative select_in selec_text">								
							<p id="edit_hostname"></p>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">单位：</span>
						<font class="sign_d sign_star">*</font>
						<div class="select_260 select_div">
							<input class="easyui-combotree" name="danwei_edit" data-options="" style="width:100%;" id="easyui_edit"/>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">IP地址：</span>
						<font class="sign_d sign_star">*</font>
						<div class="select_260 select_div select_relative select_in">								
							<input type="text" name="hostip" value="" id="edit_hostip"/>
                            <span class="error_msg">请填写主机地址</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">负责人：</span>
						<font class="sign_d sign_star" style="color:#fff;">*</font>
						<div class="select_260 select_div select_in">								
							 <input type="text" name="contact" id="edit_contact" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">联系电话：</span>
						<font class="sign_d sign_star" style="color:#fff;">*</font>
						<div class="select_260 select_div select_in">								
							 <input type="text" name="telephone" id="edit_telephone" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s">
						<span class="condition_title">工作站地址：</span>
						<font class="sign_d sign_star" style="color:#fff;">*</font>
						<div class="select_260 select_div select_in">								
							<input type="text" name="address" id="edit_address" value="" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_346 condition_s condition_textarea condition_height">
						<span class="condition_title">备注：</span>
						<font class="sign_d sign_star1">*</font>
						<!-- <div class="select_260 select_div select_days textarea_in">								
							<textarea name="memo" id="edit_memo"></textarea>
						</div> -->
						<textarea name="memo" id="edit_memo" style="width:250px;height:76px; float:right; border:1px soli #aaa;resize: none;border:1px solid #aaa; padding:2px 5px;overflow:auto;*margin-right:-5px;"></textarea>
					</div>
					<div class="clear"></div>
				</div>
				<div class="condition_top">
					<div class="condition_345 condition_s ">						
						<font class="sign_d sign_star1">*</font>
						<div class="select_260 select_div select_in selec_text">
							<input type="hidden" name="saveflag" value="1" />
                        	<input type="hidden" name="id" id="edit_id" value="" />
							<span class="sure_add" id="edit_submit">确 定</span>
							<span class="sure_cancle close_btn">取 消</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>

			</div>				
			</form>
		</div>
		<div class="notice_foot"></div>
	</div>
	<!-- 确认提示框 -->
	<div class="layer_notice lay_confirm_del">
		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
		<div class="notice_body1">
			<div class="n_left">
				<img src="./images/del_bg.png">
			</div>
			<div class="n_right">
				<p>确定删除此工作站？</p>
				<div class="clear"></div>
				<span class="sure_span sure_one_del">确 定</span>
				<span class="cancle_span close_btn">取 消</span>
			</div>
		</div>
		<div class="notice_foot"></div>
	</div>
	<!-- 成功提示框 -->
	<div class="layer_notice lay_success">
		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
		<div class="notice_body4">
			<div class="n_left">
				<img src="./images/success_bg.png">
			</div>
			<div class="n_right">
				<p id="success_flg">删除成功......<font>3</font>秒钟后返回页面！</p>
				<div class="clear"></div>
				<span class="cancle_span close_btn">确 定</span>
			</div>
		</div>
		<div class="notice_foot"></div>
	</div>
	<!-- 失败提示框 -->
	<div class="layer_notice lay_wrong">
		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
		<div class="notice_body4">
			<div class="n_left">
				<img src="./images/notice_bg.png">
			</div>
			<div class="n_right">
				<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>
				<div class="clear"></div>
				<span class="cancle_span close_btn_self">确 定</span>
			</div>
		</div>
		<div class="notice_foot"></div>
	</div>
	<script type="text/javascript">
$(document).ready(function(){
	/*search list tree*/
	$("#easyui_search").combotree({
		url:'<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname',
		method:'get',
		labelPosition:'top',
		panelWidth:'500px',	
		// 设置选中项
		onLoadSuccess:function(node,data){
			$("#easyui_search").combotree('setValues', ["<?php echo Zhimin::request('danwei');?>"]); 
		}  
	});  /*search list tree end*/ 
	/*add tree*/
	$("#easyui_add").combotree({
		url:"<?php echo Zhimin::buildUrl('unitjson', 'other')?>&id=bh&text=dname",
		method:'get',
		labelPosition:'top',
		panelWidth:'500px',
		// 设置选中项
		onLoadSuccess:function(node,data){
			$("#easyui_add").combotree('setValues', ['']);  
		}  
		});/*add tree end*/
		$('.easy_u').combobox({panelHeight:'120px',selectOnNavigation:true,editable:false,labelPosition:'top'});
	})
</script>
</body>
</html>
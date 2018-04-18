<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>同级调阅</title>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js"></script>
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/access.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js"></script>
	<style>
		.view_a_look{background: url("./images/action_bg1.png") 0 0 no-repeat !important;}
		.view_a_look:hover{background: url("./images/action_bg3.png") 0 0 no-repeat !important;}
		.view_a_del{background: url("./images/letter_delete.png") 0 0 no-repeat !important;}
		.view_a_del:hover{background: url("./images/delete_on.png") 0 0 no-repeat !important;}
		.sure_add{ margin-left:70px;}
	</style>
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
				<?php $auth = Zhimin::getComponent('auth');?>
				<?php if (!$auth->isSuperAdmin()) {
				$where .= ' AND pac.applicant=\'' . $user_name . '\''; ?>

				<?php if ($user_auth['add'] == 1) {	 ?>
				<div class="action_div">
					<span class="addlevel_s addlevel_b on" date="./addCase.php">添&nbsp;&nbsp;加</span>	
				</div>;
				<?php }?>
				<?php }?>

			<div class="table_height">
				<table class="table_detail">
					<thead><tr>
						<th class="t_back" width="6%">序号</th>
						<th width="16%">操作</th>
						<th class="t_back" width="17%">申请调阅单位</th>
						<th width="15%">申请状态</th>
						<th class="t_back" width="11%">申请时间</th>
						<th></th>
					</tr></thead>
					<tbody class="tbody_atten"><!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->
						<?php foreach ($datas as $k => $v ) {	?>
						<?php if (2 == $v['app_status']) {	?>
						<tr class="td_back td_red" date="<?php $v['id'];?>">
							<td><?php echo $k + 1;?></td>
							<td><span class="action_span">
								<a class="a_viewlevel view_a view_a_look" date="<?php echo $v['id'];?>" href="javascript:void(0)">查看</a>
								<a  class="a_viewlevel view_a view_a_del" date="<?php echo $v['id'];?>" href="javascript:void(0)">查看</a>
								</span>
							</td>
							<td><?php echo $v['dname'];?></td>
							<td><?php echo $status[$v['app_status']];?></td>
							<td><?php echo date('Y-m-d', $v['create_date']);?></td>
							<td></td>
						</tr>
						<?php }
						else {	?>
						<tr date="<?php $v['id'];?>" >
							<td><?php echo $k + 1;?></td>
							<td>
								<span class="action_span">
								<a  class="a_viewlevel view_a view_a_look" date="<?php echo $v['id'];?>" href="javascript:void(0)">查看</a>
								<a  class="a_viewlevel view_a view_a_del" date="<?php echo $v['id'];?>" href="javascript:void(0)">查看</a>
								</span>
							</td>
							<td><?php echo $v['dname'];?></td>
							<td><?php echo $status[$v['app_status']];?></td>
							<td><?php echo date('Y-m-d', $v['create_date']);?></td>
							<td></td>
						</tr>
						<?php }?>
						<?php }?>
						<!-- 没有记录时输出 -->
					<?php if (empty($datas)) {?>
						<tr class="td_back"><td colspan="6">暂无记录</td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
			<div class="page_link">
			<?php echo $page_m = Zhimin::getComponent('page');
			echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
			</div>
		</div>
	</div>
	<div class="detail_foot">
		<img src="./images/main_detail_fbg.png" width="100%" alt="" />
	</div>
</div>
<!-- 添加弹框 -->
<div class="layer_notice level_add level_l">
	<div class="notice_top atten_top"><span style="display:inline-block;width:20px;"></span>添加<span class="close close_btn"><img src="./images/close.png" alt="" /></span></div>
	<div class="notice_body">
		<form id="saveAdd" name="add_form" method="post" action="<?php Zhimin::buildUrl('accessfrom', 'access', 'index');?>&action=add">
		<div class="con_atten_wrap con_level_wrap">
			<div class="condition_top">
				<div class="condition_348 condition_s">
					<span class="condition_title">申请调阅单位：</span>
					<div class="select_260 select_div">
						<select class="easy_u" name="app_unit" id="app_unit" style="width:100%;">
							<option value="">-请选择-</option>
							<?php foreach ($brothers as $k => $v ) {?>
								<option value="<?php $v['bh'];?>">
									<?php $v['dname']?>
								</option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="condition_top">
				<div class="condition_348 condition_s"><span class="condition_title">审批负责人：</span>
					<div class="select_260 select_div">
						<select class="easy_u" name="approver" id="appr_people" style="width:100%;">
							<option value="">-请选择-</option>
							<?php foreach ($b_users as $k => $v ) {?>
								<option value="<?php $v['id'];?>"
									<?php $v['username']?>
								</option>
							<?php }?>

						</select>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="condition_top">
				<div class="condition_348 condition_s ">
					<div class="select_260 select_div select_in selec_text"><span class="sure_add" id="add_submit">确 定</span><span class="sure_cancle close_btn">取 消</span>
					</div>
				</div>
				<div class="clear"></div>
			</div>		
		</div>						
	</form>	
</div>	
<div class="notice_foot"></div>
</div>
<!-- 查看 -->
<div class="layer_notice level_add level_view">	
	<div class="notice_top atten_top">
		<span style="display:inline-block;width:20px;"></span>查看<span class="close close_btn"><img src="./images/close.png" alt="" /></span>
	</div>	
	<div class="notice_body">		
		<form>		
			<div class="con_atten_wrap con_level_view">			
				<div class="condition_top">				
					<div class="condition_348 condition_s">					
						<span class="condition_title">申请调阅单位：</span>					
						<div class="select_260 select_div select_in selec_text" id="danwei">								{单位总称｝					
						</div>
					</div>								
					<div class="clear"></div>			
				</div>			
				<div class="condition_top">				
					<div class="condition_348 condition_s">					
						<span class="condition_title">申请时间：</span>					
						<div class="select_260 select_div select_in selec_text" id="createtime">														2016.06.23					
						</div>
					</div>
					<div class="clear"></div>			
				</div>			
				<div class="condition_top">				
					<div class="condition_348 condition_s">					
						<span class="condition_title">申请状态：</span>					
						<div class="select_260 select_div select_in selec_text" id="status">														待审核					
						</div>
					</div>								
					<div class="clear"></div>			
				</div>			
				<div class="condition_top">				
					<div class="condition_348 condition_s">					
						<span class="condition_title">审批人：</span>					
						<div class="select_260 select_div select_in selec_text" id="username">														李三四				
						</div>
					</div>								
					<div class="clear"></div>			
				</div>			
				<div class="condition_top">				
					<div class="condition_348 condition_s">					
						<span class="condition_title">审批时间：</span>					
						<div class="select_260 select_div select_in selec_text" id="apptime">														2016.07.25					
						</div>				
					</div>								
					<div class="clear"></div>			
				</div>			
				<div class="condition_top level_btn">				
					<span class="sure_cancle close_btn">关 闭</span>				
					<div class="clear"></div>			
				</div>		
			</div>						
		</form>	
	</div>	
	<div class="notice_foot"></div></div>
	<!-- 确认提示框 --><div class="layer_notice lay_confirm_del">
		<div class="notice_top"><span class="close close_btn"><img src="./images/close.png" alt="" /></span>
		</div>	
		<div class="notice_body1">		
			<div class="n_left">			<img src="./images/del_bg.png">		
			</div>		
			<div class="n_right">			
				<P style="color:#cc3333;">若删除，不可再调阅该单位信息！</P>			
				<p>确定删除？</p>			
				<div class="clear"></div>			
				<span class="sure_span sure_from_del">确 定</span>			
				<span class="cancle_span close_btn">取 消</span>		
			</div>	
		</div>	
		<div class="notice_foot"></div>
	</div>
		<!-- 成功提示框 -->
		<div class="layer_notice lay_success">    	
			<div class="notice_top"><span class="close close_btn"><img src="<?php Zhimin::g('assets_uri');?>images/close.png" alt="" /></span>
			</div>    	
			<div class="notice_body">    		
				<div class="n_left">    			
					<img src="<?php Zhimin::g('assets_uri');?>images/success_bg.png" />    		
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
			<div class="notice_top">
				<span class="close close_btn"><img src="<?php Zhimin::g('assets_uri');?>images/close.png" alt="" /></span>
			</div>    	
			<div class="notice_body">    		
				<div class="n_left">    			
					<img src="<?php Zhimin::g('assets_uri');?>images/notice_bg.png" />    		
				</div>    		
				<div class="n_right">    			
					<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>    			
					<div class="clear"></div>    			
					<span class="cancle_span close_btn_self">确 定</span>    		
				</div>    	
			</div>    	
			<div class="notice_foot"></div>    
		</div>
</body>
</html>
<script type="text/javascript">$(document).ready(function(){$(\'.easy_u\').combobox({panelHeight:\'120px\',selectOnNavigation:true,editable:false,labelPosition:\'top\'});	})</script>

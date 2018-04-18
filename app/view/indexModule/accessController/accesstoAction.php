<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
	<title>同级审批</title>		
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
		.approve_look{background: url("./images/action_bg1.png") 0 0 no-repeat !important;}		
		.approve_look:hover{background: url("./images/action_bg3.png") 0 0 no-repeat !important;}		
		.approve_del{background: url("./images/letter_delete.png") 0 0 no-repeat !important;}		
		.approve_del:hover{background: url("./images/delete_on.png") 0 0 no-repeat !important;}		
		.sure_add{ margin-left:70px;}	
	</style>	<!--[if IE 7]><style>.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}.atten_top .close{line-height: normal;}</style><![endif]-->
</head>
<body class="main_body">	
	<div class="detail">
	<?php include_once ('menu.php');?>
		<div class="detail_top">			
			<img src="./images/main_detail_tbg.png" width="100%" alt="" />		
		</div>		
		<div class="detail_body">			
			<div class="tabel_box surpervision">				
				<div class="table_height">								
					<table class="table_detail">						
						<thead>							
							<tr>								
								<th class="t_back" width="6%">序号</th>								
								<th width="16%">操作</th>								
								<th class="t_back" width="9%">申请人</th>								
								<th width="17%">申请人单位</th>								
								<th class="t_back" width="17%">申请调阅单位</th>								
								<th width="15%">申请状态</th>								
								<th class="t_back" width="11%">申请时间</th>								
								<th></th>							
							</tr>						
						</thead>						
						<tbody class="tbody_atten">	
						<?php foreach ($datas as $k => $v ) {
								if (2 == $v['app_status']) {	?>						
	<tr class="td_back td_red" date="<?php echo $v['id'];?>"	>							
	<td>
		<?php echo $k + 1;?>	
	</td>								
	<td>									
		<span class="action_span">										
			<a  class="a_viewlevel approve approve_look" date="<?php echo $v['id'];?>" href="javascript:void(0)">审批</a>	<a  class="a_viewlevel approve approve_del" date="<?php echo $v['id'];?>" href="javascript:void(0)">审批</a>
		</span>								
	</td>								
	<td>
		<?php echo $v['applicant'];?>
	</td>								
	<td>
		<?php echo $v['danwei_name'];?>
	</td>								
	<td>
		<?php echo $v['dname'];?></td>								
		<td>
		<?php echo $status[$v['app_status']];?></td>								
		<td>
		<?php echo date('Y-m-d', $v['create_date']);?></td>									
		<td></td>							
	</tr>							
	<?php }
	else {?>
	<tr date="<?php $v['id'];?>">					
		<td>
		<?php echo $k + 1;?>
	</td>								
	<td>									
		<span class="action_span">										
			<a  class="a_viewlevel approve approve_look" date="<?php echo $v['id'];?>" href="javascript:void(0)">审批</a>
			<a  class="a_viewlevel approve approve_del" date="<?php  echo $v['id'];?>" href="javascript:void(0)">审批</a>
		</span>								
	</td>								
	<td>
		<?php echo $v['applicant'];?></td>								
		<td>
		<?php echo $v['danwei_name'];?></td>								
		<td>
		<?php echo $v['dname'];?></td>								
		<td>
		<?php echo $status[$v['app_status']];?>
			
		</td>								
		<td>
		<?php echo date('Y-m-d', $v['create_date']);?>
			
		</td>									
		<td></td>							
	</tr>							
	<?php }?>
	<!-- 没有记录时输出 -->		
<?php }?>					

<?php if (empty($datas)) {?>							
<tr class="td_back">								
	<td colspan="6">暂无记录</td>							
</tr>	
<?php }?>							
	</tbody>					
</table>				
</div>				
<div class="page_link">					
		<?php echo $page_m = Zhimin::getComponent('page');?>
<?php echo $page_m->show($page['base_url'] . '&page=', '', 15, $page['total'], $page['page'], 4);?>
		</div>			
	</div>					
</div>		
<div class="detail_foot">			
	<img src="./images/main_detail_fbg.png" width="100%" alt="" />		
</div>			
</div>	
<!-- 查看 -->	
<div class="layer_notice level_add level_view">		
	<div class="notice_top atten_top">
		<span style="display:inline-block;width:20px;"></span>审批<span class="close close_btn">
			<img src="./images/close.png" alt="" /></span>
		</div>		
		<div class="notice_body">			
			<form id="app_form">			
				<div class="con_atten_wrap con_level_view">				
					<div class="condition_top">					
						<div class="condition_348 condition_s">						
							<span class="condition_title">申请人单位：</span>						
							<div class="select_260 select_div select_in selec_text" id="appunit">															｛单位总称｝						
							</div>					
						</div>									
						<div class="clear"></div>				
					</div>				
							<div class="condition_top">					
								<div class="condition_348 condition_s">						
									<span class="condition_title">申请人：</span>						
									<div class="select_260 select_div select_in selec_text" id="username"></div>											
								</div>									
									<div class="clear"></div>				
								</div>				
								<div class="condition_top">					
									<div class="condition_348 condition_s">						
										<span class="condition_title">申请调阅单位：</span>						
										<div class="select_260 select_div select_in selec_text" id="unit"></div>					
									</div>									
									<div class="clear"></div>				
								</div>				
								<div class="condition_top">					
									<div class="condition_348 condition_s">						
										<span class="condition_title">申请时间：</span>						
										<div class="select_260 select_div select_in selec_text" id="createtime">															2016.06.23						</div>					
									</div>									
									<div class="clear"></div>				
								</div>				
								<div class="condition_top">					
									<div class="condition_348 condition_s">						
										<span class="condition_title">申请状态：</span>						
										<div class="select_260 select_div">                        	
											<select class="easy_u" name="approver" id="edit_group" style="width:100%;">			<option value="">-请选择-</option>								
													 <?php foreach ($status as $k => $v ) {?>
													 <option value="<?php $k?>"><?php echo $v ?></option>
													<?php }?>
											</select>   	
						</div>					
					</div>									
					<div class="clear"></div>				
				</div>				
				<div class="condition_top">					
					<div class="condition_348 condition_s">						
						<span class="condition_title">审批时间：</span>						
						<div class="select_260 select_div select_in selec_text" id="apptime">															2016.07.25						
						</div>					
					</div>									
					<div class="clear"></div>				
				</div>				
				<div class="condition_top level_btn">					
					<input type="hidden" name="id" id="app_id" value="" />					
					<!-- 当状态为审批通过或拒绝审批时，用于提示不可再审批 -->					
					<input type="hidden" name="noapp" id="app_no" value=""/>					
					<span class="sure_add" id="app_submit">确 定</span>					
					<span class="sure_cancle close_btn">取 消</span>					
					<div class="clear"></div>				
				</div>			
			</div>							
		</form>		
	</div>		
	<div class="notice_foot"></div>	</div>	
	<!-- 确认提示框 -->	
	<div class="layer_notice lay_confirm_del">		
		<div class="notice_top"><span class="close close_btn">
			<img src="./images/close.png" alt="" /></span>
		</div>		
		<div class="notice_body1">			
			<div class="n_left">				
				<img src="./images/del_bg.png">			
			</div>			
			<div class="n_right">				
				<P style="color:#cc3333;">若删除，不可再调阅该单位信息！</P>				
				<p>确定删除？</p>				
				<div class="clear"></div>				
				<span class="sure_span sure_to_del">确 定</span>				
				<span class="cancle_span close_btn">取 消</span>			
			</div>		
		</div>		
		<div class="notice_foot"></div>	
	</div>	
	<!-- 成功提示框 -->    
	<div class="layer_notice lay_success">    	
		<div class="notice_top">
			<span class="close close_btn"><img src="<?php Zhimin::g('assets_uri');?>images/close.png" alt="" />
			</span>
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
			<span class="close close_btn">
			<img src="<?php Zhimin::g('assets_uri');?>images/close.png" alt="" />
		</span>
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">	
	<title>详情页</title>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.min.js"></script>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/laydate/laydate.js"></script>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/layer/layer.js"></script>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/global.js"></script>	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/case.js"></script>	
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/reset.css" />	
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/global.css" />	
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/default/easyui.css">	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>js/themes/icon.css">	
	<link rel="stylesheet" type="text/css" href="<?php Zhimin::g('assets_uri');?>style/re_easyui.css">	
	<script type="text/javascript" src="<?php Zhimin::g('assets_uri');?>js/jquery.easyui.min.js"></script>	
	<style>		
		.action_part{float: none;}		
		.check_span{*position: static;}	
	</style>
<body style="width:946px;">	
	<div class="layer_iframe">		
		<div class="iframe_top">
			<span style="display: inline-block;width:15px;"></span>添加<span class="close close_btn">
				<img src="./images/close.png" alt="" /></span>
			</div>		
			<div class="iframe_body iframe_body01">			
				<div class="addCase_wrap">				
					<form id="caseadd">				
						<div class="condition_top">					
							<div class="condition_357 condition_s case_conditon">						
								<span class="condition_title">接警单号：</span>						
								<font></font>						
								<div class="select_280 select_div select_relative select_in">								<input type="text" class="input_error" name="pnumber" value="" />							<span class="error_msg">请填写接警单号</span>						
								</div>											
							</div>					
							<div class="condition_350 condition_s case_conditon">						
								<span class="condition_title">接警<?php $_SESSION['zfz_type']?>：</span>					<div class="select_280 select_div select_in select_relative">															
									<input type="text" class="input_error" name="brains" value="" />						</div>											
								</div>					
								<div class="clear"></div>				
							</div>				
							<div class="condition_top">					
								<div class="condition_357 condition_s case_conditon">						
									<span class="condition_title">主题：</span>						
									<font></font>						
									<div class="select_280 select_div select_relative select_in">															
										<input type="text" class="input_error" name="ptitle" value="" />							<span class="error_msg">请填写主题</span>						
									</div>											
								</div>					
								<div class="condition_357 condition_s case_conditon">						
									<span class="condition_title">单位：</span>						
									<font></font>						
									<div class="select_280 select_div">							
										<input class="easyui-combotree" name="danwei" data-options="" style="width:100%;" />							
										<span class="error_msg">请选择单位</span>						
									</div>					
								</div>					
								<div class="clear"></div>				
							</div>				
							<div class="condition_top">					
								<div class="condition_357 condition_s case_conditon">						
									<span class="condition_title">案件类型：</span>						
									<font></font>							
									<div class="select_280 select_div">								
										<select class="easy_u" name="casetaxon" style="width:100%;">								<option value="">请选择</option>
														
														<?php foreach ($casetaxon as $k => $v ) {
															echo '<option value="' . $k . '"';

															if (Zhimin::request('sort') == $k) {
																echo ' selected';
															}

															echo '>' . $v . '</option>';
														}?>


								</select>								
								<span class="error_msg">请选择案件类型</span>							
							</div>											
						</div>    				
						<div class="condition_357 condition_s case_conditon">						
							<span class="condition_title">发生时间&nbsp;:</span>						
							<font></font>						
							<div class="select_280 select_div select_in">							
								<div class="select_260 sele_c select_in select_time_i">								<input class="select_235" type="text" id="e_startup_time" name="occurtime" value="" />							
								</div>							
								<div class="select_time condition_end" onclick="laydate({elem: '#e_startup_time',istime: true,format: 'YYYY-MM-DD hh:mm:ss'});">
								</div>						
							</div>					
						</div>					
						<div class="clear"></div>									
					</div>				
					<div class="condition_top">					
						<div class="condition_350 condition_s case_conditon">						
							<span class="condition_title">简要警情：</span>						
							<div class="select_280 select_div select_in">												<input type="text" name="subject" value="" />						
							</div>									
						</div>					
						<div class="clear"></div>				
					</div>				
					<div class="condition_top">					
						<div class="condition_723 condition_s case_conditon">						
							<span class="condition_title">案件描述：</span>						
							<div class="select_653 select_div select_in">															<textarea name="note" id="" cols="30" rows="10"></textarea>				
							</div>											
						</div>					
						<div class="clear"></div>				
					</div>				
					<div class="condition_top">					
						<div class="condition_350 condition_s case_conditon">						
							<span class="condition_title">相关视频：</span>						
							<div class="select_280 select_div select_in selec_text">										<span class="video_add" id="video_add" date=""></span>						
							</div>											
						</div>					
						<div class="clear"></div>				
					</div>				
					<div class="table_height case_table_h">								
						<table class="table_detail">						
							<thead>							
								<tr>								
									<th class="t_back" width="6%">序号</th>								
									<th width="11%">操作</th>								
									<th class="t_back" width="14%">发布<?php $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type'] ?>编号）</th>								
									<th width="19%">单位</th>								
									<th class="t_back" width="12%">记录仪编号</th>								
									<th width="24%">摄录时间（摄录时长）</th>															
								</tr>						
							</thead>						
							<tbody id="video_add_body">							
								<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->											
							</tbody>					
						</table>				
					</div>				
					<div class="button_case">					
						<span class="sure_add" id="sure_add_case">确 定</span>					
						<span class="sure_cancle close_btn">取 消</span>				
					</div>				
				</form>			
			</div>		
		</div>		
		<div class="iframe_foot iframe_foot01"></div>	
	</div>	
	<!-- 确认提示框 -->	
	<div class="layer_notice lay_confirm_del">		
		<div class="notice_top">
			<span class="close close_btn"><img src="./images/close.png" alt="" /></span>
		</div>		
		<div class="notice_body">			
			<div class="n_left">				
				<img src="./images/del_bg.png">			
			</div>			
			<div class="n_right">				
				<p>确定删除此？</p>				
				<div class="clear"></div>				
				<span class="sure_span sure_one_del">确 定</span>				
				<span class="cancle_span close_btn">取 消</span>			
			</div>		
		</div>		
		<div class="notice_foot"></div>	
	</div>	
	<!-- 警告提示框 -->	
	<div class="layer_notice lay_add">		
		<div class="notice_top">
			<span class="close close_btn"><img src="./images/close.png" alt="" /></span>
		</div>		
			<div class="notice_body">			
				<div class="n_left">				
					<img src="./images/notice_bg.png">			
				</div>			
				<div class="n_right">				
					<p>标注信息不能为空......<font>3</font>秒钟后返回页面！</p>				
					<div class="clear"></div>				
					<span class="cancle_span close_btn">确 定</span>			
				</div>		
			</div>		
			<div class="notice_foot"></div>	
		</div>	
		<!-- 成功提示框 -->	
		<div class="layer_notice lay_success">		
			<div class="notice_top">
				<span class="close close_btn"><img src="./images/close.png" alt="" /></span>
			</div>		
			<div class="notice_body">			
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
			<div class="notice_top">
				<span class="close close_btn"><img src="./images/close.png" alt="" /></span>
			</div>		
			<div class="notice_body">			
				<div class="n_left">				
					<img src="./images/notice_bg.png">			
				</div>			
				<div class="n_right">				
					<p id="fail_flg">删除失败......<font>3</font>秒钟后返回页面！</p>				
					<div class="clear"></div>				
					<span class="cancle_span close_btn">确 定</span>			
				</div>		
			</div>		
			<div class="notice_foot"></div>	
		</div>	
		<!-- 相关视频框 -->	
		<div class="lay_video" style="display:none;">	
			<div class="iframe_top"><span style="display: inline-block;width:15px;"></span>添加相关视频<span class="close close_btn">
				<img src="./images/close.png" alt="" /></span>
			</div>	
			<div class="iframe_body iframe_body01">		
				<div class="addCase_wrap">			
					<form id="form_v">			
						<div class="condition_top">				
							<div class="condition_240 condition_s case_conditon">					
								<span class="condition_title">单位：</span>					
								<div class="select_200 select_div">						
									<input class="easyui-combotree" name="danwei" id="danwei_insert" data-options="" style="width:100%;" />					
								</div>				
							</div>				
							<div class="condition_s">					
								<span class="condition_title">时间：</span>				
							</div>				
							<div class="condition_144 condition_s condition_t">					
								<span>至</span>					
								<div class="select_130 select_div">						
									<div class="select_105 sele_c select_in">							
										<input type="text" id="start" name="sdate" value="<?php Zhimin::request('sdate');?>"  />						
</div>						
<div class="select_time condition_start" onclick="laydate({elem: '#start',format: 'YYYY-MM-DD'});">
	
</div>					
</div>											
</div>								
<div class="condition_130 condition_s">												
	<div class="select_130 select_div">						
		<div class="select_105 sele_c select_in">							
			<input id="end" type="text" name="edate" value="<?php Zhimin::request('edate');?>
" />						
</div>						
<div class="select_time condition_end" onclick="laydate({elem: '#end',format: 'YYYY-MM-DD'});">
</div>					
</div>				
</div>				
<div class="button_wrap sub">												
	<!--  <input type="submit" id="button_look" value="">-->					
	<input type="button" id="button_look" value="" />				
	</div>				
	<div class="clear"></div>			
	</div>			
	</form>			
	<form id="vid_form">			
		<div class="table_height case_table_add">							
			<table class="table_detail">					
				<thead>						
					<tr>							
						<th class="t_back" width="6%">序号</th>							
						<th width="11%">操作</th>							
						<th class="t_back" width="14%">发布<?php $_SESSION['zfz_type'] . '（' . $_SESSION['zfz_type']?>编号）</th>							
						<th width="19%">单位</th>							
						<th class="t_back" width="12%">记录仪编号</th>							
						<th width="24%">摄录时间（摄录时长）</th>														
						</tr>					
						</thead>					
						<tbody id="vi_form">					
							<!-- 这里有两个效果，一个隔行换色td_back和紧急状态的颜色标注td_red -->					
							</tbody>				
							</table>			
							</div>			
							<div id="pagecount"></div> 			
							<div class="button_case" style="margin:auto !important;">				
								<span class="sure_add" id="form_video_submit">确 定</span>				
								<span class="sure_cancle close_btn">取 消</span>

							</div>			
	</form>		
							</div>	
	</div>	
	<div class="iframe_foot"></div>	
	</div>	
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){

	var n="<?php Zhimin::request('date_time')?>";
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
				$("#easyui_search").combotree('setValues', ["<?php echo Zhimin::request('danwei');?>"]);      
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
		$('.easy_se').combobox('setValue',["<?php echo Zhimin::request('date_time');?>"]);
	}
});
})
</script>

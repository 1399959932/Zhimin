<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '    <title>单位编辑页</title>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/unitEdit.js"></script>' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '    <!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '' . "\r\n" . '<body>' . "\r\n" . '<!-- 修改弹框 -->' . "\r\n" . '<div class="layer_iframe1">' . "\r\n" . '    <div class="iframe_top1">修改<span class="close1 close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '    <div class="iframe_body1">' . "\r\n" . '        <form action="';
echo Zhimin::buildUrl();
echo '&action=edit" method="post" name="unit_edit_form" id="unit_edit_form">' . "\r\n" . '            <div class="con_atten_wrap recorder_notice">' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">单位编号：</span>' . "\r\n" . '                        <div class="select_260 select_div select_relative select_in selec_text">' . "\r\n" . '                            ';
echo @($data['bh']);
echo '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">上级单位：</span>' . "\r\n" . '                        <div class="select_260 select_div select_relative select_in selec_text">' . "\r\n" . '                            ';

if ($data['parentid'] == 0) {
	echo '作为顶级单位';
}
else {
	echo $p_unit['dname'];
}

echo '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">单位名称：</span>' . "\r\n" . '                        <font class="sign_d sign_star">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_relative select_in">' . "\r\n" . '                            <input type="text" name="zuming" class="input_error1" value="';
echo @($data['dname']);
echo '" />' . "\r\n" . '                            <span class="error_msg">请填写单位名称</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top sys_con">' . "\r\n" . '                    <div class="condition_345 condition_s condition_c">' . "\r\n" . '                        <span class="condition_title">排序：</span>' . "\r\n" . '                        <font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '                        <div class="select_257 select_div select_in select_config">' . "\r\n" . '                            <input type="text" name="orderby" value="';
echo $data['orderby'] == '' ? 1 : $data['orderby'];
echo '">' . "\r\n" . '                            <div class="sign">' . "\r\n" . '                                <span class="plus"></span>' . "\r\n" . '                                <span class="minus"></span>' . "\r\n" . '                            </div>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_346 condition_textarea condition_height">' . "\r\n" . '                        <span class="condition_title">备注：</span>' . "\r\n" . '                        <font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_days textarea_in">' . "\r\n" . '                            <textarea name="beizhu">';
echo $data['note'];
echo '</textarea>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s ">' . "\r\n" . '                        <font class="sign_d sign_star" style="color:#fff;">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in selec_text">' . "\r\n" . '                        	<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '                        	<input type="hidden" name="id" value="';
echo $data['id'];
echo '" />' . "\r\n" . '                            <span class="sure_add" id="edit_submit">确 定</span>' . "\r\n" . '                            <span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '        </form>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="iframe_foot1"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 成功提示框 -->' . "\r\n" . '<div class="layer_notice lay_success">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/success_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="success_flg">编辑成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 失败提示框 -->' . "\r\n" . '<div class="layer_notice lay_wrong">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/notice_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="fail_flg">编辑失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

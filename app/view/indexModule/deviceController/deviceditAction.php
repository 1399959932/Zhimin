<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '    <title>记录仪编辑</title>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/laydate/laydate.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/layer/layer.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/global.js"></script>' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/deviceEdit.js"></script>' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '    <link rel="stylesheet" type="text/css" href="';
echo Zhimin::g('assets_uri');
echo 'style/global.css" />' . "\r\n" . '    <style type="text/css">' . "\r\n" . '        .table_detail tbody td{*border-right:none;}' . "\r\n" . '    </style>' . "\r\n" . '    <!--[if IE 7]>' . "\r\n" . '<style>' . "\r\n" . '.notice_top .close{position: absolute;top:18px;right:18px;float: right;margin-right:0; margin-top:0;display: inline-block;}' . "\r\n" . '.atten_top .close{line-height: normal;}' . "\r\n" . '</style>' . "\r\n" . '<![endif]-->' . "\r\n" . '<body>' . "\r\n" . '<div class="layer_iframe1">' . "\r\n" . '    <div class="iframe_top1">编辑<span class="close1 close_btn"><img src="./images/close.png" alt="" /></span></div>' . "\r\n" . '    <div class="iframe_body1">' . "\r\n" . '        <form name="device_edit_form" id="device_edit_form">' . "\r\n" . '            <div class="con_atten_wrap recorder_notice">' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title num_record">记录仪编号&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in selec_text">' . "\r\n" . '                            <p>';
echo $data['hostbody'];
echo '</p>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">' . $_SESSION['zfz_type'] . '编号&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in">' . "\r\n" . '                            <input type="text" name="hostcode" value="';
echo $data['hostcode'];
echo '"  class="input_error input_error1 num_po"/>' . "\r\n" . '                            <span class="error_msg">请选填写' . $_SESSION['zfz_type'] . '编号</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title">配发' . $_SESSION['zfz_type'] . '&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in">' . "\r\n" . '                            <input type="text" name="hostname" value="';
echo $data['hostname'];
echo '"  class="input_error input_error1 name_po"/>' . "\r\n" . '                            <span class="error_msg">请选填写' . $_SESSION['zfz_type'] . '姓名</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title ">单位&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star">*</font>' . "\r\n" . '                        <div class="select_260 select_div">' . "\r\n" . '                            <div class="select_238 sele_c">' . "\r\n" . '                                <p class="term">-请选择-</p>' . "\r\n" . '                                <input type="hidden" name="danwei" value="" />' . "\r\n" . '                                ';
echo '<!--' . "\r\n" . '                                <p class="term">';
echo '</p>' . "\r\n" . '								<input type="hidden" name="danwei" value="';
echo '" />' . "\r\n" . '                                -->';
echo '                                <ul class="ul_band">' . "\r\n" . '									';
$optionsStr = '';
HTMLUtils::options_stair_unitsearch($optionsStr, $units_array, 'bh', 'name', 'child');
echo $optionsStr;
echo '                                </ul>' . "\r\n" . '                            </div>' . "\r\n" . '                            <div class="select_button"></div>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title product">产品名称&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in">' . "\r\n" . '                            <input type="text" name="product_name" value="';
echo $data['product_name'];
echo '" />' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title manufu">厂商&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in">' . "\r\n" . '                            <input type="text" name="product_firm" value="';
echo $data['product_firm'];
echo '" />' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s">' . "\r\n" . '                        <span class="condition_title container">容量(MB)&nbsp;:</span>' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_in">' . "\r\n" . '                            <input type="text" name="capacity" value="';
echo $data['capacity'];
echo '" />' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '                <div class="condition_top">' . "\r\n" . '                    <div class="condition_345 condition_s ">' . "\r\n" . '                        <font class="sign_d sign_star1">*</font>' . "\r\n" . '                        <div class="select_260 select_div select_  select_in selec_text">' . "\r\n" . '                        	<input type="hidden" name="id" value="';
echo $data['id'];
echo '" />' . "\r\n" . '                        	<input type="hidden" name="saveflag" value="1" />' . "\r\n" . '                            <span class="sure_add" id="edit_submit">确 定</span>' . "\r\n" . '                            <span class="sure_cancle close_btn">取 消</span>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                    <div class="clear"></div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n" . '        </form>' . "\r\n" . '</div>' . "\r\n" . '<div class="iframe_foot1"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 成功提示框 -->' . "\r\n" . '<div class="layer_notice lay_success">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/success_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="success_flg">编辑成功......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '<!-- 失败提示框 -->' . "\r\n" . '<div class="layer_notice lay_wrong">' . "\r\n" . '    <div class="notice_top"><span class="close close_btn">X</span></div>' . "\r\n" . '    <div class="notice_body">' . "\r\n" . '        <div class="n_left">' . "\r\n" . '            <img src="./images/notice_bg.png">' . "\r\n" . '        </div>' . "\r\n" . '        <div class="n_right">' . "\r\n" . '            <p id="fail_flg">编辑失败......<font>3</font>秒钟后返回页面！</p>' . "\r\n" . '            <div class="clear"></div>' . "\r\n" . '            <span class="cancle_span close_btn_self">确 定</span>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '    <div class="notice_foot"></div>' . "\r\n" . '</div>' . "\r\n" . '</body>' . "\r\n" . '</html>';

?>

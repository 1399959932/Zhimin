<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\r\n" . '<head>' . "\r\n" . '    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">' . "\r\n" . '    <title>';
echo Zhimin::a()->title;
echo '--系统信息</title>' . "\r\n" . '    <link rel="stylesheet" href="';
echo Zhimin::g('assets_uri');
echo 'style/reset.css" />' . "\r\n" . '    <script type="text/javascript" src="';
echo Zhimin::g('assets_uri');
echo 'js/jquery.min.js"></script>' . "\r\n" . '    <style type="text/css">' . "\r\n" . '        body{ background:#f2f5fc; font-size:14px;}' . "\r\n" . '        a{ color:#000000;}' . "\r\n" . '        .head{ padding: 14px 0 14px 10px; background:#ffffff; margin-bottom:15px;}' . "\r\n" . '        .content{ padding:20px 0 20px 40px; background:#ffffff; overflow:hidden;}' . "\r\n" . '        .content ul li{ height: 26px; line-height: 26px;}' . "\r\n" . '        .left,.right{ float:left;}' . "\r\n" . '        .left{ width:30px; }' . "\r\n" . '        .li3 a:hover{ color: #5fa6e6;}' . "\r\n" . '        .color1{ color:#5fa6e6;}' . "\r\n" . '' . "\r\n" . '    </style>' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '<div class="container">' . "\r\n" . '    <div class="head">' . "\r\n" . '        <b>';
echo Zhimin::a()->title;
echo '</b>--系统信息' . "\r\n" . '    </div>' . "\r\n" . '    <div class="content">' . "\r\n" . '        <div class="left"><img src="';
echo Zhimin::g('assets_uri');
echo 'images/icon_warning.png" /> </div>' . "\r\n" . '        <div class="right">' . "\r\n" . '            <ul>' . "\r\n" . '                <li class="color1">';
echo $message;
echo '</li>' . "\r\n" . '                <li>如果您不做选择，将在 <span class="color1" id="num">3</span> 秒后跳转到第一个链接地址。</li>' . "\r\n" . '                <li class="li3"><a href="#"><img  src="';
echo Zhimin::g('assets_uri');
echo 'images/icon_back.png" />&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a> </li>' . "\r\n" . '            </ul>' . "\r\n" . '        </div>' . "\r\n" . '    </div>' . "\r\n" . '</div>' . "\r\n" . '</body>' . "\r\n" . '<script>' . "\r\n" . '    $(function(){' . "\r\n" . '        $(".li3 a").hover(' . "\r\n" . '            function(){' . "\r\n" . '                $(".li3 a img").attr("src","';
echo Zhimin::g('assets_uri');
echo 'images/icon_back1.png");' . "\r\n" . '            },' . "\r\n" . '            function(){' . "\r\n" . '                $(".li3 a img").attr("src","';
echo Zhimin::g('assets_uri');
echo 'images/icon_back.png");' . "\r\n" . '            }' . "\r\n" . '        );' . "\r\n" . '' . "\r\n" . '        $(".li3 a").click(function(){' . "\r\n" . '            location.href="';
echo $url;
echo '";' . "\r\n" . '        });' . "\r\n" . '' . "\r\n" . '        //倒计时3秒' . "\r\n" . '        function jump(count) {' . "\r\n" . '            window.setTimeout(function(){' . "\r\n" . '                count--;' . "\r\n" . '                if(count > 0) {' . "\r\n" . '                    $("#num").text(count);' . "\r\n" . '                    jump(count);' . "\r\n" . '                } else {' . "\r\n" . '                    location.href="';
echo $url;
echo '";' . "\r\n" . '                }' . "\r\n" . '            }, 1000);' . "\r\n" . '        }' . "\r\n" . '        jump(3);' . "\r\n" . '    });' . "\r\n" . '</script>' . "\r\n" . '</html>';

?>

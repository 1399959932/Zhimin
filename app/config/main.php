<?php
return array(
    #系统名称
    'app_name'=>'执法记录仪视音频管理系统',
    #路由模式，未启用
    'route_mode'=>'path',
    #默认访问路径
    'default_route'=>array('m'=>'index','c'=>'index','a'=>'index'),
    #全局配置-》模块配置-》控制配置=》动作配置（后面的覆盖前面的）
    'global'=>array(
    	'web_root' => "http://".$_SERVER["HTTP_HOST"]."/",
    	'document_root' => $_SERVER["DOCUMENT_ROOT"]."/",
        'assets_uri'=>'/',
		'upload_path'=>$_SERVER['DOCUMENT_ROOT'].'/upload/',
    	'media_type'=>array(
    		'video'=>array('avi','mpg','flv','wmv','mp4','mov','asf','ts'),
    		'audio'=>array('wav','mp3','wma','aac'),
    		'photo'=>array('jpg','jpeg','bmp','png','gif')
    	),
		'zhimintype'=>3,
    	'rowcustertype'=>0,   //0 - 默认 1-交警 2-警察 3-城管 4-交通 5-消防 6-海事 7-环保 8-农业 9-法院 10-税务 11-海关 12-工商 13-检察院
    	'db_timedf'=>8,
    	'version'=>'2.1.0',
    	'hot_time' => '2',
    	'hot_count' => '10',      //热点视频2小时点击10次即可
    	'server_type' => 'linux',
    	'maccheckid' => 'MDAtNUEtMzktRTItOTAtM0I='
    ),
    #异常报告配置
    'report'=>array(
        'params'=>array(
            'host'=>'0.0.0.0', //地址
            'port'=>7777, //端口
            'status'=>'off', //不使用
            'receiver'=>'zhimin' //默认接收者
        )
    ),
    #日志记录配置
    'log'=>array(
        'params'=>array(
            'dir'=>'log' //目录
        ),
    ),
    'db'=>array(
        'params'=>array(
            'mysql:host=localhost;dbname=zmdb',
            'root',
            '',
            array(),
        ),
        'charset'=>'utf8',
        'host'		=> 'localhost',
        'dbname'	=> 'zmdbm',
        'login'		=> 'root',
        'password'	=> '',
        'persistent'	=> 'false',
    ),
    'components'=>array(
        'language'=>array(
            'class'=>'LanguageComponent',
            'params'=>array('type'=>'cn')
        ),
    	'auth'=>array(
    		'class'=>'AuthComponent',
    		'params'=>array()
        ),
        'setting'=>array(
        	'class'=>'SettingComponent',
        	'params'=>array()
        ),
        'captcha'=>array(
        	'class'=>'CaptchaComponent',
        	'params'=>array()
        ),
        'page'=>array(
        	'class'=>'PageComponent',
        	'params'=>array()
        )
    ),
    'hooks'=>array(
        #'钩子名称'=>array(
        #    array('回调类_不含Hook结尾','回调方法'),
        #),
    )
);

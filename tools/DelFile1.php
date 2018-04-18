<?php
//设置上传目录
$conf = @include ('../app/config/main.php');
$document_root = $conf['global']['document_root'];

$path = $document_root . "upload/temp/";  //文件上传临时存储目录
$filename = $_GET['filename'];
$filename = str_replace('﻿', '', trim($filename)); //替换特殊字符

$file_path = $path . iconv("UTF-8","GB2312",$filename);
//$file_path = str_replace("/","\\",$file_path);

@unlink($file_path);

/*
if(!empty($filename)){
	if(file_exists($file_path)){
		echo "file_exists".$file_path;
	}else{
		echo "file not exists".$file_path;
	}
}
*/
//die("del ok:  $file_path");
?>
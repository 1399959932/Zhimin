<?php
header("Content-Type: text/html; charset=utf-8");
$conf = @include ('../app/config/main.php');
$document_root = $conf['global']['document_root'];
date_default_timezone_set('PRC');

$path = $document_root . "upload/temp/";  //文件上传临时存储目录

if (!empty($_FILES)) {
	//得到上传的临时文件流
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//die('cccdd.jpg,yuanshi1.jpg');
	
	//允许的文件后缀
	$fileTypes = array('jpg','jpeg','mp4','wav'); 
	
	//文件原名
	$fileName = iconv("UTF-8","GB2312",$_FILES["Filedata"]["name"]);
	//$fileParts = pathinfo($_FILES['Filedata']['name']);

	//上传的文件格式 
	$type = strstr($fileName, '.'); 

	//新文件名
	//$new_filename = date('YmdHis') . $type;
	
	//保存到服务器
	if(!is_dir($path)){
		//mkdir($path);
		mkdir($path, 0777, true);
	}

	//echo $new_filename;

	//保留原文件名
	if (move_uploaded_file($tempFile, $path.$fileName)){
		echo iconv("GB2312","UTF-8",$fileName);
	}else{
		echo "failure";
	}
	/*
	*/
}
?>
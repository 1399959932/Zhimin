<?php

class UploadfileAction extends Action
{
	protected $units = array();
	protected $url_base = '';
	protected $module_sn = 10011;

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function getTime($file){
		//总长度
		$vtime = shell_exec("sudo /usr/local/bin/ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//"); 
		//创建时间 
		$ctime = date("Y-m-d H:i:s",filectime($file));
		$duration = explode(":",$vtime); 
		//转化为秒
		$duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]); 
		return array('vtime'=>$duration_in_seconds,'ctime'=>$ctime); 
	} 

	protected function _main()
	{
		$action = Zhimin::request('action');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$sysconf_m = new SysconfModel();

		//将文件类型1的值存入数组
		$restypes = $sysconf_m->get_by_type('1');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['file_types'] = $arr_types;
		//

		//modify
		//将号码类型5的值存入数组
		$restypes = $sysconf_m->get_by_type('5');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['code_types'] = $arr_types;
		//

		//将警情来源6的值存入数组
		$restypes = $sysconf_m->get_by_type('6');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['jqly_types'] = $arr_types;
		//

		//将采集设备来源7的值存入数组
		$restypes = $sysconf_m->get_by_type('7');
		$arr_types = array();
		foreach ($restypes as $typeval ) {
			$arr_types[$typeval['confcode']] = $typeval['confname'];
		}
		$this->_data['cjsbly_types'] = $arr_types;
		//

		if (!empty($_SESSION["ses_delfile"])) {
			$array_delfile = $_SESSION["ses_delfile"];
			for($j=0; $j < count($array_delfile); $j++)
			{
				@unlink($array_delfile[$j]);
				@unlink(iconv("GB2312","UTF-8",$array_delfile[$j]));
				//echo iconv("GB2312","UTF-8",$array_delfile[$j]);
				//echo "<br>";
			}
		}
		unset($_SESSION['ses_delfile']);

		if($action == 'upload') {
			$this->upload();
		}
	}

	protected function upload()
	{
		$auth = Zhimin::getComponent('auth');

		$createdate = Zhimin::param('createdate', 'post');
		$pnumber = Zhimin::param('pnumber', 'post');
		$hostname = $_SESSION["realname"];
		$hostcode = $_SESSION["hostcode"];
		$hostbody = Zhimin::param('hostbody', 'post');
		$unitcode = $_SESSION["unitcode"];
		//$unitcode = $_SESSION["unitcode"];
		$jqly = Zhimin::param('jqly', 'post');
		$cjsbly = Zhimin::param('cjsbly', 'post');
		$sort = Zhimin::param('sort', 'post');  //系统配置项中的文件类型
		$note = Zhimin::param('media_note', 'post');
		$major = Zhimin::param('main_video', 'post');
		$filelist = Zhimin::param('hfFilelist', 'post');
		$filelist_array = explode('|', $filelist);
		//die($filelist . "<hr>".$hostname . "<hr>".$hostcode . "<hr>".$unitcode);
		/*
		if (empty($createdate) || empty($pnumber) || empty($hostcode) || empty($jqly) || empty($cjsbly) || empty($filetype) || empty($major)) {
			echo 1;
			return;
		}
		*/
		
		$document_root = Zhimin::g('document_root');
		$path_tmp = $document_root . "upload/temp/";  //文件上传临时存储目录

		$media_m = new MediaModel();

		//获取平台运行服务器的名称
		$serverurl = "";
		$sql = "SELECT servername FROM zm_serverinfo limit 1";
		$q1 = $media_m->fetchOne('', $sql);
		if (!empty($q1)) {
			$serverurl = trim($q1['servername']);
		}

		$creater = gethostbyaddr($_SERVER['REMOTE_ADDR']); //获取客户端计算机名称 //'SERVER';
		$dt = date('Ymd');
		$array_delfile = array();
		$i = 0;
		foreach ($filelist_array as $fa){
			//echo $path_tmp . $fa."<br />";
			if(!empty($fa)){
				//echo $path_tmp . $fa."<br />";
				//echo $path . $fa."<br />";
				//$fa = strtoupper($fa);
				$fa = str_replace('﻿', '', trim($fa)); //替换特殊字符
				$fa_type = strstr($fa, '.');//获取文件名后缀（带.）
				//$fa_name = str_replace($fa_type, '', $fa);//文件名.前面部分
				$fa_name_new = date('YmdHis');
				$rd = rand(pow(10,(2-1)), pow(10,2)-1);  //为避免文件重名，需用到随机数
				$filename = $hostbody . '@'. $fa_name_new . '00' . $rd;  //上传到正式目录的文件新名称
				$bfilename = $hostname . '@'. $fa_name_new . '00' . $rd;

				$filepath_tmp = $path_tmp . $fa;  //保存在临时存储目录下的文件
				$filepath_tmp = str_replace('﻿', '', trim($filepath_tmp)); //替换特殊字符
				$filepath_tmp = iconv("UTF-8","GB2312",$filepath_tmp);
				$array_delfile[$i] = $filepath_tmp;
				$i++;

				$filelen = filesize($filepath_tmp)/(1024*1024);  //获取文件大小（M）
				$filetype = strtoupper(str_replace('.', '', $fa_type));  //从文件名后缀获取文件类型，改成大写形式

				$saveposition = $dt . '/' . $filetype . '/' . $filename . '.' . $filetype;  //字段，存储位置
				if($filetype == "JPG" || $filetype == "WAV"){
					$saveposition = 'media/' . $saveposition;
				}
				$playposition = 'media/' . $dt . '/' . $filetype . '/' . $filename . '.' . $filetype;  //字段，播放位置
				$uploaddate = date('Y-m-d H:i:s');

				$playtime = 0;  //播放时长

				//缩略图
				if($filetype == "WAV"){
					$thumb = 'images/audio.gif';
				}
				if($filetype == "JPG"){
					$thumb = 'media/' . $dt . '/' . $filetype . '/' . $filename . '.THM.' . $filetype;
					$this->simple_thumb($filepath_tmp, 320, 240 , $document_root . $thumb);
				}
				if($filetype == "MP4"){  //通过ffmpeg获取视频（MP4）的播放时长和缩略图
					$ptime = $this->getTime($filepath_tmp);
					$playtime = $ptime['vtime'];
				}
				//$thumb = 'media/20170504/MP4/00024@201705041039000000.THM.JPG';


				$path_obj = $document_root . "media/" . $dt . '/' . $filetype . "/";  //文件正式存储目录
				$filepath_obj = $path_obj . $filename . '.' . $filetype;
				//将文件从on个临时目录转移到正式目录并改名
				//echo "path_obj:" . $path_obj."<br />";
				if(!is_dir($path_obj)){
					//echo "create path_obj<br />";
					mkdir($path_obj, 0777, true);
				}
				//$filepath_tmp = 'E:/wamp/www/zhifayi/upload/temp/486397956612894012.jpg';
				/*
				if(file_exists($filepath_tmp)){
					echo "<br />file_exists:".$filepath_tmp."<br />";
				}else{
					echo "file not exists:".$filepath_tmp."<br />";
				}*/

				//将文件从临时目录转移到正式目录
				@copy($filepath_tmp, $filepath_obj);

				//删除临时目录里的文件
				//echo "del：".iconv("GB2312","UTF-8",$filepath_tmp)."<hr>";
				@unlink($filepath_tmp);

				//echo $saveposition."&nbsp;&nbsp;&nbsp;&nbsp;playposition：". $playposition."<br />";
				//echo $filepath_tmp."&nbsp;&nbsp;&nbsp;&nbsp;filepath_obj：". $filepath_obj."<br />";
				$sql = "INSERT INTO zm_video_list(filename, bfilename, createdate, filelen, filetype, hostname, hostcode, hostbody, danwei, note, serverurl, thumb, saveposition, playposition, sort, uploaddate, creater, major, playtime, pnumber, jqly, cjsbly) VALUES ('".$filename."', '".$bfilename."', '".$createdate."', '".$filelen."', '".$filetype."', '".$hostname."', '".$hostcode."', '".$hostbody."', '".$unitcode."', '".$note."', '".$serverurl."', '".$thumb."', '".$saveposition."', '".$playposition."', '".$sort."', '".$uploaddate."', '".$creater."', '".$major."', ".$playtime.", '".$pnumber."', '".$jqly."', '".$cjsbly."')";
				//echo($sql . '<hr />');
				// echo '<pre>';print_r($sql);exit;

				$res = $media_m->dquery($sql);
			}
		}
		if ($i > 0) {
			$_SESSION["ses_delfile"] = $array_delfile;
		}
		//die();
		/*
		$filename = '00001@20140116003522'.rand(pow(10,(4-1)), pow(10,4)-1);
		$bfilename = '刘云田@201401160035220000';
		$filelen = 1024;
		$filetype = 'MP4';
		$saveposition = '20170504/MP4/00001@201401160035020000.MP4';
		$playposition = 'media/20170504/MP4/00001@201401160035020000.MP4';
		$uploaddate = date('Y-m-d H:i:s');
		$playtime = 60;

		$thumb = 'media/20170504/JPG/00001@201401160035400000.THM.JPG';
		$sql = "INSERT INTO zm_video_list(filename, bfilename, createdate, filelen, filetype, hostname, hostcode, hostbody, danwei, note, thumb, saveposition, playposition, uploaddate, creater, major, playtime, pnumber) VALUES ('".$filename."', '".$bfilename."', '".$createdate."', '".$filelen."', '".$filetype."', '".$hostname."', '".$hostcode."', '".$hostbody."', '".$unitcode."', '".$note."', '".$thumb."', '".$savepositione."', '".$playpositione."', '".$uploaddate."', '".$creater."', '".$major."', ".$playtime.", '".$pnumber."')";
		//die($sql);

		$media_m = new MediaModel();
		$res = $media_m->dquery($sql);
		*/

		$this->_hasError = true;
		$this->_error[0] = 'error.info';
		$this->_error[1] = array('message' => '执法数据添加成功!', 'url' => Zhimin::buildUrl('uploadfile', 'media'));
		return NULL;
	}

	function deleteAll($path) {
		$op = dir($path);
		while(false != ($item = $op->read())) {
			if($item == '.' || $item == '..') {
				continue;
			}
			if(is_dir($op->path.'/'.$item)) {
				deleteAll($op->path.'/'.$item);
				rmdir($op->path.'/'.$item);
			} else {
				unlink($op->path.'/'.$item);
			}
		
		}   
	}
	
	function simple_thumb($src, $width = null, $height = null, $filename = null) {
		if (!isset($width) && !isset($height))
			return false;
		if (isset($width) && $width <= 0)
			return false;
		if (isset($height) && $height <= 0)
			return false;
	 
		$size = getimagesize($src);
		if (!$size)
			return false;
	 
		list($src_w, $src_h, $src_type) = $size;
		$src_mime = $size['mime'];
		switch($src_type) {
			case 1 :
				$img_type = 'gif';
				break;
			case 2 :
				$img_type = 'jpeg';
				break;
			case 3 :
				$img_type = 'png';
				break;
			case 15 :
				$img_type = 'wbmp';
				break;
			default :
				return false;
		}
	 
		if (!isset($width))
			$width = $src_w * ($height / $src_h);
		if (!isset($height))
			$height = $src_h * ($width / $src_w);
	 
		$imagecreatefunc = 'imagecreatefrom' . $img_type;
		$src_img = $imagecreatefunc($src);
		$dest_img = imagecreatetruecolor($width, $height);
		imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
	 
		$imagefunc = 'image' . $img_type;
		if ($filename) {
			$imagefunc($dest_img, $filename);
		} else {
			header('Content-Type: ' . $src_mime);
			$imagefunc($dest_img);
		}
	 
		imagedestroy($src_img);
		imagedestroy($dest_img);
		return true;
	}
}


?>

<?php
    //调用WebService接口
	  require_once ('../common/generalfunc.php');
	  header('Content-Type: text/html; charset=UTF-8');
	  $wsdl = "http://10.129.131.15:8070/RdmService.asmx?";    //WebService路径
	 // $wsdl = "http://61.132.233.66:8070/RdmService.asmx?";  
	 $client = new SoapClient('http://10.129.131.15:8070/RdmService.asmx?wsdl',array("trace" => 1, "exception" => 0));
	// 文件表
	  $sql = 'SELECT pvl.bfilename as wjbm,pvl.hostcode as jybh,pvl.filename as wjbh,
		filelen as wjcd,pvl.hostbody as cpxh,ph.hostip as ccfwq,pvl.saveposition as ccwz,
		pvl.playposition as bfwz,pvl.macposition as wlwz,pvl.uploaddate as scsj,pvl.is_flg as bzlx,
		pvl.filetype as wjlx,pvl.createdate as pssj,ph.hostname as gzz_xh,ph.hostip as cjzip,pvl.major as imp,pvl.thumb as slt,cjz.authKey as authKey,pvl.id as id,pvl.suc as suc from `zm_video_list` as `pvl` 
		left join `zm_danwei` as `pd` on `pvl`.`danwei`=`pd`.`bh` left join `zm_hostip` as `ph` on `pvl`.`creater`=`ph`.`hostname` left join `zm_cjzsb` as `cjz` on `ph`.`hostip`=`cjz`.`hostip`';

	  $rs = RunQuery($sql);
	  $data = array();
	    while($row = mysql_fetch_assoc($rs)){     //mysql_fetch_array($rs,MYSQL_ASSOC)
		    $data[] = $row;
	    }
	if(empty($data)){
           echo 'Query data is empty!';
           exit;
        }	
	//echo '<pre>';
	//print_r($data);
	
	//获取数组长度
	$len = count($data);
  	//接口需要的参数  
  	for($i=0;$i<$len;$i++){
	
		//判断是否传送
		$suc = $data[$i]['suc'];
	    $imp = $data[$i]['imp'];			
	    // echo $imp;exit;
         	if($suc == '0' || $imp == '1' || $imp == '0'){
				  //文件存储路径
				$cjzip = $data[$i]['cjzip'];   //采集站ip
			    // $imp = $data[$i]['imp'];			
      			
				if($imp == '1'){
					$ccwz = 'http://10.129.131.14/'.$data[$i]['bfwz'];   //服务器
					$slt = 'http://10.129.131.14/'.$data[$i]['slt'];
				}
				if($imp == '0'){
					 //处理存储路径
					$path = $data[$i]['ccwz'];
					  switch ($data[$i]['wjlx']) {
						case 'WAV':
							$path = substr($path,6);
							break;
						case 'wav':
							$path = substr($path,6);;
							break;
						case 'JPG':
							$path = substr($path,6);
							break;
						case 'jpg':
							$path = substr($path,6);;
							break;
						default:
							$path = $data[$i]['ccwz'];
							break;
					}
				
					$ccwz ='http://'.$cjzip.'/'.$path;       //采集站
					$slt = 'http://'.$cjzip.'/'.substr($data[$i]['slt'],6);
					
				}
				
				
				
	        if($i < $len || $i == $len){
			
		    $param = array(
			    'jybh'=>$data[$i]['jybh'],
			  	'gzz_xh'=>$data[$i]['gzz_xh'],    //采集站编号 (校验)
			   'authKey'=>$data[$i]['authKey'],
		        'wjbh'=>$data[$i]['wjbh'],      //主键 (校验)
		        'wjbm'=>$data[$i]['wjbm'],
	       	    'wjdx'=>ceil($data[$i]['wjcd']),
		        'wjcd'=>ceil($data[$i]['wjcd']),
			    'cpxh'=>$data[$i]['cpxh'],
			    'ccfwq'=>$data[$i]['ccfwq'],
			    'ccwz'=>$ccwz,
		        'bfwz'=>$ccwz,
		        'slt'=>$slt,
		        'scsj'=>$data[$i]['scsj'],
		        'bzlx'=>$data[$i]['bzlx'],
		        'wjlx'=>$data[$i]['wjlx'],
		        'pssj'=>$data[$i]['pssj'],
		 ); 
			
			//判断文件类型
			    switch ($param['wjlx']) {
		    	case 'MP4':
		    		$param['wjlx'] = '视频';
		    		break;
				case 'mp4':
		    		$param['wjlx'] = '视频';
		    		break;
				case 'MOV':
		    		$param['wjlx'] = '视频';
		    		break;
		    	case 'WAV':
		    		$param['wjlx'] = '音频';
		    		break;
				case 'wav':
		    		$param['wjlx'] = '音频';
		    		break;
		    	case 'JPG':
		    		$param['wjlx'] = '图片';
		    		break;
				case 'jpg':
		    		$param['wjlx'] = '图片';
		    		break;
		    	default:
		    		$param['wjlx'] = '其他 ';
		    		break;
		    }
		   // echo '<pre>';
			//print_r($param);
			
			$ret = $client->WriteDsjInfo($param);
			$skin = get_object_vars($ret);       //$skin是接口的返回结果内容
			//var_dump($skin);
			//是否上传成功
			$skinvalue = $skin['WriteDsjInfoResult'];
			
			if($skinvalue = "上传成功"){
				$sql1 = "UPDATE `zm_video_list` set `suc`=1 where `id`='{$data[$i]['id']}'";
				$res = RunQuery($sql1);
				if(mysql_affected_rows()){
					echo 'Mark success';
				}else{
					echo 'Mark failed';
				}
			}

	    }
	}else{
		echo '数据已提交过'.'<br />';
	}
	}

	
	  

<?php

	/** 
	* add 
	* 表的新增操作
	* 
	* @access public 
	* @param mixed $tableName 进行操作的表名
	* @param mixed $data 增加的数据 
	* @author qyx 
	* @datetime 2016/1/10 
	* @return array 
	*/  
	function add($tableName,$data){
	  	$backInfo['status'] = 1;
	  	try{
	  		$result = M($tableName)->add($data);
	  		if($result == false){

	  		}else{
	  			$backInfo['info'] = '新增成功,将自动刷新列表!';
	  			$backInfo['id'] = $result;
	  		}
	  	}catch(Exception $e){
	  		$backInfo['status'] = 0;
	  		$backInfo['info'] = '新增失败,请重试!';
	  		makeErrorLog($e->getMessage());
	  	}
	  	return $backInfo;
	}

	/** 
	* update 
	* 表的更新
	* 
	* @access public 
	* @param mixed $tableName 进行操作的表名
	* @param mixed $data 修改的数据 
	* @param mixed $id 	  更新的条件
	* @author qyx 
	* @datetime 2016/1/10 
	* @return array 
	*/  
    function update($tableName,$data,$id){
  		$backInfo['status'] = 1;
  		try{
  			$result = M($tableName)->where($id)->save($data);
  			if($result !== false){
  				$backInfo['info'] = '更新成功,将自动刷新列表!';
  			}else{
  				$backInfo['status'] = 0;
  				$backInfo['info'] = '更新失败,请重试!';
  			}
  		}catch(Exception $e){
  			$backInfo['status'] = 0;
  			$backInfo['info'] = '更新失败,请重试!';
  			makeErrorLog($e->getMessage());
  		}
  		return $backInfo;
  	}

  	/** 
	* del 
	* 表的删除
	* 
	* @access public 
	* @param mixed $tableName 进行操作的表名
	* @param mixed $data 删除的条件 
	* @author qyx 
	* @datetime 2016/1/10 
	* @return array 
	*/  
  	function del($tableName,$data){
  		$backInfo['status'] = 1;
  		try{
  			$result = M($tableName)->where($data)->delete();
  			//echo M($tableName)->getLastSql();
  			if($result == false){
  				$backInfo['status'] = 0;
  				$backInfo['info'] = '删除出错,请重试!';
  			}else{
  				 $backInfo['info'] = '删除成功,将自动刷新列表!';
  			}
  		}catch(Exception $e){
  			$backInfo['status'] = 0;
  			$backInfo['info'] = '删除出错,请重试!';
  			makeErrorLog($e->getMessage());
  		}
  		return $backInfo;
  	}

  	/** 
	* getColumn 
	* 表的结构查询
	* 
	* @access public 
	* @param mixed $tableName 进行操作的表名 
	* @author qyx 
	* @datetime 2016/1/10 
	* @return array 
	*/ 
  	function getColumn($tableName){
        $list = M()->query("desc {$tableName}");
        $data = array();
        foreach ($list as $key => $value) {
            $data[$key] = $value['field'];
        }
        return $data;
    }

    /**ssss
    *获取用户ip地址
    *
    *@author qyx
    *@return str
    *@datetime 2016/2/5
    */
    function getIP(){
		$ip = '127.0.0.1';
		if (getenv("HTTP_CLIENT_IP")){
			$ip = getenv("HTTP_CLIENT_IP");
		}else if(getenv("HTTP_X_FORWARDED_FOR")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else if(getenv("REMOTE_ADDR")){
			$ip = getenv("REMOTE_ADDR");
		}else{
			$ip = "Unknow";
		}
		return $ip;
	}

	/**
    *更新对应上级仓库的数量
    *
    *@author qyx
    *@return str
    *@datetime 2016/2/5
    */
	 function updateTotal($tableName,$data,$column,$num){
	 	try{
	 		if($num > 0){
	 			M($tableName)->where($data)->setInc($column,$num);
		 	}else{
		 		$num = -1 * $num;
		 		M($tableName)->where($data)->setDec($column,$num);
		 	}
	 	}catch(Exception $e){
	 		makeErrorLog($e->getMessage());
	 	}
	 }

	 /**
    *数据库错误日记生成
    *
    *@author qyx
    *@return null
    *@datetime 2016/3/8
    */
	 function makeErrorLog($message = ''){
	 	$date = date('Y-m-d');
	 	$rootPath = './Error_Log/';
	 	if(!is_dir($rootPath)){
	 		mkdir($rootPath);
	 	}
	 	$filename = $rootPath.$date.'.error_log';
	 	$fp = fopen($filename, 'a');
	 	$errorMessage = 'date:'.date('Y-m-d H:i:s').';content:'.$message.';author:'.$_SESSION['name']."\n";
	 	fwrite($fp, $errorMessage);
	 	fclose($fp);
	 }



	/**
	*@param 数据 转换编码的数据
	*
	*/ 
	function setCharset($data){
	 	return iconv('utf-8','gb2312', $data);
	}

	/**
	*@param data 导出的数据
	*@param fileNme  导出文件的文件名
	*/ 
	function  exportCsv($filename,$data){
	 	
	 	header("Content-type:text/csv");  
	    header("Content-Disposition:attachment;filename=".$filename);  
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
	    header('Expires:0');  
	    header('Pragma:public');  
	    echo $data;  
    	
    }
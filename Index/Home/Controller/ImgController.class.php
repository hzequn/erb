<?php
namespace Home\Controller;
use Think\Controller;
class ImgController extends Controller {
  	public function index(){
	    $this->id = $_GET['id'];
	    $this->assign('id',$this->id);
	    $this->show();
  	}
	public function upload(){
		//var_dump($_FILES);
	    $tableName = $_POST['type'];
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =      './Public/Upload/'.$tableName.'/'; // 设置附件上传根目录
	    // 上传单个文件 
	    $info   =   $upload->uploadOne($_FILES[$tableName]);
	    
	    if(!$info) {// 上传错误提示错误信息
	    	echo $_FILES[$tableName];
	        var_dump($_FILES);
	    }else{// 上传成功 获取上传文件信息
	    	$data['root_path'] = '/ERP/Public/Upload/'.$tableName.'/';
	    	$data['save_path'] = $info['savepath'];
	    	$data['name'] = $info['savename'];
	    	$data['type'] = $info['ext'];
	    	$data['size'] = $info['size'];
	    	$data['uploader'] = $_SESSION['name'];
	    	$data['upload_date'] = date('Y-m-d H:i:s');
	    	$back = add('img',$data);
	    	$img['img_id'] = $back['id'];
	    	$img['detail_id'] = $_POST['detail_id'];
	    	$img['table'] = $tableName;
	    	add('detail_img',$img);
	    	$this->ajaxReturn($back);
	    }
	}
	public function search(){
		$id = $_POST['id'];
		$table = $_POST['table'];
		$backInfo = array();
		try{
			$result = M('detail_img')->where(array('detail_id'=>$id,'table'=>$table))->order('id desc ')->limit('0,1')->find();
			if(isset($result['id'])){
				$imgList = M('img')->where(array('id'=>$result['img_id']))->select();
				$img = $imgList[0];
				//echo M('img')->getLastSql();
				$path = $img['root_path'].$img['save_path'].$img['name'];
				$backInfo['status'] = 1;
				$backInfo['info'] = $path; 
			}else{
				$backInfo['status'] = 0;
			}
		}catch(Exception $e){
			$backInfo['status'] = 0;

		}
		$this->ajaxReturn($backInfo);
	}

}
<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 无需验证权限的方法
 *@author qyx
 *@datetime 2016/3/9 
 */
class PublicController extends Controller {

    //获取所有角色 user 控制器中 
    public function getAllRole(){
        $data = M('auth_group')->select();
        $this->ajaxReturn($data);
    }

    //获取所属节点
    public function getNode(){
    	$level['level'] = intval($_POST['level']) - 1;
    	//echo $level['level'];
    	$data = M('auth_rule')->where($level)->select();
    	//var_dump($data);
    	$this->ajaxReturn($data);
    }

}

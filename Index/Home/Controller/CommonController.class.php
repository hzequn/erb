<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
        if(!isset($_SESSION['uid'])){
            $this->redirect('Login/index','',0,'');
        }
        $AUTH = new \Think\Auth();
        $condition = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;

        $uid = $_SESSION['uid'];
        if(!$AUTH->check($condition, $uid)){
           $this->error('没有该权限,请联系管理员!',U('Index/access'),1);
        }
	}
}
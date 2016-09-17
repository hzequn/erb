<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 用户登录控制器
 * 功能特性：
 *1.登录账号,密码,验证码 数据验证 和用户的状态验证(是否冻结)
 *2.注销，更新用户登录时间,ip
 *
 *@author qyx
 *@datetime 2016/2/7 完善
 */
class LoginController extends Controller {
    public function index(){
        $this->show();
    }

    public function checkData(){
        $back = array();
        $data = $_POST['data'];
        $verify = $data['verify'];
        $user = array(
            'account'=>$data['account'],
            'pwd'=>md5($data['pwd']),
        );
        if(!$this->checkVerify($verify,'')){
            $back['status'] =  0;
            $back['msg'] = '验证码出错,请重新输入!';
        }else{
            $result = M('user')->where($user)->find();
            if(!$result){
                $back['status'] =  1;
                $back['msg'] = '登录失败,账号或密码出错';
            }else if(!$result['status']){
                $back['status'] = 2;
                $back['msg'] = '登录失败,账号已被冻结,请联系管理员!';
            }else{
                $role = M('auth_group_access')->where(array('uid'=>$result['id']))->find();
                $_SESSION['rid'] = $role['group_id'];
                $_SESSION['uid'] = $result['id'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['account'] = $result['account'];
                $back['status'] =  3;
                $back['msg'] = '登录成功';
            }
        }
        $this->ajaxReturn($back);
    }

    public function login(){
        $this->redirect('Index/index','',0,'页面跳转中....');
    }

    public function logout(){
        $data['id'] = $_SESSION['uid'];
        $data['logindate'] = date('Y-m-d H:i:s');
        $data['loginip'] = getIP();
        M('user')->save($data);
        session(null);
        $this->redirect('Login/index','',0,'页面跳转中....');
    }

    public function verify(){
        $config =    array(
	       'fontSize'    =>    30,    // 验证码字体大小
	       'length'      =>    4,     // 验证码位数
	       'useNoise'    =>    false, // 关闭验证码杂点
	       'codeSet'     =>    '0123456789',
	       'useCurve'    =>    false,
    	);
	    $Verify =  new \Think\Verify($config);
	    $Verify->entry();
    }

    function checkVerify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}

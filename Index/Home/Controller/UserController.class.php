<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 用户及其对应的角色组控制器
 * 功能特性：
 *1.用户的增删改查,用户对应的角色关系维护,例如:删除用户则要删除用户与角色组之间的对应关系
 *2.角色的增删改查，角色与角色权限的关系维护.
 *@author qyx
 *@datetime 2016/2/7 完善
 */
class UserController extends CommonController {
   
    //用户界面
    public function index(){
        $this->show();
    }

    //角色界面
    public function role(){
    	$this->show();
    }

    //读取用户数据
    public function getUserList(){
        try{
            $tableName = 'user';
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $data = array();
            $data['rows'] = M($tableName)->join("LEFT JOIN auth_group_access ru on ru.uid =$tableName.id" )->join(" LEFT JOIN auth_group r on r.id = ru.group_id")->field('user.id as id,user.name as name,user.logindate as logindate,user.loginip as loginip, user.status as status,user.account as account,user.pwd as pwd,r.id as role_id,r.title as role')->limit(($page - 1) * $rows,$rows)->select();
            $data['total'] = M($tableName)->where($data)->count();
            $this->ajaxReturn($data);
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
    }

    //新增用户
    public function adduser(){
        $backInfo = array();
        try{
            $data = $_POST['data'];
            $tableName = 'user';
            $data['pwd'] = md5('12345');
            $data['createtime'] = date('Y-m-d H:i:s');
            $data['createname'] = $_SESSION['name'];
            $backInfo = add($tableName,$data);
        }catch(Exception $e){
             $backInfo['info'] = '新增用户出错,请检查数据或联系管理员!';
             $backInfo['status'] = 0;
             makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //删除用户
    public function delUser(){
        $backInfo = array();
        try{
            $tableName = 'user';
            $data['id'] = $_POST['id'];
            $auth_group_access['uid'] = $data['id'];
            del('auth_group_access',$auth_group_access);
            $backInfo = del($tableName,$data);
        }catch(Exception $e){
             $backInfo['info'] = '删除数据出错,请联系管理员!';
             $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //用户数据更新
    public function editUser(){
        $backInfo = array();
        try{
            $id['id'] = $_GET['id'];
            $data = $_POST['data'];
            $tableName = 'user';
            $backInfo = update($tableName,$data,$id);
        }catch(Exception $e){
            $backInfo['info'] = '更新用户数据出错,请检查数据或联系管理员!';
            $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //为用户分配角色
    public function setRole(){
        $backInfo = array();
        try{
            $data = $_POST['data'];
            $tableName = 'auth_group_access';
            $result = M($tableName)->where($data['uid'])->find();
            if($result != NULL){
                $backInfo = del($tableName,array('uid'=>$data['uid']));
            }
            $backInfo = add($tableName,$data);
        }catch(Exception $e){
            $backInfo['info'] = '出错,请检查数据或联系管理员!';
            $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }


    //读取角色数据
    public function getRoleList(){
        try{
            $tableName = 'auth_group';
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $data = array();
            $data['rows'] = M($tableName)->where($data)->limit(($page - 1) * $rows,$rows)->select();
            $data['total'] = M($tableName)->where($data)->count();
            $this->ajaxReturn($data);
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
    }

    //新增角色
    public function addRole(){
        $backInfo = array();
        try{
            $tableName = 'auth_group';
            $data = $_POST['data'];
            $backInfo = add($tableName,$data);
        }catch(Exception $e){
            $backInfo['info'] = '新增角色出错,请检查数据或联系管理员!';
            $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //删除角色
    public function delRole(){
        $backInfo = array();
        try{
            $tableName = 'auth_group';
            $data['id'] = $_POST['id'];
            $backInfo = del($tableName,$data);
        }catch(Exception $e){
            $backInfo['info'] = '删除角色出错,请重试或联系管理员!';
            $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
         $this->ajaxReturn($backInfo);
    }
    
    //角色数据更新
    public function editRole(){
        $backInfo = array();
        try{
            $id['id'] = $_GET['id'];
            $data = $_POST['data'];
            $tableName = 'auth_group';
            $backInfo = update($tableName,$data,$id);
        }catch(Exception $e){
            $backInfo['info'] = '更新角色出错,请检查数据或联系管理员!';
            $backInfo['status'] = 0;
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }
}
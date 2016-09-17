<?php
namespace Home\Controller;
use Think\Controller;
/**
*基于auth的权限管理
*/
class RbacController extends CommonController {

    public function index(){
        $this->show();
    }

    //权限节点管理
    public function node(){
        $field = array('id','name','title','pid');
        $node = M('auth_rule')->field($field)->select();
        $this->node = $this->node_merge($node);
        $this->show();
    }

    //获取所有节点
    public function getData(){
        $field = array('id','name','title','pid','level');
        $node = M('auth_rule')->field($field)->select();
        $data['total'] = M('auth_rule')->field($field)->count();
        $data['rows'] = $this->node_merge($node);
        $this->ajaxReturn($data);
    }
    //新增节点
    public function add(){
        $tableName = 'auth_rule';
        $data = $_POST['data'];
        if($data['level'] != 1){
            $parent = M($tableName)->where(array('id'=>$data['pid']))->find();
            $data['name'] = $parent['name'].'/'.$data['name'];
        }else{
            $data['pid'] = 0;
        }
        $this->ajaxReturn(add($tableName,$data));
    }

    //删除节点

    public function del(){
        $tableName = $_POST['table'];
        $data['id'] = $_POST['id'];
        $this->ajaxReturn(del($tableName,$data));
    }
    
    // 编辑节点

    public function edit(){
        $tableName = 'auth_rule';
        $data = $_POST['data'];
        $id['id'] = $_GET['id'];
        $this->ajaxReturn(update($tableName,$data,$id));
    }

    public function userAccess(){
        $status = isset($_GET['status'])?$_GET['status']:0;
        $rid = $_GET['rid'];
        $field = array('id', 'name', 'title', 'pid','level');
        $node = M('auth_rule')->field($field)->select();
        $access = M('auth_group')->where(array('id'=>$rid))->field(array('rules'))->find();
        $access = explode(',',$access['rules']);
        $this->node = $this->node_merge($node,$access);
        $this->rid = $rid;
        $this->status = $status;
        $this->show();
    }
    
    //查看权限
    public function access(){
        $rid = $_GET['rid'];
        $field = array('id', 'name', 'title', 'pid','level');
        $node = M('auth_rule')->field($field)->select();
        $access = M('auth_group')->where(array('id'=>$rid))->field(array('rules'))->find();
        $access = explode(',',$access['rules']);
        $this->node = $this->node_merge($node,$access);
        $this->rid = $rid;
        $this->show();
    }
    
    //设置权限
    public function setAccess(){
       $backInfo = array();
       try{
           $data['rules'] = implode(',',$_POST['data']);
           $rid['id'] = $_POST['rid'];
           $backInfo = update('auth_group',$data,$rid);
       }catch(Exception $e){
            $backInfo['status'] = 0;
            $backInfo['info'] = '未知错误!请重试!';
       }
       $this->ajaxReturn($backInfo);
    }


    //节点按父子关系合并成一棵树
    function node_merge($node, $access = null, $pid = 0){
        $arr = array();
        foreach($node as $v){
            if(is_array($access)){
                $v['access'] = in_array($v['id'], $access) ? 1 :0;
            }
            if($v['pid'] == $pid){
                $v['children'] = $this->node_merge($node, $access, $v['id']);
                $arr[] =$v;
            }
        }
        return $arr;
    }
}
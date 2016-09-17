<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8"); 
class IndexController extends Controller {
    public function index(){
        if(!isset($_SESSION['uid'])){
            $this->redirect('Login/index','',0,'');
        }
  	 	$this->assign('data',$this->getType('stock'));
        $this->assign('user',$_SESSION['name']);
  	 	$this->assign('rid',$_SESSION['rid']);
        //echo session_id();
        //var_dump($_COOKIE);
        $this->show();
        //var_dump($_SESSION);
    }
    public function systeminfo(){
    	$this->show();
    }
    public function access(){
        $this->show();
    }
    public function getType($tableName){
        $data = M($tableName)->select();
        foreach ($data as $key => $value){
            $id = $value['id'];
            $data[$key]['children'] = M('clothes')->join("join stock_clothes b on b.clothes_id = clothes.id and b.stock_id = $id")->field('clothes.id as id,clothes.type as type')->select();
        }
        return $data;
    }

}
<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 库存及其对应的仓库控制器
 * 功能特性：
 *1仓库入库增删改查,仓库对应的上下级关系维护
 *@author qyx
 *@datetime 2016/2/18 完善
 */
class StockController extends CommonController {
    
    //一级仓库主页面
    public function index(){
        $this->show();
    }

    //二级仓库主页面
    public function clothes(){
        try{
            $data['id'] = $_GET['id'];
            $this->assign('stockId',$data['id']);
            $this->assign('data',$this->getType($data,'stock'));
            $this->show();
        }catch(Exception $e){   
            echo "404!ERROR";
            makeErrorLog($e->getMessage());
        }
    }

    //三级仓库主页面
    public function detail(){
        try{
            $data['id'] = $_GET['id'];
            $stockId = M('stock_clothes')->where(array('clothes_id'=>$data['id']))->find();
            $this->assign('clothesId',$data['id']);
            $this->assign('stockId',$stockId['stock_id']);
            $this->assign('data',$this->getType($data,'clothes'));
            $this->show();
        }catch(Exception $e){
            echo "404!ERROR";
            makeErrorLog($e->getMessage());
        }
    }

    //仓库操作记录
    public function record(){
        try{
            $this->show();
        }catch(Exception $e){
            echo "404!ERROR";
            makeErrorLog($e->getMessage());
        }

    }

    public function getRecord(){
        $data = array();
        try{
            $tableName = 'stock_record';
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $data['total'] = M($tableName)->count();
            $data['rows'] =  M($tableName)->limit(($page - 1) * $rows,$rows)->select();
        }catch(Exception $e){
           makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($data);
    }
    /**
    *获取数据
    *@access public 
    *@return array
    */
    public function getData(){
        $data = array();
        try{
            $tableName = $_GET['table'];
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $data = array();
            if($tableName == 'stock'){
                $data = $this->getList($tableName,NULL,$page,$rows);
            }else if($tableName == 'clothes'){
                $data = $this->getClothesList($tableName,$_GET['stockId'],$page,$rows);
            }else if($tableName == 'clothesdetail'){
                $data = $this->getDetailList($tableName,$_GET['clothesId'],$page,$rows);
            }
        }catch(Exception $e){
           makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($data);
    }

    /**
    *获取二级仓库数据
    *@access public 
    *@param  string $tableName 仓库表的名称
    *@param  int    $stockId   二级仓库所属的一级仓库ID
    *@param  int    $page      页码
    *@param  int    $row       行数
    *@return array
    */
    public function getClothesList($tableName,$stockId,$page,$rows){
        $data = array();
        try{
            $data['total'] = M($tableName)->join(" JOIN stock_clothes b on b.stock_id = $stockId and b.clothes_id = $tableName.id")->count();
            $data['rows'] = M($tableName)->join(" JOIN stock_clothes b on b.stock_id = $stockId and b.clothes_id = $tableName.id")->field("$tableName.id,$tableName.type,$tableName.total,$tableName.remark")->limit(($page - 1) * $rows,$rows)->select();
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
        return $data;
    } 

    /**
    *获取三级级仓库数据
    *@access public 
    *@param  string $tableName 仓库表的名称
    *@param  int    $stockId   三级级仓库所属的二级仓库ID
    *@param  int    $page      页码
    *@param  int    $row       行数
    *@return array
    */
    public function getDetailList($tableName,$clothesId,$page,$rows){
        $data = array();
        try{
            $data['total'] = M($tableName)->join(" JOIN clothes_detail b on b.clothes_id = $clothesId and b.detail_id = $tableName.id")->count();
            $data['rows'] = M($tableName)->join(" JOIN clothes_detail b on b.clothes_id = $clothesId and b.detail_id = $tableName.id")->field("$tableName.id,$tableName.name,$tableName.total,$tableName.code,$tableName.size,$tableName.price,$tableName.remark")->limit(($page - 1) * $rows,$rows)->select();
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
        return $data;
    } 


    /**
    *获取一级级仓库数据
    *@access public 
    *@param  string $tableName 仓库表的名称
    *@param  int    $page      页码
    *@param  int    $row       行数
    *@return array
    */
    public function getList($tableName,$data,$page,$rows){
        $data = array();
        try{
            $data['rows'] = M($tableName)->where($data)->limit(($page - 1) * $rows,$rows)->select();
            $data['total'] = M($tableName)->where($data)->count();
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
    	return $data;
    }

    //数据库数据删除操作
    public function del(){
        $backInfo = array();
        $record[] = array();
        try{
            $tableName = $_POST['table'];
            $data['id'] = $_POST['id'];
            $result = M($tableName)->where($data)->find();
            if($tableName == 'stock'){
                $record['record'] = '删除一级仓库:'.$result['type'];
            }else if($tableName == 'clothes'){
                $record['record'] = '删除二级仓库:'.$result['type'];
            }else if($tableName == 'clothesdetail'){
                $record['record'] = '删除三级仓库:'.$result['name'].' 编码:'.$result['code'].' 数量:'.$result['total'].' 尺码:'.$result['size'];
            }

            $this->delRelation($tableName,$data['id']);
            $backInfo = del($tableName,$data);
        
            $record['date'] = date('Y-m-d H:i:s');
            $record['user'] = $_SESSION['name'];
            add('stock_record',$record);
        }catch(Exception $e){
            $backInfobackInfo['status'] = 0;
            $backInfo['info'] = 'Unknown Error!';
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //数据库数据更新操作,同时维护库存数目
    public function edit(){
        $backInfo = array();
        $record = array();
        try{
            $id['id'] = $_GET['id'];
            $data = $_POST['data'];
            $tableName = $_POST['table'];
            if($tableName == 'clothesdetail'){
                $result = M($tableName)->where($id)->find();
                $this->updateStock(-1 * $result['total'],$id['id']);
                $this->updateStock($data['total'],$id['id']);
            }
           $backInfo = update($tableName,$data,$id);
        }catch(Exception $e){
            $backInfo['status'] = 0;
            $backInfo['info'] ='Unknown Error!';
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //数据库数据的新增操作
    public function add(){
        $backInfo = array();
        $record = array();
        try{
            $tableName = $_POST['table'];
            $data = $_POST['data'];
            if($tableName == 'clothes'){
                //增加衣服时 要同时维护 衣服 和 衣服大类的关系 stock_clothes
                $data['total'] = 0;
                $backInfo = add($tableName,$data);
                $this->addRelation('stock_clothes',$backInfo['id'],$_POST['stockId']);
                $record['record'] = '新增二级仓库:'.$data['type'];
            }else if($tableName == 'clothesdetail'){
                $backInfo = add($tableName,$data);
                $this->addRelation('clothes_detail',$backInfo['id'],$_POST['clothesId']);
                $this->updateStock($data['total'],$backInfo['id']);
                $record['record'] = '新增三级级仓库:'.$data['name'].'   数量:'.$data['total'].'   价格:'.$data['price'].' 编码:'.$data['code'].'  尺码'.$data['size'];
            }else{
                $data['total'] = 0;
                $backInfo =  add($tableName,$data);
                $record['record'] = '新增一级仓库:'.$data['type'];
            }
            $record['date'] = date('Y-m-d H:i:s');
            $record['user'] = $_SESSION['name'];
            add('stock_record',$record);
        }catch(Exception $e){
            $backInfo['status'] = 0;
            $backInfo['info'] ='Unknown Error!';
            makeErrorLog($e->getMessage());
        }
        $this->ajaxReturn($backInfo);
    }

    //获取所有的一级仓库名    
    public function getType($data,$tableName){
        $arr = array();
        try{
            $arr = M($tableName)->where($data)->find();
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
        return $arr;
    }

    /**
    *addRelation
    *新增上下级仓库所对应的父子关系
    *@param string $tableName 仓库表的名称
    *@param int  id  子仓库id
    *@param int pid  父仓库id
    *@return null
    */
    public function addRelation($tableName,$id,$pid){
        try{
            $data = array();
            if($tableName == 'stock_clothes'){
                $data['clothes_id'] = $id;
                $data['stock_id'] = $pid;
            }else if($tableName == 'clothes_detail'){
                $data['detail_id'] = $id;
                $data['clothes_id'] = $pid;
            }
            M($tableName)->add($data);
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }
    }

    /**
    *addRelation
    *删除上下级仓库所对应的父子关系 及 库存
    *@param string $tableName 仓库表的名称
    *@param int  $id   仓库表中数据的id
    *@return null
    */
    public function delRelation($tableName,$id){
        try{    
            if($tableName == 'clothes'){
               $clothes['clothes_id'] = $id;
               $detail['clothes_id'] = $id;
               $result = M('clothes_detail')->where($detail)->field('detail_id')->select();
               del('stock_clothes',$clothes);
               del('clothes_detail',$detail);
               if($result != null){
                    $data = array();
                    foreach ($result as $key => $value) {
                        $data[] = $value['detail_id'];
                    }
                    unset($result);
                    $result['id'] = array('in',$data);
                    del('clothesdetail',$data);
               }
            
            }else if($tableName == 'stock'){
                $stock['stock_id'] = $id;
                $result = M('stock_clothes')->where($stock)->field('clothes_id')->select();
                del('stock_clothes',$stock);
                if($result != null){
                    $data = array();
                    foreach ($result as $key => $value) {
                        $data[] = $value['clothes_id'];
                    }
                    unset($result);
                    $result['id'] = array('in',$data);
                    del('clothes',$result);
                }
            
            }else if($tableName == 'clothesdetail'){
                $result = M($tableName)->where(array('id'=>$id))->find();
                $total = -1 * $result['total'];
                $this->updateStock($total,$id);
                $detail['detail_id'] = $id;
                del('clothes_detail',$detail);
            }
        }catch(Exception $e){
             makeErrorLog($e->getMessage());
        }
    }

    /**
    *updateStock,根据第三级仓库的Id  一次向上更新
    *更新库存 
    *@param int $total  第三级仓库数目的变化量 
    *@param int $id     第三级仓库在表中所属的id
    *@return null
    */
    public function updateStock($total,$id){
        try{
            $result = M('clothes_detail')->where(array('detail_id'=>$id))->find();
            $clothesId =$result['clothes_id'];
            updateTotal('clothes',array('id'=>$clothesId),'total',$total);

            $result = M('stock_clothes')->where(array('clothes_id'=>$clothesId))->find();
            $stockId = $result['stock_id'];
            updateTotal('stock',array('id'=>$stockId),'total',$total);
        }catch(Exception $e){
            makeErrorLog($e->getMessage());
        }

    }


    public function export(){
        $tableName = $_GET['table'];
        $clothes = $_GET['clothes'];
        $this->readData($tableName,$clothes);
    }

    public function readData($tableName,$clothes){
        $sql = "select a.* from clothesdetail a RIGHT JOIN clothes_detail b on a.id = b.detail_id
where b.clothes_id = $clothes";
        $data = M()->query($sql);
        $str = "尺码,编号,名称,备注,价格,数量\n";
        $str = setCharset($str);
        foreach ($data as $key => $value) {
            $name = setCharset($value['name']);
            $remark = setCharset($value['remark']);
            $str .= $value['size'].",".$value['code'].",".$name.",".$remark.",".$value['price'].",".$value['total']."\n";
        }
        $filename = date('Ymd').'.csv';
        header("Content-type:text/csv;");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $csv_data;
        exportCsv($filename,$str);
    }
}
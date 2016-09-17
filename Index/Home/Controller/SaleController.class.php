<?php
namespace Home\Controller;
use Think\Controller;
class SaleController extends CommonController {
  
  public function index(){
    $this->show();
  }
  public function record(){
    $this->show();
  }
  public function getData(){
  	$name = isset($_POST['name']) ? $_POST['name'] : null;
  	$value = isset($_POST['value']) ? $_POST['value']:null;
  	$search[$name] = array('like',"%$value%");
    $search['total'] = array('gt',0);
    $tableName = 'clothesdetail';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $data['rows'] = M($tableName)->where($search)->limit(($page - 1) * $rows,$rows)->select();
  	$data['total'] = M($tableName)->where($search)->count();
  	$this->ajaxReturn($data);
  }

  public function getRecord(){
    $search = array();
    if(isset($_POST['name'])){
        $name = ($_POST['name'] != NULL) ? $_POST['name'] : null;
        $value = ($_POST['value'] != NULL) ? $_POST['value']:null;
/*        $startDate = ($_POST['startDate']!= NULL) ? $_POST['startDate'] : date('Y-m-d H:i:s' , strtotime('-1 month'));
        $endDate = ($_POST['endDate']!= NULL) ? $_POST['endDate'] : date('Y-m-d',time());
        $endDate = date("Y-m-d H:i:s",strtotime($endDate) + 86400);
        if(strtotime($startDate) > strtotime($endDate)){
          $min = $startDate;
          $startDate = $endDate;
          $endDate = $min;
        }*/
        $search[$name] = array('like',"%$value%");
        //$search['saleDate'] = array(array('EGT',$startDate),array('ELT',$endDate));
    }
    $tableName = 'salerecord';

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $data['rows'] = M($tableName)->where($search)->order('saledate desc')->limit(($page - 1) * $rows,$rows)->select();
   // echo M($tableName)->getLastSql();
    //echo M($tableName)->getLastSql();
    $data['total'] = M($tableName)->where($search)->count();
    $this->ajaxReturn($data);
  }


  public function Sale(){

    $data = $_POST;
    $action = array();
    $length = count($data['id']);
    $orderNum = time();
    for($i = 0;$i < $length;$i++){
      foreach ($data as $key => $value) {
        $action[$i]['shop_'.$key] = $value[$i];
      }
      $action[$i]['saleDate'] = date('Y-m-d H:i:s');
      $action[$i]['saleMan'] = $_SESSION['name'];
      $action[$i]['orderNum'] = $orderNum;
      $result = add('salerecord',$action[$i]);
      $this->updateStock(-1*$action[$i]['shop_total'],$action[$i]['shop_id']);
    }
     $this->redirect('Sale/index','',0,'页面跳转中....');
  }


  public function updateStock($total,$id){
    try{
        updateTotal('clothesdetail',array('id'=>$id),'total',$total);

        $result = M('clothes_detail')->where(array('detail_id'=>$id))->find();
        $clothesId =$result['clothes_id'];
        updateTotal('clothes',array('id'=>$clothesId),'total',$total);

        $result = M('stock_clothes')->where(array('clothes_id'=>$clothesId))->find();
        $stockId = $result['stock_id'];
      updateTotal('stock',array('id'=>$stockId),'total',$total);
    }catch( Exception $e){
      echo $e->getMessage();
    }

  }

  public function export(){
    $data = M('salerecord')->select();
    $str = "商品尺码,商品名称,商品价格,商品数量,出售日期,售货员,订单号\n";
    $str = setCharset($str);
    foreach ($data as $key => $value) {
        $str .= $value['shop_size'].','.setCharset($value['shop_name']).','.$value['shop_price'].','.setCharset($value['shop_total']).','.$value['saledate'].','.setCharset($value['saleman']).','.$value['ordernum']."\n";
    }
    $filename = date('Ymd').'销售记录'.'.csv';
    exportCsv($filename,$str);
  }

}
<?php
namespace Mobile\Controller;
//use Think\Controller;
class UserController extends MobileBaseController {
    // 查询是否为供应商方法
    public function sup($name,$pwd){
        $model_suppliers = M('suppliers');
        $list = $model_suppliers->where(array('suppliers_account' =>$name,'suppliers_loginpwd' =>$pwd ))->select();
        return count($list);
    }

    public function index(){
        //$name = $this->sup($name,$pwd);
        $name = 1;
        $this->assign('name', $name);
        $this->display();
    }
    //动态地区
    public function ajaxCityList(){

        $model_region = M('region');      
        $id = $_POST['lid'];
        $list = $model_region->where(array('parent_id' =>$id ))->select();
        $good1 = array();
        for($one=0;$one<count($list);$one++){
            $temp_arr1 = array(
                'id' => $list[$one]['id'],
                'name' => $list[$one]['name'],
            );
            array_push($good1, $temp_arr1);
        }
        echo json_encode($good1);
        die;
        
    }
    //我的订单
    public function orderlist(){
        $this->display();
    }
    //我的收藏
    public function collection(){
        $this->display();
    }
    //我的评价
    public function evaluation(){
        $this->display();
    }
    //添加评价
    public function addeval(){
        $this->display();
    }
    //个人资料
    public function personal(){
        $this->display();
    }
    //管理地址
    public function manaddress(){
        $this->display();
    }
    //新建地址
    public function addmanaddress(){
        $model_region = M('region');     
        $good1 = array(); 
        $list = $model_region->where(array('parent_id' =>0 ))->select();
        for($one=0;$one<count($list);$one++){
            $temp_arr1 = array(
                'id' => $list[$one]['id'],
                'name' => $list[$one]['name'],
            );
            array_push($good1, $temp_arr1);
        }
        $this->good1=$good1;
        $this->display();
    }
    
    
}
<?php
namespace Mobile\Controller;
//use Think\Controller;
class IndexController extends MobileBaseController {

    public function index(){
        $this->display();
    }
    
    //分类页面
    public function goodlist(){
        $this->display();
    }
    //排行榜页面
    public function stats(){
        $this->display();
    }
    //综合分页面
    public function score(){
        $this->display();
    }
}
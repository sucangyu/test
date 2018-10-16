<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/24
 * Time: 10:43
 */
if ($_POST){
    //转md5
    if ($_POST['type']=='md5S'){
        $md5String = $_POST['md5String'];
        $data['x32'] = md5($md5String);//md5 32位小
        $data['x16'] = substr($data['x32'], 8, 16);//md5 16位小
        $data['d32'] = strtoupper($data['x32']);//md5 32位大写
        $data['d16'] = strtoupper($data['x16']);//md5 16位大写
        unset($_POST);
        echo json_encode($data);
        die;
    }
    //base文字转码加密
    if ($_POST['type']=='baseE'){
        $baseString = $_POST['baseString'];
        $data = base64_encode($baseString);
        unset($_POST);
        echo $data;
        die;
    }
    //base文字转码解密
    if ($_POST['type']=='baseD'){
        $baseString = $_POST['baseString'];
        $data = base64_decode($baseString);
        unset($_POST);
        echo $data;
        die;
    }
    //根据ip查询物理地址
    if ($_POST['type']=='ipS'){
        $ipString = $_POST['ipString'];
        if(empty($ipString)){
            $ipString = $_SERVER['REMOTE_ADDR'];//如果没有传进查询ip则查询客户端ip
        }
        $json = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ipString);
//            $json = json_decode($json,true);
        unset($_POST);
        echo $json;
        die;
    }


}
<?php
header("Content-type:text/html; charset=utf-8");
//初始化
 //    $ch=curl_init();
	// //设置选项，包括URL
	// curl_setopt($ch,CURLOPT_URL,"http://www.jb51.net");
	// curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// curl_setopt($ch,CURLOPT_HEADER,0);
	// //执行并获取HTML文档内容
	// $output = curl_exec($ch);

	// //释放curl句柄
	// curl_close($ch);

	// //打印获得的数据
	// print_r($output);

//初始化
	$url="http://localhost/jsshamo/index.php/Mobile/User/memberInfo.html";
	$post_data=array("username"=>"bob");
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	//post数据
	curl_setopt($ch,CURLOPT_POST,1);
	//post的变量
	curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
	$output=curl_exec($ch);
	curl_close($ch);
	//打印获得的数据
	print_r($output);

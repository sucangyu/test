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
	// $url="http://localhost/jsshamo/index.php/Mobile/User/memberInfo.html";
	// $post_data=array("username"=>"bob");
	// $ch=curl_init();
	// curl_setopt($ch,CURLOPT_URL,$url);
	// curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// //post数据
	// curl_setopt($ch,CURLOPT_POST,1);
	// //post的变量
	// curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
	// $output=curl_exec($ch);
	// curl_close($ch);
	// //打印获得的数据
	// print_r($output);

/**
 * 实例描述：在网络上下载一个网页并把内容中的“百度”替换为“屌丝”之后输出
 */
// $curlobj = curl_init();            // 初始化
// curl_setopt($curlobj, CURLOPT_URL, "http://www.baidu.com");        // 设置访问网页的URL
// curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);           // 执行之后不直接打印出来
// $output=curl_exec($curlobj);  // 执行
// curl_close($curlobj);          // 关闭cURL
// echo str_replace("百度","屌丝",$output);


/**
 * 实例描述：下载网络上面的一个HTTPS的资源
 */
$curlobj = curl_init();            // 初始化
curl_setopt($curlobj, CURLOPT_URL, "https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.js");       // 设置访问网页的URL
curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);           // 执行之后不直接打印出来

// 设置HTTPS支持
date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查从证书中检查SSL加密算法是否存在
curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, 2); // 

$output=curl_exec($curlobj);  // 执行
curl_close($curlobj);          // 关闭cURL
echo $output;
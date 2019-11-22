<?php
header('Content-type:text/html;charset=utf-8');
$base64_image_content = $_POST['img'];
//匹配出图片的格式
if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

	$type = $result[2];
	$new_file = "public/images/".date('Ymd',time())."/";
	if(!file_exists($new_file))
	{
	//检查是否有该文件夹，如果没有就创建，并给予最高权限
		mkdir($new_file, 0700);
	}
	$new_file = $new_file.time().".{$type}";
	if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
		// var_dump($result);
		echo json_encode(array('type'=>1,'msg'=>'图片保存成功','url'=>$new_file));
	}else{
		echo json_encode(array('type'=>0,'msg'=>'图片保存失败','url'=>$new_file));
	}
}

?>
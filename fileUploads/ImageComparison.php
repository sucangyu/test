<?php
/*图片搜索*/
if ($_FILES['pic']) {
	$size = 10*1024*1024;
	require_once "fileupload.class.php";
	$up = new fileupload();  
    //设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）  
    $up->set("path","public/images/");  
    $up->set("maxsize",$size); //kb  
    $up->set("allowtype",array("gif","png","jpg","jpeg"));//可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小  
    $up->set("israndname",true);//true:由系统命名；false：保留原文件名  
      
    //使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name：pic  
    //如果成功返回true，失败返回false  
  
    if($up->upload("pic")){  
        $show_link = "public/images/".$up->getFileName()  ;
    }else{  
        var_dump($up->getErrorMsg());  
    }  


    include 'picmatch_Sample/picmatch.php';
	$pic = $show_link;
	$images = glob('public/images/*.jpg');
	$matchs = array();

	foreach($images as $img){
	    $color1 = getColor($pic);
	    $color2 = getColor($img);
	    $matchs[floor(match($color1,$color2))] = $img;
	}
	var_dump($matchs);
	krsort($matchs);

	echo '<img src="'.$pic.'" width="100px;"/><br>最相似的图片是：<hr>';

	foreach($matchs as $img){
		if (array_keys($matchs)!=100) {
			echo '<img src="'.$img.'" width="100px;"/>';
		}
	    
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>图片搜索</title>
</head>
<body>
	<form method='post' action="" enctype="multipart/form-data">
		<input type="file" name="pic"  accept="image/*">
		<input type="submit" name="" value="搜索">
	</form>
</body>
</html>
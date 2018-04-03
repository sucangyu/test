<?php
/*图片裁剪上传存为不同规格*/

//获取相应规格的图片地址  
//gen=0:保持比例缩放，不剪裁,如高为0，则保证宽度按比例缩放  gen=1：保证长宽，剪裁  
function get_spec_image($img_path,$width=0,$height=0,$gen=0,$is_preview=true)  
{  
    if($width==0)  
        $new_path = $img_path;  
    else  
    {  
        $img_name = substr($img_path,0,-4);  
        $img_ext = substr($img_path,-3);      
        if($is_preview)  
        $new_path = $img_name."_".$width."x".$height.".jpg";      
        else  
        $new_path = $img_name."o_".$width."x".$height.".jpg";     
        if(!file_exists($new_path))  
        {  
            require_once "imagecls.php";  
            $imagec = new imagecls();  
            $thumb = $imagec->thumb($img_path,$width,$height,$gen,true,"",$is_preview);  
              
            if($_FILES['image']!='')  
            {  
                $paths = pathinfo($new_path);  
                $path = str_replace("./","",$paths['dirname']);  
                $filename = $paths['basename'];  
                $pathwithoupublic = str_replace("/public/","",$path);  
                  
                        $file_data = @file_get_contents($path.$file);  
                        $img = @imagecreatefromstring($file_data);  
                        if($img!==false)  
                        {  
                           $save_path = "/public/".$path;  
                           if(!is_dir($save_path))  
                           {  
                                @mk_dir($save_path);              
                           }  
                           @file_put_contents($save_path.$name,$file_data);  
                        }  
            }  
              
        }  
    }  
    //return $new_path;  
    return $thumb;  
}  

//该代码片段来自于: http://www.sharejs.com/codes/php/5993



/*
方法一
file直接提交存为不同大小规格的图片
*/
// if ($_FILES['image']) {
// 	require_once "fileupload.class.php";
// 	$up = new fileupload();  
//     //设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）  
//     $up->set("path","public/images/");  
//     $up->set("maxsize",2000000); //kb  
//     $up->set("allowtype",array("gif","png","jpg","jpeg"));//可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小  
//     $up->set("israndname",true);//true:由系统命名；false：保留原文件名  
      
//     //使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name：pic  
//     //如果成功返回true，失败返回false  
  
//     if($up->upload("image")){  
//         // echo '<pre>';  
//         //获取上传成功后文件名字
//         $show_link = "public/images/".$up->getFileName()  ;
//         // var_dump($show_link);  
//         // echo '</pre>';  
          
//     }else{  
//         // echo '<pre>';  
//         //获取上传失败后的错误提示  
//         var_dump($up->getErrorMsg());  
//         // echo '<pre/>';  
//     }  
// 	$small_url=get_spec_image($show_link,48,48,0);
// 	$big_url=get_spec_image($show_link,200,200,0);
// 	//var_dump($small_url);
// 	echo "<img src='".$small_url['url']."'>".$small_url['path'];
// 	echo "<img src='".$big_url['url']."'>".$big_url['path'];
// 	unlink('./'.$show_link);
// 	unset($_FILES['image']);
// }

/*
方法二
file上传后经过截取后用PHP函数保存图片
*/

if($_POST&&$_FILES['image']){
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
  
    if($up->upload("image")){  
        $show_link = "public/images/".$up->getFileName()  ;
    }else{  
        var_dump($up->getErrorMsg());  
    }  

	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;//指定图像质量，范围从 0（最差质量，文件最小）到 100（最佳质量，文件最大），默认75 ，imagejpeg() 独有参数

	$src = $show_link;
	$img_r = imagecreatefromjpeg($src);//创建一块画布，并从 JPEG 文件或 URL 地址载入一副图像
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );//建立的是一幅大小为 x和 y的黑色图像(默认为黑色)，如想改变背景颜色则需要用填充颜色函数imagefill($img,0,0,$color);   

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);//该函数将一幅图像中的正方形区域复制到另一个图像中，平滑地插入像素值，因此减小了图像的大小而仍然保持了极高的清晰度。如果成功，则返回TRUE，失败则返回FALSE
	$path = mt_rand(100000000, 999999999).'.jpg';//临时文件名
	//header('Content-type: image/jpeg');// 函数向客户端发送原始的 HTTP 报头。
	imagejpeg($dst_r,'public/images/'.$path,$jpeg_quality);//以 JPEG 格式将图像输出到浏览器或文件

	$url = 'public/images/'.$path;
	//echo "<img src='".$url."'>".$url;
	$small_url=get_spec_image($url,48,48,0);
	$big_url=get_spec_image($url,200,200,0);
	echo "<img src='".$small_url['url']."'>".$small_url['path'];
	echo "<img src='".$big_url['url']."'>".$big_url['path'];
	unlink('./'.$show_link);
	unlink('./'.$url);
	unset($_FILES['image']);
	unset($_POST);
	//exit;
}


?>



<!DOCTYPE html>
<html>
<head>
	<title>图片上传</title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<script type="text/javascript" src="public/js/jquery.min.js"></script>
	<script type="text/javascript" src="public/js/jquery.Jcrop.js"></script>
	<style type="text/css">
		#show{width: 90%;overflow: auto;margin: 0 auto;}
		#target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }
	</style>
</head>
<body>
	
	<img src="public/images/value_add.png" id="img1" style="width: 100px;height: 100px;">
	<form method='post' action="upImage.php" enctype="multipart/form-data" onsubmit="return checkCoords();">
		<input type="file" name="image" id="img_file" style="display: none;" accept="image/*">
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="submit" value="提交" class="btn btn-large btn-inverse" />
	</form>
	<div id="show">
		<!-- <img src="public/images/20180322145614_200x200.jpg" id="cropbox" style="width: 100%;"> -->
	</div>
	
	<div style="width: 100px;height: 100px;"></div>
	<script type="text/javascript">
		$("#img1").click(function () {
	        $("#img_file").click(); //隐藏了input:file样式后，点击头像就可以本地上传
	        $("#img_file").on("change",function(){
	            var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
	            if (objUrl) {
	            	var html = '<img id="cropbox" src='+objUrl+'>';
	            	$("#show").html(html);
	            	//截取图像
	            	var jcropApi;
	            	$('#cropbox').Jcrop({
						aspectRatio: 1,
						allowMove: true,
						onSelect: updateCoords
					});
	            }
	        });
	    });
	    //建立一個可存取到該file的url
	    function getObjectURL(file) {
	        var url = null ;
	        if (window.createObjectURL!=undefined) { // basic
	            url = window.createObjectURL(file) ;
	        } else if (window.URL!=undefined) { // mozilla(firefox)
	            url = window.URL.createObjectURL(file) ;
	        } else if (window.webkitURL!=undefined) { // webkit or chrome
	            url = window.webkitURL.createObjectURL(file) ;
	        }
	        return url ;
	    }
	    //截取图像
	    function updateCoords(c)
		{
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
		};

		function checkCoords()
		{
			if (parseInt($('#w').val())) return true;
			alert('请选择一个区域然后按下提交.');
			return false;
		};
	</script>
</body>
</html>
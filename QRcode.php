<?php 

include 'phpqrcode.php'; 

$value = 'http://www.learnphp.cn'; //二维码内容 

$errorCorrectionLevel = 'L';//容错级别 

$matrixPointSize = 6;//生成图片大小 

//生成二维码图片 

QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2); 

$logo = 'logo.png';//准备好的logo图片 

$QR = 'qrcode.png';//已经生成的原始二维码图 

  

if ($logo !== FALSE) { 

$QR = imagecreatefromstring(file_get_contents($QR)); 

$logo = imagecreatefromstring(file_get_contents($logo)); 

$QR_width = imagesx($QR);//二维码图片宽度 

$QR_height = imagesy($QR);//二维码图片高度 

$logo_width = imagesx($logo);//logo图片宽度 

$logo_height = imagesy($logo);//logo图片高度 

$logo_qr_width = $QR_width / 5; 

$scale = $logo_width/$logo_qr_width; 

$logo_qr_height = $logo_height/$scale; 

$from_width = ($QR_width - $logo_qr_width) / 2; 

//重新组合图片并调整大小 

imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 

$logo_qr_height, $logo_width, $logo_height); 

} 

//输出图片 

imagepng($QR, 'helloweba.png'); 

echo '<img src="helloweba.png">'; 
echo strtotime(date('2007').'-01-01');
$a=10;
$b=1136070000;
$c = "+".$a."year";
echo strtotime($c,$b);

echo date('Y-m-d H:i:s',strtotime("+1year",$b));//指定时间戳+1年 2018-01-09 21:10:16
?>
<?php
require_once("lib/Image/Image.php");

$src = "./uploads/{$_REQUEST['picName']}"; // 源路径
$des = "./uploads/crop_{$_REQUEST['picName']}"; // 目标路径

$thinkImage = new Image();

$thinkImage->open($src);
$src_w = $thinkImage->width();
$src_h = $thinkImage->height();
$des_x = $_REQUEST['x1'] / $_REQUEST['scale'];
$des_y = $_REQUEST['y1'] / $_REQUEST['scale'];
$thinkImage->crop($_REQUEST['w'] / $_REQUEST['scale'], $_REQUEST['h'] / $_REQUEST['scale'], $des_x, $des_y)->save($des);

exit(json_encode([
    'code' => 1,
    'body' => "./uploads/crop_{$_REQUEST['picName']}"
]));
<?php
ob_start();

require_once('sqlcity/wap.php');
$str= ob_get_contents();

// echo " i love you";
// ob_end_clean();
// echo $str;
file_put_contents('index.shtml', $str);
?>
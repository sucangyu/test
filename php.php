<?php
header("Content-type: text/html; charset=utf-8");

//1维数组
$m_date1=array(
    'price' => '279',
    'product' => '金条',
    'shop' => '老庙',
);
$m_date2=array(
    'price' => '322',
    'product' => '金条',
    'shop' => '老凤祥',
);
$m_date3=array(
    'price' => '299',
    'product' => '黄金',
    'shop' => '老庙',
);
$m_date4=array(
    'price' => '300',
    'product' => '金条',
    'shop' => '六福',
);
$m_date5=array(
    'price' => '299',
    'product' => '黄金',
    'shop' => '老凤祥',
);
$aa = serialize($m_date5);
echo $aa.'<br/>';
$ss = unserialize($aa);
echo $ss['shop'];
?>
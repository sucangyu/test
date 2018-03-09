<?php
header("Content-type: text/html; charset=utf-8");
$gold = [];
$m_array=array();
$all_gold=array();
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
//组装2维数组
array_push($m_array,$m_date1,$m_date2,$m_date3,$m_date4,$m_date5);


//组装3维数组；
for($i=0;$i<count($m_array);$i++){
    if(array_key_exists( $m_array[$i]['shop'], $gold) ){
          //  echo "该数组中包含了'key'";
       array_push($gold[$m_array[$i]['shop']],$m_array[$i]);
      }
    else{
      echo 'aaaa';
        $gold[$m_array[$i]['shop']][0]=$m_array[$i];
    }
}
//定义一个3维数组
// $pt = array (
//             '六福' =>
//                 array (

//                     'price' => '310',
//                     'product' => 'pt999',
//                     'shop' => '六福',

//                 ),
//             '老凤祥'=>
//               array(
//                   array (
//                       'price' => '300',
//                       'product' => 'pt995',
//                       'shop' => '老凤祥',
//                     ),
//                   array(
//                       'price' => 'pt',
//                       'product' => '黄金',
//                       'shop' => '老凤祥',
//                     )
//                 )
// );
// 组装成 4维数组
//    $all_gold=array(
//          'pt' => $pt,
//          'gold' => $gold
//      );
 echo "<pre>";
 var_dump($gold);
?>
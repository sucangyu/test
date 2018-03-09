<?php
header("content-type:text/html;charset=utf-8;");

$test=array(); 
for ($i=0; $i < 5; $i++) { 
	$test[]=array( 
        'title'=>'Q'.$i.'.较为科学的安全期算法是什么？', 
        ); 
}
// $test[]=array( 
//         'title'=>'Q1.较为科学的安全期算法是什么？', 
//         ); 
// $test[]=array( 
//         'title'=>'Q2.较为科学的安全期算法是什么？', 
//         ); 
// $test[]=array( 
//         'title'=>'Q3.较为科学的安全期算法是什么？', 
//         ); 
// $test[]=array( 
//         'title'=>'Q4.较为科学的安全期算法是什么？', 
//         ); 
//随机排序 
shuffle($test); 
print_r($test); 



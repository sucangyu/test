<?php
//简单计算器
header("Content-type: text/html; charset=utf-8");

//加法
function add($a,$b){
	return $a + $b;
}
//减法
function subtr($a,$b){
	return $a - $b;
}
//乘法
function mult($a,$b){
	return $a * $b;
}
//除法
function division($a,$b){
	return $a / $b;
}
//$a的$b次方
function factorial($a,$b){
	if ($b<2) {
		return '阶乘不能小于两次';
		die;
	}
	return pow($a,$b);
}
//开平方根
function openroot($a){
	return sqrt($a);
}
//计算
/*
$funcName 函数名
$a        在次方和开平方时是主体(全体必选)
$b        在开平方时为null
*/
function calc($funcName,$a,$b){
	return $funcName($a,$b);
}

echo calc('openroot',121,null);

echo '<hr/>';
echo session_id();
?>
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
echo $ss['shop'].'<br/>';
echo 'time时间:';
echo time().'<br/>';
echo 'md5 aaaaaa:';
echo md5('aaaaaa').'<br/>';
echo 'crypt aaaaaa:';
echo crypt('aaaaaa').'<br/>';
echo 'base64 图片:'.'<br/>';
$filename = 'logo.png';
$data = file_get_contents($filename);
$img_base64 = base64_encode($data);
echo "<img src='data:;base64,".$img_base64."'/>".'<br/>';

echo "<hr/>";
class Car {
    public $name = 'car';
    
    public function __clone() {
        $obj = new Car();
        $obj->name = $this->name;
    }
}
$a = new Car();
$a->name = 'new car';
$b = clone $a;
if ($a == $b) echo '=='.'<br/>';   //true
if ($a === $b) echo '==='.'<br/>'; //false

$str = serialize($a); //对象序列化成字符串
echo $str.'<br>';
$c = unserialize($str); //反序列化为对象
var_dump($c);
echo "<hr/>";
$filename = 'text.txt';
//编写代码读取$filename的文件内容
if (file_exists($filename)) {
    $content = file_get_contents($filename);
    echo $content;
}else{
   echo '文件不存在';
}

echo '1:使用for循环、while循环和递归写出3个函数来计算给定数列的总和。<br/>';
$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];
echo 'for循环'.getFor($arr).'<br/>';
echo 'while循环'.getWhile($arr).'<br/>';
echo '递归循环'.getDg(0,$arr).'<br/>';
function getFor($arr){
    $sum = 0;
    for ($i=0; $i < count($arr); $i++) { 
        $sum += $arr[$i];
    }
    return $sum;
}
function getWhile($arr){
    $sum = 0;
    $i = 0;
    while ($i < count($arr)) {
        $sum += $arr[$i];
        $i++;
    }
    return $sum;
}
function getDg($i,$arr){
    if ($i<count($arr)) {
        return $arr[$i] + getDg($i+1,$arr);
    }else{
        return $arr[$i];
    }
}
echo '问题3:编写一个计算前100位斐波那契数的函数。根据定义，斐波那契序列的前两位数字是0和1，随后的每个数字是前两个数字的和。例如，前10位斐波那契数为：0，1，1，2，3，5，8，13，21，34。<br/>';
//递推
function fbnq($n){
    if( $n <=2){
        return 1;
    }
    $n1=1;//斐波那契数列第一项初始为1
    $n2=1;//斐波那契数列第二项初始为1
    $result=0;
    for($i=3;$i<=$n;$i++){
        $result=$n1+$n2;
        $n1=$n2;//更新旧值
        $n2=$result;//更新旧值
    }
    return $result; 

}

$a=fbnq(20);//求斐波那契数列第20个数
echo "斐波那契数列第20项为:".$a;
echo '<br/>问题4:编写一个能将给定非负整数列表中的数字排列成最大数字的函数。例如，给定[50，2，1,9]，最大数字为95021。<br/>';
$arr = [50,2,1,9];
// function grtMax($arr){
//     for ($i=0; $i < count($arr); $i++) { 

//     }
//     return $str;
// }
// echo grtMax($arr);
?>
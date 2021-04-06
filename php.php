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
$arr = range(1,10,1);//step可选。规定元素之间的步进制。默认是 1。
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
$arr = array(50,2,1,9);
// function grtMax($arr){
//     for ($i=0; $i < count($arr); $i++) { 

//     }
//     return $str;
// }
// echo grtMax($arr);
echo '<br/>range()函数:';
print_r (range("A","Z"));
echo '<br/>';
$a = range(1,30);
$b = array_chunk($a, 6);//函数把数组分割为新的数组块.其中每个数组的单元数目由 size 参数决定。最后一个数组的单元数目可能会少几个。
echo 'array_chunk():'.print_r ($b);
echo '<br/>';
$c = call_user_func_array('array_map', array_merge(array(null), $b));
echo '<br/>';
echo 'array_merge():'.print_r (array_merge(array(null), $b));
echo 'call_user_func_array():'.print_r ($c);
echo '<br/>结果:';
foreach($c as $v) echo join(' ', $v), '<br/>';


echo '<br/>PHP 计算2的N次方可以使用PHP自带的函数';
echo '<br/>1:  pow(2,4)  ';
var_dump(pow(2,4));
echo '<br/>2:  1<<$n  ';
$n=4;
var_dump(3<<$n);
echo '<br/>pow(1,18);';
echo pow(10,18);
echo '<br/>';
$src = date("Y.m.d");
echo str_replace('.', '', date("Y.m.d"));
echo '<br/>';
//随机整型利用“不同”就有顺序的原理，
function randomDivInt($pnum,$tmoney){
    $remain=$tmoney;
    $max_sum=($pnum-1)*$pnum/2;
    $p=$pnum; $min=0.01;
    $a=array();
    for($i=0; $i<$pnum-1; $i++){
        $max=($remain-$max_sum)/($pnum-$i);
        $e=rand($min,$max);    
        $min=$e+1; $max_sum-=--$p;
        $remain-=$e;
        $a[$e]=true;
    }
    $a=array_keys($a);
    $a[]=$remain;
    return $a;
}
 
 
/*for($i=0; $i<3; $i++){
    $a=randomDivInt(5,100);
    var_dump($a);//$a中便是分的不等数
    var_dump(array_sum($a));
    echo '<br>';
}*/
echo '~~~~~~~~~<br/>';
$money_total=50.003;
$personal_num=3;
$zdz = 200;
$min_money=0.01;
$money_right=$money_total;
$randMoney=array();
for($i=1;$i<=$personal_num;$i++){
    if($i== $personal_num){
        $money=$money_right;
    }else{
        // $max=$money_right*100 - ($personal_num - $i ) * $min_money *100;
        $aa = ($money_right/($personal_num-$i+1))*2*100;
        $max=min($zdz*100,$aa);
        $money= rand($min_money*100,$max) /100;
        $money=sprintf("%.2f",$money);
        $bb = max(0,$money_right - $money-$zdz*($personal_num-$i));
        $money = $money+$bb;
    }
    $randMoney[]=$money;
    $money_right=$money_right - $money;
    $money_right=sprintf("%.2f",$money_right);
}
// shuffle($randMoney);
var_dump($randMoney);
class test{
    /**
     *
     */
    public function aaa(){

    }
}

?>
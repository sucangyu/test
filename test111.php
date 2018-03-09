<?php
header("Content-type: text/html; charset=utf-8");
$a=3;
$b=5;
echo $a.'  '.$b.'<br/>';
if ($a=5 || $b = 7) {
    echo $a.'  '.$b.'<br/>';
    ++$a;
    $b++;
    echo $a.'  '.$b.'<br/>';
}
echo $a.'  '.$b;
?>
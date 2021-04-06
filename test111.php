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
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>单多行文字垂直居中</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <style>
        div{
            display:table;
            height:200px;
            background: #F5F5F5;
            margin-bottom: 20px;
        }
        div p,div span{
            display:table-cell;
            vertical-align:middle;

        }
        div{
            display:flex;
            height:200px;
            align-items:center;
        }
    </style>
</head>
<body>
<div>
    <p>
        单行多行都垂直居中
    </p>
</div>
<div>
    <p>
        单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中居中单行多行都垂直居中居中单行多行都垂直居中居中单行多行都垂直居中居中单行多行都垂直居中
    </p>
</div>
<div>
    <p>
        单行多行都垂直居中
    </p>
</div>
<div>
		<span>
			单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居中居中单行多行都垂直居中	居中单行多行都垂直居中	居中单行多行都垂直居中	居中单行多行都垂直居中单行多行都垂直居中单行多行都垂直居
		</span>
</div>
</body>
</html>

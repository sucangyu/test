<?php
//session_start(); //开启 session 
header("content-type:text/html;charset=utf-8;");
//require_once "dbClassMessage.php";
require_once "testAjax.php";
$url = U('testAjax/log');
$ss = "11";
?>

<!doctype html>
<html>
<head>
<title></title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
<!-- <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script> -->

<title></title>
<style type="text/css">

</style>
</head>

  <script type="text/javascript">
  	var ww = <?php echo $url;?>;
  	console.log(ww);
    function login() {
      $.ajax({
      //几个参数需要注意一下
        type: "POST",//方法类型
        //dataType: "json",//服务端接收的数据类型
        url: "testAjax.php" ,//url
        data: $('#form1').serialize(),
        success: function (result) {
          console.log(result);//打印服务端返回的数据(调试用)
          if (result.resultCode == 200) {
            alert("SUCCESS");
          }
          ;
        },
        error : function() {
          alert("异常！");
        }
      });
    }
  </script>

<body>
<div id="form-div">
  <form id="form1" onsubmit="return false" action="##" method="post">
    <p>用户名：<input name="userName" type="text" id="txtUserName" tabindex="1" size="15" value=""/></p>
    <p>密　码：<input name="password" type="password" id="TextBox2" tabindex="2" size="16" value=""/></p>
    <p><input type="button" value="登录" onclick="login()"> <input type="reset" value="重置"></p>
    <input type="hidden" name="type" value="1">
  </form>
</div>
</body>
</html>




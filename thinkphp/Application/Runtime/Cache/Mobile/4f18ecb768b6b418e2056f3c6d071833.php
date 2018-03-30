<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>个人资料</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/index.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/user.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/layer.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
</head>
<style type="text/css">
.percontent ul li{width: 100%;border-bottom: 1px solid #b5b4b5;border-top: 1px solid #b5b4b5;background-color: #ffffff;padding:10px 15px 10px 15px;font-size: 18px;overflow:auto; zoom:1;}
.percontent .spleft{float: left;color: #231815;}
.percontent .spright{float: right;color: #898a89;}
.percontent .portrait .spleft{margin-top: 8%}
.percontent .portrait .spright{width: 25%;display: flex;align-items: center;/*margin-left: 62%;*/}
.percontent .portrait .img-circle{width: 100%;float: left;line-height: 120px;}
.percontent .portrait .spright .glyphicon{float: right;}
.percontent .name{margin-top:8px;}
.percontent .name{border-bottom: 0px solid #b5b4b5;}
.percontent .perweixin{margin-top:8px;}
#submit{width:100%;bottom: 0px;height: 60px;background-color: #7d191d;color: #ffffff;text-align: center;line-height: 60px;position: absolute;font-size: 24px;}
</style>
<body style="background-color:#EAEAEC;">
<style type="text/css">
.header{height: 55px;border-bottom: 0 solid #ccc;background-color: #ffffff}
.sb-back{line-height: 55px;margin-left: 8px;float: left;}
.h-mid{line-height: 55px;text-align: center;height: 55px;width: 80%}
#heatatle{font-size: 26px;}
</style>
<script type="text/javascript">
var tatles = document.title;
window.onload = function(){ 
 　　$("#heatatle").html(tatles);
} 
</script>
<header> 
	<div class="tab_nav">
		<div class="header">
			<a class="sb-back" href="javascript:history.back(-1)" title="返回">
				<img class="" src="/Public/mobile/img/left1.png">
			</a>
			<div class="h-mid" id="heatatle">
fff
				<!-- <span id="heatatle"></span> -->
			</div>
			<!-- <a href=""><img class="share"></a> -->
		</div>
		
	</div>

</header>
<div class="percontent">
	<ul>
		<li class="portrait">
			<div class="spleft">头像</div>
			<div class="spright">
				<img class="img-circle" src="/Public/images/v-shop/logo.png" >	
				<!-- <span class="glyphicon glyphicon-menu-right"></span>	 -->		
			</div>
			
		</li>
		<li class="name">
			<div class="spleft">姓名</div>
			<div class="spright">
			吴晓
				<span class="glyphicon glyphicon-menu-right"></span>
			</div>
		</li>
		<li class="">
			<div class="spleft">手机</div>
			<div class="spright">
				123456789111
				<span class="glyphicon glyphicon-menu-right"></span>
			</div>
		</li>
		<li class="perweixin">
			<div class="spleft">微信帐号</div>
			<div class="spright">
				1321546
				<!-- <span class="glyphicon glyphicon-menu-right"></span> -->
			</div>
		</li>
	</ul>

</div>
<div id="submit" onclick="submit()">
保存修改
</div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>我的收藏</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/user.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/layer.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<script src="/Public/mobile_js/jquery.json.js"></script>
<script src="/Public/mobile_js/layer.js"></script>
<script src="/Public/mobile_js/TouchSlide.1.1.js"></script>
<script src="/Public/mobile_js/touchslider.dev.js"></script>
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
</head>
<style type="text/css">
.Evaluation2{height: 20px;}
.order{margin-top: 10px;}
.order_list1{width: 100%;background-color: #ffffff;padding: 10px;margin-bottom: 8px;}
.order_list1 .serial{width: 100%;height: 30px;line-height: 30px;color: #b9b4b2;font-size: 16px;border-bottom: 1px solid #b5b4b5;}
.order_list1 div{padding:5px 0 5px 0;}
.order_list1 div img{width: 20%}
.order_list1 div span{font-size: 16px;color: #b9b4b2;margin-left: 8px;line-height: 20px;}

</style>
<body style="background-color:#EAEAEA; ">
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
<div id="tbh5v0">
	<div class="Evaluation2">

    </div>  
    <div class="order ajax_return">
     	<?php $__FOR_START_2374__=1;$__FOR_END_2374__=4;for($i=$__FOR_START_2374__;$i < $__FOR_END_2374__;$i+=1){ ?><div class="order_list1">
     		<p class="serial ">订单编号:123465</p>
     		<a href="">
     			<div>
     				<img src="/Public/mobile/img/jiu1.png">
     				<span>商品名称xxxxxxx</span> 
     			</div>
     		</a> 
     	</div><?php } ?>
    </div>   
</div>

</body>
</html>
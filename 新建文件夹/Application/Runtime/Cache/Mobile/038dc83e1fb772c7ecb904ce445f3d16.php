<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>德商-综合分</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/index.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<script src="/Public/mobile_js/jquery.json.js"></script>
<script src="/Public/mobile_js/layer.js"></script>
<script src="/Public/mobile_js/TouchSlide.1.1.js"></script>
<script src="/Public/mobile_js/touchslider.dev.js"></script>
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
</head>
<style type="text/css">
.ontitle{width: 100%;background-color:#7d191d; height: 160px;padding: 10% 18% 10% 18%;}
.ontitle img{width: 30%;vertical-align:middle;float: left;}
.ontitle ul{float: left;margin-top:5%;margin-left: 10px;}
.ontitle ul li{height: 22px;color: #FFFFFF;font-size: 16px;}
.uncontent{padding:10%;}
.uncontent ul{margin:0 auto;width: 80%;font-size: 20px;}
.uncontent ul li{height:30px;line-height: 30px;border-bottom: 1px solid #b5b5b6;color: #727171;}
.uncontent ul li .spanright{float: right;color: #7d191d;}
.uncontent p{color: #7d191d;font-size: 24px;width: 80%;margin:20px auto;}
.uncontent p .spanright{float: right;}
</style>
<body style="background-color:#eaebec;">
<style type="text/css">
.search span{height: 30px;border-radius:20px;border-style: none; font-size: 16px;width: 60%;vertical-align:middle;text-align:center;}
</style>
<script type="text/javascript">
var tatles = document.title;
window.onload = function(){ 
 　　$("#heatatle").html(tatles);
} 
</script>
<header id="header"> 
	<div class="logo">
		<a href="javascript:history.back(-1)" title="返回"><img class="city"></a>
		<div class="search">
			<span id="heatatle"></span>
		</div>
		<a href=""><img class="share"></a>
	</div>

</header>
<div class="ontitle">
	<img src="/Public/mobile/img/jiu1.png" class="img-rounded">
	<ul>
		<li>巴黎欧莱雅沐浴露</li>
		<!-- <li></li> -->
		<li>企业名称</li>
	</ul>
</div>
<div class="uncontent">
	<ul>
		<li><span class="spanleft">销售额</span><span class="spanright">7899</span></li>
		<li><span class="spanleft">服务</span><span class="spanright">40</span></li>
		<li><span class="spanleft" style="color: #dcdddd;">路演</span><span class="spanright"></span></li>
		<li><span class="spanleft" style="color: #dcdddd;">现成PK</span><span class="spanright"></span></li>
		<li><span class="spanleft" style="color: #dcdddd;">盟友助阵</span><span class="spanright"></span></li>
	</ul>
	<p><span class="spanleft">综合分</span><span class="spanright">98</span></p>
</div>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
	<div class="vf_nav">
		<ul>
			<li> <a href="<?php echo U('Index/index');?>">
			    <i class="vf_1"></i>
			    <!-- <span>首页</span> --></a></li>
			<!-- <li><a href="tel:<?php echo ($tpshop_config['shop_info_phone']); ?>">
			    <i class="vf_2"></i>
			    <span>客服</span></a></li> -->
			<li><a href="<?php echo U('Goods/categoryList');?>">
			    <i class="vf_3"></i>
			    <!-- <span>分类</span> --></a></li>
			<li>
			<a href="<?php echo U('Cart/cart');?>">
			   <em class="global-nav__nav-shop-cart-num" id="cart_quantity" style="right:9px;"></em>
			   <i class="vf_4"></i>
			   <!-- <span>购物车</span> -->
			   </a>
			</li>
			<li><a href="<?php echo U('User/index');?>">
			    <i class="vf_5"></i>
			    <!-- <span>我的</span> --></a>
			</li>
		</ul>
	</div>
</div> 
<script type="text/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<?php if($signPackage != null): endif; ?>
<!-- 微信浏览器 调用微信 分享js  end-->
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>德商-所有分类</title>
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
.primarylist .col-xs-6{width: 24%;background-color:#FFFFFF; text-align:center;margin:8px 1px 8px 1px;padding-bottom:5px;}
.primarylist .col-xs-6 .img-rounded{width: 100%;}
</style>
<body style="background-color:#EAEAEA; ">
<style type="text/css">
.search input{height: 30px;border-radius:20px;border-style: none; font-size: 12px;width: 60%;vertical-align:middle;text-align:center;}
</style>
<header id="header"> 
	<div class="logo">
		<a href="javascript:history.back(-1)" title="返回"><img class="city"></a>
		<div class="search">
			<input type="text" name="" placeholder="请输入您所搜索的商品"/>
		</div>
		<a><img class="share"></a>
	</div>

</header>
<div class="row primarylist">
	<?php $__FOR_START_6439__=1;$__FOR_END_6439__=16;for($i=$__FOR_START_6439__;$i < $__FOR_END_6439__;$i+=1){ ?><div class="col-xs-6 col-sm-3">
			<img  class="img-rounded" src="/Public/images/1440439318451279676.png"/>
			<span>女装</span>
		</div><?php } ?>
	

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
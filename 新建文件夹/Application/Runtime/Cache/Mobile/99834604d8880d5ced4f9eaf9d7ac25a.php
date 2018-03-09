<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>首页</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/index.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/star-rating.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<script src="/Public/mobile_js/jquery.json.js"></script>
<script src="/Public/mobile/js/star-rating.js"></script
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
<style type="text/css">
.selindtop{width: 100%;height: 100px;background-color:#7d191d;}
.selindtop .portrait{width: 20%;line-height: 100px;margin-left: 15px;float: left;}
.selindtop .portrait img{width: 100%;}
.selindtop .introduction{height: 75%;margin-top: 4%;width: 40%; border-left: 1px solid #b5b4b5;margin-left: 10px;padding:5px 10px 5px 10px; float: left;color: #fff;font-size: 16px;line-height: 25px;}
.selindtop .share1{margin-top: 5%;width: 26%;float: right;margin-right: 5px;}
.selindtop .share1 div{width: 50px;height: 50px;font-size: 16px;background-color: #c49d62;color: #7d191d;padding:5px;line-height: 20px;text-align: center;margin: 0 auto;}
.selindtop .share1 p{font-size: 10px;line-height: 18px;color: #fff;}
.selindcon .col-xs-6{width: 48.5%;background-color: #fff;margin-left: 1%;margin-top: 1%}
.selindcon .col-xs-6 img{width: 100%;}
.selindcon .col-xs-6 p{font-size: 12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;height: 14px; line-height: 14px;}
.selindcon .col-xs-6 .p2 .span1{color: #CD0000;}
.selindcon .col-xs-6 .p2 .span2{color: #A8A8A8;}
</style>
</head>
<body style="background-color: #dcdddd;">
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
<div class="selindtop">
	<div class="portrait"><img src="/Public/images/v-shop/logo.png" class="img-circle"></div>
	<div class="introduction">
		<ul>
			<li>公司名称</li>
			<li>jkladjgairjgvjij</li>
			<li>xxxxxxxx</li>
		</ul>
	</div>
	<a href="<?php echo U('Seller/addshare');?>">
		<div class="share1">
			<div>分享店铺</div>
			<p>让更多人为你代言</p>
		</div>
	</a>
	
</div>
<div class="selindcon">
	<?php $__FOR_START_9221__=1;$__FOR_END_9221__=7;for($i=$__FOR_START_9221__;$i < $__FOR_END_9221__;$i+=1){ ?><div class="col-xs-6">
		<img src="/Public/images/v-shop/logo.png"">
		<p class="p1">商家名称xxxxxxxxxxxxxxxxxxxxxxxx</p>
		<p class="p2"><span class="span1">￥155.0</span><span class="span2">  123人已购买</span></p>
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
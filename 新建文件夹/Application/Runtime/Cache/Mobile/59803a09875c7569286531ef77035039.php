<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>德商首页</title>
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
<style type="text/css">
.clalist{width: 100%;height: 80px;}
.clalist .col-xs-6{height: 80px;    }
.clalist .col-xs-6 .btn{width: 70px;margin-top: 15px;border-color:#A52A2A;}
.clalist .col-xs-6 .btn .glyphicon{color:#A52A2A;}
.clalist .col-xs-6 p{font-size: 12px;}
.product{border-top:5px solid #8A8A8A ;width: 100%; }
.product .col-xs-6{margin-bottom: 5px; padding-right: 5px;padding-left: 5px;}
.product .col-xs-6 img{width: 100%;margin:0 auto;border:1px solid #E3E3E3;}
.product .col-xs-6 .details{margin-top: 10px;}
.product .col-xs-6 .details .details1{float: left;width: 20%;}
.product .col-xs-6 .details .details1 img{width: 100%;}
.product .col-xs-6 .details .details1 p{font-size: 12px;text-align: center;}
.product .col-xs-6 .details .details2{float: left;width: 80%;margin-top: 6px;padding-left:5px;font-size: 12px;}
.product .col-xs-6 .details .details2 .p1{width: 100%;overflow: hidden;text-overflow: ellipsis; white-space: nowrap; }
.product .col-xs-6 .details .details2 .span1{color: #CD0000;}
.product .col-xs-6 .details .details2 .span2{color: #A8A8A8;}
</style>
</head>
<body>
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
<div id="scrollimg" class="scrollimg">
  <div class="bd">
	 <ul>
	    	<li><a href="#" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> ><img src="/Public/images/563a01ccb5dc9.jpg" title="<?php echo ($v[title]); ?>"width="100%" style="<?php echo ($v[style]); ?>"/></a></li>
	    	<li><a href="#" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> ><img src="/Public/images/563a014600063.jpg" title="<?php echo ($v[title]); ?>"width="100%" style="<?php echo ($v[style]); ?>"/></a></li>
     </ul>
  </div>
  <div class="hd">
	<ul></ul>
  </div>
</div>
<script type="text/javascript">
	TouchSlide({ 
		slideCell:"#scrollimg",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true //自动播放
	});
</script> 

<div class="clalist">
	<div class="col-xs-6">
		<a class="btn btn-default" href="<?php echo U('Index/goodlist');?>" style="float: right;"><span class="glyphicon glyphicon-list"></span></a>
		<p style="float: right;width: 30px; margin-top: 49px;margin-right: -50px;">分类</p>
	</div>
	<div class="col-xs-6">
		<a class="btn btn-default" href="<?php echo U('Index/stats');?>"><span class="glyphicon glyphicon-stats"></span></a>
		<p style="margin-left: 15px;">   排行榜</p>
	</div>
</div>
<div class="product">
	<p style="text-align: center;color:#A8A8A8;margin-top: 10px;"><span>————— </span>产品展示<span> —————</span></p>
	<div class="col-xs-6">
		<img src="/Public/images/jmpic/1442452886830104584.jpg">
		<div class="details">
			<div class="details1">
				<img src="/Public/images/v-shop/logo.png" alt="..." class="img-circle">
				<p>窦骁</p>
			</div>
			<div class="details2">
				<p class="p1">商品名称xxxxxxxxxxxxxxxxxxxxxx</p>
				<span class="span1">￥155.0</span><span class="span2">  123人已购买</span>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<img src="/Public/images/jmpic/1442452784680942491.jpg">
		<div class="details">
			<div class="details1">
				<img src="/Public/images/v-shop/logo.png" alt="..." class="img-circle">
				<p>窦骁</p>
			</div>
			<div class="details2">
				<p class="p1">商品名称xxxxxxxxxxxxxxxxxxxxxx</p>
				<p class="p2"><span class="span1">￥155.0</span><span class="span2">  123人已购买</span></p>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<img src="/Public/images/jmpic/1442452784680942491.jpg">
		<div class="details">
			<div class="details1">
				<img src="/Public/images/v-shop/logo.png" alt="..." class="img-circle">
				<p>窦骁</p>
			</div>
			<div class="details2">
				<p class="p1">商品名称xxxxxxxxxxxxxxxxxxxxxx</p>
				<p class="p2"><span class="span1">￥155.0</span><span class="span2">  123人已购买</span></p>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<img src="/Public/images/jmpic/1442452886830104584.jpg">
		<div class="details">
			<div class="details1">
				<img src="/Public/images/v-shop/logo.png" alt="..." class="img-circle">
				<p>窦骁</p>
			</div>
			<div class="details2">
				<p class="p1">商品名称xxxxxxxxxxxxxxxxxxxxxx</p>
				<p class="p2"><span class="span1">￥155.0</span><span class="span2">  123人已购买</span></p>
			</div>
		</div>
	</div>
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
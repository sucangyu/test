<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>德商-排行榜</title>
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
.listtitle{width:100%;height: 40px; border-bottom:1px solid #b5b5b6;}
.listtitle .listtitlebor{border:1px solid #7d191d;width: 90%;border-radius:5px;margin:8px auto;text-align: center;}
.listtitle .listtitlebor a{width: 24%;text-align: center;border-left:1px solid #7d191d;}
.listtitle .listtitlebor a span{font-size: 10px;}
.listcontent ul li{width: 100%;height: 90px;border-bottom: 1px solid #b5b5b6;}
.listcontent .mation{float: left;margin-top:10px; margin-left: 8px;}
.listcontent .mation li{height: 20px;border:0px;}
.mationnum{float: right;margin-right: 8px;margin-top: 10px;width: 25%; text-align: center;}
.mationnum input{border:1px solid #7d191d; color: #7d191d;}
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
<div class="listtitle">
	<div class="row listtitlebor">
		<a class="col-xs-6 col-md-4" href="" style="width: 28%;border-left:0px solid #000;"><span>按销售额</span></a>
		<a class="col-xs-6 col-md-4" href=""><span>按销量</span></a>
		<a class="col-xs-6 col-md-4" href=""><span>按地区</span></a>
		<a class="col-xs-6 col-md-4" href=""><span>综合分</span></a>
	</div>
</div>
<div class="listcontent">
	<ul>
		<?php $__FOR_START_18388__=1;$__FOR_END_18388__=7;for($i=$__FOR_START_18388__;$i < $__FOR_END_18388__;$i+=1){ ?><li>
				<span style="font-size: 24px;color:#9fa0a0;width: 25px;margin-left: 5px; line-height:90px; float: left;"><?php echo ($i); ?></span>
				<a href="<?php echo U('Index/score');?>">
					<img src="/Public/mobile/img/jiu1.png" class="img-rounded" style="width: 18%;float: left;margin-top:10px">
					<ul class="mation">
						<li>巴黎偶来也沐浴露</li>
						<li>企业名称</li>
						<li>xxxx</li>
					</ul>
					<div class="mationnum">
						<input class="btn btn-default" type="button" value="789923"  />
						<p style="font-size: 12px;color: #">总销售额</p>
					</div>
				</a>
			</li><?php } ?>
	</ul>
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
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>评价</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/index.css"/>
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
.addcon{padding: 10%;}
.evalname{width: 100%;margin-bottom: 10px;}
.evalname img{width: 30%;margin:0 auto;}
.evalname p{font-size: 16px;height: 18px;}
.addcon form{margin-top: 25px;}
.addcon .row{width: 100%; margin:0 auto;font-size: 16px;color: #3e3a39;}
.addcon .row .col-xs-6{width: 50%;height: 25px;line-height: 25px;}
/*星星打分css*/
 h2{text-align:center;margin-top:5em;}
.all>input{opacity:0;position:absolute;width:2em;height:2em;margin:0;cursor:pointer;}
.all>input:nth-of-type(1),
.all>span:nth-of-type(1){display:none;}
.all>span{font-size:1em;color:#7d191d;
 -webkit-transition:color .8s;
 transition:color .8s;
}
.all>input:checked~span{color:#666;}
.all>input:checked+span{color:#7d191d;}

.addcon form textarea{width:100%;height:80px;margin-top: 10%;}
.addcon form .submit{width: 100%;height: 50px;line-height: 50px;color: #fff;background-color: #7d191d;border: 0px;font-size: 16px;}
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
        <ul>
          <li><a href="<?php echo U('/Mobile/User/orderlist');?>" class="tab_head <?php if($_GET[type] == ''): ?>on<?php endif; ?>"  >全部</a></li>
          <li><a href="<?php echo U('/Mobile/User/orderlist',array('type'=>'WAITPAY'));?>"      class="tab_head <?php if($_GET[type] == 'WAITPAY'): ?>on<?php endif; ?>">待付款</a></li>
          <li><a href="<?php echo U('/Mobile/User/orderlist',array('type'=>'WAITSEND'));?>"     class="tab_head <?php if($_GET[type] == 'WAITSEND'): ?>on<?php endif; ?>">待发货</a></li>
          <li><a href="<?php echo U('/Mobile/User/orderlist',array('type'=>'WAITRECEIVE'));?>"  class="tab_head <?php if($_GET[type] == 'WAITRECEIVE'): ?>on<?php endif; ?>">已发货</a></li>
          <li><a href="<?php echo U('/Mobile/User/orderlist',array('type'=>'WAITCCOMMENT'));?>" class="tab_head <?php if($_GET[type] == 'WAITCCOMMENT'): ?>on<?php endif; ?>">待评价</a></li>
        </ul>
     </div>  
     <div class="addcon">
     	<div class="evalname"  align="center">
               <img src="/Public/mobile/img/jiu1.png"  class="img-circle">
               <p style="color: #231815;">公司名称</p>
               <p style="color: #c9caca;">正观堂男袜</p>
               <p>—————<span style="color: #c9caca;"> 匿名评价 </span>—————</p>
          </div>
          <form>
               <div class="row">
                    <div class="col-xs-6 col-sm-3">物流速度</div>
                    <div class="col-xs-6 col-sm-3">
                         <p class="all">
                              <input type="radio" name="b" value="0" checked="checked" />
                              <span>★</span>
                              <input type="radio" name="b" value="1" />
                              <span>★</span>
                              <input type="radio" name="b" value="2" />
                              <span>★</span>
                              <input type="radio" name="b" value="3" />
                              <span>★</span>
                              <input type="radio" name="b" value="4" />
                              <span>★</span>
                              <input type="radio" name="b" value="5" />
                              <span>★</span>
                         </p>    
                    </div>
                    <div class="col-xs-6 col-sm-3">服务态度</div>
                    <div class="col-xs-6 col-sm-3">
                         <p class="all">
                              <input type="radio" name="q" value="0" checked="checked" />
                              <span>★</span>
                              <input type="radio" name="q" value="1" />
                              <span>★</span>
                              <input type="radio" name="q" value="2" />
                              <span>★</span>
                              <input type="radio" name="q" value="3" />
                              <span>★</span>
                              <input type="radio" name="q" value="4" />
                              <span>★</span>
                              <input type="radio" name="q" value="5" />
                              <span>★</span>
                         </p>    
                    </div>
                    <div class="col-xs-6 col-sm-3">商品评分</div>
                    <div class="col-xs-6 col-sm-3">
                         <p class="all">
                              <input type="radio" name="y" value="0" checked="checked" />
                              <span>★</span>
                              <input type="radio" name="y" value="1" />
                              <span>★</span>
                              <input type="radio" name="y" value="2" />
                              <span>★</span>
                              <input type="radio" name="y" value="3" />
                              <span>★</span>
                              <input type="radio" name="y" value="4" />
                              <span>★</span>
                              <input type="radio" name="y" value="5" />
                              <span>★</span>
                         </p>    
                    </div>
               </div>
               <textarea name="x">
               </textarea>
               <input class="submit" type="submit" name="" value="提交评价" />
          </form>
     </div>   
</div>

</body>
</html>
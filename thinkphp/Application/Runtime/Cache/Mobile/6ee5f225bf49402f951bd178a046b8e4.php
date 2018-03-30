<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>添加分享</title>
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
.addsharetop img{width: 100%;}
.addsharecon{width: 100%;background-color: #030000;padding:15px;overflow:auto; zoom:1; color: #fff;font-size: 18px;}
.addsharecon .top{width: 100%;overflow:auto; zoom:1;}
.addsharecon .top img{width: 25%;float: left;border: 2px solid #b5b4b5;}
.addsharecon .top div{width: 66%;float: left;margin-left: 15px;line-height: 24px;}
.addsharecon .Under{margin-top: 15px;width: 100%;}
.addsharecon .Under div{width: 100%;background-color: #fff;padding:10px 15px 10px 15px;color: #d6d6d6;font-size: 16px;}
.addsharegood{margin:0 auto;width: 80%;color: #fff;}
.addsharegood ul li img{width: 250px;}
.addsharegood ul li input{float: left;}
#submit{width:100%;bottom: 0px;height: 45px;background-color: #7d191d;color: #ffffff;text-align: center;line-height: 45px;position: absolute;font-size: 16px;position: fixed;}
</style>
<body style="background-color:#030000; ">

<div class="addsharetop">
     <img src="/Public/mobile/img/sharetop.png">
     <div class="addsharecon">
          <div class="top">
               <img src="/Public/images/v-shop/logo.png" class="img-circle">
               <div>
                    我是xx,正参加20107首届"赢在德商"中小微企业创品牌大赛
               </div>
          </div>
          <div class="Under">
               <p>我承诺</p> 
               <div>
                    我是xx,正参加20107首届"赢在德商"中小微企业创品牌大赛
               </div>
          </div>
     </div>
</div>
<div class="addsharegood">
     <ul>
          <?php $__FOR_START_29650__=1;$__FOR_END_29650__=7;for($i=$__FOR_START_29650__;$i < $__FOR_END_29650__;$i+=1){ ?><li>
               <img src="/Public/images/v-shop/logo.png">
               <input type="radio" name="identity" value="" checked="checked" />选择图片
          </li><?php } ?>
     </ul>
</div>

<div style="margin-bottom: 46px;width: 100%;height: 1px;"></div>
<div id="submit" onclick="submit()">
生成页面
</div>
<script type="text/javascript">
$("#submit").click(function(){
  window.location.href = "<?php echo U('Seller/selshare');?>";
});
</script>
</body>
</html>
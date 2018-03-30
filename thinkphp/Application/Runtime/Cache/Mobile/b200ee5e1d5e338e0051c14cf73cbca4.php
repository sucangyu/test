<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>地址管理</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/index.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile_css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/index.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<script src="/Public/mobile_js/jquery.json.js"></script>
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
<style type="text/css">
.mantop{height: 30px;background-color: #fff;width: 100%;}
.mantop img{margin-top: 25px;width: 100%;}
.mancon{width: 100%;padding:10px 15px 10px 15px;height: 80px;border-bottom: 1px solid #b5b4b5;font-size: 16px;}
.mancon span{width: 15%;float: left;}
.mancon div{width: 60%;float: left;margin-left: 5px;margin-top: 3px;}
.mancon div p{width: 100%;word-break:break-word;line-height: 12px;}
.mancon input{float: right;margin-top: 20px;}
#newadd{width:100%;bottom: 0px;height: 60px;background-color: #7d191d;color: #ffffff;text-align: center;line-height: 60px;position: absolute;font-size: 24px;position: fixed;}
</style>
</head>
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

<div class="mantop">
<img src="/Public/mobile/img/2.png">
</div>
<?php $__FOR_START_7773__=1;$__FOR_END_7773__=8;for($i=$__FOR_START_7773__;$i < $__FOR_END_7773__;$i+=1){ ?><div class="mancon">
		<span>吴晓</span>
		<div>
			<p>1235464</p>  
			<p class="text-left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
		</div>
		<input type="radio" name="identity" value="" checked="checked" />
	</div><?php } ?>
<div style="margin-bottom: 61px;width: 100%;height: 1px;"></div>
<a id="newadd" href="<?php echo U('User/addmanaddress');?>">+新建地址</a>
</body>
</html>
<?php
echo 'hello world!' ;

//phpinfo() ;
?>
<!DOCTYPE html>
<html class="area">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
<title>设置-收货地址</title>
<link rel="stylesheet" href="../css/app.css">
<script src="../js/jquery.js"></script>

<script>
$(function(){
//改变样式同时改变右边的文字
$("span.zdy-icon-radio").click(function(){
$(this).addClass("active").text("默认地址")
.parent().parent().parent().siblings().find("span.zdy-icon-radio").removeClass("active").text("设为默认");
});
})

</script>
<style>
.bjsc-lf span{float: left;}
.bjsc-lf > span:last-child{line-height: 2.1rem;}
.zdy-icon-radio{display:block;width: 30%rem; height: 2.15rem;margin-right: 1rem;padding-left: 3.15rem;line-height: 2.15rem;
font-family:"微软雅黑";float: left;background:url(../img/checkRight.jpg) no-repeat;background-size: 2.1rem 2.1rem;;}
.bjsc-rt{float: right;}
.zdy-icon-radio.active{background: url(../img/checked.png) no-repeat;background-size: 2.1rem 2.1rem;color: #f08417;}
</style>
</head>
<body>
<div class="xp-content02">
<div class="tt02">
编辑地址
</div>
<div class="bianji-dizhi">
<div class="tt09">
<span>15354656536</span>
<span>苏定芳</span>
</div> 
<div class="your-adress02">
南昌市北京东路1999号江西师范科技大学科技园讯升信息技术有限公司
</div>
<div class="bianji-shanchu mui-clearfix">
<div class="bjsc-lf mui-clearfix">
<span class="zdy-icon-radio active">默认地址</span>
</div>
<div class="bjsc-rt">
<span class="mui-icon mui-icon-compose"></span>编辑
<span class="mui-icon mui-icon-trash"></span>删除
</div>
</div>
</div>
<div class="greybg02"></div>
<div class="bianji-dizhi">
<div class="tt09">
<span>15354656536</span>
<span>苏定芳</span>
</div> 
<div class="your-adress02">
南昌市北京东路1999号江西师范科技大学科技园讯升信息技术有限公司
</div>
<div class="bianji-shanchu mui-clearfix">
<div class="bjsc-lf">
<span class="zdy-icon-radio">设为默认</span> 
</div>
<div class="bjsc-rt">
<span class="mui-icon mui-icon-compose"></span>编辑
<span class="mui-icon mui-icon-trash"></span>删除
</div>
</div>
</div>
<div class="greybg02"></div>
<div class="bianji-dizhi">
<div class="tt09">
<span>15354656536</span>
<span>苏定芳</span>
</div> 
<div class="your-adress02">
南昌市北京东路1999号江西师范科技大学科技园讯升信息技术有限公司
</div>
<div class="bianji-shanchu mui-clearfix">
<div class="bjsc-lf">
<span class="zdy-icon-radio">设为默认</span> 
</div>
<div class="bjsc-rt">
<span class="mui-icon mui-icon-compose"></span>编辑
<span class="mui-icon mui-icon-trash"></span>删除
</div>
</div>
</div>
<div class="greybg02"></div>
</body>
</html>

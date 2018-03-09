<?php
$str = '红梅春谢亦源香？';
echo mb_substr($str,0,6).'...';
?>


<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>text-overflow案例在线演示 www.divcss5.com</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<script src="js/jquery-1.8.3.min.js"></script>
<style type="text/css"> 
*{ padding:0; margin:0} 
a{ text-decoration:none;color:#6699ff} 
ul,li{ list-style:none; text-align:left} 
 
#divcss5{border:1px #ff8000 solid; padding:10px; width:150px; 
margin-left:10px; margin-top:10px} 
#divcss5 li{width:150px;height:24px;line-height:24px; font-size:12px; 
color:#6699ff;overflow:hidden;text-overflow:ellipsis; 
border-bottom:1px #ff8000 dashed;} 
#divcss5 li a:hover{ color:#333} 
/* css注释说明：为了便于截图、文章中能排版完整 所以css代码进行换行 不影响功能 */ 
</style> 
</head> 
<body> 
<ul id="divcss5"> 
<li><a href="#"><nobr>&#8226; 显示不完显示省略号，测试内容</nobr></a></li> 
<li><a href="#"><nobr>&#8226; 第二排测试内容超出显示省</nobr></a></li> 
<li><a href="#"><nobr>&#8226; 能显示完几个字</nobr></a></li> 
<a id="Contact" style="margin-left:4%"><em class="bg1"></em>联系客服</a>
<textarea id="g_jingle" name="g_jingle" style="font-size:16px;" placeholder="商品卖点最长不能超过140个汉字"></textarea>
</ul> 
<script>
$("#Contact").on("click",function(){ 
	alert('aaa');
	// var store_id = <%=store_id%>;
	// alert(store_id);
	$.ajax({ 
        type: "POST", 
        data :'cha_id='+store_id,
        async: false, 
        url: ApiUrl+"/index.php?con=member_order&fun=ajax_shop_list",
        success: function(data) {
        	location.href="http://dev.rysd365.com/application/index.php?c=chat&uid="+data;
 
        }

    });
}); 
</script>
</body> 
</html> 
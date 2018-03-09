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
<link rel="stylesheet" type="text/css" href="/Public/mobile/css/LArea.css"/>
<link rel="stylesheet" type="text/css" href="/Public/bootstrap-3.3.7/css/bootstrap.css"/>
<script src="/Public/mobile_js/jquery.js"></script>
<!-- <script src="/Public/mobile/js/LAreaData2.js"></script> -->
<script src="/Public/mobile/js/LArea.js"></script>
<script src="/Public/mobile_js/jquery.json.js"></script>
<script src="/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
<style type="text/css">
.addmantop{width: 100%;height: 55px;border-bottom: 1px solid #b5b4b5;text-align: center;}
.addmantop span{line-height: 55px;font-size: 26px;}
.addmantop a{float: right;margin-right: 15px;line-height: 55px;}
.addmancon ul li{width: 100%;height: 50px;padding:6px 15px 6px 15px;border-bottom: 1px solid #b5b4b5;line-height: 40px;font-size: 20px;color: #898a89;}
.addmancon ul li input{width: 100%;height: 100%;border: 0px;}
.addmancon ul li select{width: 31%;font-size: 12px;height: 35px;margin-top: -15px;}
.default{text-align: center;color: #898a89;font-size: 16px;}
.default input{width: 15px;height: 15px;margin-top: -1px;}
</style>
</head>
<body>
<form>
	<div class="addmantop">
		<span>地址管理</span>
		<a href="" onclick="submit()">保存</a>
	</div>
	<div class="addmancon">
		<ul>
			<li><input type="text" name="" placeholder="姓名"></li>
			<li><input type="text" name="" placeholder="手机号码"></li>
			<!-- <li><span id="demo2">省份、城市、区县</span><input id="value2" type="hidden" /></li> -->
			<li>
				<select id="pre" onchange="chg(this);">
		            <option value="-1">选择省</option>
		            <?php if(is_array($good1)): $i = 0; $__LIST__ = $good1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		        </select>
		        <select id="city" onchange="chg2(this)" ;><option value="-1">选择市</option></select>
		        <select id="area"><option value="-1">选择区</option></select>
			</li>
			<li><input type="text" name="" placeholder="详细地址，街道，楼牌号"></li>
		</ul>
	</div>
	<div class="default">
		<input type="checkbox" id="chk" value="" />设为默认地址
	</div> 
</form>
<script type="text/javascript">
var preEle = document.getElementById("pre");
var cityEle = document.getElementById("city");
var areaEle = document.getElementById("area");
function chg(obj) {
var ss=obj.value; 
//alert(ss);
  $.ajax({
	type: 'POST',
	url: "<?php echo U('Mobile/User/ajaxCityList');?>",
	data:"lid="+ss,
	success: function(data){ 
	console.log(data);
	//var obj=[data];
	//console.log(obj);
	var jnobj=JSON.parse(data);
	console.log(jnobj);
	//console.log(data[0].id);
	  //先清空市
	  cityEle.options.length = 0;
	  areaEle.options.length = 0;
	  for (var i = 0; i < jnobj.length; i++) {
		  //声明option.<option value="pres[i]">Pres[i]</option>
		  var op = new Option(jnobj[i].name, jnobj[i].id);
		  //添加
		  cityEle.options.add(op);
	  }
  
	},
  
  });
  
}
function chg2(obj) {
	var val = obj.value;
	$.ajax({
	type: 'POST',
	url: "<?php echo U('Mobile/User/ajaxCityList');?>",
	data:"lid="+val,
	success: function(aedata){ 
	console.log(aedata);
	var jnobj=JSON.parse(aedata);
	console.log(jnobj);
	  //先清空区
	  areaEle.options.length = 0;
	  for (var i = 0; i < jnobj.length; i++) {
		  //声明option.<option value="pres[i]">Pres[i]</option>
		  var op = new Option(jnobj[i].name, jnobj[i].id);
		  //添加
		  areaEle.options.add(op);
	  }
  
	},
  
  });
}

</script>
</body>
</html>
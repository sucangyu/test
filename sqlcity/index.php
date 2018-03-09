<?php
//session_start(); //开启 session 
header("content-type:text/html;charset=utf-8;");
require_once "dbClassMessage.php";
// $db1 = new dbClassManage('localhost','root','','dsshop');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>pc版三级联动数据源为数据库输出</title>
<!--<script type="text/javascript" src="jquery-1.8.2.min.js"></script>-->
<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
</head>

<body>
省：
        <select style="width: 100px;" id="pre" onchange="chg(this);">
            <option value="-1">请选择</option>
            <?php
                $list = $db->getMoreData("select * from ds_region where parent_id=0");
                var_dump($list);

                for($one=0;$one<count($list);$one++){
                    echo "<option value='".$list[$one]['id']."'>".$list[$one]['name']."</option>";
                }
            ?>
        </select>
        市：
        <select style="width: 100px;" id="city" onchange="chg2(this)" ;></select>
        区：
        <select style="width: 100px;" id="area"></select>
 <script>
//var ss=document.getElementById("pre").value.substring(0,4); 
var preEle = document.getElementById("pre");
var cityEle = document.getElementById("city");
var areaEle = document.getElementById("area");
function chg(obj) {
var ss=obj.value; 
//alert(ss);
  $.ajax({
	type: 'POST',
	url: "ajax.php",
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
	url: "ajax.php",
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
/* $.ajax({  
	  url:"ajax.php",  
	  //url: ApiUrl + "/index.php?con=seller_goods&fun=ajax_goods_class",
	  success: function(data){  
		//console.log(data);
		var objs = JSON.parse(data);
		var pres = objs.provs_data;
		var cities = objs.citys_data;
		var areas = objs.dists_data;
		console.log(pres);
		console.log(cities);
		console.log(areas);
		//arrItemids = new Array(); 
        
            //设置一个省的公共下标
        var pIndex = -1;
        var preEle = document.getElementById("pre");
        var cityEle = document.getElementById("city");
        var areaEle = document.getElementById("area");
         //先设置省的值
        for (var i = 0; i < pres.length; i++) {
            //声明option.<option value="pres[i]">Pres[i]</option>
            var op = new Option(pres[i].name, i);
            //添加
            preEle.options.add(op);
        }
        function chg(obj) {
            if (obj.value == -1) {
                cityEle.options.length = 0;
                areaEle.options.length = 0;
            }
            //获取值
            var val = obj.value;
			//alert(val);
            pIndex = obj.value;
			//alert(pIndex);
            //获取ctiry
            var cs = cities[val];
			preEle.options.add(val);
            //获取默认区
            var as = areas[val][0];
            //先清空市
            cityEle.options.length = 0;
            areaEle.options.length = 0;
            for (var i = 0; i < cs.length; i++) {
                var op = new Option(cs[i].name, i);
                cityEle.options.add(op);
            }
            for (var i = 0; i < as.length; i++) {
                var op = new Option(as[i].name, i);
                areaEle.options.add(op);
            }
        }
        function chg2(obj) {
            var val = obj.selectedIndex;
            var as = areas[pIndex][val];
            areaEle.options.length = 0;
            for (var i = 0; i < as.length; i++) {
                var op = new Option(as[i].name, i);
                areaEle.options.add(op);
            }
        }
		
		
	}  
}); 
*/

/* //声明省
        var pres = ["北京", "上海", "山东", "山东2", "山东3", "山东4", "山东5"]; //直接声明Array
         //声明市
        var cities = [
            ["东城", "昌平", "海淀"],
            ["浦东", "高区"],
            ["济南", "青岛"],
			["济南2", "青岛2"],
			["济南3", "青岛3"],
			["济南4", "青岛4"],
			["济南5", "青岛5"]
        ];
        var areas = [
                [
                    ["东城1", "东城2", "东城3"],
                    ["昌平1", "昌平2", "昌平3"],
                    ["海淀1", "海淀2", "海淀3"]
                ],
                [
                    ["浦东1", "浦东2", "浦东3"],
                    ["高区1", "高区2", "高区3"]
                ],
                [
                    ["济南1", "济南2"],
                    ["青岛1", "青岛2"]
                ],
				[
                    ["济南3", "济南4"],
                    ["青岛3", "青岛4"]
                ],
				[
                    ["济南31", "济南32"],
                    ["青岛41", "青岛42"]
                ],
				[
                    ["济南51", "济南52"],
                    ["青岛62", "青岛62"]
                ],
				[
                    ["济南71", "济南72"],
                    ["青岛82", "青岛81"]
                ]
				
            ]
            //设置一个省的公共下标
        var pIndex = -1;
        var preEle = document.getElementById("pre");
        var cityEle = document.getElementById("city");
        var areaEle = document.getElementById("area");
         //先设置省的值
        for (var i = 0; i < pres.length; i++) {
            //声明option.<option value="pres[i]">Pres[i]</option>
            var op = new Option(pres[i].name, i);
            //添加
            preEle.options.add(op);
        }
        function chg(obj) {
            if (obj.value == -1) {
                cityEle.options.length = 0;
                areaEle.options.length = 0;
            }
            //获取值
            var val = obj.value;
            pIndex = obj.value;
			console.log(val);
			console.log('aa');
            //获取ctiry
            var cs = cities[val];
			console.log(cs);
            //获取默认区
            var as = areas[val][0];
            //先清空市
            cityEle.options.length = 0;
            areaEle.options.length = 0;
            for (var i = 0; i < cs.length; i++) {
                var op = new Option(cs[i].name, i);
                cityEle.options.add(op);
            }
            for (var i = 0; i < as.length; i++) {
                var op = new Option(as[i].name, i);
                areaEle.options.add(op);
            }
        }
        function chg2(obj) {
            var val = obj.selectedIndex;
            var as = areas[pIndex][val];
            areaEle.options.length = 0;
            for (var i = 0; i < as.length; i++) {
                var op = new Option(as[i].name, i);
                areaEle.options.add(op);
            }
        }
*/    </script>

</body>
</html>
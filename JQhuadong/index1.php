<!DOCTYPE HTML>
<html>

<head>
<meta charset="UTF-8">
<title>swiper手机端左右滑动</title>

<link rel="stylesheet" type="text/css" href="css/swiper.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="cityjson"></script>
<script src="js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery-1.11.2.min.js" type="text/javascript" charset="utf-8"></script>

<style type="text/css">
/*头部滑动css*/

#swiper-container {width: 840px;height: 280px;margin: 10px auto;}
#swiper-container .swiper-slide {color: #fff;box-sizing: border-box;border-radius: 5px;text-align: center;font-family: "微软雅黑";}
#swiper-container .swiper-slide .local {font-size: 16px;font-weight: bolder;}
#swiper-container .swiper-slide .date {margin-left: 10px;font-size: 14px;}
#swiper-container .swiper-slide .wp {position: relative;height: 35px;line-height: 35px;}
#swiper-container .swiper-slide .currTemp {font-size: 28px;position: absolute;left: 105px;}
#swiper-container .swiper-slide .currTempLable {font-size: 12px;position: absolute;left: 143px;line-height: 15px;top: 10px;}
#swiper-container .swiper-slide .weather {font-size: 12px;position: absolute;left: 145px;top: 25px;line-height: 15px;}
#swiper-container .swiper-slide .tips {font-size: 12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin-top: 10px;}
.swiper-slide .p1{padding: 5px 4%;font-size: 14px;width: 100%;overflow: auto;margin-top: 10px;}
.swiper-slide .p1 .col-md-6{width: 50%;display: block;float: left;}

/*数字滚动插件的CSS可调整样式*/
.mt-number-animate{ font-family: '微软雅黑'; line-height:15px; height: 15px;/*设置数字显示高度*/; font-size: 12px;/*设置数字大小*/ overflow: hidden; display: inline-block; position: relative; color: #EE7600;}
.mt-number-animate .mt-number-animate-dot{ width: 5px;/*设置分割符宽度*/ line-height: 15px; float: left; text-align: center;}
.mt-number-animate .mt-number-animate-dom{ width: 10px;/*设置单个数字宽度*/ text-align: center; float: left; position: relative; top: 2px;}
.mt-number-animate .mt-number-animate-dom .mt-number-animate-span{ width: 100%; float: left;}

.headfixed{width: 100%;position: fixed;top: 0px;height: 50px;background: rgba(255,255,255,0.5);box-shadow: 5px 5px 3px #F5F5F5;}
.headfixed .col-xs-6{width: 25%;text-align: center;line-height: 50px;color: #474747;}
</style>
<script src="js/radialindicator.js"></script>
<script src="js/numberAnimate.js"></script>
<script>
//头部滑动js
var date = 0;
function time(){
	$(function(){
		$.ajax({
			type : "POST",
		    url:"ajax.php",
		    data:{'action':1},
		    success: function(data)
		    {
		    	console.log(data);
				var jnobj=JSON.parse(data);
				//console.log(jnobj);
				var nowDate = jnobj.time;
				var existing=jnobj.existing;
				var number=jnobj.total;
				
    			//var nums2 = 15343242;
				//var date = date++;
    			dates = date++;
    			if (dates>0) {
    				$(".swiper-wrapper").empty();
    			}
				//console.log(dates);
				var txtl = '<div class="swiper-slide" style="background: #fff;color:#6E6E6E;">'
					+ '<h5><span class="local">大病数据</h5>'
					+ '<p><span class="sp1"></span>   <span>' +existing + '</span></p>'
					+ '<p><span class="sp2"></span>   <span>' +existing + '</span></p>'
					+ '<p><span class="sp3"></span>   <span>' +existing + '</span></p>'
					+ '</div>';
				var txtc = '<div class="swiper-slide" style="background: #fff;color:#6E6E6E;">'
					//+ '<span class="pm">空气质量: ' + pm25 + '</span>'
					+ '<h5><span class="local">当&nbsp;前&nbsp;爱&nbsp;心&nbsp;程&nbsp;度</h5>'
					//+ '<img src="' + o.dayPictureUrl + '" />'
					//+ currTemp
					+ '<div class="prg-cont rad-prg" id="indicatorContainer2"></div>'
					+ '<p class="p1"><span class="col-md-6 numberRun2">' + existing +'</span><span class="col-md-6 numberRun1">' +number + '</span><span class="col-md-6">今日累计筹款额</span><span class="col-md-6">今日预计筹款额</span></p>'
					+ '<p class="tips">' + nowDate + '</p>'
					+ '</div>';
				var txtr = '<div class="swiper-slide" style="background: #fff;color:#6E6E6E;">'
					+ '<h5><span class="local">今日爱心大数据</h5>'
					+ '<p><span class="sp1"></span>   <span>' +number + '</span></p>'
					+ '<p><span class="sp2"></span>   <span>' +number + '</span></p>'
					+ '<p><span class="sp3"></span>   <span>' +number + '</span></p>'
					+ '</div>';
				//$("#swiper-container").empty();
				$(txtl).appendTo($(".swiper-wrapper"));
				$(txtc).appendTo($(".swiper-wrapper"));
				$(txtr).appendTo($(".swiper-wrapper"));
				var mySwiper = new Swiper('#swiper-container', {
					grabCursor: true,
					slidesPerView: 2,
					effect: "coverflow",
					centeredSlides: true,
					initialSlide: 1,
				});
				//圆形进度条js
				var num =  Math.round(existing/number * 10000)/100;
				//console.log(num);
				var remaining = 100-num;
				    $('#indicatorContainer2').radialIndicator({
				        barColor: '#EE9A00',
				        barWidth: 10,
				        initValue: num,
				        roundCorner: true,
				        percentage: true
				    });
				var radialObj = $('#indicatorContainer2').data('radialIndicator');
				//radialObj.animate(remaining);
				//数字翻滚js
				var numRun2 = $(".numberRun2").numberAnimate({num:existing, speed:2000, symbol:","});
				var numRun1 = $(".numberRun1").numberAnimate({num:number, speed:2000, symbol:","});
			}	
		});

		
	});
//setTimeout("time()", 10000);
}
time();
</script>

</head>
<body style="background: #F5F5F5;">
<div class="headfixed">
	<a href=""><div class="col-xs-6">发起救助</div></a>
	<a href=""><div class="col-xs-6">轻松公益</div></a>
	<a href=""><div class="col-xs-6">轻松互助</div></a>
	<a href=""><div class="col-xs-6">梦想清单</div></a>
</div>
<div style="width: 100%;height: 50px;"></div>
<!-- 头部滑动 -->
<div class="swiper-container" id="swiper-container">
	<div class="swiper-wrapper">
	</div>
</div>

<div class="demo">
<?php 
$test=array(1,2,3,4,5);
shuffle($test); 
for($i=0 ;$i< count($test);$i++){ ?>
	<div class="progress" >
		<div class="progress-bar" style="width: <?php echo $test[$i]*10; ?>%; background:#228B22;">
			<span><?php echo $test[$i]*10; ?>%</span>
		</div>
	</div>
<?php }?>
</div>   
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JQ长按响应事件</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="JQhuadong/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/layer/layer-min.js"></script>

    <style type="text/css">
        .div-none{display: none;}
        .div-show{display: block;}
    </style>
</head>
<body>

<div class="container">

<!--    长按响应-->
    <?php for ($i=0;$i<10;$i++){?>
    <div id="mydiv" class="divs" style="width:100%; height:50px; background:#ddd;margin-top: 20px;" data-id="<?php echo $i?>">
        长按<?php echo $i?>
        <div class="div-none" id="show<?php echo $i?>">显示内容<?php echo $i?></div>
    </div>
    <?php }?>
</body>
</html>

<script>
    /*设置一个长按的计时器，如果点击这个图层超过2秒则触发，mydiv里面的文字从out变in的动作*/

    var self = this;
    var longClick =0;
    $(".divs").on({
        touchstart: function(e){
            var id= $(this).data("id");
            longClick=0;//设置初始为0
            timeOutEvent = setTimeout(function(){
                //此处为长按事件-----在此显示遮罩层及删除按钮
                longClick=1;//假如长按，则设置为1
                var msg = "您确定要这么做吗?显示内容"+id;
                //询问框
                layer.confirm(msg, {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    location.href = "xx/xx/x/"+id;
                }, function () {
                    layer.closeAll();//取消按钮
                });
            },500);
        },
        touchmove: function(){
            clearTimeout(timeOutEvent);
            timeOutEvent = 0;
            e.preventDefault();
        },
        touchend: function(e){
            clearTimeout(timeOutEvent);
            if(timeOutEvent!=0 && longClick==0){//点击
                //此处为点击事件----在此处添加跳转详情页
            }
            return false;
        }
    });




</script>
</body>

</html>

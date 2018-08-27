<?php
function getIp()
{
    $IPaddress='';
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
            $IPaddress = getenv("REMOTE_ADDR");
        }
    }
    return $IPaddress;
}
$myIp =  getIp();//就可以输出用户的IP地址。


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>个人MD5&&unix&&bse64&&ip转换查询工具</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="JQhuadong/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>

    <style type="text/css">
        #form1{margin-top: 20px;}
        #form1 .table{display: none;}
        .table .back{background: #E6E6E6;}
        #form2,#form4{background: #f3f5f9;width: 100%;overflow: auto;margin-top: 20px;}
        #form2 .unixs{width: 100%;border-bottom: 1px #bbbbbb solid;padding: 20px;}
        #form2 .unixs .utspan{display: inline-block;padding: 5px;border: #E6E6E6 1px solid;}
        #currentunixtime{color: red;}
        #form3{background: #E6E6E6;width: 100%;overflow: auto;margin-top: 20px;margin-bottom: 20px;}
        #form3 .bases{width: 100%;height: auto;border-top: 20px;}
        #form3 .bases .textareas{width: 100%;height: 100px;}
        #form3 .bases .base-span{display: inline-block;border: 1px #1d75b3 solid;border-radius: 5px;padding: 3px;}
        .base-img{width: 96%;padding: 10px;border-radius: 5px;background: #f3f5f9;margin: 10px auto;}
        #upimg{width: auto;display: inline-block;}
        .right{border: 1px #bbbbbb solid;border-radius: 3px;padding: 3px;float: right;}
        .sp-ilk{display: inline-block;}
        #form4 .img{font-size: 36px;padding: 5px;background: #00a65a;}
    </style>
</head>
<body>

<div class="container">
<!--    md5-->
    <div id="form1">
        <h2>转md5()</h2>
        <form class="form-inline" >
            <div class="form-group">
                <input type="text" class="form-control" id="input1" placeholder="转md5()">
            </div>
            <span class="btn btn-default" id="sb-md5">转</span>
        </form>
        <table class="table table-bordered table-hover">
            <tr>
                <td class="back">字符串</td>
                <td id="oldstring"></td>
            </tr>
            <tr>
                <td class="back">16位小写</td>
                <td id="x16"></td>
            </tr>
            <tr>
                <td class="back">16位大写</td>
                <td id="d16"></td>
            </tr>
            <tr>
                <td class="back">32位小写</td>
                <td id="x32"></td>
            </tr>
            <tr>
                <td class="back">32位大写</td>
                <td id="d32"></td>
            </tr>
        </table>
    </div>
    <script>
        $("#sb-md5").click(function () {
            var string = $("#input1").val();
            $.ajax({
                type: 'POST',
                url: "turnAjax.php",
                data:{"md5String":string,"type":'md5S'},
                success: function(data){
                    $(".table").css('display','block');
                    // console.log(data);
                    var jnobj=JSON.parse(data);
                    // console.log(jnobj);
                    $("#oldstring").html(string);
                    $("#x16").html(jnobj.x16);
                    $("#d16").html(jnobj.d16);
                    $("#x32").html(jnobj.x32);
                    $("#d32").html(jnobj.d32);

                },
            });
        });
    </script>
<!--    unix时间戳-->
    <div id="form2">
        <h2>unix时间戳转换</h2>
        <div id="unix1" class="unixs">
            现在的Unix时间戳(Unix timestamp(毫秒))是：
            <span class="utspan" id="currentunixtime"></span>
            <sapn class="utspan" id="start">开始</sapn>
            <sapn class="utspan" id="stop">停止</sapn>
            <sapn class="utspan" id="refresh">刷新</sapn>
        </div>
        <div id="unix2" class="unixs">
            Unix时间戳（Unix timestamp(秒)）
            <input id="firstTimestamp" value="">
            <span id="unixtoutc8" class="utspan">转成北京时间</span>
            <input id="unixtoutc8result" readonly>
        </div>
        <div id="unix3" class="unixs">
            北京时间（年-月-日 时:分:秒）
            <input id="utc8" value="">
            <span id="utc8tounix1" class="utspan">转成unix时间戳</span>
            <input id="unixtoutc8result1" readonly>
        </div>
    </div>
    <script>
        var nowtime = new Date().getTime();
        var nowtimeS = Date.parse(new Date());
        nowtimeS = nowtimeS.toString();//转为字符串类型
        nowtimeS = nowtimeS.substring(0,10);//截取前10位
        $('#firstTimestamp').val(nowtimeS);
        $('#currentunixtime').html(nowtime);
        //unix1当前时间戳
        function func(){
            var nowtime = new Date().getTime();
            $('#currentunixtime').html(nowtime);
        } //定时任务
        var interval = setInterval(func, 1000); //启动,func不能使用括号

        $("#refresh").click(function () {
            $('#currentunixtime').html(nowtime);//刷新
        });
        $("#stop").click(function () {
            clearInterval(interval );//停止
        });
        $("#start").click(function () {
            interval = setInterval(func, 1000); //重新启动即可
        });
        //unix2时间戳转北京时间
        function timestampToTime(timestamp) {
            var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
            var Y = date.getFullYear() + '-';
            var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
            var D = date.getDate() + ' ';
            var h = date.getHours() + ':';
            var m = date.getMinutes() + ':';
            var s = date.getSeconds();
            return Y+M+D+h+m+s;
        }
        $("#unixtoutc8").click(function () {
            var unix2 = $('#firstTimestamp').val();
            var result = timestampToTime(unix2);
            $('#unixtoutc8result').val(result);
        });

        //unix3北京时间转时间戳
        $("#utc8tounix1").click(function () {
            var unix3 = $('#utc8').val();
            var date = new Date(unix3);
            var result = date.getTime();
            $('#unixtoutc8result1').val(result);
        });
    </script>
<!--    base64文字和图片互转-->
    <div id="form3">
        <h2>base64文字和图片互转</h2>
        <h4>字符编码</h4>
        <div id="base1" class="bases">
            <p>
                请输入要进行编码或解码的字符：
            </p>
            <textarea class="textareas" id="src"></textarea>
            <p>
                <span class="base-span" id="encode">编码</span>
                <span class="base-span" id="decode">解码</span>
                <span class="base-span" id="coderemot">清空</span>
            </p>
            <textarea class="textareas" id="dest"></textarea>
        </div>
        <h4>图片互转</h4>
        <div id="base2" class="bases">
            <p>
                <input type="file" accept="image/*" value="点击这里选择选择要转换成Base64的图片" id="upimg" >
<!--                <sapn class="right" id="copy_input">复制</sapn>-->
                <sapn class="right" id="coderemot1">清空</sapn>
            </p>
            <textarea class="textareas" id="uploadFile"></textarea>
            <p id="scimg">还原生成的base编码为图片</p>
            <div class="base-img">
                <img src="" id="base">
            </div>
        </div>
    </div>
    <script>
        //1.文字加密
        $("#encode").click(function () {
            var str=$("#src").val();
            $.ajax({
                type: 'POST',
                url: "turnAjax.php",
                data:{"baseString":str,"type":'baseE'},
                success: function(data){
                    // console.log(data);
                    $("#dest").val(data);

                },
            });
        });
        //2.文字解密
        $("#decode").click(function () {
            var words  = $("#src").val();
            $.ajax({
                type: 'POST',
                url: "turnAjax.php",
                data:{"baseString":words,"type":'baseD'},
                success: function(data){
                    // console.log(data);
                    $("#dest").val(data);

                },
            });
        });
        //文字清空
        $("#coderemot").click(function () {
            $("#src").val('');
            $("#dest").val('');
        });
        //图片转编码
        $(function() {
            // 前端只需要给input file绑定这个change事件即可（下面两个方法不需要修改）获取到图片
            $('#upimg').bind('change', function (event) {
                var imageUrl = getObjectURL($(this)[0].files[0]);
                convertImgToBase64(imageUrl, function (base64Img) {

                    //base64Img为转好的base64,放在img src直接前台展示(<img src="data:image/jpg;base64,/9j/4QMZRXh...." />)
                    //alert(base64Img);
                    $("#base").attr("src", imageUrl);
                    //base64转图片不需要base64的前缀data:image/jpg;base64
                    //alert(base64Img.split(",")[1]);
                    $("#uploadFile").val(base64Img.split(",")[1]);
                });
                event.preventDefault();
            });

            //生成图片的base64编码
            function convertImgToBase64(url, callback, outputFormat) {
                //html5 的convas画布
                var canvas = document.createElement('CANVAS');
                var ctx = canvas.getContext('2d');
                var img = new Image;
                img.crossOrigin = 'Anonymous';
                img.onload = function () {
                    var width = img.width;
                    var height = img.height;
                    // 按比例压缩4倍
                    //var rate = (width<height ? width/height : height/width)/4;
                    //原比例生成画布图片
                    var rate = 1;
                    canvas.width = width * rate;
                    canvas.height = height * rate;
                    ctx.drawImage(img, 0, 0, width, height, 0, 0, width * rate, height * rate);
                    // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
                    var dataURL = canvas.toDataURL(outputFormat || 'image/png');
                    callback.call(this, dataURL);
                    canvas = null;
                };
                img.src = url;
            }
            //createobjecturl()静态方法创建一个包含了DOMString代表参数对象的URL。该url的声明周期是在该窗口中.也就是说创建浏览器创建了一个代表该图片的Url.
            function getObjectURL(file) {
                var url = null;
                if (window.createObjectURL != undefined) {
                    // basic
                    url = window.createObjectURL(file);
                } else if (window.URL != undefined) {
                    // mozilla(firefox)
                    url = window.URL.createObjectURL(file);
                } else if (window.webkitURL != undefined) {
                    //web_kit or chrome
                    url = window.webkitURL.createObjectURL(file);
                }
                return url;
            }
        });
        //编码生成img
        $("#scimg").click(function () {
            // console.log('进来了');
            var base64Img = $("#uploadFile").val();
            // console.log(base64Img);
            $("#base").attr("src", base64Img);
        });
        //图片清空
        $("#coderemot1").click(function () {
            $("#uploadFile").val('');
            $("#base").attr("src", '');
        });
    </script>
<!--    ip地址查询-->
    <div id="form4">
        <h2>ip地址查询</h2>
        <div>
            <span class="sp-ilk img">IP</span>
            <span class="sp-ilk">本机IP:<?php echo $myIp;?></span>
        </div>
    </div>
</div>
<div style="width: 100%;height: 60px;"></div>
</body>

</html>

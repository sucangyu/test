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
        #form4 .img{font-size: 36px;padding:0px 10px;background: #00a65a;}
        nav{width: 100%;height: 50px;border-bottom: 1px #bbbbbb solid;font-size: 16px;}
        nav .nav-sp{display: inline-block;padding: 10px;line-height: 30px;}
        nav .nav-sp:hover{cursor:pointer;}
        nav .active{color: #00a65a;border-bottom: #00a65a solid 1px;}
        .div-none{display: none;}
        .div-show{display: block;}
        #form5  button {font-size: 18px;font-weight: bold;width: 90px;}
    </style>
</head>
<body>

<div class="container">
    <nav>
        <span class="nav-sp active" data-id="1">转md5</span>
        <span class="nav-sp" data-id="2">unix时间戳互转</span>
        <span class="nav-sp" data-id="3">base64文字和图片互转</span>
        <span class="nav-sp" data-id="4">ip地址查询</span>
        <span class="nav-sp" data-id="5">计算器</span>
    </nav>
    <script>
        $(".nav-sp").click(function () {
            var id = $(this).data("id");
            $(".nav-sp").removeClass("active");
            $(this).addClass("active");
            $(".div-none").removeClass("div-show");
            $("#form"+id).addClass("div-show");
        });
    </script>
<!--    md5-->
    <div class="div-none div-show" id="form1">
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
    <div class="div-none" id="form2">
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
    <div class="div-none" id="form3">
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
    <div class="div-none" id="form4">
        <h2>ip地址查询</h2>
        <div>
            <span class="sp-ilk img">IP</span>
            <span class="sp-ilk my-ipadd" ></span>
        </div>
        <div style="margin-top: 10px;">
            <input type="text" id="op-ip-input">
            <span id="cxip">查询</span>
            <p id="show-ip"></p>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            // 更新商品价格
            var ip = '115.199.215.46';//可以为空
            ajaxIP(ip,0);
        });
        $("#cxip").click(function () {
            $("#show-ip").html('');
            var ip = $("#op-ip-input").val();
            ajaxIP(ip,1);
        });
        function ajaxIP(ip,type) {
            $.ajax({
                type: 'POST',
                url: "turnAjax.php",
                data:{"ipString":ip,"type":'ipS'},
                success: function(data){
                    // console.log(data);
                    var jnobj=JSON.parse(data);
                    if (type==0){
                        var html = "本机IP:"+jnobj.data.ip+"  "+jnobj.data.region+jnobj.data.city+"  "+jnobj.data.isp;
                        $(".my-ipadd").html(html);
                    } else{
                        var html = jnobj.data.ip+"来自:"+jnobj.data.region+jnobj.data.city+"  "+jnobj.data.isp;
                        $("#show-ip").html(html);
                    }

                },
            });
        };
    </script>
<!--    计算器-->
    <div class="div-none" id="form5">
        <h2>计算器</h2>
        <table>
            <tr>
                <td colspan="4">
                    <div id="jieguo"
                         style="width: 370px;height: 30px;font-size: 30px;text-align: right;font-weight:bold;color: red;">0</div>
                </td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="cunChu">存储(F1)</button></td>
                <td>
                    <button id="quCun">取存(F2)</button></td>
                <td>
                    <button id="tuiGe">&nbsp;退&nbsp;格&nbsp;</button></td>
                <td>
                    <button id="qingPing">&nbsp;清&nbsp;屏&nbsp;</button></td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="leiCun">累存(F3)</button></td>
                <td>
                    <button id="jiCun">积存(F4)</button></td>
                <td>
                    <button id="qingCun">清存(F6)</button></td>
                <td>
                    <button id="Chuyi" class="yunSuan" name="4">&nbsp;&nbsp;÷&nbsp;&nbsp;</button>
                </td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="seven" class="number" name="7">&nbsp;&nbsp;7&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="eight" class="number" name="8">&nbsp;&nbsp;8&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="nine" class="number" name="9">&nbsp;&nbsp;9&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="chengYi" class="yunSuan" name="3">&nbsp;&nbsp;×&nbsp;&nbsp;</button>
                </td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="four" class="number" name="4">&nbsp;&nbsp;4&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="five" class="number" name="5">&nbsp;&nbsp;5&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="six" class="number" name="6">&nbsp;&nbsp;6&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="jianQu" class="yunSuan" name="2">&nbsp;&nbsp;-&nbsp;&nbsp;</button>
                </td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="one" class="number" name="1">&nbsp;&nbsp;1&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="two" class="number" name="2">&nbsp;&nbsp;2&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="three" class="number" name="3">&nbsp;&nbsp;3&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="jiaShang" class="yunSuan" name="1">&nbsp;&nbsp;+&nbsp;&nbsp;</button>
                </td>
            </tr>
            <tr style="height: 40px;">
                <td>
                    <button id="zero" class="number" name="0">&nbsp;&nbsp;0&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="dian" class="number" name=".">&nbsp;&nbsp;.&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="zhengFu" class="number" name="-1">&nbsp;&nbsp;+/-&nbsp;&nbsp;</button>
                </td>
                <td>
                    <button id="dengYu">&nbsp;&nbsp;=&nbsp;&nbsp;</button></td>
            </tr>
        </table>
    </div>
    <script>
        var yunSuan = 0;// 运算符号，0-无运算;1-加法;2-减法;3-乘法;4-除法
        var change = 0;// 属于运算符后需要清空上一数值
        var num1 = 0;// 运算第一个数据
        var num2 = 0;// 运算第二个数据
        var cunChuValue = 0;// 存储的数值
        $(function() {
            // 点击数字触发事件
            $(".number").click(function() {
                var num = $(this).attr('name');
                var oldValue = $("#jieguo").html();
                if (change == 1) {
                    oldValue = "0";
                    change = 0;
                }
                var newValue = "";
                if (num == -1) {
                    oldValue = parseFloat(oldValue);
                    newValue = oldValue * -1;
                } else if (num == ".") {
                    if (oldValue.indexOf('.') == -1)
                        newValue = oldValue + ".";
                    else
                        newValue = oldValue;
                } else {
                    if (oldValue == 0 && oldValue.indexOf('.') == -1) {
                        newValue = num;
                    } else {
                        newValue = oldValue + num;
                    }
                }
                $("#jieguo").html(newValue);
            });
            // 点击清屏触发事件
            $("#qingPing").click(function() {
                $("#jieguo").html("0");
                yunSuan = 0;
                change = 0;
                num1 = 0;
                num2 = 0;
            });
            // 点击退格触发事件
            $("#tuiGe").click(function() {
                if (change == 1) {
                    yunSuan = 0;
                    change = 0;
                }
                var value = $("#jieguo").html();
                if (value.length == 1) {
                    $("#jieguo").html("0");
                } else {
                    value = value.substr(0, value.length - 1);
                    $("#jieguo").html(value);
                }
            });
            // 点击运算符号触发事件
            $(".yunSuan").click(function() {
                change = 1;
                yuSuan = $(this).attr('name');
                var value = $("#jieguo").html();
                var dianIndex = value.indexOf(".");
                if (dianIndex == value.length) {
                    value = value.substr(0, value.length - 1);
                }
                num1 = parseFloat(value);
            });
            // 点击等于符号触发事件
            $("#dengYu").click(function() {
                var value = $("#jieguo").html();
                var dianIndex = value.indexOf(".");
                if (dianIndex == value.length) {
                    value = value.substr(0, value.length - 1);
                }
                num2 = parseFloat(value);
                var sum = 0;
                if (yuSuan == 1) {
                    sum = num1 + num2;
                } else if (yuSuan == 2) {
                    sum = num1 - num2;
                } else if (yuSuan == 3) {
                    sum = num1 * num2;
                } else if (yuSuan == 4) {
                    sum = num1 / num2;
                } else if (yuSuan == 0 || num1 == 0 || num2 == 0) {
                    sum = num1 + num2;
                }
                var re = /^[0-9]+.?[0-9]*$/;
                if (re.test(sum)) {
                    sum = sum.toFixed(2);
                }
                $("#jieguo").html(sum);
                change = 1;
                yuSuan = 0;
                num1 = 0;
                num2 = 0;
            });
            // 点击存储触发事件
            $("#cunChu").click(function() {
                change = 1;
                var value = $("#jieguo").html();
                var dianIndex = value.indexOf(".");
                if (dianIndex == value.length) {
                    value = value.substr(0, value.length - 1);
                }
                cunChuValue = parseFloat(value);
            });
            // 点击取存触发事件
            $("#quCun").click(function() {
                change = 1;
                $("#jieguo").html(cunChuValue);
            });
            // 点击清存触发事件
            $("#qingCun").click(function() {
                change = 1;
                cunChuValue = 0;
            });
            // 点击累存触发事件
            $("#leiCun").click(function() {
                change = 1;
                var value = $("#jieguo").html();
                var dianIndex = value.indexOf(".");
                if (dianIndex == value.length) {
                    value = value.substr(0, value.length - 1);
                }
                cunChuValue += parseFloat(value);
            });
            // 点击积存触发事件
            $("#jiCun").click(function() {
                change = 1;
                var value = $("#jieguo").html();
                var dianIndex = value.indexOf(".");
                if (dianIndex == value.length) {
                    value = value.substr(0, value.length - 1);
                }
                if (cunChuValue == 0) {
                    cunChuValue = parseFloat(value);
                } else {
                    cunChuValue = cunChuValue * parseFloat(value);
                }
            });
        });

        // 按键监听
        $(document)
            .keydown(
                function(event) {
                    // 数字监听
                    if (((event.keyCode > 47 && event.keyCode < 58)
                        || (event.keyCode > 95 && event.keyCode < 106) || (event.keyCode == 190 || event.keyCode == 110))
                        && !event.shiftKey) {
                        keyDownNum(event.keyCode);
                    }
                    // "+"监听
                    if ((event.keyCode == 187 && event.shiftKey)
                        || event.keyCode == 107) {
                        keyDownYuSuan(1);
                    }
                    // "-"监听
                    if ((event.keyCode == 189 && event.shiftKey)
                        || event.keyCode == 109) {
                        keyDownYuSuan(2);
                    }
                    // "*"监听
                    if ((event.keyCode == 56 && event.shiftKey)
                        || event.keyCode == 106) {
                        keyDownYuSuan(3);
                    }
                    // "/"监听
                    if (event.keyCode == 191 || event.keyCode == 111) {
                        keyDownYuSuan(4);
                    }
                    // "="监听
                    if ((event.keyCode == 187 && !event.shiftKey)
                        || event.keyCode == 13 || event.keyCode == 108) {
                        $("#dengYu").click();
                    }

                    // "回退"监听
                    if (event.keyCode == 8) {
                        $("#tuiGe").click();
                        return false;
                    }

                    // "清屏"监听
                    if (event.keyCode == 27 || event.keyCode == 46
                        || (event.keyCode == 110 && event.shiftKey)) {
                        $("#qingPing").click();
                        return false;
                    }

                    // "存储"监听
                    if (event.keyCode == 112) {
                        $("#cunChu").click();
                        return false;
                    }

                    // "取存"监听
                    if (event.keyCode == 113) {
                        $("#quCun").click();
                        return false;
                    }

                    // "累存"监听
                    if (event.keyCode == 114) {
                        $("#leiCun").click();
                        return false;
                    }

                    // "积存"监听
                    if (event.keyCode == 115) {
                        $("#jiCun").click();
                        return false;
                    }

                    // "清存"监听
                    if (event.keyCode == 117) {
                        $("#qingCun").click();
                        return false;
                    }
                });

        /**
         * 按键触发运算符 value 1-'+' 2-'-' 3-'*' 4-'/'
         */
        function keyDownYuSuan(value) {
            change = 1;
            yuSuan = value;
            var value = $("#jieguo").html();
            var dianIndex = value.indexOf(".");
            if (dianIndex == value.length) {
                value = value.substr(0, value.length - 1);
            }
            num1 = parseFloat(value);
        }

        /**
         * 按键触发数字 code ASCLL码
         */
        function keyDownNum(code) {
            var number = 0;
            if (code == 48 || code == 96) {// "0"监听
                number = 0;
            }
            if (code == 49 || code == 97) {// "1"监听
                number = 1;
            }
            if (code == 50 || code == 98) {// "2"监听
                number = 2;
            }
            if (code == 51 || code == 99) {// "3"监听
                number = 3;
            }
            if (code == 52 || code == 100) {// "4"监听
                number = 4;
            }
            if (code == 53 || code == 101) {// "5"监听
                number = 5;
            }
            if (code == 54 || code == 102) {// "6"监听
                number = 6;
            }
            if (code == 55 || code == 103) {// "7"监听
                number = 7;
            }
            if (code == 56 || code == 104) {// "8"监听
                number = 8;
            }
            if (code == 57 || code == 105) {// "9"监听
                number = 9;
            }
            if (code == 190 || code == 110) {// "."监听
                number = ".";
            }
            var num = number;
            var oldValue = $("#jieguo").html();
            if (change == 1) {
                oldValue = "0";
                change = 0;
            }
            var newValue = "";
            if (num == -1) {
                oldValue = parseFloat(oldValue);
                newValue = oldValue * -1;
            } else if (num == ".") {
                if (oldValue.indexOf('.') == -1)
                    newValue = oldValue + ".";
                else
                    newValue = oldValue;
            } else {
                if (oldValue == 0 && oldValue.indexOf('.') == -1) {
                    newValue = num;
                } else {
                    newValue = oldValue + num;
                }
            }
            $("#jieguo").html(newValue);
        }
    </script>
</div>
<div style="width: 100%;height: 60px;"></div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文字识别</title>
    <link rel="stylesheet" href="/public/assets/css/amazeui.min.css" />
    <link rel="stylesheet" href="/public/assets/css/admin.css">
    <link rel="stylesheet" href="/public/assets/css/app.css">
    <link rel="stylesheet" href="/public/assets/css/amazeui.flat.min.css">
    <script src="http://cos.rain1024.com/blog/static/assets/js/amazeui.ie8polyfill.min.js"></script>
    <script src="http://cos.rain1024.com/blog/static/assets/js/amazeui.min.js"></script>
    <script src="http://cos.rain1024.com/blog/static/assets/js/amazeui.widgets.helper.min.js"></script>
    <script src="http://cos.rain1024.com/blog/static/assets/js/app.js"></script>
    <script src="http://cos.rain1024.com/blog/static/assets/js/handlebars.min.js"></script>

    <link rel="stylesheet" type="text/css" href="public/css/reset.css" />
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        body {
            font-size: 12px;
            margin: 0px;
            text-align:center;
            vertical-align:middle;
            overflow-y: auto;
        }
    </style>
</head>
<body >
<?php require ('header.php');
require_once 'config/rain_function.php';
$function = new rain_function();
$use_num = $function->use_num('4');?>
<main class="cd-main-content">
<!--<div align="left" style="margin-top: 2%;margin-left: 2%;font-size: 30px;">-->
<!--    <button class="am-btn am-btn-default am-btn-xl" onclick="location.href='index.php';">返回</button>-->
<!--</div>-->
<h1 align="center" style="margin-top: 3%;margin-bottom: -2%;font-size: 30px;">文字识别---通用文字识别功能<br>
    <span style="font-size: 17px;">基于深度学习技术，提供多场景、多语种、高精度的整图文字检测和识别服务</span><br>
    <span style="font-size: 20px;" id="use_num">（今日剩余使用次数<?php echo $use_num;?>）</span></h1>
    <?php if ($use_num==0){?>
        <h1 align="center" style="margin-top: 8%;font-size: 35px;">今日次数以及使用完毕，请明日再来</h1>
    <?php }else{?>
<div align="center" style="margin-top: 5%;">
    <form enctype="multipart/form-data" method="post" action="ocr_all.php" id="myform">
<div class="am-form-group am-form-file">

    <button type="button" class="am-btn am-btn-default am-btn-sm">
        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>

        <input type="file" name="image" onchange="document.getElementById('myform').submit();"  value=""  multiple>&nbsp;&nbsp;


<!--    <input type="text" value="0" name="tip">-->
</div>
<!--        <button type="submit" class="am-btn am-btn-sm">提交</button>-->
    </form>

</div>
    <?php }?>
<?php
//echo $_SERVER["REQUEST_URI"];
if(!empty($_FILES['image'])){
    $file = $_FILES['image'];
//    echo "321342314123";
//    $data['g_addtime'] = date("Y-m-d");
//        onchange="document.getElementById('myform').submit();"                                    echo date("Y-m-d");
    $image_src = $function->upload_file($file);
//    echo $image_src;exit();
    if ($image_src=='0'){?> <h1 align='center' style='color: red;font-size: 50px;'>上传文件格式不对！</h1>
    <?php }else{
    $result = $function->ocr_recognition($image_src,1);
    $use_num = $function->use_num('4');
    //    var_dump($result);
    ?>
        <script>document.getElementById('use_num').innerHTML = '（今日剩余使用次数<?php echo $use_num;?>）';</script>
    <div style="width: 100%;" align="left">
        <div align="center" style="width: 50%;float: left;">
            <img src="<?php echo $image_src;?>" width="80%" height="80%">
        </div>
        <div align="left" style="width: 45%;height:1000px; float: left;margin-bottom: 10%;">
            <table class="am-table am-table-bordered am-table-centered" >
                <thead>
                <tr>
                    <th width="23%">识别行数</th>
                    <th><?php echo $result['words_result_num'];?></th>
                </tr>
                </thead>
            </table>

                <?php
                    foreach ($result['words_result'] as $line){
                ?>
<!--            <table align="left" class="am-table am-table-bordered am-table-centered">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>人脸属性</th>-->
<!--                    <th>值</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody align="left">-->
<!--                        <tr align="left">-->
<!--                            <td>颜值分数</td>-->
<!--                            <td align="left">-->
                                <?php echo $line['words'];?><br><br>
<!--                            </td>-->
<!--                        </tr>-->

<!--                </tbody>-->
<!--            </table>-->
                <?php }?>


        </div>
    </div>

    <?php
}}else{
    ?> <?php
}
?>
</main>
<script src="http://cos.rain1024.com/blog/static/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="http://cos.rain1024.com/blog/static/js/modernizr-custom.js"></script>
<script src="http://cos.rain1024.com/blog/static/js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>
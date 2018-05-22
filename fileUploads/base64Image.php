<?php
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
        <script type="text/javascript" src="public/js/jquery.min.js"></script>
        <script type="text/javascript" src="public/js/cropper.js"></script>
        <script type="text/javascript" src="public/js/layer.js"></script>
        <link rel="stylesheet" href="public/css/cropper.css" />
        <style>
        	.tx-head { line-height:60px; height:60px;background:#F8F8F8; overflow:hidden; position:fixed; z-index:999; width:100%;}
            .new-a-back {position: absolute;top: 12px;left: 6px;width: 20px;height: 32px;background-image: url(public/images/arrow_left_b.png);background-position: 50% 50%;background-repeat: no-repeat;background-size: 100%;opacity: 0.75;}
        </style>
    </head>

    <body>
    	<img src="public/images/value_add.png" id="img1" style="width: 100px;height: 100px;">
        <form method='post' action="upImage.php" enctype="multipart/form-data" onsubmit="return checkCoords();">
			<input type="file" name="image" id="img_file"  onChange="upload(this)" style="display: none;" accept="image/*">
			<input type="submit" value="提交" class="btn btn-large btn-inverse" />
		</form>
		<script type="text/javascript">
			$("#img1").click(function () {
		        $("#img_file").click(); //隐藏了input:file样式后，点击头像就可以本地上传
		        
		    });
		    function upload(the) {
                var objUrl = getObjectURL(the.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                if (objUrl) {
                    layer.open({
                            type: 1,
                            closeBtn: 1, //0是不显示关闭按钮
                            title:0,
                            area: ['100%', '100%'],
                            shadeClose: false,
                            content: '<div class="tx-head"><i id="close" class="glyphicon glyphicon-menu-left" style="margin-left:20px;margin-right:50%;"></i><a href="#" id="img-save" class="btn btn-default">保存</a></div><div class="container small" style="width:100%;overflow:hidden;padding-left: 0px;padding-right:0px;"><img id="base64" src="' + objUrl + '"></div>',
                            style: 'width:100%; height:' + document.documentElement.clientHeight + 'px; background-color:#F2F2F2; border:none; overflow:hidden'
                        });
                        $("#backUrl").click(function(){
                            layer.closeAll();
                        });
                        //裁剪框比例
                        jQuery('#base64').cropper({
                            aspectRatio: 1 / 1,
                            preview: '.img-preview',
                            crop: function (data) {

                            },
                            dragMode:'move',// 在裁剪框外拖动鼠标会移动原图。
                            guides:true,
                            center:true,
                            background : true,// 容器是否显示网格背景  
                            movable : true,//是否能移动图片  
                            //cropBoxMovable :false,//是否允许拖动裁剪框  
                            // cropBoxMovable:false,
                            // guides: true,  //是否在剪裁框上显示虚线
                            // movable: true,  //是否允许移动剪裁框
                            // resizable: true,  //是否允许改变剪裁框的大小
                            // dragCrop: true,  //是否允许移除当前的剪裁框，并通过拖动来新建一个剪裁框区域
                            minCropBoxWidth:80,//裁剪层的最小宽度
                            minCropBoxHeight:80,//裁剪层的最小高度
                            minContainerWidth: 300,  //容器的最小宽度
                            minContainerHeight: 300  //容器的最小高度
                        })



                        //保存裁剪图片

                        jQuery("#img-save").click(function () {
                            var touxiang = jQuery('#base64').cropper('getCroppedCanvas', { width: 900, height: 900 }).toDataURL("image/jpeg", 0.9);
                            var loading = layer.open({
                                type: 2,
                                shadeClose:false
                            });
                            //console.log(touxiang);
                            // 这里该上传给后端啦
                            $.ajax({
                                url: "base64ImageAjax.php",
                                type: "post",
                                data: { img: touxiang},//base64数据
                                dataType: "json",
                                success: function (data) {
                                    //console.log(data);
                                    layer.closeAll();
                                    $("#img1").attr("src",data.url);
                                },error:function(data){
                                    
                                    //console.log(data);
                                    layer.open({
                                        content: '图片上传失败！',
                                        time: 1.5
                                    });
                                    layer.closeAll();
                                }
                            });  

                        })

                }else{
                    layer.open({
                        content: '上传错误',
                        time: 2
                    });
                }


                
	        };

            //建立一個可存取到該file的url
            function getObjectURL(file) {
                var url = null ;
                if (window.createObjectURL!=undefined) { // basic
                    url = window.createObjectURL(file) ;
                } else if (window.URL!=undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(file) ;
                } else if (window.webkitURL!=undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(file) ;
                }
                return url ;
            }

		</script>
    </body>

</html>
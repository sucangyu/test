<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:03
 */
require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
$path="file";
$path=$_REQUEST['path']?$_REQUEST['path']:$path;
$info=readDirectory($path);
if(!$info){
    echo "<script>alert('没有文件或目录！！！');location.href='index.php';</script>";
}
$redirect="index.php?path={$path}";
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" charset="utf-8" />
    <title>在线文件管理系统</title>
</head>
<style type="text/css">
    body,p,div,ul,ol,table,dl,dd,dt{
        margin:0;
        padding: 0;
    }
    a{
        text-decoration: none;
    }
    ul,li{
        list-style: none;
        float: left;
    }
    #top{
        width:100%;
        height:48px;
        margin:0 auto;
        background: #E2E2E2;
    }
    #navi a{
        display: block;
        width:48px;
        height: 48px;
    }
    #main{
        margin:0 auto;
        border:2px solid #ABCDEF;
    }
    .small{
        width:25px;
        height:25px;
        border:0;
    }
</style>
<script type="text/javascript">
    function show(dis){
        document.getElementById(dis).style.display="block";
    }
    function delFile(filename,path){
        if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
            location.href="index.php?act=delFile&filename="+filename+"&path="+path;
        }
    }
    function delFolder(dirname,path){
        if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
            location.href="index.php?act=delFolder&dirname="+dirname+"&path="+path;
        }
    }
    function showDetail(t,filename){
        $("#showImg").attr("src",filename);
        $("#showDetail").dialog({
            height:"auto",
            width: "auto",
            position: {my: "center", at: "center",  collision:"fit"},
            modal:false,//是否模式对话框
            draggable:true,//是否允许拖拽
            resizable:true,//是否允许拖动
            title:t,//对话框标题
            show:"slide",
            hide:"explode"
        });
    }
    function goBack($back){
        location.href="index.php?path="+$back;
    }
</script>

<body>
    <table width="100%" border="1" cellpadding="0" bgcolor="#abcdef">
        <tr>
            <td>编号</td>
            <td>名称</td>
            <td>类型</td>
            <td>大小</td>
            <td>可读</td>
            <td>可写</td>
            <td>可执行</td>
            <td>创建时间</td>
            <td>修改时间</td>
            <td>访问时间</td>
            <td>操作</td>
        </tr>
        <?php if($info['file']){
            $i = 1;
            foreach ($info['file'] as $val){
                $p = $path."/".$val;
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $val?></td>
                <td><?php echo filetype($p)=="file"?"文件":"文件夹";?></td>
                <td><?php echo transByte(filesize($p));?></td>
                <td><?php echo is_readable($p)?"可读":"不可读";?></td>
                <td><?php echo is_writable($p)?"可写":"不可写";?></td>
                <td><?php echo is_executable($p)?"可执行":"不可执行";?></td>
                <td><?php echo date("Y-m-d H:i:s",filectime($p));?></td>
                <td><?php echo date("Y-m-d H:i:s",filemtime($p));?></td>
                <td><?php echo date("Y-m-d H:i:s",fileatime($p));?></td>
                <td>操作</td>
            </tr>
        <?php
                $i++;
            }}
            ?>
    </table>
</body>
</html>








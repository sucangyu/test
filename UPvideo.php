

<?php
//设置最多允许10个文件同时上传
define('MUILTI_FILE_UPLOAD', '10');
//设置文件大小不超过5MB
define('MAX_SIZE_FILE_UPLOAD', '500000' );
//设置上传文件的存储目录
define('FILE_UPLOAD_DIR', './fileUploads');
//允许上传的文件扩展名
$array_extention_interdite = array( '.flv' , '.wmv' , '.rmvb' , '.php' , '.php3' , '.php4' , '.exe' , '.msi' , '.htaccess' , '.gz' );
//显示信息的公共函数
function func_message($message='', $ok=''){
 echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">';
 if($ok == true)
 echo '<tr><td width="50%"> '.$message.'</td></tr>' ;
 else
 echo '<tr><td width="50%"> '.$message.'</td></tr>';
 echo '</table>';  
}
//处理表单提交
$action = (isset($_POST['action'])) ? $_POST['action'] :'' ;
$file = (isset($_POST['file'])) ? $_POST['file'] :'' ;
if($file != '')
  $file = $file.'/';
$message_true = '';
$message_false = '';
switch($action){
 case 'upload' :  
 //chmod(FILE_UPLOAD_DIR,0777);  
 for($nb = 1 ; $nb <= MUILTI_FILE_UPLOAD ; $nb ++ ){   
	if( $_FILES['file_'.$nb]['size'] >= 10 ){ 
		if ($_FILES['file_'.$nb]['size'] <= MAX_SIZE_FILE_UPLOAD ){ 
			if (!in_array(ereg_replace('^[[:alnum:]]([-_.]?[[:alnum:]])*.' ,'.', $_FILES['file_'.$nb]['name'] ) , $array_extention_interdite) ){ 
			       if($_POST['file_name_'.$nb] !='')
			         $file_name_final = $_POST['file_name_'.$nb].$extension ;
			       else
			         $file_name_final = $_FILES['file_'.$nb]['name'] ;
			       //修改文件名
			       $file_name_final = strtr($file_name_final, 'aaaaaa', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'); 
			       $file_name_final = preg_replace('/([^.a-z0-1]+)/i', '_', $file_name_final ); 
			        
			       $_FILES['file_'.$nb]['name'] = $file_name_final;  
			       //开始上传
			       move_uploaded_file( $_FILES['file_'.$nb]['tmp_name'] , FILE_UPLOAD_DIR . $file . $file_name_final );
			    
			       $message_true .= '文件上传成功 : '.$_FILES['file_'.$nb]['name'] .'<br>'; 
	    }else
	       $message_false .= '文件上传失败 : '.$_FILES['file_'.$nb]['name'] .' <br>';
	}else
	    $message_false .= '文件最大尺寸不能超过'.MAX_SIZE_FILE_UPLOAD/1000 . 'KB : "'.$_FILES['file_'.$nb]['tmp_name'].'" <br>';
	}
 }//end for
 break;
}
?>
 

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<title>PHP文件上传</title>
<style type="text/css" rel="stylesheet" >
.border{
 background-color:#000000
}
.box{
 background-color:#f8f8f9;
}
.text{ 
 color:#000000;
 font-family: "宋体";
 font-size: 12px;
 font-weight:bold
}
input, select{
 font-size: 12px;
}
body{
  margin: 0;
}
</style>
<body>
 <!-- 文件上传表单，enctype属性是必须的 -->
 <form name="form" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
 <input type="hidden" name="action" value="upload">
 <table border="0" cellspacing="1" cellpadding="0" align="center" class="border">
  <tr> 
  <td>
   <?php
   if($message_true != '')
    func_message($message_true, true);
   if($message_false != '')
    func_message($message_false, false);
   ?>
   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" class="box">
   <?php
    for($nb = 1 ; $nb <= MUILTI_FILE_UPLOAD ; $nb ++ ){ 
   ?>
   <tr class="text"> 
    <td>上传文件： <?php echo $nb; ?></td> 
    <td><input type="file" name="file_<?php echo $nb; ?>"></td>
    <td>新文件名（包括扩展名）：<?php echo $nb; ?> </td>
    <td><input type="text" name="file_name_<?php echo $nb; ?>"></td>
   </tr>
   <?php } ?>
   <tr> 
    <td colspan="2" align="right" class="text">
    上传目的地址：<?php echo FILE_UPLOAD_DIR ;?>
     <select name="file">    
     <option value=""></option>
     <?php
     $repertoire = opendir(FILE_UPLOAD_DIR); 
     while( $file = readdir($repertoire) ) { 
      $file = str_replace('.','',$file);
      if( is_dir($file)) { 
     ?> 
     <option value="<?php echo $file; ?>"> <?php echo $file; ?>/</option>
     <?php
       } 
     } 
     closedir($repertoire); 
     ?>
    </select>
    </td>
    <td colspan="2" align="right"><input type="submit" value="可同时上传<?php echo $nb-1; ?> 个文件 "></td>
   </tr>
   </table>
  </td>
  </tr>
 </table>
 </form>  
</body>
</html>


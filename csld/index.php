<?php 
 
 
/*  表结构
--
-- 表的结构 `web_city`
--
 
CREATE TABLE IF NOT EXISTS `web_city` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `pid` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
 
--
-- 转存表中的数据 `web_city`
--
 
INSERT INTO `web_city` (`id`, `title`, `pid`) VALUES
(1, '北京', 0),
(2, '东单', 1),
(3, '西单', 1);
 
*/
 
$my_db = mysql_connect("localhost","root","");
mysql_select_db("shop", $my_db);
mysql_query("set names 'utf8'");
$sql = "select * from s_goods_class where type_id = 0";
$query = mysql_query($sql);
$provice = array();
while($row = mysql_fetch_assoc($query))
{
  $provice[] = $row;
}
 
?>
 
 
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>php+ajax 城市联动</title>
<script src="jquery-1.8.2.min.js"></script>
</head>
<body>
<script>
function select_city(){
    var id = jQuery("#provice option:selected").val();
    $("#city").html('<option value="">选择市</option>');  
    $.ajax({
           type: "post",
           url: "ajax.php",
           data: "id="+id,
           dataType: "json",
           success: function(msg){
                    var tbody = "";   
                    $.each(msg.optionss,function(n,value){
                     var trs = "";  
                     trs += "<option value='"+ value.id +"'>"+value.title+"</option>";  
                     tbody += trs;      
                    })
                   $("#city").append(tbody); 
                   
                }
           });
     
    }
</script>
<div>
<select name="provice" id="provice" onchange="select_city()">
<option value="">选择省/市</option>
<?php foreach($provice as $val){?>
<option value="<?php echo $val['id'];?>"><?php echo $val['title'];?></option>
<?php }?>
</select>
<select name="city" id="city">
<option value="">选择市</option>
 
</select>
</div>
</body>
</html>
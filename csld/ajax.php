<?php 
$my_db = mysql_connect("localhost","root","");
mysql_select_db("city", $my_db);
mysql_query("set names 'utf8'");
if(isset($_POST['id'])){
$id = $_POST['id'];
$sql_city = "select * from web_city where pid = $id";
$query_city = mysql_query($sql_city);
$city = array();
while($row = mysql_fetch_assoc($query_city))
{
  $city[] = $row;
}
echo json_encode(array('optionss'=>$city));
}
?>
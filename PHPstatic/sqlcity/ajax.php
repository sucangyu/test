<?php
header("content-type:text/html;charset=utf-8;");
require_once "dbClassMessage.php"; 
	
if(!isset($_POST['lid']))
{
	exit;
}
$id = $_POST['lid'];
$list = $db->getMoreData("select * from ds_region where parent_id=".$id);
$good1 = array();
for($one=0;$one<count($list);$one++){
	$temp_arr1 = array(
		'id' => $list[$one]['id'],
		'name' => $list[$one]['name'],
	);
	array_push($good1, $temp_arr1);
}
echo json_encode($good1);



 die;
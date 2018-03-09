<?php
header("content-type:text/html;charset=utf-8;");

if($_POST['action']==1){
	$data = array(
	'time' => date('Y-m-d H:i:s',time()),	
	'existing'=>2534324,
	'total'=> 15343242,
	);
	// $data['time'] = date('Y-m-d h:i',time());
	// $data['total'] = 160;
	// $data['existing'] = 80;
	echo json_encode($data);
	die;
}


if($_POST['action']==2){





}
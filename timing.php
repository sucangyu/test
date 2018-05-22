<?php 
require_once "sqlcity/dbClassMessage.php";	

$list1 = $db->exeSql("update test_users set status = 1 where id = 89");
if ($list1) {
	
	echo '2222';
	echo '<script>window.close();</script>';
}
	// $requestResults = file_get_contents('http://market.forex.com.cn/zhongfuMarketIndex/findAllPriceAjax.do?' . mt_rand(100000000, 999999999));
 //    //Cache::forget(md5($requestResults));
 //    var_dump($requestResults);
 //    //die;
// $mytime=date("Y-m-d 0:0:0", strtotime("-1 day")); //获取前一天的时间
// echo $mytime.'<br/>';
// echo strtotime($mytime).'<br/>';//转为时间戳
// echo md5(strtotime($mytime).'固定字符串');
?>

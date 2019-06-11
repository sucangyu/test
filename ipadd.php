<meta charset="UTF-8">
<?php
ini_set('date.timezone','Asia/Shanghai');
class Log
{
	// 打印log
	function  log_result($file,$word) 
	{
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H: %M: %S",time()).$word."\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
}

function geturl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
}



?>
<form name="form1" method="post" action="ipadd.php">
	
	<div class="pay-mod bot">
		<div class="pay-line">
			<p class="pay-title">IPaddress：
				<input type="text" name="ipadd" value="" class="remarks">
			</p>
		</div>
	</div>
	<div class="pay-btn">

		<input type="hidden" name="action" value="doit" />
		<button type="submit" name="sub" class="payBtn_2"  />查询</button>

	</div>
</form>
<?php
//提交之后进行处理_并跳转。
if(isset($_REQUEST['action']) && $_REQUEST['action']=="doit")
{
	
	$ipadd='';
	if(isset($_REQUEST['ipadd']))
	{
		$ipadd=$_REQUEST['ipadd'];
	}
	
	$logword="-[".$_SERVER['REMOTE_ADDR']."]=>".$ipadd;
	
	$url='https://apis.map.qq.com/ws/location/v1/ip?ip='.$ipadd.'&key=32ABZ-GZNCU-NKCVO-4PFXA-SKQZK-N4BKP';
	$rbk=geturl($url);

	if($rbk['status']==0)
	{
		$logword=$logword." 纬经度：".$rbk["result"]["location"]["lat"].','.$rbk["result"]["location"]["lng"];
		echo "IP地址：".$ipadd."</br>";
		echo "经度：".$rbk["result"]["location"]["lng"]."  &nbsp;纬度:".$rbk["result"]["location"]["lat"]." 纬经度：".$rbk["result"]["location"]["lat"].','.$rbk["result"]["location"]["lng"]."</br>";
		echo "地址信息：".$rbk["result"]["ad_info"]["nation"]."-".$rbk["result"]["ad_info"]["province"]."-".$rbk["result"]["ad_info"]["city"]."-".$rbk["result"]["ad_info"]["district"]."-".$rbk["result"]["ad_info"]["adcode"]."</br>";
		$burl='https://apis.map.qq.com/ws/geocoder/v1/?location='.$rbk["result"]["location"]["lat"].','.$rbk["result"]["location"]["lng"].'&key=32ABZ-GZNCU-NKCVO-4PFXA-SKQZK-N4BKP&get_poi=1';
		$rbkb=geturl($burl);
		if($rbkb['status']==0)
		{
			echo "详细信息：".$rbkb["result"]['address']."</br>";
			echo "位置描述：".$rbkb["result"]['formatted_addresses']['recommend']."</br>";
			$logword=$logword." 详细信息：".$rbkb["result"]['address']." 位置描述：".$rbkb["result"]['formatted_addresses']['recommend'];
		}
		$jwd=$rbk["result"]["location"]["lat"].','.$rbk["result"]["location"]["lng"];
		echo '<img style="-webkit-user-select: none;" src="https://apis.map.qq.com/ws/staticmap/v2/?key=32ABZ-GZNCU-NKCVO-4PFXA-SKQZK-N4BKP&amp;size=456*240&amp;center='.$jwd.'&amp;markers='.$jwd.'">';
		
	}
	$log = new Log();
	//$logName="ippaddresslog".date('Y-m-d').'.log';//log文件路径
	$logName="ippaddresslog.log";//log文件路径
	$log->log_result($logName,$logword);
	
}
?>
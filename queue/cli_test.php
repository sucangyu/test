<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/30
 * Time: 14:33
 */
//
$count = 0;
while(true){
    $count++;
//    echo $count."\r\n";
    file_put_contents('./test_result.txt',$count."\r\n",FILE_APPEND);
    if($count>10){
        break;
    }
    sleep(3);//每循环一次睡3秒
}
echo 'done';
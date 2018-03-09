<?php
header("content-type:text/html;charset=utf-8;");
require_once "dbClassMessage.php"; 
		
		$finalArr = array();
		$finalArr['provs_data'] = array();		
        $list1 = $db->getMoreData("select * from ds_region where parent_id=0 and level=1");
        //$list2 = $db->getMoreData("select * from ds_region where level=2");
        $list3 = $db->getMoreData("select * from ds_region where level=3");
        for($one=0;$one<count($list1);$one++){
            $temp_arr1 = array(
                'id' => $list1[$one]['id'],
                'name' => $list1[$one]['name'],
            );
            //echo json_encode($finalArr['provs_data']);
            array_push($finalArr['provs_data'], $temp_arr1);
            $list2 = $db->getMoreData("select * from ds_region where level=2 and parent_id=".$list1[$one]['id']);
            $finalArr['citys_data'][$temp_arr1['id']] = array();
	        for($tow=0;$tow<count($list2);$tow++){
	            $temp_arr2 = array(
	                'id' => $list2[$tow]['id'],
	                'name' => $list2[$tow]['name'],
	            );
	            //echo json_encode($finalArr['citys_data']);
	            array_push($finalArr['citys_data'][$temp_arr1['id']], $temp_arr2);
	        }
        }
        
        // for ($i=0; $i < count($list2); $i++) { 
        // 	$finalArr['dists_data'] = array();
	       //  for($three=0;$three<count($list3);$three++){
	       //      $temp_arr3 = array(
	       //          'id' => $list3[$three]['id'],
	       //          'name' => $list3[$three]['name']
	       //      );
	       //      //echo json_encode($finalArr['dists_data']);
	       //      array_push($finalArr['dists_data'], $temp_arr3);
	       //  }
        // }
        
        
        echo json_encode($finalArr);

 die;
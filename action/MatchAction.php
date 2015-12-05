<?php
	require('../dao/GetDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$getDao = new GetDao();
	
	$self = (int)($getDao -> getCount($userId));
	if($self == 0) {
		echo json_encode(array('mesg' => '没有完成任何成就，匹配不成功', 'result' => false));
		exit;
	}
	
	$match_list_json = $getDao -> match($userId);
	$match_list = json_decode($match_list_json);
	
	if(count($match_list) == 0) {
		echo json_encode(array('mesg' => '未找到任何与您有相同成就的人，匹配不成功', 'result' => false));
		exit;
	}
	
	$index = 0;
	$max = 0;
	
	for($i = 0; $i < count($match_list); $i ++) {
		$common = $match_list[$i] -> common;
		$total = $match_list[$i] -> total;
		
		$value = round($common / sqrt($total * $self), 4);
		if($value > $max) {
			$max = $value;
			$index = $i;
		}
	}
		
	
	$match = $getDao -> getMatchUser($match_list[$index] -> getUser, $userId);
	$match -> matchScore = $max;
	
	echo json_encode($match);
?>
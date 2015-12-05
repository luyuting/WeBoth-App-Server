<?php
	require('../dao/AchieveDao.php');
	
	date_default_timezone_set('PRC');
	
	/**
	*	$getTime 上一次查询最后一条显示的时间，如果是第一次加载则为当前时间
	*/
	$getTime = empty($_REQUEST['getTime'])? Date("Y-m-d H:i:s"): $_REQUEST['getTime'];
	$userId = $_REQUEST['userId'];
	
	$achieveDao = new AchieveDao();
	$getDao = new GetDao();
	
	$achieve = json_decode($achieveDao -> getAchieveByUser($_REQUEST['userId'], $getTime));
	$achieve -> userGetCount = $getDao -> getCount($userId);
	
	echo json_encode($achieve);
?>
<?php
	require('../dao/AchieveDao.php');

	date_default_timezone_set('PRC');
	
	/**
	*	@Note 获取个人关注的成就列表，包括已经完成和未完成的成就，完成的成就默认关注，分页返回，一次15条
	*	$getTime 上一次查询最后一条显示的时间，如果是第一次加载则为当前时间
	*/
	$getTime = empty($_REQUEST['getTime'])? Date("Y-m-d H:i:s"): $_REQUEST['getTime'];
	$userId = $_REQUEST['userId'];
	
	$achieveDao = new AchieveDao();
	
	echo $achieveDao -> getAchieveByUser($_REQUEST['userId'], $getTime, true);
?>
<?php
	require('../dao/AchieveDao.php');
	/**
	*	@Note 用户所关注的成就的动态。包括吐槽（即评论）和完成成就，按时间降序排列，分页获取
	*/
	
	date_default_timezone_set('PRC');
	
	$userId = $_REQUEST['userId'];
	$time = empty($_REQUEST['time'])? Date("Y-m-d H:i:s"): $_REQUEST['time'];
	
	$acheiveDao = new AchieveDao();
	
	echo $acheiveDao -> getAchieveNewsList($userId, $time);
?>
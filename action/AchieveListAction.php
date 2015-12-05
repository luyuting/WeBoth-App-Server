<?php
	require('../dao/AchieveDao.php');
	header("content-type: text/html; charset = utf-8"); 
	
	/**
	*	列表采用基于查询的分页，一次15条
	*/
	date_default_timezone_set('PRC');
	$userId = $_REQUEST['userId'];
	$achieveTime = empty($_REQUEST['achieveTime'])? Date("Y-m-d H:i:s"): $_REQUEST['achieveTime'];
	
	$achieveDao = new AchieveDao();
	
	/**
	*	按照类型查询成就列表（包括推荐内容：发布时间在30天内，用户尚未完成且完成数小于等于3的成就，按时间降序排列）
	*/
	if(isset($_REQUEST['achieveType'])) {
		$achieveType = $_REQUEST['achieveType'];
		
		//判断是否获取推荐的成就
		if($achieveType == "推荐") {
			echo $achieveDao -> getRecommendAchieve($userId, $achieveTime);
			exit;
		}
		
		//默认排序条件为“最新”，否则为“最热”
		$condition = empty($_REQUEST['condition'])? "最新": $_REQUEST['condition'];		
		if($condition != "最新") {
			$pageIndex = $_REQUEST['pageIndex'];
			$isGetOrder = (boolean)$_REQUEST['isGetOrder'];								//是否按完成数作为排序依据，否则按吐槽数				
			echo $achieveDao -> getHotAchieve($userId, $achieveType, $pageIndex, $isGetOrder);		//按热度排序pageIndex, isGetOrder为必传参数, 
																						//初始pageIndex值为1，每次分页查询均会返回当前pageIndex，下次查询时加1再传入
		}
		else
			echo $achieveDao-> getAchieveByType($userId, $achieveType, $achieveTime);
		exit;
	}
	
	/**
	*	最后一次更新的时间，返回最新发表的成就列表
	*/
	$lastTime =$_REQUEST['lastTime'];
	
	echo $achieveDao -> getAchieveList($userId, $achieveTime, $lastTime);
	
	
?>
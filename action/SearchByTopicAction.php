<?php
	require('../dao/TopicDao.php');
	require('../dao/GetDao.php');
	require('../dao/MessageDao.php');
	
	$topicName = $_REQUEST['topicName'];
	$userId = $_REQUEST['userId'];
	//是否精确查询，否则采取模糊匹配
	$isExact = (boolean)$_REQUEST['isExact'];
	
	$topicDao = new TopicDao();
	$getDao = new GetDao();
	$messageDao = new MessageDao();
	
	$topicDao = new TopicDao();
	
	$topic = (object) array();
	$topic -> postTopic = json_decode($topicDao -> searchPostTopic($userId, $topicName, $isExact)) -> resultArray;
	$topic -> achieveTopic = json_decode($topicDao -> searchAchieveTopic($userId, $topicName, $isExact)) -> resultArray;
	
	foreach($topic -> achieveTopic as $index => $achieve) {
		$achieveId = $achieve -> achieveId;
		$achieve -> getCount = (int) $getDao -> achieveGetCount($achieveId);
		$achieve -> mesgCount = (int) $messageDao -> achieveMessageCount($achieveId);
	}
	
	echo json_encode($topic);
	
?>
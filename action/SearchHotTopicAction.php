<?php
	require('../dao/TopicDao.php');
	require('../dao/GetDao.php');
	require('../dao/MessageDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$topicDao = new TopicDao();
	
	$topic = (object) array();
	$topic -> postTopic = json_decode($topicDao -> postHotTopic()) -> resultArray;
	$topic -> achieveTopic = json_decode($topicDao -> achieveSelfTopic($userId)) -> resultArray;
	
	echo json_encode($topic);
	
?>
<?php
	require('../dao/PostDao.php');
	
	date_default_timezone_set('PRC');
	
	$userId = $_REQUEST['userId'];
	$visitUser = $_REQUEST['visitUser'];
	$postTime = empty($_REQUEST['postTime'])? Date("Y-m-d H:i:s"): $_REQUEST['postTime'];
	
	$postDao = new PostDao();
	$obj = json_decode($postDao->userPostList($userId, $visitUser, $postTime));
	$obj->postCount = $postDao->userPostCount($userId);
	echo json_encode($obj);
?>
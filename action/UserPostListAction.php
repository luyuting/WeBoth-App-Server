<?php
	require('../dao/PostDao.php');
	
	date_default_timezone_set('PRC');
	
	$userId = $_REQUEST['userId'];
	$visitUser = $_REQUEST['visitUser'];
	$postTime = empty($_REQUEST['postTime'])? Date("Y-m-d H:i:s"): $_REQUEST['postTime'];
	
	/**
	*	@Note 获得用户所发的帖子列表，分页，一次15条，访客不能看到用户所发的匿名帖，本人可以看到全部
	*/
	$postDao = new PostDao();
	$obj = json_decode($postDao->userPostList($userId, $visitUser, $postTime));
	$obj->postCount = $postDao->userPostCount($userId, $visitUser == $userId);
	echo json_encode($obj);
?>
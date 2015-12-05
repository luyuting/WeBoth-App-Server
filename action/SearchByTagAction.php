<?php
	require('../dao/PostDao.php');
	
	/**
	*	@Note 根据频道（标签）分类查找帖子，分页查询，一次取出15条
	*/
	date_default_timezone_set('PRC');
	
	$userId = $_REQUEST['userId'];
	$postTag = $_REQUEST['postTag'];
	$postTime = empty($_REQUEST['postTime'])? Date("Y-m-d H:i:s"): $_REQUEST['postTime'];
	
	$postDao = new PostDao();
	echo $postDao -> searchByTag($userId, $postTag, $postTime);
?>
<?php
	/**
	*	collect function abandoned in v2.1.4 +;
	*/
	require('../dao/PostDao.php');
	
	date_default_timezone_set('PRC');
	
	$userId=$_REQUEST['userId'];
	$postTime=empty($_REQUEST['postTime'])?Date("Y-m-d H:i:s"):$_REQUEST['postTime'];
	
	$postDao=new PostDao();
	echo $postDao->getCollectList($userId,$postTime);
?>
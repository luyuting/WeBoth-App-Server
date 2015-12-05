<?php
	require('../dao/CommentDao.php');
	require('../dao/PostDao.php');
	
	$userId = $_REQUEST['userId'];
	$postId = $_REQUEST['postId'];
	
	$commentDao = new CommentDao();
	$postDao = new PostDao();
	
	$obj = json_decode($commentDao -> postCommentList($postId));
	$obj -> post = json_decode($postDao -> getPostById($userId, $postId)) -> resultArray[0];
	
	echo json_encode($obj);
?>
<?php
	require('../dao/CommentDao.php');
	
	$userId = $_REQUEST['userId'];
	$postId = $_REQUEST['postId'];
	$commentTarget = $_REQUEST['commentTarget'];		//回复的用户，他的userId
	$commentContent = $_REQUEST['commentContent'];		
	$commentAfter = (int)$_REQUEST['commentAfter'];		//回复的评论id，如果直接评论的帖子，传空值即可
	$isAnonymity = (int)$_REQUEST['isAnonymity'];		//此条评论是否匿名 boolean
	
	$commentDao = new CommentDao();
	if(($obj = $commentDao -> setComment($postId, $userId, $commentTarget, $commentContent, $commentAfter, $isAnonymity)) != null)
		echo json_encode(array('mesg' => 'success', 'result' => true, 'data' => json_decode($obj) -> resultArray[0]));
	else 
		echo json_encode(array('mesg' => 'fail', 'result' => false, 'data' => null));
?>
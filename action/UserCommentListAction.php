<?php
	require('../dao/CommentDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$commentDao = new CommentDao();
	
	echo $commentDao -> userCommentList($userId);
?>
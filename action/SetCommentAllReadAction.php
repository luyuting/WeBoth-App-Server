<?php
	require('../dao/CommentDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$commentDao = new CommentDao();
	
	if($commentDao -> setAllRead($userId) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
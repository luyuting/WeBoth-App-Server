<?php
	require('../dao/CommentDao.php');
	
	$replyId = $_REQUEST['replyId'];
	
	$commentDao = new CommentDao();
	
	if($commentDao -> setRead($replyId) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
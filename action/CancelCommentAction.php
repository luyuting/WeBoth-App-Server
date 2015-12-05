<?php
	require('../dao/CommentDao.php');
	
	$commentId=$_REQUEST['commentId'];
	
	$commentDao=new CommentDao();
	if(($commentDao->cancelComment($commentId)>0))
		echo json_encode(array('mesg'=>'success','result'=>true));
	else 
		echo json_encode(array('mesg'=>'fail','result'=>false));
?>
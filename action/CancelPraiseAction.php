<?php 
	require('../dao/PraiseDao.php');
	
	$userId = $_REQUEST['userId'];
	$postId = $_REQUEST['postId'];
	
	$praiseDao = new PraiseDao();
	if($praiseDao -> cancelPraise($userId,$postId) > 0)
		echo json_encode(array('mesg' => 'success','result' => true));
	else 
		echo json_encode(array('mesg' => 'fail','result' => false));
?>
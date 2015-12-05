<?php
	/**
	*	collect function abandoned in v2.1.4 +;
	*/
	require('../dao/CollectDao.php');
	
	$userId=$_REQUEST['userId'];
	$postId=$_REQUEST['postId'];
	
	$collectDao=new CollectDao();
	if($collectDao->setCollect($userId,$postId)>0)
		echo json_encode(array('mesg'=>'success','result'=>true));
	else
		echo json_encode(array('mesg'=>'fail','result'=>false));
?>
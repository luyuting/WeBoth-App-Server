<?php 
	require('../dao/MessageDao.php');
	
	$userId = $_REQUEST['userId'];
	$mesgAchieve = $_REQUEST['mesgAchieve'];
	$mesgContent = $_REQUEST['mesgContent'];
	$isAnonymity = (int)$_REQUEST['isAnonymity'];	//boolean
	
	$messageDao = new MessageDao();
	if(($obj = $messageDao -> setMessage($userId, $mesgAchieve, $mesgContent, $isAnonymity, 0)) != null)
		echo json_encode(array('mesg' => 'success', 'result' => true, 'data' => json_decode($obj) -> resultArray[0]));
	else 
		echo json_encode(array('mesg' => 'fail', 'result' => false, 'data' => null));
?>
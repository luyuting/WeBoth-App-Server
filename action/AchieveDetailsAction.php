<?php
	require('../dao/GetDao.php');
	require('../dao/MessageDao.php');
	
	$achieveId = $_REQUEST['achieveId'];
	$userId = $_REQUEST['userId'];
	$requestType = strtolower($_REQUEST['requestType']);
	
	/**
	*	@Note: 获得成就的完成列表
	*/
	if($requestType == 'get') {
		$getDao = new GetDao();
		echo json_encode(array('resultArray' => $getDao -> getCompleteList($achieveId, $userId)));
	
	}
	/**
	*	@Note: 获得成就的吐槽列表
	*/
	else if($requestType == 'message') {
		$messageDao = new MessageDao();
		echo $messageDao -> achieveMessageList($achieveId);
	}
	
	exit;
?>
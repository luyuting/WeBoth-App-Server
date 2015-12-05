<?php
	require('../dao/GetDao.php');
	
	$userId = $_REQUEST['userId'];
	$targetUser = $_REQUEST['targetUser'];
	
	$getDao = new GetDao();
	
	echo json_encode($getDao -> getMatchUser($targetUser, $userId));
?>
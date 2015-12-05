<?php
	require('../dao/GetDao.php');
	
	$achieveId = $_REQUEST['achieveId'];
	$userId = $_REQUEST['userId'];
	
	$getDao = new GetDao();
	
	if($getDao -> completeAchieve($achieveId, $userId) > 0)
		echo json_encode(array('mesg' => 'success','result' => true));
	else
		echo json_encode(array('mesg' => 'fail','result' => false));
?>
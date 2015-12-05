<?php
	require('../dao/GetDao.php');
	
	$achieveId = $_REQUEST['achieveId'];
	$userId = $_REQUEST['userId'];
	
	$getDao = new GetDao();
	
	$getDao -> setConcern($achieveId, $userId);
	echo json_encode(array('mesg' => 'success','result' => true));
?>
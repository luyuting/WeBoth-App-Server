<?php
	require('../dao/ConcernDao.php');
	
	$userId = $_REQUEST['userId'];
	$concernTarget = $_REQUEST['concernTarget'];
	
	$concernDao = new ConcernDao();
	if($concernDao -> cancelConcern($userId,$concernTarget) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
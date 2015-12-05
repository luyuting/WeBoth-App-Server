<?php
	require('../dao/PraiseDao.php');
	
	$praiseId = $_REQUEST['praiseId'];
	
	$praiseDao = new PraiseDao();
	
	if($praiseDao -> setRead($praiseId) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
<?php
	require('../dao/PraiseDao.php');
	
	$praiseId = $_REQUEST['userId'];
	
	$praiseDao = new PraiseDao();
	
	if($praiseDao -> setAllRead($userId) > 0)
		echo json_encode(array('mesg' => 'success','result' => true));
	else
		echo json_encode(array('mesg' => 'fail','result' => false));
?>
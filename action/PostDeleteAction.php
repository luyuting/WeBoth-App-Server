<?php
	require('../dao/DeleteDao.php');
	
	$postId = $_REQUEST['postId'];

	$deleteDao = new DeleteDao();
	if($deleteDao -> postDelete($postId))
		echo json_encode(array('mesg' => 'success','result' => true));
	else
		echo json_encode(array('mesg' => 'fail','result' => false));
?>
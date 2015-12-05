<?php
	require('../dao/TagConcernDao.php');

	$tagName = $_REQUEST['tagName'];
	$userId = $_REQUEST['userId'];

	$tagConcernDao = new TagConcernDao();
	if($tagConcernDao -> setTagConcern($tagName, $userId) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
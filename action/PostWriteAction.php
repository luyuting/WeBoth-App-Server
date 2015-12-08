<?php
	require('../dao/PostDao.php');
	require('../dao/MessageDao.php');
	require('ImageUpload.php');

	$imageUpload = new ImageUpload();
	
	$postUser = $_REQUEST['postUser'];
	$postImage = $imageUpload->getImageUrl();
	$postTopic = $_REQUEST['postTopic'];
	$postContent = $_REQUEST['postContent'];
	$postTag = $_REQUEST['postTag'];
	$isAnonymity = (int)$_REQUEST['isAnonymity'];	//boolean
	
	$achieveId = 0;
	if(!empty($_REQUEST['achieveId']))
		$achieveId = $_REQUEST['achieveId'];
	
	$postDao = new PostDao();
	$id = $postDao -> postWrite($postUser, $postImage, $postTopic, $postContent, $postTag, $isAnonymity);
	if($id == null || $id == 0)
		echo json_encode(array('mesg' => 'fail', 'result' => false));
	else {
		if($achieveId != 0) {
			$messageDao = new MessageDao();
			$messageDao -> setMessage($postUser, $achieveId, null, $isAnonymity, $id);
		}
		echo json_encode(array('mesg' => 'success', 'result' => true));
	}
		
?>
<?php
	require('../dao/UserDao.php');
	require('ImageUpload.php');
	
	$imageUpload = new ImageUpload();
	
	$userId = $_REQUEST['userId'];
	$field = "userImage";
	$value = $imageUpload->setUserImage();
	
	$userDao = new UserDao();
	
	if($userDao -> setUserInfo($userId, $field, $value) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true, 'imgUrl' => $value));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
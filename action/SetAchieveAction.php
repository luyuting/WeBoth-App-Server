<?php
	require('../dao/AchieveDao.php');
	require('ImageUpload.php');
	
	$imageUpload = new ImageUpload();
	
	$userId = $_REQUEST['userId'];
	$achieveType = $_REQUEST['achieveType'];
	if(!empty($_REQUEST['achieveImage']))
		$achieveImage = $_REQUEST['achieveImage'];
	else
		$achieveImage = $imageUpload->setAchieveImage();
	$achieveTitle = $_REQUEST['achieveTitle'];
	$achieveContent = $_REQUEST['achieveContent'];
	$isGet = (boolean)$_REQUEST['isGet'];
	
	$achieveDao = new AchieveDao();
	
	if($achieveDao -> setAchieve($userId, $achieveType, $achieveImage, $achieveTitle, $achieveContent, $isGet) > 0)
		echo json_encode(array('mesg' => 'success','result' => true));
	else
		echo json_encode(array('mesg' => 'fail','result' => false));
?>
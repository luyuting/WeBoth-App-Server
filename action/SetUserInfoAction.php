<?php
	require('../dao/UserDao.php');
	
	$userId = $_REQUEST['userId'];
	$field = $_REQUEST['field'];
	$value = $_REQUEST['value'];
	
	$userDao = new UserDao();
	
	if($userDao -> setUserInfo($userId, $field, $value) > 0)
		echo json_encode(array('mesg' => 'success', 'result' => true));
	else
		echo json_encode(array('mesg' => 'fail', 'result' => false));
?>
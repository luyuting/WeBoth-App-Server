<?php 
	require('../dao/UserDao.php');
	
	date_default_timezone_set('PRC');
	
	$userMark = null;
	$userPass = '';
	$userName = null;
	
	if(isset($_REQUEST['openid'])) {
		$userMark = $_REQUEST['openid'];
		$userName = 'qq_';
	}
	else {
		$userMark = $_REQUEST['tel'];
		$userPass = $_REQUEST['userPass'];
		$userName = 'tel_';
	}
	/*
	$userId=$_REQUEST['userId'];
	$userPass=$_REQUEST['userPass'];
	$userName=$_REQUEST['userName'];
	*/
	
	$userDao = new UserDao();
	
	if($userDao -> check($userMark) > 0) {
		echo json_encode(array('mesg' => 'already registered', 'result' => true));
		exit;
	}
	$result = false;
	while(!$result) {
		$timestamp = strtotime(date("Y-m-d H:i:s"));
		$userId = rand(10, 99).substr($timestamp, 3);
		
		$userName = $userName . $userId;
	
		if($userDao->register($userId, $userMark, $userName, $userPass)>0)
			$result = true;
	}
	echo json_encode(array('userId' => $userId, 'userName' => $userName));
?>
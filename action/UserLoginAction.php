<?php
	require('../dao/UserDao.php');
	
	$userMark = $_REQUEST['userMark'];
	$userPass = $_REQUEST['userPass'];
	
	$userDao = new UserDao();
	if($userDao -> getUserPassByMark($userMark) == $userPass && $userDao -> check($userMark))
		echo json_encode(array('mesg' => 'success','result' => true,'data' => json_decode($userDao -> getUserInfoByMark($userMark)) -> resultArray[0]));
	else 
		echo json_encode(array('mesg' => 'fail','result' => false,'data' => null));
?>
<?php
	require('../dao/UserDao.php');
	require('../dao/ConcernDao.php');
	
	$userId=$_REQUEST['userId'];
	$visitUser=empty($_REQUEST['visitUser'])?null:$_REQUEST['visitUser'];
	
	$userDao=new UserDao();
	$obj=json_decode($userDao->getUserInfo($userId));
	
	if($visitUser!=null||$visitUser=$userId){
		$concernDao=new ConcernDao();
		$obj->hasConcerned=$concernDao->isConcern($visitUser,$userId);
	}
	echo json_encode($obj);
?>
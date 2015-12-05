<?php
	require('../dao/ConcernDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$concernDao = new ConcernDao();

	echo $concernDao -> getConcernList($userId);
?>
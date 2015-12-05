<?php
	require('../dao/PraiseDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$praiseDao = new PraiseDao();
	
	echo $praiseDao -> getPraiseList($userId);
?>
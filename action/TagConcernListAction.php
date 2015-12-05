<?php
	require('../dao/TagConcernDao.php');
	
	$userId=$_REQUEST['userId'];
	
	$tagConcernDao = new TagConcernDao();
	
	echo $tagConcernDao -> getTagConcernList($userId);
?>
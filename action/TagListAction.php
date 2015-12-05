<?php
	require('../dao/TagDao.php');
	
	$userId = $_REQUEST['userId'];
	
	$tagDao = new TagDao();
	echo $tagDao -> getTag($userId);
?>
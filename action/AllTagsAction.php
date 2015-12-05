<?php
	require('../dao/PostDao.php');
	
	/**
	*	this action is abandoned in v2.1.15+
	*/
	$postDao = new PostDao();
	echo $postDao -> getAllTags();
?>
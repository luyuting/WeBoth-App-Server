<?php
	require('../dao/AchieveDao.php');
	
	$userId = $_REQUEST['userId'];
	//搜索词，按成就名进行模糊查询，不能为空
	$achieveSearch = $_REQUEST['achieveSearch'];
	$achieveDao = new AchieveDao();
	echo $achieveDao -> getAchieveBySearch($userId, $achieveSearch);
?>
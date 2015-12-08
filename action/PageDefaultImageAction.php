<?php
	require('../dao/ImageDao.php');
	$imageDao = new ImageDao();
	echo $imageDao -> getPageImage();
?>
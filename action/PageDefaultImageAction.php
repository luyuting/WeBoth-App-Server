<?php
	require('DefaultImage.php');
	$defaultImage = new DefaultImage();
	$image_list = $defaultImage -> defaultPageImage();
	echo json_encode($image_list);
?>
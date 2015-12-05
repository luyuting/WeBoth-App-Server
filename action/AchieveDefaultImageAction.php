<?php
	require('DefaultImage.php');
	$defaultImage = new DefaultImage();
	$image_list = $defaultImage -> defaultAchieveImage();
	echo json_encode($image_list);
?>
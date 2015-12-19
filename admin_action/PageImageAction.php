<?php
	require('../dao/ImageDao.php');
	require('../action/ImageUpload.php');
	
	class PageImage extends ImageUpload {
		public function setPageImage() {
			return $this -> setImage('../action/pageImage');
		}
	} 
	
	$pageImage = new PageImage();
	
	$imageUrl = $_POST['describe'];
	$imageAddress = explode(",", $pageImage -> setPageImage());
	
	$imageDao = new ImageDao();
	for($i = 0; $i < count($imageUrl); $i ++) {
		if(empty($imageUrl[$i]))
			continue;
		$imageDao -> setPageImage($imageAddress[$i], $imageUrl[$i]);
	}
	echo "<script>alert('success');location.href = '../imageEditor.php';</script>";
?>
<?php
	require_once('BaseDao.php');
	class ImageDao extends BaseDao {

		public function getPageImage() {
			$sql = "select imageAddress, imageUrl from tb_image order by imageId desc limit 0, 4";
			return $this -> query($sql);
		}
		
		public function setPageImage($imageAddress, $imageUrl) {
			$sql = "insert into tb_image(imageAddress, imageUrl) values('$imageAddress', '$imageUrl')";
			return $this -> execute($sql);
		}
	}
	
?>
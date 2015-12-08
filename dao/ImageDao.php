<?php
	require_once('BaseDao.php');
	class ImageDao extends BaseDao {

		public function getPageImage() {
			$sql = "select imageAddress, imageUrl from tb_image";
			return $this -> query($sql);
		}
	}
	
?>
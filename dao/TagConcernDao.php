<?php	
	require_once('BaseDao.php');
	class TagConcernDao extends BaseDao{
		
		public function setTagConcern($tagName, $userId) {
			$sql = "insert into tb_tag_concern(tagName, tagUser) values('$tagName', '$userId')";
			return $this -> execute($sql);
		}
		
		public function cancelTagConcern($tagName, $userId) {
			$sql = "delete from tb_tag_concern where tagName = '$tagName' and tagUser = 'tagUser'";
			return $this -> execute($sql);
		}
		
		public function getTagConcernList($userId) {
			$sql = "select tagName from tb_tag_concern where tagUser = '$userId'";
			return $this -> query($sql);
		}
	}
?>
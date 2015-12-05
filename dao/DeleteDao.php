<?php	
	require_once('BaseDao.php');
	class DeleteDao extends BaseDao{
		
		public function postDelete($postId) {
			$del_in_sql = "insert into tb_delete select * from tb_post where postId = $postId";
			$del_sql = "delete from tb_post where postId = $postId";
			if($this -> execute($del_in_sql) > 0)
				if($this -> execute($del_sql) > 0)
					return true;
			return false;
				
		}
	}
?>
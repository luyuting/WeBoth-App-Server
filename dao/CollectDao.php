<?php
	/**
	*	collect function abandoned in v2.1.4 +;
	*/
	require_once('BaseDao.php');
	class CollectDao extends BaseDao{
		
		public function setCollect($userId,$postId){
			$sql="insert into tb_collect(collectPost,collectUser,collectTime) values('$postId','$userId',now())";
			return $this->execute($sql);
		}
		
		public function cancelCollect($userId,$postId){
			$sql="delete from tb_collect where collectUser='$userId' and collectPost='$postId'";
			return $this->execute($sql);
		}
	}
?>
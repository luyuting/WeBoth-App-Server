<?php	
	require_once('BaseDao.php');
	class PraiseDao extends BaseDao{
		
		public function setPraise($userId,$postId){
			$sql="insert into tb_praise(praiseUser,praisePost,praiseTime,isRead) values('$userId',$postId,now(),false)";
			if($this->execute($sql)>0){
				$update_sql="update tb_post set postPraise=postPraise+1 where postId=$postId";
				return $this->execute($update_sql);
			}
			return 0;
		}
		
		public function cancelPraise($userId,$postId) {
			$sql="delete from tb_praise where praiseUser = '$userId' and praisePost = $postId";
			$delete=$this->execute($sql);
			if($delete>0){
				$update_sql="update tb_post set postPraise=postPraise-$delete where postId=$postId";
				return $this->execute($update_sql);
			}
			return 0;
		}
		
		public function setRead($praiseId){
			$sql="update tb_praise set isRead=true where praiseId=$praiseId";
			return $this->execute($sql);
		}
		
		public function setAllRead($userId) {
			$sql = "update tb_praise set isRead = true where isRead = false";
			return $this -> execute($sql);
		}
		
		public function getPraiseList($userId){
			$sql="select userName,userImage,userSex,i.*,postContent,postImage,postTime from tb_praise i,tb_post,tb_user
				where userId=i.praiseUser and i.praisePost=PostId and postUser='$userId' and i.isRead=false 
				order by i.praiseTime desc";
			return $this->query($sql);
		}
		
	}
?>
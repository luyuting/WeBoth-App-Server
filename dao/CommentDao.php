<?php 
	require_once('BaseDao.php');
	class CommentDao extends BaseDao{
		
		public function setComment($postId, $userId, $commentTarget, $commentContent, $commentAfter, $isAnonymity) {
			$sql = "insert into tb_comment(commentPost, commentUser, commentTarget, commentContent, commentTime, commentAfter, isAnonymity) 
				values($postId, '$userId', '$commentTarget', '$commentContent', now(), $commentAfter, $isAnonymity)";
			$id = $this -> getId($sql);
			if($id == null||$id == 0)
				return null;
			
			$update_sql = "update tb_post set postComment = postComment + 1 where postId = $postId";
			$this->execute($update_sql);
			
			$host_sql = "select postUser from tb_post where postId = $postId";
			$host = $this -> getField($host_sql);
			if($host != $userId) {
				$reply_host_sql = "insert into tb_reply(replyComment, replyTarget) values($id, (select postUser from tb_post where postId 
					= $postId))";
				$this -> execute($reply_host_sql);
			}
			
			if($commentTarget != null && $commentTarget != "" && $commentTarget != $host && $commentTarget != $userId) {
				$reply_sql = "insert into tb_reply(replyComment, replyTarget) values($id, '$commentTarget')";
				$this -> execute($reply_sql);
			}
			
			$select_sql = "select k.*, t.userName targetName from (select u.userName, u.userImage, u.userSex, i.* from tb_user u, 
				tb_comment i where i.commentId = $id) k left outer join tb_user t on t.userId = k.commentTarget ";
			return $this -> query($select_sql);
		}
		
		public function cancelComment($commentId) {
			$update_sql = "update tb_post set postComment = postComment -1  where postId = (select commentPost from 
				tb_comment where commentId = $commentId)";
			if($this -> execute($update_sql) > 0) {
				$sql = "delete from tb_comment where commentId = $commentId";
				return $this -> execute($sql);
			}
			return 0;
		}
		
		public function userCommentList($userId) {
			$sql = "select k.*, t.userName targetName from (select u.userName, u.userImage, u.userSex, r.replyId, i.* , postUser, p.userName postUserName, 
				p.userSex postUserSex, p.userImage postUserImage, postContent, postImage from tb_reply r, tb_user u, tb_user p, tb_comment i, tb_post where 
				r.replyTarget = '$userId' and postUser =  p.userId and u.userId = i.commentUser and i.commentPost = postId and r.isRead = false and 
				r.replyComment = i.commentId) k left outer join tb_user t on t.userId = k.commentTarget order by commentTime desc";
			return $this -> query($sql);
		}
		
		public function postCommentList($postId) {
			$sql = "select k.*, t.userName targetName from (select u.userName, u.userImage, u.userSex, i.* from tb_user u, 
				tb_comment i where i.commentPost = $postId and u.userId = i.commentUser) k left outer join 
				tb_user t on t.userId = k.commentTarget order by commentTime asc";
			return $this -> query($sql);
		}
		
		public function setRead($replyId) {
			$sql = "update tb_reply set isRead = true where replyId = $replyId";
			return $this -> execute($sql);
		}
		
		public function setAllRead($userId) {
			$sql = "update tb_reply set isRead = true where replyTarget = '$userId' and isRead = false";
			return $this -> execute($sql);
		}
	}
?>
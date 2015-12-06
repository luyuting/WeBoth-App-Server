<?php	
	require_once('BaseDao.php');
	class PostDao extends BaseDao {
		
		public function userPostCount($userId, $isUser) {
			$where_condition = $isUser? "true": "isAnonymity = false"; 
			$sql="select count(*) from tb_post where postUser = '$userId' and $where_condition";
			return $this -> getField($sql);
		}
		
		public function getPostById($userId, $postId) {
			$sql="select userName, userSex, userImage, i.* from tb_user, tb_post i where userId = postUser and postId = $postId order by postTime desc limit 0, 15";
			return $this->postSelect($userId,$sql);
		}
		
		public function getPostListByConcern($userId, $postTime) {
			$sql = "select userName, userSex, userImage, i.* from tb_user, tb_post i where userId = postUser and postTime < '$postTime'
				and postTag in (select tagName from tb_tag_concern where tagUser = '$userId') order by postTime desc limit 0,15";
			return $this -> postSelect($userId, $sql);
		}
		
		public function getPostList($userId, $postTime) {
			$sql = "select userName, userSex, userImage, i.* from tb_user,tb_post i where userId = postUser and postTime < '$postTime' 
				and (postTag in (select tagName from tb_tag_concern where tagUser = '$userId') or postTag = '') order by postTime desc limit 0, 15";
			return $this -> postSelect($userId, $sql);
		}
		
		public function userPostList($userId, $visitUser, $postTime) {
			$where_condition = $userId == $visitUser? "true": "isAnonymity = false";
			$sql="select userName, userSex, userImage, i.* from tb_user, tb_post i where userId = '$userId' and userId = postUser and postTime < '$postTime' 
				and $where_condition order by postTime desc limit 0, 15";
			return $this -> postSelect($visitUser, $sql);
		}
		
		public function postWrite($postUser, $postImage, $postTopic, $postContent, $postTag, $isAnonymity){
			$sql="insert into tb_post(postUser, postImage, postTopic, postContent, postTag, postPraise, postComment, postTime, isAnonymity) values(
				'$postUser', '$postImage', '$postTopic', '$postContent', '$postTag', 0, 0, now(), $isAnonymity)";
			return $this -> getId($sql);
		}
		
		public function getAllTags(){
			$sql="select postTag,count(*) postSum  from tb_post group by(postTag) order by postSum desc";
			return $this -> query($sql);
		}
		
		public function searchByTag($userId,$postTag,$postTime) {
			$sql="select userName,userSex,userImage,i.* from tb_user,tb_post i where userId=postUser and postTime<'$postTime'
				and postTag='$postTag' order by postTime desc limit 0,15";
			return $this -> postSelect($userId,$sql);
		}
		
		/*
		public function getCollectList($userId,$postTime){
			$sql="select userName,userSex,userImage,i.* ,collectTime from tb_user,tb_post i,tb_collect where userId=postUser and postTime<'$postTime'
				and postId=collectPost order by collectTime desc limit 0,15";
			return $this->postSelect($userId,$sql);
		}*/
		
		private function postSelect($userId, $sql) {
			$obj_arr = json_decode($this -> query($sql)) -> resultArray;
			for($i = 0; $i < count($obj_arr); $i ++){
				$postId = $obj_arr[$i] -> postId;
				$count_praise_sql = "select count(*) from tb_praise where praiseUser = '$userId' and praisePost = '$postId'";
				/**
				*	collect function abandoned in v2.1.4 +;
				*/
				//$count_collect_sql="select count(*) from tb_collect where collectUser='$userId' and collectPost='$postId'";
				$hasPraised = false;
				//$hasCollected=false;
				if($this -> getField($count_praise_sql) > 0)
					$hasPraised = true;
				//if($this->getField($count_collect_sql)>0)
					//$hasCollected=true;
				$obj_arr[$i] -> hasPraised = $hasPraised;
				//$obj_arr[$i]->hasCollected=$hasCollected;
			}
			return json_encode(array('resultArray' => $obj_arr));
		}
		
	}
?>
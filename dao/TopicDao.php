<?php	
	require_once('BaseDao.php');
	class TopicDao extends BaseDao{
		
		public function postHotTopic($hot = 5) {
			$sql = "select postTopic topicName, count(*) topicNum from tb_post where postTopic <> '' group by(postTopic) order by topicNum
				desc limit 0, $hot";
			return $this -> query($sql);
		}
		
		/*public function achieveHotTopic($userId, $hot = 5) {
			$sql = "select r.*, g.isGet from (select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser
				and a.achieveId in (select mesgAchieve from (select mesgAchieve, count(*) sum from tb_message group by(mesgAchieve) 
				order by sum desc limit 0, $hot) k)) r left outer join tb_get g on g.getAchieve = r.achieveId and g.getUser = '$userId'";
			return $this -> query($sql);
		}*/
		
		public function achieveSelfTopic($userId) {
			$sql = "select a.achieveId, a.achieveTitle from tb_achieve a, tb_get g where g.getUser = '$userId' and a.achieveId = g.getAchieve order by g.getTime desc ";
			return $this -> query($sql);
		}
		
		public function searchPostTopic($userId, $topicName, $isExact = false) {
			if($isExact)
				return $this -> searchPostTopicExactly($userId, $topicName);
			else
				return $this -> searchPostTopicRoughly($topicName);
		}
		
		private function searchPostTopicRoughly($topicName) {
			$sql = "select postTopic topicName, count(*) topicNum from tb_post where postTopic like '%$topicName%' and postTopic <> '' group by(postTopic) 
				order by topicNum desc";
			return $this -> query($sql);
		}
		
		private function searchPostTopicExactly($userId, $topicName) {
			$sql = "select userName, userSex, userImage, i.* from tb_user, tb_post i where postTopic = '$topicName' and postTopic <> '' and userId = postUser 
				order by postTime desc limit 0, 20";
					
			$obj_arr = json_decode($this -> query($sql)) -> resultArray;
			for($i = 0; $i < count($obj_arr); $i ++){
				$postId = $obj_arr[$i] -> postId;
				$count_praise_sql = "select count(*) from tb_praise where praiseUser = '$userId' and praisePost = '$postId'";
				$hasPraised = false;
				if($this -> getField($count_praise_sql) > 0)
					$hasPraised = true;
				$obj_arr[$i] -> hasPraised = $hasPraised;
			}
			return json_encode(array('resultArray' => $obj_arr));
		}
		
		public function searchAchieveTopic($userId, $topicName, $isExact = false) {
			if(!$isExact) 
				$topicName = '%' . '%';
			$sql = "select r.*, g.isGet from (select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where a.achieveTitle like '$topicName' 
				and u.userId = a.achieveUser order by achieveTime desc) r left outer join tb_get g on g.getAchieve = r.achieveId and g.getUser = '$userId'";
			return $this -> query($sql);
		}
	}
?>
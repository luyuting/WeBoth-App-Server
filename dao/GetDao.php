<?php 
	require_once('BaseDao.php');
	class GetDao extends BaseDao {
		
		public function setConcern($achieveId, $userId) {
			$sql = "insert into tb_get(getAchieve, getUser, isGet, getTime) values($achieveId, '$userId', false, now())";
			return $this -> execute($sql);
		}
		
		public function completeAchieve($achieveId, $userId) {
			
			$sql = "insert into tb_get(getAchieve, getUser, isGet, getTime) values($achieveId, '$userId', true, now())";
			if($this -> execute($sql) <= 0) {
				$get_sql = "update tb_get set isGet = true where getAchieve = $achieveId and getUser = '$userId'";
				if($this -> execute($get_sql) <= 0)
					return 0;
			}
			
			$score_user_sql = "update tb_user set userCredit = userCredit + 3 where userId = '$userId'";
			$score_host_sql = "update tb_user set userCredit = userCredit + 1 where userId <> '$userId' and userId = (select 
				achieveUser from tb_achieve where achieveId = $achieveId)";
			$this -> execute($score_user_sql);
			$this -> execute($score_host_sql);
			return 1;
		}
		
		public function getCompleteList($achieveId, $userId) {
			$sql = "select userName, userSex, userSchool, userGrade, userImage, getUser, getTime from tb_user, tb_get where userId =
				getUser and getAchieve = $achieveId and isGet = true order by getTime asc";
			$list = json_decode($this -> query($sql)) -> resultArray; 
			for($i = 0; $i < count($list); $i ++) {
				$list[$i] -> commonList = $this -> getCommon($list[$i] -> getUser, $userId);
			}
			return $list;
		}
		
		private function getCommon($targetUser, $userId) {
			$sql = "select a.achieveTitle from tb_achieve a, tb_get g where g.getUser = '$targetUser' and isGet = true and 
				a.achieveId = g.getAchieve and g. getAchieve in (select getAchieve from tb_get where isGet = true and getUser = '$userId')";
			return json_decode($this -> query($sql)) -> resultArray;
		}
		
		public function match($userId) {
			$sql = "select c.*, t.total from (select getUser, count(*) common from tb_get g where getUser <> '$userId' and isGet =true and g.getAchieve in 
				(select getAchieve from tb_get where isGet = true and getUser = '$userId') group by(getUser)) c, 
				(select getUser, count(*) total from tb_get g where getUser <> '$userId' and isGet =true group by(getUser)) t where c.getUser = t.getUser";
			return $this -> query($sql);
		}
		
		public function getCount() {
			$sql = "select count(*) from tb_get where isGet = true and getUser = '$userId'";
			return $this -> getField($sql);
		}
		
		public function getMatchUser($targetUser, $userId) {
			$sql = "select userName, userSex, userSchool, userGrade, userImage, getUser from tb_user where userId = '$targetUser'";
			$match = json_decode($this -> query($sql)) -> resultArray[0];
			$match -> commonList = $this -> getCommon($targetUser, $userId);
			return $match;
		}
		
		public function achieveGetCount($achieveId) {
			$sql = "select count(*) from tb_get where getAchieve = $achieveId and isGet = true";
			return $this -> getField($sql);
		}
	}
?>
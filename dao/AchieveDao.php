<?php 
	require_once('BaseDao.php');
	require_once('GetDao.php');
	require_once('MessageDao.php');
	class AchieveDao extends BaseDao {
		
		/**
		*	发布成就，发布一条成就给该用户成就积分加1分，同时点亮成就另加3分
		*	@Param $userId
		*	@Param $achieveType
		*	@Param $achieveImage
		*	@Param $achieveTitle
		*	@Param $achieveContent
		*	@Param $isGet
		*	@Return
		*/
		public function setAchieve($userId, $achieveType, $achieveImage, $achieveTitle, $achieveContent, $isGet) {
			$sql = "insert into tb_achieve(achieveUser, achieveType, achieveImage, achieveTitle, achieveContent, achieveTime)
				values('$userId', '$achieveType', '$achieveImage', '$achieveTitle', '$achieveContent', now())";
			$id = $this -> getId($sql);
			if($id != 0 && $id != null) {
				$get_sql = "insert into tb_get(getAchieve, getUser, isGet, getTime) values($id, '$userId', $isGet, now())";
				$this -> execute($get_sql);
				
				$score  = 1;
				if((boolean)$isGet)
					$score += 3;
				
				$score_sql = "update tb_user set userCredit = userCredit + $score where userId = '$userId'";
				$this -> execute($score_sql);
				
				return 1;
			}
			return 0;
		}
		
		/**
		*	用户获得或关注的成就
		*	@Param $userId
		*	@Param $getTime	上一次查询用户已经完成的成就的最后一条显示的完成时间，如果是第一次加载则为当前时间
		*	@Param $isConcern( default false) 是否返回关注列表，或已经获得的成就列表，默认为后者
		*	@Return 用户成就列表，分页查询，15条
		*/
		public function getAchieveByUser($userId, $getTime, $isConcern = false) {
			$where_condition = $isConcern? "true": "g.isGet = true";
			$sql = "select u.userName, u.userSchool, u.userGrade, a.*, g.* from tb_user u, tb_achieve a, tb_get g where a.achieveId = g.getAchieve
				and g.getUser = '$userId' and u.userId = a.achieveUser and $where_condition and g.getTime < '$getTime' order by g.getTime desc limit 0, 15";
			return $this -> achieve(null, $sql);
		}
		
		/**
		*	用户关注的成就的相关动态（吐槽或完成）
		*	@Param $userId
		*	@Param $time
		*	@Return 关注的成就的动态列表，按时间降序排列
		*/
		public function getAchieveNewsList($userId, $time) {
			$sql = "select u.userName, u.userSex, u.userImage, t.*, a.achieveTitle, a.achieveImage from ((select g.getId id, g.getAchieve achieveId, 'get' type, 
				g.getUser user, g.getTime time from tb_get g where g.isGet = true) union( select m.mesgId id, m.mesgAchieve achieveId, 'message' type,m.mesgUser user, 
				m.mesgTime time from tb_message m))t, tb_achieve a, tb_user u where a.achieveId = t.achieveId and u.userId = t.user and t.achieveId in (select getAchieve
				from tb_get where getUser = '$userId') and t.time < '$time' order by t.time desc limit 0, 15";
			return $this -> query($sql);
		}
		
		/**
		*	最新发布的成就
		*	@Param $userId
		*	@Param $achieveTime	上一次查询最后一条显示的时间，如果是第一次加载则为当前时间
		*	@Param $lastTime 前一次查看最新成就的时间
		*	@Return 最新成就列表，分页查询，15条
		*/
		public function getAchieveList($userId, $achieveTime, $lastTime) {
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser
				and a.achieveTime < '$achieveTime'  and a.achieveTime > '$lastTime' order by achieveTime desc limit 0, 15";
			return $this -> achieve($userId, $sql, 'achieveTime');
		}
		
		/**
		*	根据类别查询相应成就，该类别下的成就总数及用户已经完成的成就数（默认排序条件：最新）
		*	@Param $userId
		*	@Param $achieveType 成就的类别
		*	@Param $achieveTime
		*	@Return
		*/
		public function getAchieveByType($userId, $achieveType, $achieveTime) {
			$where_condition = $achieveType == "全部"? "true": "a.achieveType = '$achieveType'";
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser and 
				$where_condition and a.achieveTime < '$achieveTime' order by achieveTime desc limit 0, 15";
			return $this -> achieve($userId, $sql, 'achieveTime', $achieveType);
		}
		
			/**
		*	根据类别查询相应成就，该类别下的成就总数及用户已经完成的成就数（默认排序条件：最热）
		*	@Param $userId
		*	@Param $achieveType 成就的类别
		*	@Param $achieveTime
		*	@Return
		*/
		public function getHotAchieve($userId, $achieveType, $pageIndex, $isGetOrder = true) {
			
			
			$start_row = ($pageIndex - 1 ) * 15;
			
			$where_condition = $achieveType == "全部"? "true": "a.achieveType = '$achieveType'";
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser and 
				$where_condition ";
				
			$hot_sql = null;
			if($isGetOrder) {
				$hot_sql = "select r.* , k.sum from ($sql) r left outer join (select g.getAchieve, count(*) sum from tb_get g 
					where isGet = true group by g.getAchieve) k on (k.getAchieve = r.achieveId) order by k.sum desc limit $start_row, 15";
			}
			else { 
				$hot_sql = "select r.* , k.sum from ($sql) r left outer join (select m.mesgAchieve, count(*) sum from tb_message m 
					group by m.mesgAchieve) k on (k.mesgAchieve = r.achieveId) order by k.sum desc limit $start_row, 15";
			}
		
			$hotAchieve = json_decode($this -> achieve($userId, $hot_sql, 'sum', $achieveType));
			$hotAchieve -> pageIndex = $pageIndex;
			$hotAchieve -> achievePerPage = 15;
			$hotAchieve -> totalPage = ($hotAchieve -> totalAchieveCount - $hotAchieve -> totalAchieveCount % $hotAchieve -> achievePerPage)
				/ $hotAchieve -> achievePerPage  + 1;
			
			
			return json_encode($hotAchieve);
		}
		
		/**
		*	推荐的成就，30天之内，用户尚未完成且完成数小于等于3的成就，按时间降序排列
		*	@Param $userId
		*	@Param $achieveTime
		*	@Return 最新成就列表，分页查询，15条
		*/
		public function getRecommendAchieve($userId, $achieveTime) {
			//mysql:date_sub(now(), interval 1 day)
			//mysql:date_add(now(), interval 1 day)
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser and a.achieveTime 
				< '$achieveTime' and a.achieveTime > date_sub(now(), interval 30 day) and a.achieveId not in (select getAchieve from tb_get where 
				getUser = '$userId' and isGet = true) order by achieveTime desc limit 0, 15";
			return $this -> achieve($userId, $sql, 'achieveTime');
		}
		
		/**
		*	搜索成就，根据成就名进行模糊查询
		*	@Param $userId
		*	@Param $achieveSearch
		*	@Return 全部符合条件的成就列表，按时间降序排列
		*/
		public function getAchieveBySearch($userId, $achieveSearch) {
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser and 
				a.achieveTitle like '%$achieveSearch%' order by achieveTime desc";
			return $this -> achieve($userId, $sql, 'achieveTime');
		}
		
		/**
		*	根据成就id，查询成就详情，包括吐槽数和完成数 
		*	@Param $userId
		*	@Param $achieveSearch
		*	@Return
		*/
		public function getAchieve($userId, $achieveId) {
			$sql = "select u.userName, u.userSchool, u.userGrade, a.* from tb_user u, tb_achieve a where u.userId = a.achieveUser and 
				a.achieveId = $achieveId";
			return $this -> achieve($userId, $sql);
		}
		
		/**
		*	特定类别下用户完成的成就数目
		*	@Param $userId
		*	@Param $achieveType
		*	@Return
		*/
		private function userGetCount($userId, $achieveType) {
			$where_condition = $achieveType == "全部"? "true": "a.achieveType = '$achieveType'";
			$sql = "select count(*) from tb_get where getAchieve in (select a.achieveId from tb_achieve a where $where_condition)
				and getUser = '$userId' and isGet = true";
			return $this -> getField($sql);
		}
		
		/**
		*	特定类别下的成就总数
		*	@Param $achieveType
		*	@Return
		*/
		private function totalAchieveCount($achieveType) {
			$where_condition = $achieveType == "全部"? "true": "a.achieveType = '$achieveType'";
			$sql = "select count(*) from tb_achieve a where $where_condition";
			return $this -> getField($sql);
		}
		
		/**
		*	获得成就列表中每条成就的详尽信息，包括吐槽数、完成数
		*	@Param $userId
		*	@Param $sq
		*	@Param $orderField( default '') 排序字段
		*	@Param $achieveType( default '')
		*	@Return
		*/
		private function achieve($userId, $sql, $orderField = '', $achieveType = '') {
			if($userId != null) {
				$sql = "select p.* , g.isGet from ($sql) p left outer join tb_get g on g.getUser = '$userId' and g.getAchieve = p.achieveId ";
				if(!empty($orderField))
					$sql .= "order by p.$orderField desc";
			}
			$achieveList = json_decode($this -> query($sql)) -> resultArray;
			
			$messageDao = new MessageDao();
			$getDao = new GetDao();
			
			$result = (object)array();
			
			if(!empty($achieveType)) {
				$result -> userGetCount = $this -> userGetCount($userId, $achieveType);
				$result -> totalAchieveCount = $this -> totalAchieveCount($achieveType);
			}
			
			foreach($achieveList as $index => $achieve) {
				$achieveId = $achieve -> achieveId;
				$achieve -> getCount = $getDao -> achieveGetCount($achieveId);
				$achieve -> mesgCount = $messageDao -> achieveMessageCount($achieveId);
			}
			
			
			$result -> achieveList = $achieveList;
			
			return json_encode($result);
		}

	}
?>
<?php 
	require_once('BaseDao.php');
	class MessageDao extends BaseDao {
		
		public function setMessage($userId, $mesgAchieve, $mesgContent, $isAnonymity, $mesgPost) {
			$sql = "insert into tb_message(mesgUser, mesgAchieve, mesgContent, mesgTime, isAnonymity, mesgPost) values('$userId',
				$mesgAchieve, '$mesgContent', now(), $isAnonymity, $mesgPost)";
			$id = $this -> getId($sql);
			if($id == null || $id == 0)
				return null;
			
			if(!$isAnonymity) {
				$score_sql = "update tb_user set userCredit = userCredit + 1 where userId = '$userId' and userId <> (select achieveUser from 
					tb_achieve where achieveId = $mesgAchieve)";
				$this -> execute($score_sql);
			}
			
			$select_sql= "select u.userName, u.userSex, u.userImage, m.* from tb_message m, tb_user u where mesgId = $id
				and u.userId = m.mesgUser";
			return $this -> query($select_sql);
		}
		
		public function achieveMessageList($achieveId) {
			$sql = "select u.userName, u.userSex, u.userImage, m.* from tb_message m, tb_user u where m.mesgAchieve = $achieveId 
				and u.userId = m.mesgUser order by mesgTime asc";
			return $this -> query($sql);
		}
		
		public function achieveMessageCount($achieveId) {
			$sql = "select count(*) from tb_message where mesgAchieve = $achieveId";
			return $this -> getField($sql);
		}
	}
?>
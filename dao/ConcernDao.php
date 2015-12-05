<?php
	require_once('BaseDao.php');
	class ConcernDao extends BaseDao{
		
		public function getConcernList($userId){
			$sql="select concernTarget,userName,userSex,userImage,userSchool,userGrade,userMajor from tb_user,tb_concern
				where userId=concernTarget and concernUser='$userId' order by concernId desc";
			return $this->query($sql);
		}
		
		public function setConcern($userId,$concernTarget){
			$sql="insert into tb_concern(concernUser,concernTarget) values('$userId','$concernTarget')";
			return $this->execute($sql);
		}
		
		public function cancelConcern($userId,$concernTarget){
			$sql="delete from tb_concern where concernUser='$userId' and concernTarget='$concernTarget'";
			return $this->execute($sql);
		}
		
		public function isConcern($visitUser,$userId){
			$sql="select count(*) from tb_concern where concernUser='$visitUser' and concernTarget='$userId'";
			if($this->getField($sql)>0)
				return true;
			return false;
		}
	}
?>
<?php
	require_once('BaseDao.php');
	class UserDao extends BaseDao{
		
		public function check($userMark) {
			$sql = "select count(*) from tb_user where userMark ='$userMark'";
			return $this -> getField($sql);
		}
		
		public function register($userId, $userMark, $userName, $userPass) {
			$sql="insert into tb_user(userId, userMark, userName, userPass) values('$userId', 
				'$userMark', '$userName', '$userPass')";
			return $this->execute($sql);
		}
		
		public function getUserPass($userId){
			$sql="select userPass from tb_user where userId='$userId'";
			return $this->getField($sql);
		}
		
		public function getUserPassByMark($userMark) {
			$sql = "select userPass from tb_user where userMark = '$userMark'";
			return $this -> getField($sql);
		}
		
		public function getUserInfoByMark($userMark) {
			$sql = "select userId, userName, userSex, userImage, userNote, userHome, userSchool,
				userGrade, userMajor from tb_user where userMark = '$userMark'";
			return $this -> query($sql);
		}
		public function getUserInfo($userId){
			$sql="select userId,userName,userSex,userImage,userNote,userHome,userSchool,
				userGrade,userMajor from tb_user where userId='$userId'";
			return $this->query($sql);
		}
		
		public function setUserInfo($userId,$field,$value){
			$sql="update tb_user set $field='$value' where userId='$userId'";
			return $this->execute($sql);
		}
	}
?>
<?php
	require_once('BaseDao.php');
	class TagDao extends BaseDao {
		
		/**
		*	管理员权限，添加频道（标签）
		*	@Param $tagName
		*	@Param $tagImage
		*	@Param $tagContent
		*	@Return 频道添加操作影响的行数
		*/
		public function adminSetTag($tagName, $tagImage, $tagContent) {
			$sql = "insert into tb_tag(tagName, tagImage, tagContent, isShow) values('$tagName', '$tagImage',
				'$tagContent', true)";
			return $this -> execute($sql);
		}
		
		/**
		*	管理员权限，变更频道（标签）属性，设置为不可见/可见
		*	@Param $tagName
		*	@Return 频道变更操作影响的行数
		*/
		public function adminAlterTagState($tagName) {
			$sql = "update tb_tag set isShow = !isShow where tagName = '$tagName'";
			return $this -> execute($sql);
		}
		
		/**
		*	管理员权限，修改频道（标签）图片或描述
		*	@Param $tagName
		*	@Param $tagImage
		*	@Param $tagContent
		*	@Return 编辑频道内容影响的行数
		*/
		public function adminEditTag($tagName, $tagImage, $tagContent) {
			$sql = "update tb_tag set tagImage = '$tagImage', tagContent = '$tagContent' where tagName = '$tagName'";
			return $this -> execute($sql);
		}
		
		/**
		*	管理员频道（标签）列表
		*	@Param $isShow 是否可见（删除）
		*	@Return 获得当前频道列表或已经删除的列表
		*/
		public function adminGetTag($isShow) {
			$sql = "select * from tb_tag where isShow = $isShow";
			return $this -> query($sql);
		}
		
		/**
		*	获得频道（标签）的名称、图片和描述
		*	@Param $userId
		*	@Return 已经关注的标签和尚未关注的列表
		*/
		public function getTag($userId) {
			$concerned_sql = "select t.tagName, t.tagImage, t.tagContent from tb_tag t where t.isShow = true and 
				tagName in (select c.tagName from tb_tag_concern c where c.tagUser = '$userId')";
			$not_concerned_sql = "select t.tagName, t.tagImage, t.tagContent from tb_tag t where t.isShow = true and
				tagName not in (select c.tagName from tb_tag_concern c where c.tagUser = '$userId')";
				
			$tag = (object)array();
			$tag -> concernedList = json_decode($this -> query($concerned_sql)) -> resultArray;
			$tag -> hotList = json_decode($this -> query($not_concerned_sql)) -> resultArray;
			return json_encode($tag);
		}
	}
?>
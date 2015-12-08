<?php
	class DefaultImage {
		private $php_url;
		private $php_path;
		
		public function __construct() {
			$this -> php_url = dirname($_SERVER['PHP_SELF']) . '/';
			$this -> php_path = dirname(__FILE__) . '/';
		}
		private function defaultImage($file_dir) {
			$current_url = $this -> php_url . $file_dir . '/';
			$current_path = realpath($this -> php_path . $file_dir . '/');
			
			$file_list = array();
			if($handle = opendir($current_path)) {
				
				while(false !== ($file_name = readdir($handle))) {
					if ($file_name{0} == '.') continue;
					$file = $current_path . $file_name;
					if (!is_dir($file)) {
						$file_list[] = $current_url . $file_name;
					} 
				}
				closedir($handle);
			}
			
			return $file_list;
		}
		
		public function defaultAchieveImage() {
			return $this -> defaultImage("achieveImage/default");
		}
		
		public function defaultPageImage() {
			return $this -> defaultImage("pageImage");
		}
	}
?>
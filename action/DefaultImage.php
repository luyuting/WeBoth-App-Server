<?php
	class DefaultImage {
		private $php_url;
		private $php_path;
		
		public function __construct() {
			$this -> php_url = dirname($_SERVER['PHP_SELF']) . '/';
			$this -> php_path = dirname(__FILE__) . '/';
		}
		
		public function defaultAchieveImage() {
			$current_url = $this -> php_url . 'achieveImage/default/';
			$current_path = realpath($this -> php_path . 'achieveImage/default/');
			
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
	}
?>
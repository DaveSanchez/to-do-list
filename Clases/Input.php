<?php 

class Input {

	public static function get($item) {
		if(isset($_POST[$item])) {
			return $_POST[$item];
		}
		if(isset($_GET[$item])) {
			return $_GET[$item];
		}
		return "";
	}

	public static function exists($source = "post") {
		switch ($source) {
			case 'post':
				return (!empty($_POST)) ? true: false;
				break;
			case 'get':
				return (!empty($_GET)) ? true: false;
			break;	
			default:
				return false;
			break;
		}
	}

	public static function isAlfNum($item) {
		if(!ctype_alnum($item)) {
			return false;
		}
		return true;
	}

}

?>
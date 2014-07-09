<?php 

class Ajax {
	public static function exists() {
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	return true;
		}
		return false;
	}
}

?>
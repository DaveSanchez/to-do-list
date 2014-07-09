<?php 

class Session {
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	public static function exists($session) {
		return (isset($_SESSION[$session])) ? true: false;
	}

	public static function get($session) {
		return $_SESSION[$session];
	}

	public static function delete($session) {
		if(self::exists($session)) {
			unset($_SESSION[$session]);
		}
	}
}

?>
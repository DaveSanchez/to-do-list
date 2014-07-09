<?php 

class Hash {

	public static function make($string, $salt = "") {
		return hash("sha256", $string.$salt);
	}

	public static function salt() {
		return base64_encode(mcrypt_create_iv(ceil(0.75*12), MCRYPT_DEV_URANDOM));
	}


}

?>
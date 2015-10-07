<?php 

class Redirect {

	public static function to($path = null) {
		return header("location: ".$path);
	}

}

?>
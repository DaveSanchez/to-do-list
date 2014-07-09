<?php 

class User {
	private $_db = null,
			$_isLoggedIn = false,
			$_data,
			$_sessionId;


	public function __construct(DB $_db) {
		$this->_db = $_db;
		$this->_sessionId = Config::get("session/session_name");
		if(Session::exists($this->_sessionId)) {
			$user = Session::get($this->_sessionId);
			if($this->find($user)) {
				$this->_isLoggedIn = true;
			}
		}
	}

	public function newUser($fields = array(), $values = array()) {
		if(!$this->_db->Insert("users", $fields)->Go($values)) {
			return false;
		}	
		return true;
	}

	public function find($key = null) {
		$campo = is_numeric($key) ? "Id_user" : "user_nick";
		$user = $this->_db->Get("users")->Where($campo,"=")->Go(array($key));
		if($user->count()) {
			$this->_data = $user->first();
			return true;
		}
		return false;
	} 

	public function login($username = null, $password = null) {
		$user = $this->find($username);
		if($user) {
			if($this->data()->user_password === Hash::make($password, $this->data()->user_salt)) {
				Session::put($this->_sessionId, $this->data()->Id_user);
				return true;
			}
		}
		return false;
	}

	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
	
}

?>
<?php 

class Validate {

	private $_db = null,
			$_errors = [],
			$_passed = false;

	public function __construct(DB $db) {
		$this->_db = $db;
	}

	public function check($fuente, $params = array()) {
		foreach ($params as $fields => $field) {
			foreach($field as $rule => $rulevalue) {
				if($rule === "display") {
					$display = $rulevalue;
				}
				if($rule === "required" && empty($fuente[$fields])) {
					$this->addError("El campo ".$display." es requerido");
				}
				
				else if(!empty($fuente[$fields])){
					switch ($rule) {
						case 'minlength':
						if(strlen($fuente[$fields])<$rulevalue) {
									$this->addError("El campo ".$display." debe contener al menos ".$rulevalue." caracteres");
								}
								break;
						case 'maxlength':
								if(strlen($fuente[$fields])>$rulevalue) {
									$this->addError("El campo ".$display." no debe contener mas de ".$rulevalue." caracteres");
								}
								break;
						case 'match':
								if($fuente[$fields] != $fuente[$rulevalue]) {
									$this->addError("Los campos de ".$display." no coinciden");
								}
								break;
						case "alnum":
								if(!Input::isAlfNum(Input::get($fields))) {
									$this->addError("El campo ".$display." debe ser alfanumerico");	
								}
								break;	
						
						default:
							# code...
							break;
					}	
				}				
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		} 
		return $this;
	}

	protected function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}



}

?>
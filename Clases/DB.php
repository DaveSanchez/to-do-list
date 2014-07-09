<?php 

class DB {
	private static $_link = null;
	private $_pdo,
			$_query,
			$_count = 0,
			$_error = false,
			$_results,
			$_operators = array ("<",">","<=",">=","<>");

	public function __construct() {
		$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));    	//$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function Get($table) {
		$this->_query = "SELECT * FROM ".$table;
		return $this;
	}

	public function Insert($table, $params = array()) {
		$keys = "";
		$values = "";
		$keys = implode("`, `", $params);
		$x = 1;
		foreach($params as $param) { 
			$values .= "?";
			if($x<count($params)) {
				$values .= ",";
			}
			$x++;
		}
			
		$this->_query = "INSERT INTO {$table} (`".$keys."`) VALUES (".$values.")";
		return $this;
	}

	public function Go($params = array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($this->_query)) {
			$x = 1;
			//var_dump($this->_query);
			if(isset($params) && !empty($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}
			else {
				$this->_error = true;
			}
		}
		return $this;
	}

	public function delete($table, $campo = null) {
		$this->_query = "DELETE FROM {$table} WHERE {$campo} = ?";
		return $this;
	}

	public function update($table, $campos = null, $id, $operator) {
		$this->_query = "UPDATE {$table} SET {$campos} WHERE {$id} {$operator} ?";
		return $this;
	}

	public function ANDC($and) {
		$this->_query = $this->_query." AND ".$and."?";
		return $this;
	}
	
	public function Where($field, $operator) {
		$this->_query = $this->_query." WHERE ".$field." ".$operator." ? ";
		return $this;
	}

	public function limit($limit, $perpage) {
		$this->_query = $this->_query." LIMIT ".$limit.", ".$perpage;
		return $this;
	}

	public function innerJ($table1, $column1, $table2, $column2) {
		$this->_query = $this->_query." INNER JOIN ".$table2." ON ".$table1.".".$column1."=".$table2.".".$column2;
		return $this;
	}

	public function orderBy($campo, $AsOrDes) {
		$this->_query = $this->_query." ORDER BY ".$campo." ".$AsOrDes;
		return $this;
	}

	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}

	public function results() {
		return $this->_results;
	}

	public function first()
	{
		return $this->_results[0];
	}
}

?>
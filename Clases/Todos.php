<?php 

class Todos {
	private $_db = null,
			$_allTodos,
			$_numTodos,
			$_pages,
			$_todosPerPage = 5;

	public function __construct(DB $db, $iduser = null) {
		date_default_timezone_set('America/Mexico_City');
		$this->_db = $db;
		if($iduser) {
			$this->hasFailed($iduser);
		}
	}

	public function hasFailed($iduser) {
		$ongoing = $this->_db->update("todo", "Id_flag = ?", "todo_dateStart", "<=")->ANDC("Id_flag <> ")->ANDC("Id_user = ")->Go(array("2",date("Y-m-d"), "3", $iduser));
		$passed = $this->_db->update("todo", "Id_flag = ?", "todo_dateEnd", "<")->ANDC("Id_user = ")->Go(array("4",date("Y-m-d"),$iduser));
	}

	public function newTodo($fields = array(), $values = array()) {
		if(!$this->_db->Insert("todo",$fields)->Go($values)) {
			return false;
		}return true;
	}

	public function getTodos($campo, $operator, $values = array()) {
		$alltodos = $this->_db->Get("todo")->Where($campo,$operator)->Go($values);
		if($alltodos->count()) {
			$this->_allTodos = $alltodos->count();
		}
		return $this;
	}

	public function pages($total, $perpage) {
		$this->_pages = ceil($total / $perpage);
		return $this;
	}

	public function pagesNeeded() {
		return $this->_pages;
	}

	public function numTodos() {
		return $this->_allTodos;
	}

	public function paginateTodos($campo, $operator, $limit, $resultsPerPage, $params = array()) {
		$results = $this->_db->Get("todo")->innerJ("todo","Id_flag","flags","Id_flag")->Where($campo,$operator)->orderBy("Id_todo","DESC")->limit($limit, $resultsPerPage)->Go($params);
		if($results->count()) {
			$this->_allTodos = $results->results();
			$this->_numTodos = $results->count();
		}
		return $this;
	}

	public function deleteTodo($id = null) {
		$delete = $this->_db->delete("todo","Id_todo")->Go(array($id));
		if(!$delete->error()) {
			return true;
		}return false;
	}

	public function updateTodo($campos = array(), $values = array()) {
		$params = "";
		$x=1;
		foreach ($campos as $campo) {
				$params.=$campo;
				if($x<count($campos)) {
					$params.=", ";
				}
				$x++;
		}

		$update = $this->_db->update("todo", $params ,"Id_todo", "=")->Go($values);
	}

	public function doneTodo($id = null) {
		$done = $this->_db->update("todo","Id_flag = ?", "Id_todo", "=")->Go(array("3",$id));
		if(!$done->error()){
			return true;
		}return false;
	}

	public function todosPerPage() {
		return $this->_todosPerPage;
	}
}

?>
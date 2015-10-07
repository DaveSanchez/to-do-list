<?php 

class Paginate {

	private $_db = null;

	public function __construct(DB $db) {
		$this->_db = $db;
	}

	public function paginateTodos($resultsPerPage) {
		$results = $this->_db->Get("todo")
	}

}

?>
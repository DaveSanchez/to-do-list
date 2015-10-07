<?php 
require_once "Core/init.php";
	if(Ajax::exists()) {
		$todos = new Todos(new DB);
		switch (Input::get("action")) {
			case 'delete':				
				$deleteTodo = $todos->deleteTodo(Input::get("idTodo"));
				if($deleteTodo): ?>
				<?=true;?>
		  <?php endif;	
				break;
				case 'done':
				$deleteTodo = $todos->doneTodo(Input::get("idTodo"));
				if($deleteTodo): ?>
				<?=true;?>
		  <?php endif;		
				break;
				case 'update':
	            $updateTodo = $todos->updateTodo(array("todo_name = ?", "todo_description = ?", "todo_dateStart = ?", "todo_dateEnd = ?"),
                                            array(Input::get("tarea"), Input::get("descr"), Input::get("fs"), Input::get("fe"), Input::get("idTodo")));
                if($updateTodo){ ?>
				<?=true;?>
		  <?php }else {?>
				<?=false;?>	
		  		<?php }
       			break;			
				default: ?>
				<?=false;?>	
				<?php break;
		}
	}
?>
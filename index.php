<?php 
require_once "Core/init.php";
$user = new User(new DB);
if(!$user->isLoggedIn()) {
    Redirect::to("./");
}
$msgsT = array();
$newTodo = false;
if(Input::exists()) {
    if(Token::check(Input::get("csrfToken"))) {
        $validate = new Validate(new DB);
        $NewTodoValidation = $validate->check($_POST, array(
                                        "Tarea" => array(
                                            "display" => "tarea",
                                            "required" => true,
                                            "maxlength" => 30,
                                            ),
                                        "taDescr" => array(
                                            "display" => "descripción",
                                            "required" => true,
                                            "maxlength" => 250
                                            )
                                            ));
        if($NewTodoValidation->passed()) {
            $todo = new Todos(new DB);
            $newTodo = $todo->newTodo(array("todo_name","todo_description","todo_dateCreated","todo_dateStart","todo_dateEnd","Id_user","Id_flag"),
                                        array(Input::get("Tarea"), Input::get("taDescr"), date("Y-m-d"), Input::get("tfDS"), Input::get("tfDE"), $user->data()->Id_user, "1"));
        }else {
            foreach($NewTodoValidation->errors() as $errors) {
                $msgsT [] = $errors;
            }
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>To do list</title>
	<link rel="stylesheet" href="public/css/doc.css">
    <link rel="stylesheet" href="public/css/uikit.gradient.min.css">
    <link rel="stylesheet" href="public/css/addons/uikit.almost-flat.addons.min.css">
</head>
<body>
	<div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                    <div class="uk-vertical-align uk-text-center">
                        <div class="uk-vertical-align-middle uk-width-1-2">
                            <h1 class="uk-heading-large">To-do list</h1>
                            <h4>Hola <?=$user->data()->user_nick?></h4>
                            <p>
                                <a class="uk-button uk-button-primary uk-button-large" href="#new-todo" data-uk-modal><i class="uk-icon-plus"></i> Nueva</a>                                
                            </p>
                        </div>
                    </div>
                    <?php 
                    if($newTodo) { ?>                        
                    <div class="uk-vertical-align uk-text-center uk-height-1-1">
                        <div class="uk-vertical-align-middle">
                            <div class="uk-alert uk-alert-success">
                                <a href="" class="uk-alert-close uk-close"></a>
                                <p>Tarea guardada</p>
                            </div> 
                        </div>
                    </div>       
                    <?php }
                   elseif(!empty($msgsT)) { ?>
                    <div class="uk-vertical-align uk-text-center uk-height-1-1">
                        <div class="uk-vertical-align-middle">
                            <div class="uk-alert uk-alert-danger">
                                <?php foreach($msgsT as $ms): ?>
                                    <p><?=$ms?></p>
                                <?php endforeach; ?>
                            </div> 
                        </div>
                    </div>                                                               
                    <?php } ?>

                    <div id="new-todo" class="uk-modal">
                        <div class="uk-modal-dialog">
                            <a class="uk-modal-close uk-close"></a>
                            <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST" class="uk-form uk-form-horizontal">
                                <input type="hidden" name="csrfToken" value="<?=Token::make();?>">
                                <div class="uk-form-row">
                                    <label for="tfTarea" class="uk-form-label">Tarea</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-1" id="tdTarea" name="Tarea">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="idDescr">Descripción</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <textarea name="taDescr" id="idDescr" class="uk-width-1-1" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="tfFechaI">Inicia</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-3" name="tfDS" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="tfFechaI">Termina</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-3" name="tfDE" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <button class="uk-button uk-button-primary">Crear</button>
                                </div>
                            </form>
                        </div>
                    </div>

                     <div id="update-todo" class="uk-modal">
                        <div class="uk-modal-dialog">
                            <a class="uk-modal-close uk-close"></a>
                            <form method="POST" class="uk-form uk-form-horizontal">
                                <input type="hidden" name="csrfToken" value="<?=$token;?>">
                                <div class="uk-form-row">
                                    <label for="utdTarea" class="uk-form-label">Tarea</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-1" id="utdTarea" name="uTarea">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="uidDescr">Descripción</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <textarea name="utaDescr" id="uidDescr" class="uk-width-1-1" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="uidtfDS">Inicia</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-3" name="utfDS" id="uidtfDS" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="uidtfDE">Termina</label>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-2">
                                            <input type="text" class="uk-width-1-3" name="utfDE" id="uidtfDE" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                            <input type="hidden" name="idTUpdate" id="idUpdate">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <input type="hidden" id="idTodo" name="idTodo" value="">
                                    <button type="button" class="uk-button uk-button-primary btnUpTodo">Actualizar</button>
                                </div>
                                <div id="updatediv"></div>
                            </form>
                        </div>
                    </div>
                    <div class="uk-width-medium-2-3 uk-container-center">
                        <?php $getTodos = new Todos(new DB, $user->data()->Id_user); 
                            $allTodos = $getTodos->getTodos("Id_user","=",array($user->data()->Id_user));
                            $totalTodos = $allTodos->numTodos();
                            $totalTodosPerPage = $getTodos->todosPerPage();
                            if(count($totalTodos)) { 
                                $pagesToUse = $getTodos->pages($allTodos->numTodos(), $totalTodosPerPage);
                                $totalPages = $pagesToUse->pagesNeeded();
                                $page = ((Input::get("page"))) ? (int)Input::get("page"):1;
                                $start = ($page-1)*$totalTodosPerPage;
                                $listTodos = $getTodos->paginateTodos("Id_user","=",$start,$totalTodosPerPage,array($user->data()->Id_user));
                                ?>
                        <table class="uk-table uk-table-striped">
                            <caption>Lista de que haceres</caption>
                            <thead>
                                <tr>
                                    <th>Tarea</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Inicia</th>
                                    <th>Termina</th>
                                    <th>Estado</th>
                                    <th>*</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listTodos->numTodos() as $listTodos): ?>
                                <tr id="<?=$listTodos->Id_todo;?>">                                    
                                    <td id="todoNom"><?=$listTodos->todo_name;?></td>
                                    <td id="todoDes"><?=$listTodos->todo_description;?></td>
                                    <td id="todoDC"><?=$listTodos->todo_dateCreated;?></td>
                                    <td id="todoDS"><?=$listTodos->todo_dateStart;?></td>
                                    <td id="todoDE"><?=$listTodos->todo_dateEnd;?></td>
                                    <td>
                                        <?php switch ($listTodos->Id_flag) {
                                            case "1": ?>
                                                    <span id="estado" class="uk-text-bold"><?=$listTodos->flag_name;?></span>
                                            <?php break;
                                            case "2":?>
                                                    <span id="estado" class="uk-text-bold uk-text-primary"><?=$listTodos->flag_name;?></span>
                                            <?php break;
                                            case "3":?>
                                                    <span id="estado" class="uk-text-bold uk-text-success"><?=$listTodos->flag_name;?></span>
                                            <?php break;
                                            case "4":?>
                                                    <span id="estado" class="uk-text-bold uk-text-danger"><?=$listTodos->flag_name;?></span>
                                            <?php break;
                                            
                                             default:
                                            break;
                                        }?>
                                    </td>
                                    <td>
                                        <div class="uk-button-group">
                                            <button class="uk-button btnHecho" data-uk-tooltip title="Hecho"><i class="uk-icon-check"></i></button>
                                            <button class="uk-button btnDelete" data-uk-tooltip title="Eliminar"><i class="uk-icon-eraser"></i></button>
                                            <a class="uk-button btnUpdate" data-uk-tooltip title="Editar" href="#update-todo" data-uk-modal><i class="uk-icon-edit"></i></a>                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>                            
                        </table>
                        <?php if($totalTodos>$totalTodosPerPage): ?>
                            <ul class="uk-pagination">
                                <?php for ($i=1; $i <= $totalPages; $i++) {?>
                                    <?php if($page == $i){ ?>
                                        <li class="uk-active">
                                            <span><a href="?page=<?=$i;?>" class="link-paginate"><?=$i;?></a></span>
                                        </li>
                                    <?php }
                                          else{ ?>
                                         <li>
                                            <a href="?page=<?=$i;?>"><?=$i;?></a>
                                        </li>
                                        <?php } ?>                                 
                                <?php } ?>
                            </ul>
                        <?php endif; ?>        
                        <?php } else { ?>
                            <div class="uk-alert">
                                <p>No existen tareas!</p>
                            </div>
                        <?php } ?>
                        <div id="msg"></div>
                    </div>                    
                </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>                
<script src="public/js/uikit.min.js"></script>
<script src="public/js/todo.js"></script>                
<script src="public/js/addons/datepicker.js"></script> 
</body>
</html>


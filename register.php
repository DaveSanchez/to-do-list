<?php require_once "Core/init.php"; ?>
<!DOCTYPE html>
<html lang="es-en">
<head>
	<meta charset="UTF-8">
	<title>Registro</title>
    <link rel="stylesheet" href="public/css/doc.css">
	<link rel="stylesheet" href="public/css/uikit.gradient.min.css">
</head>
<body class="uk-height-1-1">

        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width: 250px;">
                <?php
                $newUser = false; 
                $errorsV = array();
                $userLogin = new User(new DB);
                if(!$userLogin->isLoggedIn()){
                if(Input::exists()){
                    if(Token::check(Input::get("csrfToken"))) {
                        $validate = new Validate(new DB);
                        $validation = $validate->check($_POST,array(
                                                    "userRegister" => array(
                                                    "display" => "usuario",
                                                    "required" => true,
                                                    "minlength" => 5,
                                                    "maxlength" => 15,
                                                    "alnum" => true,
                                                    "unique" => "user_nick"
                                                    ),
                                                    "passwordRegister" => array(
                                                    "display" => "contraseña",
                                                    "required" => true,
                                                    "minlength" => 5,
                                                    "match" => "passwordAgainRegister"
                                                    ))
                            );
                        if($validation->passed()) {
                            $user = new User(new DB);
                            $salt = Hash::salt();
                            $newUser = $user->newUser(array("user_nick","user_password","user_salt"),
                                                      array(Input::get("userRegister"), 
                                                            Hash::make(Input::get("passwordRegister"), $salt), 
                                                            $salt));
                        } else {
                            foreach($validation->errors() as $errors) {
                                $errorsV[] = $errors;
                            }
                        }
                    }
                }
            } else {Redirect::to("./");} 
                ?>                
            <!--    <div class="uk-alert uk-alert-danger">Usuario y/o contraseña incorrecta</div>-->
                <img class="uk-margin-bottom" width="140" height="120" src="public/img/user_icon.png" alt="">
                <form class="uk-panel uk-panel-box uk-form form-register" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" autocomplete="off">
                    <input type="hidden" name="csrfToken" value="<?=Token::make()?>">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" id="tfUser" name="userRegister" type="text" placeholder="Username" value="<?=Input::get("user")?>">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" id="tfPassword" name="passwordRegister" type="password" placeholder="Password">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" id="tfPasswordAgain" name="passwordAgainRegister" type="password" placeholder="Confirmar password">                        
                    </div>                    
                    <div class="uk-form-row">
                        <button class="uk-width-1-1 uk-button uk-button-primary uk-button-large" id="btnRegister" type="submit">Registrarme</button>
                    </div>                    
                </form>
                <?php 
                if($newUser) { ?>                        
                    <div class="uk-alert uk-alert-success">
                        <h2>Usuario registrado!</h2>
                        <a href="login.php" class="uk-button uk-button-success">Iniciar sesión</a>
                    </div>        
                <?php } elseif(!empty($errorsV)) { ?>
                    <div class="uk-alert uk-alert-danger">
                        <?php foreach($errorsV as $eV): ?>
                            <p><?=$eV?></p>
                        <?php endforeach; ?>
                    </div>                                        
                <?php } ?>
            </div>
        </div>

    </body>
</html>
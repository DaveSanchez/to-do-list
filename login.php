<?php require_once "Core/init.php"; ?>
<!DOCTYPE html>
<html lang="es-en">
<head>
	<meta charset="UTF-8">
	<title>Log In</title>
	<link rel="stylesheet" href="public/css/uikit.gradient.min.css">
    <link rel="stylesheet" href="public/css/addons/uikit.almost-flat.addons.min.css">
</head>
 <body class="uk-height-1-1">
        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width: 250px;">
                <?php 
                $errorsL = array();
                $userLogin = new User(new DB);
                if(!$userLogin->isLoggedIn()){
                if(Input::exists()){
                    if(Token::check(Input::get("csrfToken"))) {
                     $validate = new Validate(new DB);
                     $validateLogin = $validate->check($_POST,array(
                            "Loginuser" => array(
                                "display" => "usuario",
                                "required" => true    
                                ),
                            "Loginpassword" => array(
                                "display" => "contraseña",
                                "required" => true    
                                )
                        )); 

                        if($validateLogin->passed()) {
                            if($user = $userLogin->login(Input::get("Loginuser"), Input::get("Loginpassword"))) {
                                Redirect::to("./");
                            }
                            $login = $userLogin->login(Input::get("Loginuser"), Input::get("Loginpassword"));
                            if($login) {
                                   echo "logged";
                            }    
                             else {
                                $errorsL[] = "Usuario y/o contraseña incorrecta.";
                            }                            
                        } else {
                            foreach($validateLogin->errors() as $error) {
                                $errorsL [] = $error;
                            }
                        }
                    }
                }

            }else {
                Redirect::to("./");
            } 

                ?>
                <div id="modalmail" class="uk-modal">
                    <div class="uk-modal-dialog">
                        <a class="uk-modal-close uk-close"></a>
                        <div id="form-recoverPass">
                            <form class="uk-form uk-form-stacked" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="tfMailRecover">Correo:</label>
                                    <div class="uk-form-row uk-width-1-1">
                                        <input type="text" id="tfMailRecover" name="mail" placeholder="">
                                        <button type="button" class="uk-button uk-button-primary" id="btnSendMail">Enviar</button>
                                        <div id="msg"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>        
                <img class="uk-margin-bottom" width="140" height="120" src="public/img/user_icon.png" alt="">
                <form class="uk-panel uk-panel-box uk-form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" autocomplete="off">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" id="tfUser" name="Loginuser" type="text" placeholder="Username" value="<?=Input::get("Loginuser")?>">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" id="tfPassword" name="Loginpassword" type="password" placeholder="Password">
                        <input type="hidden" name="csrfToken" value="<?=Token::make()?>">
                    </div>                    
                    <div class="uk-form-row">
                        <button class="uk-width-1-1 uk-button uk-button-primary uk-button-large" id="btnLogin" type="submit">Login</button>
                    </div>
                </form>
                <?php if(!empty($errorsL)) { ?>
                    <div class="uk-alert uk-alert-danger">
                        <?php foreach($errorsL as $eL): ?>
                            <p><?=$eL?></p>
                        <?php endforeach; ?>
                    </div>                                        
                <?php } ?>    
            </div>
        </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>                
<script src="public/js/uikit.min.js"></script> 
<script src="public/js/todo.js"></script> 
</body>
</html>
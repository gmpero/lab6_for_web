<?php
    session_start();
    
    if(isset($_SESSION['id'])) // если мы уже зашли
    {
        header('Location: lk.php'); 
        exit();
    }
    if(isset($_SESSION["error_messages"])&&!empty($_SESSION["error_messages"])){
        $err =  "{$_SESSION["error_messages"]} Попробуйте еще раз хд)";
        unset($_SESSION["error_messages"]);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/auth.css" rel="stylesheet" type="text/css">
    <title>Авторизация</title>
</head>
<body>
    
    <div class = "errors">
        <h1>
            <?php 
                if(isset($err))
                    echo "$err"; 
            ?>
        </h1>
    </div> 
    
    <div class = "auth">
        <h2>Авторизация</h2>
        <form action="php/auth.php" method="POST">
            <table>
                <tr>
                    <td>Логин:</td>
                    <td><input type="text" size="25" maxlength="64" name="login"></td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td><input type="password" size="25" maxlength="64" name="password"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><input type="submit" value="Войти" name="submit"></td>
                </tr>
            </table>
        </form>

        <a href="https://oauth.vk.com/authorize?client_id=7707640&display=page&redirect_uri=http://localhost/php/php/auth_vk.php&response_type=code">
                <img height="50" width="50" src="data/vk_logo.png">
        </a>
        <h1><a href="form_registration.html">Регистрация</a></h1>
    </div>
    
</body>
</html>
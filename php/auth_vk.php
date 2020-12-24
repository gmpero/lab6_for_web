<?php
    session_start();
    require_once("bdconnect.php");
    
    unset($_SESSION['error_message']);

    if(!isset($_POST['submit']))
    {
        if(isset($_SESSION['id']))
        {
            header("Location: ".$address_site."lk.php");
        }
        
        if(isset($_GET['code']))
        {
            $code = $_GET['code'];
        }
        else
        {
            exit("Нет кода");
        }

        $get_token = file_get_contents("https://oauth.vk.com/access_token?client_id=7707640&display=page&redirect_uri=http://localhost/php/php/auth_vk.php&client_secret=FnqszXbZIM8QOQYrXsFc&code=".$code);

        if(!$get_token)
        {
            exit("Нет токена");
        }

        $token = json_decode($get_token, true);
        $id_vk = $token['user_id'];

        $result = $mysqli->query("SELECT* FROM user WHERE id_vk = $id_vk");

        if($result->num_rows == 0) // проверяем, есть ли такой пользователь в базе
        {
            $_SESSION['error_messages'] = "К данному ВК не привязан аккаунт нашего сервиса!";
            header("Location: ".$address_site."auth_form.php");
        }
        else
        {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['id_vk'] = $row['id_vk'];
            $_SESSION['login'] = $row['login'];
            
            header("Location: ".$address_site."lk.php");
        }
    }
    else
    {
        exit("Нельзя переходить по прямой ссылке");
    }
?>
<?php

    session_start();
    require_once("bdconnect.php");

    //Если нажата кнопка
    if(isset($_POST['submit']))
    {
        if(empty($_POST['login'])){
            $_SESSION["error_messages"] = 'Сэр! Вы не ввели Логин.';
        }
        else if(empty($_POST['password'])){
            $_SESSION["error_messages"] = 'Сэр! Вы не ввели Пароль.';
        }
        else
        {   
            $password = md5($_POST['password']);
            $sql = "SELECT * FROM user WHERE login = '{$_POST['login']}'";
            
            $result = mysqli_query($mysqli, $sql);
            
            if($row = mysqli_fetch_array($result))
            {
                if($row['password']==$password)
                {
                    $_SESSION['login'] = $row['login']; // Логин запомним и id
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['id_vk'] = $row['id_vk'];
                }
                else
                    $_SESSION["error_messages"] = 'Неверный пароль!';
            }
            else
                $_SESSION["error_messages"] = "Логин \"". $_POST['login'] ."\" не найден!";
        }

    }
    else
    {
        exit('Переход по прямой ссылке запрещён');
    }
    
    if(!empty($_SESSION["error_messages"])) //если была ошибка, то возвращаем нас обратно в форму авторизации
    {
        header("Location: ".$address_site."auth_form.php");
    }
    else
    {
        header("Location: ".$address_site."lk.php");
    }

?>
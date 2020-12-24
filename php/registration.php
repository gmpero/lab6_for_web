<?php
    session_start();
    require_once("bdconnect.php");

    if(!isset($_SESSION['captcha']) || $_POST['captcha']!=$_SESSION['captcha'])
    {
        echo 'Вы не так ввели капчу!';
        exit();
    }
    
    $login = $_POST['login'];
    $password = md5($_POST['password']); // сразу хешируем
    
    $result = $mysqli->query("SELECT id FROM user WHERE login = '$login'");

    if(mysqli_fetch_array($result)) // если он что-то нашёл
    {
        echo 'Такой логин уже занят!';
        exit();
    }
    
    $reg = $mysqli->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
    $reg->bind_param("ss", $login, $password);
    $reg->execute();
    $reg->close();
?>
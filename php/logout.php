<?php
    //Запускаем сессию
    session_start();
    require_once("bdconnect.php");

    unset($_SESSION['id']);
    unset($_SESSION['login']);
    unset($_SESSION['id_vk']);
     
    header("Location: ".$address_site."auth_form.php");
?>
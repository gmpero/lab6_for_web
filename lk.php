<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header("Location: auth_form.php");
    }
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lk.css" rel="stylesheet" type="text/css">
        <title>Личный кабинет</title>
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    </head>

    <body>
        
        <div id="display">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2216.8999093128036!2d44.42159863653636!3d48.64135906249554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x41052d9f0d97618f%3A0x11a1a6099a60a532!2z0JLQvtC70LPQvtCz0YDQsNC00YHQutC40Lkg0LPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INGD0L3QuNCy0LXRgNGB0LjRgtC10YI!5e0!3m2!1sru!2sru!4v1608813786687!5m2!1sru!2sru" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        
        <div style=" text-align:center;"><h1><a href="car/index.php">Посмотреть авто</a></h1></div>
        
        <div class="good">
            <table>
                <tr><td>
                    <h2>Вы авторизовались!<br>
                        <?php echo $_SESSION['login']; ?><br>
                        <a href="php/logout.php">Выйти из учётной записи</a>
                    </h2>
                </td></tr>
                <?php
                    if($_SESSION['id_vk'] == NULL)
                    {
                ?>      
                        <tr><td>
                            <h3>Можно привязать к соц. сетям:</h3>
                            <a class="link_auth_vk" href="https://oauth.vk.com/authorize?client_id=7707640&display=page&redirect_uri=http://localhost/php/php/add_vk.php&response_type=code">
                                <h2>Привязать к ВК</h2>
                            </a>
                        </td></tr>
                <?php
                    }
                    else
                    {
                ?>
                    <tr><td>
                        <h2>id привязанного к Вам аккаунта ВК:<br>
                            <a href="https://vk.com/id<?php echo $_SESSION['id_vk']; ?>" alt="no"><?php echo $_SESSION['id_vk']; ?></a>
                        </h2>
                    </td></tr>    
                <?php
                    }
                ?>
            </table>
        </div>
            
    </body>
</html>
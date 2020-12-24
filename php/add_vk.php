<?php
    session_start();
    require_once("bdconnect.php");
    
    if(!isset($_SESSION['id']))
    {
        exit("Это доступно только для авторизовавшихся");
    }

    if(isset($_GET['code']))
    {
        $code = $_GET['code'];
    }
    else
    {
        exit("Нет кода");
    }

    $get_token = file_get_contents("https://oauth.vk.com/access_token?client_id=7707640&display=page&redirect_uri=http://localhost/php/php/add_vk.php&client_secret=FnqszXbZIM8QOQYrXsFc&code=".$code);

    if(!$get_token)
    {
        exit("Нет токена");
    }

    $token = json_decode($get_token, true);
    $id_vk = $token['user_id'];
    
    $result = $mysqli->query("SELECT id_vk FROM user WHERE id_vk = $id_vk");

    if($result->num_rows > 0) // проверяем, есть ли такой пользователь в базе
    {
        echo '<a href="'.$_SERVER['HTTP_REFERER'].'">Вернуться назад</a><br>';
        exit("Данный ВК уже привязан к пользователю");
    }
    else
    {
        $result = $mysqli->prepare("UPDATE user SET id_vk = ? WHERE id = ?");
        $result->bind_param("ii", $id_vk, $_SESSION['id']);
        $result->execute();
        $result->close();
        
        $_SESSION['id_vk'] = $id_vk;

        header("Location: ".$address_site."lk.php");
    }
?>
<?php
    //$access_token = $token['access_token'];    
    /*
            $get_data = file_get_contents("https://api.vk.com/method/users.get?user_id=".$user_id."&access_token=".$access_token."&fields=uid,first_name,last_name,photo_big,sex,city,country,bdate&v=5.52");
            if(!$get_data){
                exit("Нет данных");
            }
            $data = json_decode($get_data, true)['response'][0];

            echo "<img src='".$data['photo_big']."'/><br>";
            echo "Имя: ".$data['first_name']."<br>";
            echo "Фамилия: ".$data['last_name']."<br>";
            echo "Идентификатор: ".$data['id']."<br>";
            if($data['sex'] == 0){echo "Пол: не указан<br>";}
            if($data['sex'] == 1){echo "Пол: женский<br>";}
            if($data['sex'] == 2){echo "Пол: мужской<br>";}
            echo "Дата рождения: ".$data['bdate']."<br>";
            echo "Страна: ".$data['country']['title']."<br>";
            echo "Город: ".$data['city']['title'];
    */
?>
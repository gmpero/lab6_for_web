<?php
    session_start();
    require_once("bdconnect.php");
    
    if(isset($_POST['submit_brand']))
    {
        $id_brand = $_POST['id_brand'];
        
        $id_brand = $_POST['id_brand'];

        $result_query = $mysqli->query("SELECT img_path FROM brand WHERE id_brand = $id_brand");
        $row = $result_query->fetch_assoc();
        $img_path = $row['img_path'];
        unset($row);

        unlink($img_path); // удаляем старый файл-изображение
        
        $result_query = $mysqli->prepare("DELETE FROM car WHERE id_brand = ?"); // удаляем все машины
        $result_query->bind_param("s", $id_brand);
        $result_query->execute();
        $result_query->close();
        
        $result_query = $mysqli->prepare("DELETE FROM brand WHERE id_brand = ?"); // удаляем марки
        $result_query->bind_param("s", $id_brand);
        $result_query->execute();
        $result_query->close();
        
        header("Location: ".$address_site."index.php");
    }
    else
    {
        echo 'Так делать не хорошо, не ходите по прямым ссылкам!';
    }
?>
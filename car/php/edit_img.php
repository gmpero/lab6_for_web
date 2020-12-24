<?php
    session_start();
    require_once("bdconnect.php");
    
    if(isset($_POST['submit_img']))
    {
        $id_brand = $_POST['id_brand'];

        $result_query = $mysqli->query("SELECT img_path FROM brand WHERE id_brand = $id_brand");
        $row = $result_query->fetch_assoc();
        $img_path = $row['img_path'];
        unset($row);
        
        unlink($img_path); // удаляем старый файл

        $img_path = 'uploads/'.$_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        echo '<br>'.$img_path;

        move_uploaded_file($tmp_name, $img_path);
  

        $result_prepare = $mysqli->prepare("UPDATE brand SET img_path = ? WHERE id_brand = ?");
        $result_prepare->bind_param("si", $img_path, $id_brand); // меняем файл в базе данных
        $result_prepare->execute();


        $result_prepare->close();

        header("Location: ".$address_site."index.php");
    }
    else
    {
        echo 'НЕЛЬЗЯ ТАК ПЕРЕХОДИТЬ ПО ССЫЛКАМ!';
    }
?>
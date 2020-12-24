<?php
    session_start();
    require_once("bdconnect.php");
    
    if(isset($_POST['submit']))
    {
        $id_brand = $_POST['id_brand'];
        $wheel_drive = $_POST['wheel_drive'];
        $number_of_passengers = $_POST['number_of_passengers'];
        $trunk_volume = $_POST['trunk_volume'];
        $brand = $_POST['brand'];
        
        $result_query = $mysqli->prepare("UPDATE brand SET brand = ?, wheel_drive = ?, number_of_passengers = ?, trunk_volume = ? WHERE id_brand = ?");
        $result_query->bind_param("siiii", $brand, $wheel_drive, $number_of_passengers, $trunk_volume, $id_brand);
        $result_query->execute();
        $result_query->close();
        
        header("Location: ".$address_site."index.php");
    }
    else
    {
        echo 'Так делать не хорошо, не ходите по прямым ссылкам!';
    }
?>
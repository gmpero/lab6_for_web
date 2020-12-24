<?php

    session_start();

    if(isset($_POST['submit']))
    {
        require_once("bdconnect.php");
        
        $id_brand = $_POST['id_brand'];

        if($id_brand == 0) //если мы добавили НОВУЮ МАРКУ
        {
            $brand = $_POST['brand'];
            $wheel_drive = $_POST['wheel_drive'];
            $number_of_passengers = $_POST['number_of_passengers'];
            $trunk_volume = $_POST['trunk_volume'];

            // добавляем марку
            $result_query_insert_orders = $mysqli->prepare("INSERT INTO brand 
            (brand, wheel_drive, number_of_passengers, trunk_volume) VALUES (?, ?, ?, ?)");
            $result_query_insert_orders->bind_param("siii", $brand, $wheel_drive, $number_of_passengers, $trunk_volume);
            $result_query_insert_orders->execute();
            $result_query_insert_orders->close();
            
            
            $sql = mysqli_query($mysqli, "SELECT id_brand FROM brand WHERE brand = '$brand'");
            $row = mysqli_fetch_array($sql);
            $id_brand = $row['id_brand'];
        }
        
        $car_cost = $_POST['car_cost'];
        $release_date = $_POST['release_date'];
        
        // добавляем авто
        $result_query_insert_orders = $mysqli->prepare("INSERT INTO car (id_brand, car_cost, release_date) VALUES (?, ?, ?)");
        $result_query_insert_orders->bind_param("iis", $id_brand, $car_cost, $release_date);
        $result_query_insert_orders->execute();
        $result_query_insert_orders->close();
        
        header("Location: index.php");
    }
    else
    {
        echo 'Переход по прямой ссылке запрещён!' . '<br>';
    }

?>
<?php
    session_start();
    require_once("bdconnect.php");

    $display = '';

    $result_brand = $mysqli->query("SELECT * FROM `brand` ORDER BY brand");

    if(isset($_SESSION['id']) && $_SESSION['id'] == 1) // дисплей дли администратора
    {
        while($row_brand = $result_brand->fetch_assoc())
        {
            switch($row_brand['wheel_drive'])
            {
                case 1: $wheel_drive = 'Переднеприводный'; break;
                case 2: $wheel_drive = 'Заднеприводный'; break;
                case 3: $wheel_drive = 'Полноприводный'; break;
            }
            
            $display .=
                '<div class="table">
                    <img src="php/'.$row_brand['img_path'].'" alt="*Здесь должно быть фото*" height="100" width="150">
                    <table>
                        <tr>
                            <th><h2>'.$row_brand['brand'].'</h2></th>

                            <th>
                                 <form action="form_edit_brand.php" method="post">
                                     <input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'">
                                     <input type="submit" value="Редактировать" name="submit_brand" class="button">
                                </form>
                            </th>
                            <th>
                                <form action="php/delete_brand.php" method="post">
                                    <input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'">
                                    <input type="submit" value="Удалить" name="submit_brand" class="button_delete">
                                </form>
                            </th>
                        </tr>
                    </table>
                    <p class="info_about_auto">Информация о этой марке: <br>
                        Привод - '.$wheel_drive.'
                        <br>
                        Число пассажиров - '.$row_brand['number_of_passengers'].' <br>
                        Вместимость багажника - '.$row_brand['trunk_volume'].' литров <br>
                    </p>

                    <h3>Вот что у нас есть:</h3><br>

                    <table>
                        <tr><th class="name_car">Цена</th><th class="name_car">Год выпуска</th></tr>';
                    
                    $result_car = $mysqli->query("SELECT * FROM `car` 
                    WHERE id_brand = ". $row_brand['id_brand'] ." AND car_display = true"); 

                    while ($row_car = $result_car->fetch_assoc())
                    {
                        $display.=
                        '<tr>
                            <th>'.$row_car['car_cost'].'</th>
                            <th>'.$row_car['release_date'].'</th>
                            <th>
                                <form action="form_edit_car.php" method="post">
                                    <input type="hidden" name="id_car" value="'.$row_car['id_car'].'">
                                    <input type="submit" value="Редактировать" name="submit_car" class="button">
                                </form>
                            </th>
                            <th>
                                <form action="php/delete_car.php" method="post">
                                    <input type="hidden" name="id_car" value="'.$row_car['id_car'].'">
                                    <input type="submit" value="Удалить" name="submit_car" class="button_delete">
                                </form>
                            </th>
                        </tr>'; 
                    }
            $display.='</table></div>';
        }
        echo $display;
    }
    else // дисплей для общего пользования
    {
        while($row_brand = $result_brand->fetch_assoc())
        {
            switch($row_brand['wheel_drive'])
            {
                case 1: $wheel_drive = 'Переднеприводный'; break;
                case 2: $wheel_drive = 'Заднеприводный'; break;
                case 3: $wheel_drive = 'Полноприводный'; break;
            }
            
            $display .=
                '<div class="table">
                    <img src="php/'.$row_brand['img_path'].'" alt="*Здесь должно быть фото*" height="100" width="150">
                    <table>
                        <tr>
                            <th><h2>'.$row_brand['brand'].'</h2></th>
                        </tr>
                    </table>
                    <p class="info_about_auto">Информация о этой марке: <br>
                        Привод - '.$wheel_drive.'
                        <br>
                        Число пассажиров - '.$row_brand['number_of_passengers'].' <br>
                        Вместимость багажника - '.$row_brand['trunk_volume'].' литров <br>
                    </p>

                    <h3>Вот что у нас есть:</h3><br>

                    <table>
                        <tr><th class="name_car">Цена</th><th class="name_car">Год выпуска</th></tr>';
                    
                    $result_car = $mysqli->query("SELECT * FROM `car` 
                    WHERE id_brand = ". $row_brand['id_brand'] ." AND car_display = true"); 

                    while ($row_car = $result_car->fetch_assoc())
                    {
                        $display.=
                        '<tr>
                            <th>'.$row_car['car_cost'].'</th>
                            <th>'.$row_car['release_date'].'</th>
                        </tr>'; 
                    }
            $display.='</table></div>';
        }
        echo $display;
    }
?>
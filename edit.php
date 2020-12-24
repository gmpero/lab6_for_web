<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ru">
    <link rel="stylesheet" href="add_car.css" type="text/css"/>
 <head>
     
     <title>Редактирование</title>
     <meta charset="utf-8">
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
     
 </head>
 <body>
     <?php
        if(!isset($_SESSION['id']) || $_SESSION['id'] != 1) // если это не администратор
        {
            echo '<br> Вы не админ, тут вам делать нечего <br>';
        }
        if(isset($_POST['submit_add_brand'])) // если он не нажал кнопку
        {
     ?>
     <div>
         Марка: <br>
         <h1><p><?php echo $_POST['brand']; ?></p></h1>
        <form action="add_brand.php" method="post">
            <table>
                <tr>
                    <th>Максимальное число пассажиров :</th>
                    <th><input name="number_of_passengers" type="text" placeholder="Введите в людях" maxlength="3"></th>
                    <th><span id="number_of_passengers_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Вместимость багажника :</th>
                    <th><input name="trunk_volume" type="text" placeholder="Введите в литрах" maxlength="10"></th>
                    <th><span id="trunk_volume_message" class="error_mesage"></span></th>
                </tr>
            </table>
            <p><input name="wheel_drive" type="radio" value="1" checked>Передний привод</p>
            <p><input name="wheel_drive" type="radio" value="2">Задний привод</p>
            <p><input name="wheel_drive" type="radio" value="3">Полный привод</p>
           
            <p>
            <input name="submit" type="submit" value="Добавить марку">
            </p>
        </form>
     </div>
     
     <?php
        }
        else if(isset($_POST['submit_add_car']))
        {
     ?>        
        
     <?php
        }
        else
        {
            echo '<br> Вы не нажали на кнопку <br>';
        }
     ?>
        
     
     
 </body> 
</html>
<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ru">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
 <head>
     
     <title>Редактирование</title>
     <meta charset="utf-8">
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
     
     <script type="text/javascript">
        $(document).ready(function(){
            
            var button = $('input[name=submit]');
            //button.attr('disabled', true); // т.к. форма уже правильная - нет смысла блокировать кнопку
            
            var valid_number_of_passengers = false;
            var valid_trunk_volume = false;
            var valid_brand = false;
            
            var number_of_passengers = $('input[name=number_of_passengers]');
            var trunk_volume = $('input[name=trunk_volume]');
            var brand = $('input[name=brand]');
            
            var button_img = $('input[name=submit_img]');
            var file = $('input[type=file]');
            
            button_img.attr('disabled', true);
            
            number_of_passengers.blur(function_valid_number_of_passengers);
            trunk_volume.blur(function_valid_trunk_volume); // при нажатие одной из кнопок так же проверяем
            brand.blur(function_valid_brand);
            
            function all_valid()// проверяет хорошо ли всё 
            {
                return valid_number_of_passengers && valid_trunk_volume && valid_brand;
            }
            
            function function_valid_number_of_passengers()
            {
                var message = $('#number_of_passengers_message');
                
                if(number_of_passengers.val() == '')
                {
                    message.text('Заполните это поле!');
                    button.attr('disabled', true); // блокируем кнопку

                    valid_number_of_passengers = false; // не валидно
                }
                else if(number_of_passengers.val().match(/[^0-9]/)) // если нашёлся посторонний знак
                {
                    message.text('Что-то непонятное ввели');
                    button.attr('disabled', true); // блокируем кнопку

                    valid_number_of_passengers = false; // не валидно
                }
                else if(number_of_passengers.val() < 1)
                {
                    message.text('Как-то мало получается');
                    button.attr('disabled', true); // блокируем кнопку

                    valid_number_of_passengers = false; // не валидно
                }
                else
                {
                    message.text('');
                    
                    valid_number_of_passengers = true;
                    
                    if(all_valid())
                    {
                        button.attr('disabled', false); // открываем кнопку "отправить авто" 
                    }
                }
            }
            
            function function_valid_trunk_volume()
            {
                var message = $('#trunk_volume_message');
                
                if(trunk_volume.val() == '')
                {
                    message.text('Заполните поле!');
                    button.attr('disabled', true); // блокируем кнопку

                    valid_trunk_volume = false; // не валидно
                }
                else if(trunk_volume.val().match(/[^0-9]/)) // если нашёлся посторонний знак
                {
                    message.text('Что-то непонятное ввели');
                    button.attr('disabled', true); // блокируем кнопку

                    valid_trunk_volume = false; // не валидно
                }
                else
                {
                    message.text('');
                    
                    valid_trunk_volume = true;
                    
                    if(all_valid())
                    {
                        button.attr('disabled', false); // открываем кнопку "отправить авто" 
                    }
                }
            }
            
            function function_valid_brand()
            {
                var message = $('#brand_message');
                
                if(brand.val() == '')
                {
                    message.text('Введите марку!');
                    button.attr('disabled', true);
                    
                    valid_brand = false;
                }
                else if(!brand.val().match(/[а-яa-z]/i))
                {
                    message.text('В строке нет особого смысла!');
                    button.attr('disabled', true);
                    
                    valid_brand = false;
                }
                else
                {
                    message.text('');
                    
                    valid_brand = true;
                    
                    // если все поля валидны - включаем кнопку
                    if(all_valid())
                    {
                        button.attr('disabled', false); // открываем кнопку "отправить авто" 
                    }
                }
            }
            
            file.change(function()
            {
                var message = $('#file_message');
                
                if(file.val() == '')
                {
                    message.text("Не выбран файл");
                    button_img.attr('disabled', true); // на всякий блокируем
                }
                else if(!file.val().match(/(.jpg)$/)) // если у файла НЕ такое расширение
                {
                    message.text("Недопустимое расширение");
                    button_img.attr('disabled', true); // на всякий блокируем
                }
                else 
                {                
                    message.text('');
                    button_img.attr('disabled', false); // открываем кнопку "отправить авто" 
                }
            });
        });

    </script>
     
 </head>
 <body>
     <?php
        if(!isset($_SESSION['id']) || $_SESSION['id'] != 1) // если это не администратор
        {
            echo '<br> Вы не админ, тут вам делать нечего <br>';
        }
        else if(isset($_POST['submit_brand'])) // если он не нажал кнопку
        {
            require_once("php/bdconnect.php");
            $result_query = $mysqli->query("SELECT * FROM brand WHERE id_brand = '{$_POST['id_brand']}'");
            $row = $result_query->fetch_assoc();
     ?>
     <div>
        <form action="php/edit_brand.php" method="post">
            
            <input type="hidden" name="id_brand" value="<?php echo $_POST['id_brand']; ?>">
            <table>
                <tr>
                    <th>Марка :</th>
                    <th><input value="<?php echo $row['brand']; ?>" name="brand" type="text" placeholder="Марка авто" maxlength="64"></th>
                    <th><span id="brand_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Максимальное число пассажиров :</th>
                    <th><input value="<?php echo $row['number_of_passengers']; ?>" name="number_of_passengers" type="text" placeholder="Введите в людях" maxlength="3"></th>
                    <th><span id="number_of_passengers_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Вместимость багажника :</th>
                    <th><input value="<?php echo $row['trunk_volume']; ?>" name="trunk_volume" type="text" placeholder="Введите в литрах" maxlength="10"></th>
                    <th><span id="trunk_volume_message" class="error_mesage"></span></th>
                </tr>
            </table>
                <p>
                    <?php
                        if($row['wheel_drive'] == 1)
                        {
                            echo '<input name="wheel_drive" type="radio" value="1" checked>Передний привод';
                        }
                        else
                        {
                            echo '<input name="wheel_drive" type="radio" value="1">Передний привод';
                        }
                    ?>
                </p>
                <p>
                    <?php
                        if($row['wheel_drive'] == 2)
                        {
                            echo '<input name="wheel_drive" type="radio" value="2" checked>Задний привод';
                        }
                        else
                        {
                            echo '<input name="wheel_drive" type="radio" value="2">Задний привод';
                        }
                    ?>
                </p>
                <p>
                    <?php
                        if($row['wheel_drive'] == 3)
                        {
                            echo '<input name="wheel_drive" type="radio" value="3" checked>Полный привод';
                        }
                        else
                        {
                            echo '<input name="wheel_drive" type="radio" value="3">Полный привод';
                        }
                    ?>
                </p>
                
                <p>
                    <input type="submit" name="submit" value="Редактировать">
                </p>
        </form>
     </div>
     
     <?php
        }
        else
        {
            echo '<br> Вы не нажали на кнопку <br>';
        }
     ?>
    <form action="php/edit_img.php" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="id_brand" value="<?php echo $_POST['id_brand']; ?>">
        
        <table>
            <tr>
                <th>
                    <input type="file" name="file"> <!-- для каждой марки свой файл -->
                </th>
                <th>
                    <span id="file_message" class="error_mesage"></span>
                </th>
            </tr>
        </table>
        <input type="submit" name="submit_img" value="Поменять фото">
    </form>
     <div>
         <p>
             <?php
                if(isset($_SESSION['massege']))
                {
                    echo $_SESSION['massege'];
                    unset($_SESSION['massege']);
                }
             ?>
        </p>
     </div>
     
 </body> 
</html>
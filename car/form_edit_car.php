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
            
            var valid_car_cost = false;
            var valid_release_date = false;
            
            var car_cost = $('input[name=car_cost]');
            var release_date = $('input[name=release_date]');
            
            function all_valid() 
            { // проверяет хорошо ли всё
                return valid_car_cost && valid_release_date;
            }
            
            car_cost.blur(function()
            {
                var message = $('#car_cost_message');
                
                if(car_cost.val() == '')
                {
                    message.text('Введите цену!');
                    button.attr('disabled', true);
                    
                    valid_car_cost = false;
                }
                else if(car_cost.val().match(/[^0-9]/)) // если нашли лишние символы
                {
                    message.text('В этой строке должны быть только цифры!');
                    button.attr('disabled', true);
                    
                    valid_car_cost = false;
                }
                else
                {
                    message.text('');
                    
                    valid_car_cost = true;
                    
                     // если все поля валидны - включаем кнопку
                    if(valid_car_cost && valid_release_date) 
                    {
                        button.attr('disabled', false);
                    }
                }
            });
            
            release_date.blur(function()
            {
                var message = $('#release_date_message');
                
                if(release_date.val() == '')
                {
                    message.text('Введите дату!');
                    button.attr('disabled', true);
                    
                    valid_release_date = false;
                }                                   
                else if(!release_date.val().match(/^[0-9]{2}.[0-9]{2}.[0-9]{4}$/))
                {
                    message.text("Нарушен синтаксис 'ДД.ММ.ГГГГ'!");
                    button.attr('disabled', true);
                    
                    valid_release_date = false;
                }
                else
                {
                    var day = release_date.val().substr(0,2); // вырезаем день, месяц, год (для обработки)
                    var month = release_date.val().substr(3,2);
                    var year = release_date.val().substr(6,4);
                    
                    if(day < 1 || day > 31)
                    {
                        message.text('Недопустимая дата!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else if(month < 1 || month > 12)
                    {
                        message.text('Недопустимый месяц!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else if(year < 2000 || year > 2021)
                    {
                        message.text('Недопустимый год!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else
                    {
                        message.text('');
                        
                        valid_release_date = true;
                        
                         // если все поля валидны - включаем кнопку
                        if(valid_car_cost && valid_release_date) 
                        {
                            button.attr('disabled', false);
                        }
                    }
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
        else if(isset($_POST['submit_car'])) // если он не нажал кнопку
        {
            require_once("php/bdconnect.php");
            $result_query = $mysqli->query("SELECT * FROM car WHERE id_car = '{$_POST['id_car']}'");
            $row = $result_query->fetch_assoc();
     ?>
     <div>
        <form action="php/edit_car.php" method="post">
            
            <input type="hidden" name="id_car" value="<?php echo $_POST['id_car']; ?>">
            <table>
                <tr>
                    <th>Цена :</th>
                    <th><input value="<?php echo $row['car_cost']; ?>" name="car_cost" type="text" placeholder="Стоимость авто" maxlength="11"></th>
                    <th><span id="car_cost_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Выпуск :</th>
                    <th><input value="<?php echo $row['release_date']; ?>" name="release_date" type="text" placeholder="ДД.ММ.ГГГГ" maxlength="10"></th>
                    <th><span id="release_date_message" class="error_mesage"></span></th>
                </tr>
            </table>
            <p>
                <input name="submit" type="submit" value="Редактировать авто">
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
        
     
     
 </body> 
</html>
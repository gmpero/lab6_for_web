<?php
    session_start();
    require_once("bdconnect.php");
?>

<!doctype html>
<html lang="en">
<link rel="stylesheet" href="add_car.css" type="text/css"/>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <title>Авто</title>

    <script type="text/javascript">
        $(document).ready(function(){
            
            var button = $('input[name=submit]');
            button.attr('disabled', true); // сразу блокируем кнопку, т.к. мы ничего не написали
            
            var valid_car_cost = false; // т.к. поля ещё не введины - поля не валидны (в самом начале)
            var valid_release_date = false;
            var valid_number_of_passengers = false;
            var valid_trunk_volume = false;
            var valid_brand = false;
            
            var car_cost = $('input[name=car_cost]');
            var release_date = $('input[name=release_date]');
            var id_brand = $('select[name=id_brand]');
            var number_of_passengers = $('input[name=number_of_passengers]');
            var trunk_volume = $('input[name=trunk_volume]');
            var wheel_drive = $('input[name=wheel_drive]');
            var brand = $('input[name=brand]');

            function all_valid() 
            { // проверяет хорошо ли всё
return valid_car_cost && valid_release_date && valid_number_of_passengers && valid_trunk_volume && valid_brand;
            }
            
            function function_valid_number_of_passengers() // используем несколько раз функцию на проверки валидности
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
        
            id_brand.change(function()
            {
                if(id_brand.val() == 0)
                {
                    number_of_passengers.attr('disabled',false); // даём пользователю записать туда что-нибудь
                    trunk_volume.attr('disabled',false);
                    wheel_drive.attr('disabled',false);
                    brand.attr('disabled',false);
                    
                    function_valid_number_of_passengers();
                    function_valid_trunk_volume(); // проверка на валидность полей которые разморозили
                    function_valid_brand();
                    
                    button.attr('disabled', true); // и на всякий блокируем кнопку
                }
                else
                {
                    number_of_passengers.attr('disabled',true);
                    trunk_volume.attr('disabled',true);
                    wheel_drive.attr('disabled',true);
                    brand.attr('disabled',true);
                    
                    // если мы выбрали марку, то значит поля уже введины, а значит всё валидно
                    valid_number_of_passengers = valid_trunk_volume = valid_brand = true;

                    if(all_valid()) // и если всё хорошо
                    {
                        button.attr('disabled', false); // открываем кнопку "отправить авто" 
                    }
                }
            });
            
            number_of_passengers.blur(function_valid_number_of_passengers);
            
            trunk_volume.blur(function_valid_trunk_volume);
            
            brand.blur(function_valid_brand);
            
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
   // if(isset($_SESSION['id']) && $_SESSION['id'] == 1) // если это определённый пользователь (т.е. админ), тогда даём ему возможность добавить форму
  //  {
        $result = mysqli_query($mysqli, "SELECT id_brand, brand FROM brand");
?>
    <div class="form_car">
        <h2>Добавление в Базу Авто</h2>

        
        
        
        <form action="add_car.php" method="post">
             
            <p>
                <select id="id_brand" name="id_brand">
                    <option value="0" selected>Добавить новую</option>
                <!--    <option value="1">Не</option> -->
                        
                        <?php
                            while($row = mysqli_fetch_assoc($result))
                            {
                        ?>
                            <option value="<?php echo $row['id_brand']; ?>"><?php echo $row['brand']; ?></option>
                        <?php
                            }
                        ?>
                </select>
            </p>

            <table>
                <tr>
                    <th>Марка :</th>
                    <th><input name="brand" type="text" placeholder="Марка авто" maxlength="64"></th>
                    <th><span id="brand_message" class="error_mesage"></span></th>
                </tr>
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
            
            <table>
                <tr>
                    <th>Цена :</th>
                    <th><input name="car_cost" type="text" placeholder="Стоимость авто" maxlength="11"></th>
                    <th><span id="car_cost_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Выпуск :</th>
                    <th><input name="release_date" type="text" placeholder="ДД.ММ.ГГГГ" maxlength="10"></th>
                    <th><span id="release_date_message" class="error_mesage"></span></th>
                </tr>
            </table>
            <p>
            <input class="button" name="submit" type="submit" value="Добавить авто">
            </p>
        </form>
    </div>
<?php
   // }
?>
   
    <?php
    
        $result_brand = $mysqli->query("SELECT * FROM `brand` ORDER BY brand");
        while($row_brand = $result_brand->fetch_assoc())
        {
    ?>
        <div class="table">
            <table>
                <tr>
                    <th><h2><?php echo $row_brand['brand'] ?></h2></th>
                    <th>
                         <form action="#" method="post">
                             <input type="hidden" name="id_brand" value="<?php echo $row_brand['id_brand']; ?>">
                             <input class="button" type="submit" value="Редактировать" name="submit_brand">
                        </form>
                    </th>
                    <th>
                        <form action="#" method="post">
                            <input type="hidden" name="id_brand" value="<?php echo $row_brand['id_brand']; ?>">
                            <input class="button_delete" type="submit" value="Удалить" name="submit_brand">
                        </form>
                    </th>
                </tr>
            </table>
            <p class="info_about_auto">Информация о этой марке: <br>
                Привод - 
                <?php 
                    switch($row_brand['wheel_drive'])
                    {
                        case 1: echo 'Переднеприводный'; break;
                        case 2: echo 'Заднеприводный'; break;
                        case 3: echo 'Полноприводный'; break;
                    }
                ?> <br>
                Число пассажиров - <?php echo $row_brand['number_of_passengers'] ?> <br>
                Вместимость багажника - <?php echo $row_brand['trunk_volume'] ?> литров <br>
            </p>
            
            <h3>Вот что у нас есть:</h3><br>
            
            <table>
                <tr><th class="name_car">Цена</th><th class="name_car">Год выпуска</th></tr>
                <?php
                    
                    //Вытаскиваем все комментарии для данной страницы
                    $result_car = $mysqli->query("SELECT * FROM `car` 
                    WHERE id_brand = ". $row_brand['id_brand'] ." AND car_display = true"); 

                    while ($row_car = $result_car->fetch_assoc())
                    {
                ?>
                        <tr>
                            <th> <?php echo $row_car['car_cost']; ?> </th>
                            <th> <?php echo $row_car['release_date']; ?> </th>
                            <th>
                                <form action="#" method="post">
                                    <input type="hidden" name="id_car" value="<?php echo $row_car['id_car']; ?>">
                                    <input class="button" type="submit" value="Редактировать" name="submit_brand">
                                </form>
                            </th>
                            <th>
                                <form action="#" method="post">
                                    <input type="hidden" name="id_car" value="<?php echo $row_car['id_car']; ?>">
                                    <input class="button_delete" type="submit" value="Удалить" name="submit_brand">
                                </form>
                            </th>
                        </tr>
                <?php  
                    }
                ?>
            </table>
        </div>
    <?php
        }
    ?>
    
</body>
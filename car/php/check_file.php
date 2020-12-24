<?php
    session_start();
    
  	$_SESSION["error_messages"] = '';
    $_SESSION["success_messages"] = '';

    function check_file($file_name)
    {
        if(isset($_FILES[$file_name]))
        {
            $allowedType = 'image/jpeg';
            $uploadFile = "uploads/{$_FILES[$file_name]['name']}";

            if($_FILES[$file_name]['type']==$allowedType)
            {
                $fileChecked = true;
            }
            else
            {
                $fileChecked = false;
            }

            if($fileChecked) // если разрешённый формат
            {
                if(is_writable($_FILES[$file_name]['tmp_name'], $uploadFile)) //если он есть и может быть перемещён
                {
                    $_SESSION["success_messages"] = "Файл успешно загружен";
                    unset($_SESSION["error_messages"]);
                    return true;
                }
                else
                {
                    $_SESSION["error_messages"] = "Не удалось загрузить файл!";
                    unset($_SESSION["success_messages"]);
                    return false;
                }
            }
            else
            {
                $_SESSION["error_messages"] = $_FILES[$file_name]['type']." - не резрешённый формат!";
                unset($_SESSION["success_messages"]);
                return false;
            }
        }
        else
        {
            $_SESSION["error_messages"] = "Файл не обнаружен!";
            unset($_SESSION["success_messages"]);
            return false;
        }
    }

    
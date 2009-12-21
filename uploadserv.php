<?php
require "auth.php"; // скрипт авторизации и ведения сессий
// определим некоторые переменные 
$uploads_dir = 'uploaduserfiles/'; // директория для сохранения файлов
$upload_max_filesize = 5*1024*1024; //установим ограничение на размер файла в 5 мегабайт
$filenamealias=strtotime("now"); // псевдоним имени файла сгенерируем как UNIX timestamp
//--------------------------------------------------------------------------------------
   if($_FILES["filename"]["size"] > $upload_max_filesize)  
   {
     echo ("Размер файла превышает 5 мегабайт");
     exit;
   }
// в целях безопасности переименуем файл случайным образом, а настоящее имя сохраним в БД.
//  уникальная директория совпадающая с идентификатором пользователя создаётся только на этапе регистрации этого нового пользователя.
   if(move_uploaded_file($_FILES["filename"]["tmp_name"], "$uploads_dir".$_SESSION['user_id']."/$filenamealias"))
   {
     echo("Файл успешно загружен <br>");
     echo("Имя файла: ");
     echo($_FILES["filename"]["name"]);
     echo("<br>Размер файла: ");
     echo($_FILES["filename"]["size"]);
     echo("<br>Каталог для загрузки: ");
     echo($_FILES["filename"]["tmp_name"]);
     echo("<br>Тип файла: ");
     echo($_FILES["filename"]["type"]);
   } else {
      echo("Ошибка загрузки файла");
	  }

	  $link = mysql_connect("localhost", "upload_files", "UF")
        or die("Ошибка соединения: " . mysql_error());
    print "Успешное подключение";
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");

// сформируем все переменные для передачи в БД	
//--------------------------------------------------------------------------------------
$fullfilename="../uploaduserfiles/";
$DaTi=date("Y-m-d H:i:s");  
$uploadfile=$_FILES["filename"]["name"];
$uploadfilealias=$_FILES["filename"]["name"];
$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];
$user_id=$_SESSION['user_id'];	
//--------------------------------------------------------------------------------------
	
	//  сформируем строку запроса
 $query = "INSERT INTO `upload_files` ( `filename`,`filename_alias`, `datetime`, `IP`, `browser`, `comments_enabled`, `user_id`) VALUES 
 ( '$uploadfile','$filenamealias', '$DaTi', '$ip_user', '$browser_user', '1', '$user_id'); ";
 // для поля file_id назначено автоинрементирование, поэтому в строке запроса его указывать не нужно
 
$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());

	  ?>
</body>
</html>

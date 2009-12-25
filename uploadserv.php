<?php
require_once "settings.php";
require "auth.php"; // скрипт авторизации и ведения сессий
// определим некоторые переменные 
$filenamealias=strtotime("now"); // псевдоним имени файла сгенерируем как UNIX timestamp
//--------------------------------------------------------------------------------------
   if($_FILES["filename"]["size"] > $upload_max_filesize)  
   {
     echo ("Размер файла превышает заданный");
     exit;
   }
// в целях безопасности переименуем файл случайным образом, а настоящее имя сохраним в БД.
// уникальная директория совпадающая с идентификатором пользователя создаётся только на этапе регистрации этого нового пользователя.
   if(move_uploaded_file($_FILES["filename"]["tmp_name"], "$uploads_dir".$_SESSION['user_id']."/$filenamealias"))
   {
	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");

// сформируем все переменные для передачи в БД	
//--------------------------------------------------------------------------------------
$fullfilename="../uploaduserfiles/";
$filetype=$_FILES["filename"]["type"];
$DaTi=date("Y-m-d H:i:s");  
$uploadfile=$_FILES["filename"]["name"];
$uploadfilealias=$_FILES["filename"]["name"];
$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];
$user_id=$_SESSION['user_id'];
	
//--------------------------------------------------------------------------------------
	
	//  сформируем строку запроса
 $query = "INSERT INTO `upload_files` ( `filename`,`filetype`,`filename_alias`, `datetime`, `IP`, `browser`, `comments_enabled`, `user_id`) VALUES 
 ( '$uploadfile','$filetype','$filenamealias', '$DaTi', '$ip_user', '$browser_user', '1', '$user_id'); ";
 // для поля file_id назначено автоинрементирование, поэтому в строке запроса его указывать не нужно
 
$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());	 
// вернёмся к списку файлов 
	header("Location: http://".$_SERVER['HTTP_HOST']."/list.php");	 
   } else {
      //echo("Ошибка загрузки файла");
	  }
	  ?>
</body>
</html>

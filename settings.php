<?php
// глобальные переменные
$uploads_dir = 'uploaduserfiles/'; // директория, где располагаются файлы пользователей
$upload_max_filesize = 5*1024*1024; //установим ограничение на размер файла в 5 мегабайт
//  определения
define('RECSPERPAGE', 25); // количество записей на одной странице
define('ADMIN_EMAIL', 'device@rambler.ru'); // email администратора

//  ДОСТУП К БАЗЕ ДАННЫХ
define('DBHOST', 'localhost'); // имя хоста
define('DBUSER', 'upload_files'); // имя пользователя
define('DBPASSWD', 'UF'); // пароль
define('DBNAME', 'upload_files'); // имя базы данных

?>

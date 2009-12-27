<?
require_once "settings.php";
// создадим всё необходимое для работы тестового задания onliner.by
$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
// $query[0]="CREATE DATABASE $DBNAME DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;";
$query[1]="USE $DBNAME;";
$query[2]="CREATE TABLE `comments` ( `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `IP` text NOT NULL,
  `browser` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1; ";

$query[3]="CREATE TABLE `upload_files` (
  `file_id` int(11) NOT NULL auto_increment,
  `filename` text,
  `filetype` text NOT NULL,
  `filename_alias` text NOT NULL,
  `datetime` datetime default NULL,
  `IP` text NOT NULL,
  `browser` text NOT NULL,
  `comments_enabled` binary(1) default NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`file_id`),
  UNIQUE KEY `file_id_3` (`file_id`),
  UNIQUE KEY `file_id_4` (`file_id`),
  KEY `file_id` (`file_id`),
  KEY `file_id_2` (`file_id`),
  FULLTEXT KEY `filepath` (`filename`),
  FULLTEXT KEY `IP` (`IP`),
  FULLTEXT KEY `browser` (`browser`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$query[4]="CREATE TABLE `users` (
  `user` text,
  `email` text,
  `password` text,
  `user_id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

for ($i=1; $i<sizeof($query); $i++)
{
$result = mysql_query($query[$i]) or die(print "БД- ошибка запроса: " . mysql_error()); 
}
// if (!mkdir ("$uploads_dir")) {print "директория $uploads_dir не создана. Проверьте  права доступа и настройки вашего сервера"; exit;}


print "1.Удалите install.php из рабочей директории<br>
Регистрация нового пользователя: <a href='registration.html'>registration.html</a><br>
Перейти к списку файлов: <a href='listnonregister.php'>listnonregister.php</a><br>
Перейти к управлению личными файлами <a href='list.php'>list.php</a>
		";
  
?>
<?
require_once "settings.php";
// �������� �� ����������� ��� ������ ��������� ������� onliner.by
$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("������ ����������: " . mysql_error());
$query[0]="CREATE DATABASE $DBNAME DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;";
$query[1]="USE $DBNAME;";
$query[2]="CREATE TABLE `comments` ( `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `IP` text NOT NULL,
  `browser` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1; ";

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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;";

$query[4]="CREATE TABLE `users` (
  `user` text,
  `email` text character set utf8 collate utf8_estonian_ci,
  `password` text,
  `user_id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

for ($i=0; $i<sizeof($query); $i++)
{
$result = mysql_query($query[$i]) or die(print "��- ������ �������: " . mysql_error()); 
}
print "1.������� install.php �� ������� ����������<br>
����������� ������ ������������: <a href='registration.html'>registration.html</a><br>
������� � ������ ������: <a href='listnonregister.php'>listnonregister.php</a><br>
������� � ���������� ������� ������� <a href='list.php'>list.php</a>
		";
  
?>
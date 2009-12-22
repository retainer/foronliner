<?
function prepareforsave ($string)  // подготовим строку для корректного сохранения в БД
{
$string = trim($string);
$string = stripslashes($string);
return htmlspecialchars($string, ENT_QUOTES);
}


print $_POST['nm']."<br>";
print $_POST['file_id']."<br>";
print $_POST['comment'];
print "<br>цитирование комментария с link_ID=";
print $_POST['link_id'];
print "<br>";
if ($_POST['nm']=="")
{
print "имя не введено<br>";exit;
}
if ($_POST['comment']=="") 
{
print "текст не введен";exit;
}
if ($_POST['file_id']=="") 
{
print "нет привязки к файлу"; exit;
}
if ($_POST['link_id']=="")
{
$_POST['link_id']="0";
}
// проведём подготовку строк
$nm=prepareforsave($_POST['nm']);
$comment=prepareforsave($_POST['comment']);
$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];
$file_id=$_POST['file_id'];
$link_id=$_POST['link_id'];
// проверим, возможно ли добавлять комментарии к этому файлу 

	$link = mysql_connect("localhost", "upload_files", "UF")  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files  WHERE file_id=".$_POST['file_id']; 
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
	 if ($row['comments_enabled']==1) // возможно добавление комментария
	 	//$query = "INSERT INTO `comments` (`name`,`text`,`IP `,`browser`, `link_id`, `file_id`) VALUES 
		//($_POST['nm'], $_POST['comment']), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_POST['link_id'], $_POST['file_id']"; 
		 $query = "INSERT INTO `comments` (`name`,`text`,`IP`,`browser`,`file_id`,`link_id`) 
		 VALUES  ('$nm', '$comment','$ip_user','$browser_user','$file_id', '$link_id')"; 	
		$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
	}
?>
<?
require_once "settings.php";
function prepareforsave ($string)  // подготовим строку для корректного сохранения в БД
{
// требования задания не предполагают форматированный ввод комментариев
$string = strip_tags($string);
$string = nl2br($string);
$string = trim($string);
$string = stripslashes($string);

return $string;
}

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


	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files  WHERE file_id=".$_POST['file_id']; 
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
	 // проверим, можно ли добавлять комментарии к этому файлу 
	 if ($row['comments_enabled']==1) // возможно добавление комментария
	 	//$query = "INSERT INTO `comments` (`name`,`text`,`IP `,`browser`, `link_id`, `file_id`) VALUES 
		//($_POST['nm'], $_POST['comment']), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_POST['link_id'], $_POST['file_id']"; 
		 {
		 $query = "INSERT INTO `comments` (`name`,`text`,`IP`,`browser`,`file_id`,`link_id`) 
		 VALUES  ('$nm', '$comment','$ip_user','$browser_user','$file_id', '$link_id')"; 	
		$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
		// выполним возврат на страницу с комментариями в случае успешного добавления комментария
		  header("Location: http://".$_SERVER['HTTP_HOST']."/comment.php?file_id=".$_POST['file_id']);
		}
		else print "Комментарий к этому файлу запрещён владельцем";
	}

?>
<?
require_once "settings.php";
function checkmail($string)
{
return preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $string);
}
function prepareforsave ($string)  // подготовим строку для корректного сохранения в БД
{
//$string = strip_tags($string);
//$string = nl2br($string);

return $string;
}
//print_r ($_POST);

if ($_POST['username']=="")
{
print "имя не введено<br>";exit;
}
if ($_POST['mail']=="") 
{
print "почта на указана";exit;
}
if (!checkmail($_POST['mail'])) 
{
print "формат почты указан неверно";exit;
}

if ($_POST['pass1']=="") 
{
print "пароль не введён"; exit;
}
if (strlen($_POST['pass1'])<$passlen) 
{
print "длина пароля должна быть не менее $passlen символов"; exit;
}

if ($_POST['pass1']!=$_POST['pass2'])
{
print "пароль и его подтверждение не совпадают"; exit;
}

// проведём подготовку строк
$username=prepareforsave($_POST['username']);
$mail=prepareforsave($_POST['mail']);
$pass1=prepareforsave($_POST['pass1']);

$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];

	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("$DBNAME") or die("невозможно выполнить выборку из БД");
// проверим, не существует ли уже такой  пользователь
	$query = "SELECT * FROM users WHERE email='$mail'";
	
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
		print "На данный email уже зарегистрирован пользователь. <br> Выберите другой email";
	}
	else 
	{
		$query = "INSERT INTO `users` ( `user`,`email`,`password`) VALUES  ( '$username','$mail', '$pass1');";
		$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());	
	
	//Теперь узнаем идентификатор этой цепочки и создадим папку для файлов с таким же именем
    $query = "SELECT * FROM users WHERE email='$mail'";
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
		if (!mkdir ("$uploads_dir".$row['user_id'])) {print "директория $uploads_dir".$row['user_id']." не создана. Проверьте  права доступа и настройки вашего сервера"; exit;}
		header("Location: http://".$_SERVER['HTTP_HOST']."/foronliner/list.php");
	}
	}

?>
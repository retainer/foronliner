<?
// функция проверяет является ли строка адресом e-mail
require_once "settings.php";
function checkmail($string)
{
return preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $string);
}
	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    //print "<b>Успешное подключение</b>";
    mysql_select_db($DBNAME) or die("невозможно выполнить выборку из БД");
if ((isset($_POST['email']))&(checkmail($_POST['email']))&(strlen($_POST['password'])>=8))
{
  $email=@mysql_real_escape_string($_POST['email']);
  $password=@mysql_real_escape_string($_POST['password']);
  	
  $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";   
  $res = mysql_query($query) or trigger_error(mysql_error().$query);
  if ($row = mysql_fetch_assoc($res)) {
    // начнём сессию и определим некоторые переменные
	session_start();
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}
if (isset($_GET['action']) AND $_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: http://".$_SERVER['HTTP_HOST']."/foronliner/listnonregister.php");
  exit;
}
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {
?>

<html>
<html>
<head>
<title>Log in</title>


<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
table {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
-->
</style>
</head>
<body>
<form method="POST">
<table border=0>
<tr><td>
email</td><td><input type="text" name="email"></td></tr>
<tr><td>password</td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit"></td></tr></table>
</form>
</body>
</html>
<?
}
exit;
?>
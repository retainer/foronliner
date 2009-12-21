<?

    $link = mysql_connect("localhost", "upload_files", "UF")  or die("Ошибка соединения: " . mysql_error());
    //print "<b>Успешное подключение</b>";
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
if (isset($_POST['email'])) 
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
  header("Location: http://".$_SERVER['HTTP_HOST']."/upload.php");
  exit;
}
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {
?>
<form method="POST">
email<input type="text" name="email"><br>
password<input type="password" name="password"><br>
<input type="submit"><br>
</form>
<?
}
exit;
?>
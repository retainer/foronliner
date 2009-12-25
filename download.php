<?
// Расскоментировать, если скачивание разрешено только авторизованным пользователям
//require "auth.php";
require_once "settings.php";
$fID=$_GET['file_id'];
	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
//  сгенерируем настоящий путь к файлу и предложим его пользователю
// $filepath="$uploads_dir".$_SESSION['user_id']."/".$row['filename_alias'];  //Расскоментировать, если скачивание разрешено только авторизованным пользователям
$user_id=$row['user_id']; 
$filepath="$uploads_dir$user_id/".$row['filename_alias'];
header("Content-Type: ".$row['filetype']);
$fn=$row['filename'];
$fn=$row['filename'];
header("Content-Disposition: attachment; filename=$fn"); 
readfile($filepath);
     }
?>
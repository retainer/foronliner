<?
require_once "settings.php";
require "auth.php";
$fID=$_GET['file_id'];
$uID=$_SESSION['user_id'];

// удалить файл может только авторизованный владелец файла
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID AND user_id=$uID";
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
if ($row = mysql_fetch_assoc($result))
{
$filepath="$uploads_dir".$_SESSION['user_id']."/".$row['filename_alias'];
if (unlink($filepath))  
	{$query = "DELETE FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
	// возвращаемся к списку файлов
	header("Location: http://".$_SERVER['HTTP_HOST']."/list.php");		
     }
}
?>
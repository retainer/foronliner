<?
require "auth.php";
$uploads_dir = 'uploaduserfiles/';
$uID=$_SESSION['user_id'];
//по соображениям безопасности будем проводить проверку для каждой цепочки 'пользователь'-'файл'.

// определим список файлов  переданных для обработки по скрытому полю c именем hidX.
print_r ($_POST);

foreach ( $_POST as $key => $val )
{
 $$key = $val;

 if (substr($key, 0,3)=="hid")
 {
	$currentID=substr($key, 3); // рабочий идентификатор
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files WHERE user_id=$uID AND file_id=$currentID"; 
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
	$row = mysql_fetch_assoc($result);
	
// установим булевое значение для отправки в БД
$CurComm="com$currentID";
$Curdel="del$currentID";	
if (!isset($$CurComm))
{
$CurComm=0;
}
else $CurComm=1;
	$query = "UPDATE upload_files SET comments_enabled=$CurComm  WHERE user_id=$uID  AND file_id=$currentID";  
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());

// произведём групповое удаление файлов с проверкой подлиности пользователя для каждого файла	
$CurDel="del$currentID";
	if ($$CurDel=="on")
	{
		$fID=substr($key, 3);
			$query = "SELECT * FROM upload_files WHERE file_id=$fID AND user_id=$uID";
			$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
			
			    if ($row = mysql_fetch_assoc($result)) // если есть выборка проведём удаление
				{
				$filepath="$uploads_dir".$_SESSION['user_id']."/".$row['filename_alias'];
				if (!unlink($filepath)) $txerror="файл не удалён";
				else // не удаляем и из базы, если не удалили из директории 
				{
				$query = "DELETE FROM upload_files WHERE file_id=$fID";
				$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
				}
				}
	}
}
} 
// вернёмся к списку
header("Location: http://".$_SERVER['HTTP_HOST']."/list.php");
?>
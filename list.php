<?
require "auth.php";
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>Список файлов пользователя</title>
</head>

<body><table border=1>
<tr><td>№</td><td>ID</td><td>Имя файла</td><td>Помещён на сервер</td><td>комментарии</td><td>открыть</td><td>удалить</td></tr>";
$rows_in_page=25;

if (!isset($_GET['page'])) {$page=0;}
else {$page=$_GET['page'];}
$user_id=$_SESSION['user_id'];
$query = "SELECT * FROM upload_files WHERE user_id=$user_id";
	  
$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
$counter=0;
while ($row = mysql_fetch_assoc($result)) {
$counter++;
if ((($page==0)&($counter<=25))|(($page>0)&($counter>$page*$rows_in_page)&($counter<$rows_in_page*($page+1))))
{ 
    print "<tr><td>$counter</td>";
    print "<td>".$row['file_id']."</td>";
    print "<td>".$row['filename']."</td>";	
    print "<td>".$row['datetime']."</td>";
    print "<td>".$row['comments_enabled']."</td><td>-</td><td>-</td></tr>";
}
	}
// используем полученное значение $counter для подсчёта количества страниц и  организуем навигацию по списку файлов
$pages=round ($counter/25,0)+1;
	print "</table>pages:$pages ---";


for ($i=0; $i<$pages; $i++)
{
if ($i==$page) print "<a href=http://foronliner.com/list.php?page=$i><b>[$i] </b></a>";
else print "<a href=http://foronliner.com/list.php?page=$i> [$i] </a>";
}

print"<br></body>";
print "</html>";

?>
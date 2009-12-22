<?
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>Список файлов для неавторизованного пользователя</title>
</head>

<body>
<h3>Список файлов для неавторизованного пользователя</h3>
<table border=1>
<tr><td>№</td><td>ID</td><td>Имя файла</td><td>Помещён на сервер</td><td>доступные операции</td></tr>";
$rows_in_page=25;
// первая страница будет начинаться не с нуля, а 1.
if (!isset($_GET['page'])) {$page=1;}
else {$page=$_GET['page'];}
// Сортировка
if ((!isset($_GET['sort'])))
	$ord="datetime";
elseif  ($_GET['sort']=="filename") $ord="filename";
if ((isset($_GET['desc'])))
	$ord="$ord DESC";
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files  ORDER BY $ord";
$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
$counter=0;
while ($row = mysql_fetch_assoc($result)) {
$counter++;
if ((($page==1)&($counter<=25))|(($page>1)&($counter>($page-1)*$rows_in_page)&($counter<$rows_in_page*($page))))
{ 
    print "<tr><td>$counter </td>";
    print "<td>".$row['file_id']."</td>";
    print "<td><a href=download.php?file_id=".$row['file_id'].">".$row['filename']."</a></td>";	
    print "<td>".$row['datetime']."</td>";
if ($row['comments_enabled']==1) 
{
	//$query="SELECT COUNT(*) FROM comments WHERE file_id= ".$row['file_id']." ORDER BY id DESC";
	$querycount = mysql_query  ("SELECT COUNT(*) FROM comments WHERE file_id= ".$row['file_id']." ORDER BY id DESC");
	$countcomm = mysql_result ($querycount,0);	
	$commlink="<a href=\"comment.php?file_id=".$row['file_id']."\">оставить комментарий ($countcomm)</a>";
}
else $commlink="не доступно";
	print "<td>$commlink</td></tr>\r";
}
}
print "</table>";

// используем полученное значение $counter для подсчёта количества страниц и  организуем навигацию по списку файлов
$pages=Ceil($counter/25);
print  "Страниц:$pages >";

for ($i=1; $i<$pages+1; $i++)
{
if ($i==$page) print "<a href=listnonregister.php?page=$i><b>[$i] </b></a>";
else print "<a href=listnonregister.php?page=$i> [$i] </a>";
}


print"<br><br>Авторизуйтесь: <br>
<form method=\"POST\" action=list.php>
email <input type=\"text\" name=\"email\"><br>
pass: <input type=\"password\" name=\"password\"><br>
<input type=\"submit\"><br>
</form>

<br></body>";
print "</html>";

?>
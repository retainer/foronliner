<?
require_once "settings.php";
if (!(isset($_GET['desc'])))   //эти проверки необходимы для подготовки навигации сортировки
	$desclink="desc";
	else $desclink="";
if ((isset($_GET['page'])))   //эти проверки необходимы для подготовки навигации сортировки
	$pagelink="&page=".$_GET['page'];
	else $pagelink="";		

print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>Список файлов для неавторизованного пользователя</title>
<style type=\"text/css\">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #FF0000;
}
a:active {
	color: #FF0000;
}
body,td {
	font-family: Arial, Helvetica, sans-serif;
}
table 
{

padding-bottom:0px;
width:100%;
border:0px;
border-color:#FFFFFF;

}
td 
{
background-color:#DFDFDF;
}

-->
</style>



</head>

<body>
<h3>Список файлов для неавторизованного пользователя</h3>
<table>
<tr><td><b>№</b></td><td><b>ID</b></td><td><b><a href=\"listnonregister.php?sort=filename&$desclink$pagelink\">Имя файла</a></b></td><td><b><a href=\"listnonregister.php?$desclink$pagelink\">Помещён на сервер</a></b></td><td><b>доступные операции</b></td></tr>";
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
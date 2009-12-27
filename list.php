<?
require_once "settings.php";
require "auth.php";

if (!(isset($_GET['desc'])))   //эти проверки необходимы для подготовки навигации сортировки
	$desclink="&desc";
	else $desclink="";
if ((isset($_GET['page'])))   //эти проверки необходимы для подготовки навигации сортировки
	$pagelink="&page=".$_GET['page'];
	else $pagelink="";	

	print "<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"cp-1251\" />
<title>Управление списком файлов авторизованного пользователя</title>
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
#logout {
	position: absolute;
	right: 13px;
	height: 24px;
	width: 91px;
	top: 9px;
	background-color: #CCFFCC;
}
-->
</style>
</head>
<body>
<h3>Управление списком файлов авторизованного пользователя</h3>
<form id=\"list\" name=\"list\" method=\"POST\" action=\"groupcorrection.php\">
<table>
<tr><td width=50><b>№</b></td><td width=50><b>ID</b></td><td><b><a href=\"/foronliner/list.php?sort=filename$desclink$pagelink\">Имя файла</a></b></td><td width=200><b><a href=\"/foronliner/list.php?$desclink$pagelink\">Помещён на сервер</b></td><td width=300><b>комментарии разрешены</b></td><td width=100><b>удалить</b></td></tr>";
// первая страница будет начинаться не с нуля, а 1.
if (!isset($_GET['page'])) {$page=1;}
else {$page=$_GET['page'];}
$user_id=$_SESSION['user_id'];
// Сортировка
if ((!isset($_GET['sort'])))  // если без параметров - то по дате
	$ord="datetime";
elseif  ($_GET['sort']=="filename") $ord="filename";
if ((isset($_GET['desc'])))
	$ord="$ord DESC";

	$query = "SELECT * FROM upload_files WHERE user_id=$user_id ORDER BY $ord";	  
	$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
	$counter=0;
	while ($row = mysql_fetch_assoc($result)) {
$counter++;
if ((($page==1)&($counter<=RECSPERPAGE))|(($page>1)&($counter>($page-1)*RECSPERPAGE)&($counter<RECSPERPAGE*($page))))
{ 
    print "<tr><td>$counter </td>";
    print "<td>".$row['file_id']."</td>";
    print "<td><a href=/foronliner/download.php?file_id=".$row['file_id'].">".$row['filename']."</a></td>";	
    print "<td>".$row['datetime']."</td>";
    if ($row['comments_enabled']) $CommEnab="checked";
	else $CommEnab="";
	print "<td> 
	<label>  <input type=\"checkbox\" name=\"com".$row['file_id']."\" id=\"com\" $CommEnab /></label></td><td><a href=\"/foronliner/remove_UF.php?file_id=".$row['file_id']."\">удалить </a><label> <input type=\"checkbox\" name=\"del".$row['file_id']."\" id=\"del\" /></label>  <input type=\"hidden\" name=\"hid".$row['file_id']."\" value=\"1\" />
	 <input type=\"hidden\" name=\"hid".$row['file_id']."\" value=\"1\" />   
	</td></tr>\r";
}
}
print "</table>
  <label><input type=\"submit\"  value=\"Внести коррекцию\" /> </label>
</form>";



// используем полученное значение $counter для подсчёта количества страниц и  организуем навигацию по списку файлов
$pages=Ceil($counter/RECSPERPAGE);
if ($pages==0) $pages=1; // исправление счётчика страниц и навигации при ситуации, когда у пользователя нет загруженых файлов
print  "Страниц:$pages >";
for ($i=1; $i<$pages+1; $i++)
{
if ($i==$page) print "<a href=/foronliner/list.php?page=$i><b>[$i] </b></a>";  // текущая страница выделяется жирным шрифтом
else print "<a href=/foronliner/list.php?page=$i> [$i] </a>";
}
print"<div>
   <form action=\"uploadserv.php\" method=\"post\" enctype=\"multipart/form-data\">
      <input type=\"file\" name=\"filename\"><br>
      <input type=\"submit\" value=\"Загрузить\"><br>
      </form>

</div>";


print"<br>
<div align=\"center\" class=\"logout\" id=\"logout\"><a href=/foronliner/list.php?action=logout><b>выход</b></a></div>
</body>";
print "</html>";

?>
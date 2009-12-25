<?
require_once "settings.php";
function  reccom ($idlink, $idfile)  // рекурсивная функция
{
	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
	$queryrec = "SELECT * FROM comments WHERE file_id=$idfile AND id=$idlink";
	$resultrec = mysql_query($queryrec) or die("БД- ошибка запроса: " . mysql_error());
	$row2 = mysql_fetch_assoc($resultrec);
	if ($row2['link_id']!="0") 
		{
		 print "<div class=\"comment\" id=\"comment\">";
		 reccom ($row2['link_id'],$row2['file_id']);
		print $row2['name'];
		print " писал ";
		print $row2['text'];
		print "<br></div><br>";		 
		}
	else 
	{
		print "<div class=\"comment\" id=\"comment\">";
		print $row2['name'];
		print " писал ";
		print $row2['text'];
		print "<br></div><br>";
		return;
	}
}


if (!isset ($_GET['file_id'])) 
{ 
	print "не указан файл для комментирования <a href='listnonregister.php'>вернуться</a>";
	exit; 
};
$fID=$_GET['file_id'];

	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
    mysql_select_db("upload_files") or die("невозможно выполнить выборку из БД");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
	$fn=$row['filename'];
	}

print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; />
<title>Комментарии для  файла $fn:</title>";
print "
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
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
#comment {
	background-color: #FFFFCC;
	border-color:#000000;
	border:1px;
	border-style:dotted;
	padding: 5px;
}
#comauthor {
	color:#ffffff;
	background-color: #000000;
	border-color: #FF0000;
	position: relative;
	left: 10px;
	width:500px;
}
#comarea {
	color:#000000;
	background-color: #FFFFFF;
	border-color: #FFFFFF;
	position: relative;
	left: 10px;
	width:400px;
}
-->
</style>";


print "</head>
<body>
<h3>Комментарии для  файла $fn</h3>
<table border=1>";
	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("Ошибка соединения: " . mysql_error());
	$query = "SELECT * FROM comments WHERE file_id=$fID ORDER BY id DESC";
	$result = mysql_query($query) or die("БД- ошибка запроса: " . mysql_error());

while ($row = mysql_fetch_assoc($result)) 
	{
		if ($row['link_id']!="0") 
		{
		// данный комментарий - ответ на цитату с id=link_id, организуем древовидный вывод комментариев посредством рекурсии
		print "<div class=\"comment\" id=\"comment\">";
		 reccom ($row['link_id'],$row['file_id']);
		print $row['name'];
		print "<br>";
		print $row['text'];
		print "<br>";
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID#inputform>ответить</a><br></div><br>";		 
		 print "</div>";
		}	

		else {
		print "<div class=\"comment\" id=\"comment\">";
		print $row['name'];
		print "<br>";
		print $row['text'];
		print "<br>";
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID#inputform>ответить</a><br></div><br>";
		}
	}
	
print"</table>";
//  поле для ввода комментария:
print "<a href=comment.php?&file_id=$fID#inputform name=\"inputform\">Оставить мнение для файла:</a><br>";
print "
<form id=\"addcomment\" name=\"addcomment\" method=\"POST\" action=\"addcomment.php\">

  <p>
    <label>Комментарий к файлу:<br>";
	
	if (isset($_GET['link_id'])) {print "Вы отвечаете на сообщение id#";  print $_GET['link_id']."<br>";}
	
	print "<textarea name=\"comment\" id=\"comarea\" cols=\"45\" rows=\"5\"></textarea>
    </label>
  </p>
  <p>  <label>Имя:
  <input type=\"text\" name=\"nm\" id=\"nm\" />
  </label>
    <label>
    <input type=\"submit\" name=\"add\" id=\"add\" value=\"Добавить\" />
    </label>
	<input type=\"hidden\" name=\"file_id\" value=\"$fID\" />
	<input type=\"hidden\" name=\"link_id\" value=\"".$_GET['link_id']." \" /></p>
</form>
";
?>
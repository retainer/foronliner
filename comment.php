<?
function  reccom ($idlink, $idfile)  // ����������� �������
{
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("������ ����������: " . mysql_error());
	$queryrec = "SELECT * FROM comments WHERE file_id=$idfile AND id=$idlink";
	$resultrec = mysql_query($queryrec) or die("��- ������ �������: " . mysql_error());
	$row2 = mysql_fetch_assoc($resultrec);
	if ($row2['link_id']!="0") 
		{
		 print "<div class=\"comment\" id=\"comment\">";
		 reccom ($row2['link_id'],$row2['file_id']);
		print $row2['name'];
		print " ����� ";
		print $row2['text'];
		print "<br></div><br>";		 
		}
	else 
	{
		print "<div class=\"comment\" id=\"comment\">";
		print $row2['name'];
		print " ����� ";
		print $row2['text'];
		print "<br></div><br>";
		return;
	}
}


if (!isset ($_GET['file_id'])) 
{ 
	print "�� ������ ���� ��� ��������������� <a href='listnonregister.php'>���������</a>";
	exit; 
};
$fID=$_GET['file_id'];

	$link = mysql_connect("localhost", "upload_files", "UF") or die("������ ����������: " . mysql_error());
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
	$fn=$row['filename'];
	}

print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>����������� ���  ����� $fn:</title>";
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
<h3>����������� ���  ����� $fn</h3>
<table border=1>";
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("������ ����������: " . mysql_error());
	$query = "SELECT * FROM comments WHERE file_id=$fID ORDER BY id DESC";
	$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());

while ($row = mysql_fetch_assoc($result)) 
	{
		if ($row['link_id']!="0") 
		{
		// ������ ����������� - ����� �� ������ � id=link_id, ���������� ����������� ����� ������������ ����������� ��������
		print "<div class=\"comment\" id=\"comment\">";
		 reccom ($row['link_id'],$row['file_id']);
		print $row['name'];
		print "<br>";
		print $row['text'];
		print "<br>";
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID#inputform>��������</a><br></div><br>";		 
		 print "</div>";
		}	

		else {
		print "<div class=\"comment\" id=\"comment\">";
		print $row['name'];
		print "<br>";
		print $row['text'];
		print "<br>";
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID#inputform>��������</a><br></div><br>";
		}
	}
	
print"</table>";
//  ���� ��� ����� �����������:
print "<a href=comment.php?&file_id=$fID#inputform name=\"inputform\">�������� ������ ��� �����:</a><br>";
print "
<form id=\"addcomment\" name=\"addcomment\" method=\"POST\" action=\"addcomment.php\">

  <p>
    <label>����������� � �����:<br>";
	
	if (isset($_GET['link_id'])) {print "�� ��������� �� ��������� id#";  print $_GET['link_id']."<br>";}
	
	print "<textarea name=\"comment\" id=\"comarea\" cols=\"45\" rows=\"5\"></textarea>
    </label>
  </p>
  <p>  <label>���:
  <input type=\"text\" name=\"nm\" id=\"nm\" />
  </label>
    <label>
    <input type=\"submit\" name=\"add\" id=\"add\" value=\"��������\" />
    </label>
	<input type=\"hidden\" name=\"file_id\" value=\"$fID\" />
	<input type=\"hidden\" name=\"link_id\" value=\"".$_GET['link_id']." \" /></p>
</form>
";
?>
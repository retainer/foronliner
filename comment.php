<?
function  reccom ($idlink, $idfile)
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
if (!isset ($_GET['file_id'])) { 
print "�� ������ ���� ��� ��������������� <a href='	listnonregister.php'>���������</a>";
exit; };
$fID=$_GET['file_id'];

	$link = mysql_connect("localhost", "upload_files", "UF") or die("������ ����������: " . mysql_error());
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
	$fn=$row['filename'];
	}
print "����������� ����������� � link_ID=";
print $_GET['link_id'];
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>����������� ���  ����� $fn:</title>";
print "
<style type=\"text/css\">
<!--
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
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID>��������</a><br></div><br>";		 
		 print "</div>";
		}	

		else {
		print "<div class=\"comment\" id=\"comment\">";
		print $row['name'];
		print "<br>";
		print $row['text'];
		print "<br>";
		print "<a href=comment.php?link_id=".$row['id']."&file_id=$fID>��������</a><br></div><br>";
		}
	}
	
print"</table>";
//  ���� ��� ����� �����������:
print "�������� �����������:<br>";
print "
<form id=\"addcomment\" name=\"addcomment\" method=\"POST\" action=\"addcomment.php\">
  <label>name
  <input type=\"text\" name=\"nm\" id=\"nm\" />
  </label>
  <p>
    <label>comment <br>
    <textarea name=\"comment\" id=\"comment\" cols=\"45\" rows=\"5\"></textarea>
    </label>
  </p>
  <p>
    <label>
    <input type=\"submit\" name=\"add\" id=\"add\" value=\"Submit\" />
    </label>
	<input type=\"hidden\" name=\"file_id\" value=\"$fID\" />
	<input type=\"hidden\" name=\"link_id\" value=\"".$_GET['link_id']." \" /></p>
</form>
";
?>
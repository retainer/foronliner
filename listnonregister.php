<?
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>������ ������ ��� ����������������� ������������</title>
</head>

<body>
<h3>������ ������ ��� ����������������� ������������</h3>
<table border=1>
<tr><td>�</td><td>ID</td><td>��� �����</td><td>������� �� ������</td><td>��������� ��������</td></tr>";
$rows_in_page=25;
// ������ �������� ����� ���������� �� � ����, � 1.
if (!isset($_GET['page'])) {$page=1;}
else {$page=$_GET['page'];}
// ����������
if ((!isset($_GET['sort'])))
	$ord="datetime";
elseif  ($_GET['sort']=="filename") $ord="filename";
if ((isset($_GET['desc'])))
	$ord="$ord DESC";
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("������ ����������: " . mysql_error());
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");
	$query = "SELECT * FROM upload_files  ORDER BY $ord";
$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
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
	$commlink="<a href=\"comment.php?file_id=".$row['file_id']."\">�������� ����������� ($countcomm)</a>";
}
else $commlink="�� ��������";
	print "<td>$commlink</td></tr>\r";
}
}
print "</table>";

// ���������� ���������� �������� $counter ��� �������� ���������� ������� �  ���������� ��������� �� ������ ������
$pages=Ceil($counter/25);
print  "�������:$pages >";

for ($i=1; $i<$pages+1; $i++)
{
if ($i==$page) print "<a href=listnonregister.php?page=$i><b>[$i] </b></a>";
else print "<a href=listnonregister.php?page=$i> [$i] </a>";
}


print"<br><br>�������������: <br>
<form method=\"POST\" action=list.php>
email <input type=\"text\" name=\"email\"><br>
pass: <input type=\"password\" name=\"password\"><br>
<input type=\"submit\"><br>
</form>

<br></body>";
print "</html>";

?>
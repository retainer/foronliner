<?
require "auth.php";
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>���������� ������� ������ ��������������� ������������</title>
</head>

<body>
<h3>���������� ������� ������ ��������������� ������������</h3>
<form id=\"list\" name=\"list\" method=\"POST\" action=\"groupcorrection.php\">
<table border=1>
<tr><td>�</td><td>ID</td><td>��� �����</td><td>������� �� ������</td><td>����������� ���������</td><td>�������</td></tr>";
$rows_in_page=25;
// ������ �������� ����� ���������� �� � ����, � 1.
if (!isset($_GET['page'])) {$page=1;}
else {$page=$_GET['page'];}
$user_id=$_SESSION['user_id'];
// ����������
if ((!isset($_GET['sort'])))
	$ord="datetime";
elseif  ($_GET['sort']=="filename") $ord="filename";
if ((isset($_GET['desc'])))
	$ord="$ord DESC";

	$query = "SELECT * FROM upload_files WHERE user_id=$user_id ORDER BY $ord";	  
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
    if ($row['comments_enabled']) $CommEnab="checked";
	else $CommEnab="";
	print "<td> 
	<label>  <input type=\"checkbox\" name=\"com".$row['file_id']."\" id=\"com\" $CommEnab /></label></td><td><a href=\"remove_UF.php?file_id=".$row['file_id']."\">������� </a><label> <input type=\"checkbox\" name=\"del".$row['file_id']."\" id=\"del\" /></label>  <input type=\"hidden\" name=\"hid".$row['file_id']."\" value=\"1\" />
	 <input type=\"hidden\" name=\"hid".$row['file_id']."\" value=\"1\" />   
	</td></tr>\r";
}
}
print "</table>
  <label><input type=\"submit\" name=\"runbutton\" id=\"runbutton\" value=\"������ ���������\" /> </label>
</form>";



// ���������� ���������� �������� $counter ��� �������� ���������� ������� �  ���������� ��������� �� ������ ������
$pages=Ceil($counter/25);
if ($pages==0) $pages=1; // ����������� �������� ������� � ��������� ��� ��������, ����� � ������������ ��� ���������� ������
print  "�������:$pages >";

for ($i=1; $i<$pages+1; $i++)
{
if ($i==$page) print "<a href=http://foronliner.com/list.php?page=$i><b>[$i] </b></a>";
else print "<a href=http://foronliner.com/list.php?page=$i> [$i] </a>";
}
print"<div>

   <form action=\"uploadserv.php\" method=\"post\" enctype=\"multipart/form-data\">
      <input type=\"file\" name=\"filename\"><br> 
	   <input type=\"checkbox\" name=\"comment_enabled\" id=\"comment_enabled\" /> 
       ����������� �������������������� ������������� ���������</label><br>
      <input type=\"submit\" value=\"���������\"><br>
      </form>

</div>";


print"<br></body>";
print "</html>";

?>
<?
require "auth.php";
$fID=$_GET['file_id'];
$uID=$_SESSION['user_id'];
// ������� ���� ����� ������ �������������� �������� �����
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("������ ����������: " . mysql_error());
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");
	$query = "SELECT * FROM upload_files WHERE file_id=$fID AND user_id=$uID";
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{

$uploads_dir = 'uploaduserfiles/';
$filepath="$uploads_dir".$_SESSION['user_id']."/".$row['filename_alias'];
if (unlink($filepath))  print "������� ����� ���� $filepath";
	$query = "DELETE FROM upload_files WHERE file_id=$fID";
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
     }
?>
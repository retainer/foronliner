<?
require "auth.php";
$uploads_dir = 'uploaduserfiles/';
$uID=$_SESSION['user_id'];
//print_r ($_POST);
//print "<br>";
//�� ������������ ������������ ����� ��������� �������� ��� ������ ������� '������������'-'����'.

// ��������� ������ ������  ���������� ��� ��������� �� �������� ���� c ������ hidX.
foreach ( $_POST as $key => $val )
{
 $$key = $val;
 print "<br>---$key -- $val--- "; 
 if (substr($key, 0,3)=="hid")
 {
	print substr($key, 3);
	$currentID=substr($key, 3); // ������� �������������
	$link = mysql_connect("localhost", "upload_files", "UF")  or die("������ ����������: " . mysql_error());
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");
	$query = "SELECT * FROM upload_files WHERE user_id=$uID AND file_id=$currentID"; 
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
	$row = mysql_fetch_assoc($result);
	
	print "<b>".$row['filename']."</b>";
// ��������� ������� �������� ��� �������� � ��
$CurComm="com$currentID";
$Curdel="del$currentID";	
if (!isset($$CurComm))
{
print " $CurComm =${$CurComm} off  $Curdel= ${$Curdel} off ";
$CurComm=0;
}
else $CurComm=1;

	$query = "UPDATE upload_files SET comments_enabled=$CurComm  WHERE user_id=$uID  AND file_id=$currentID";  
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
}
// ��������� ��������� �������� ������ � ��������� ���������� ������������ ��� ������� �����	
$CurDel="del$currentID";
	if ($$CurDel=="on")
	{
		$fID=substr($key, 3);
			$query = "SELECT * FROM upload_files WHERE file_id=$fID AND user_id=$uID";
			$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
			
			    if ($row = mysql_fetch_assoc($result)) // ���� ���� ������� ������� ��������
				{
				$filepath="$uploads_dir".$_SESSION['user_id']."/".$row['filename_alias'];
				if (unlink($filepath))  print "������� ����� ���� $filepath";
				$query = "DELETE FROM upload_files WHERE file_id=$fID";
				$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
				}
	}
	} 

?>
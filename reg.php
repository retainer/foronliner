<?
require_once "settings.php";
function checkmail($string)
{
return preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $string);
}
function prepareforsave ($string)  // ���������� ������ ��� ����������� ���������� � ��
{
//$string = strip_tags($string);
//$string = nl2br($string);

return $string;
}
//print_r ($_POST);

if ($_POST['username']=="")
{
print "��� �� �������<br>";exit;
}
if ($_POST['mail']=="") 
{
print "����� �� �������";exit;
}
if (!checkmail($_POST['mail'])) 
{
print "������ ����� ������ �������";exit;
}

if ($_POST['pass1']=="") 
{
print "������ �� �����"; exit;
}
if (strlen($_POST['pass1'])<$passlen) 
{
print "����� ������ ������ ���� �� ����� $passlen ��������"; exit;
}

if ($_POST['pass1']!=$_POST['pass2'])
{
print "������ � ��� ������������� �� ���������"; exit;
}

// ������� ���������� �����
$username=prepareforsave($_POST['username']);
$mail=prepareforsave($_POST['mail']);
$pass1=prepareforsave($_POST['pass1']);

$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];

	$link = mysql_connect(DBHOST, DBUSER, DBPASSWD)  or die("������ ����������: " . mysql_error());
    mysql_select_db("$DBNAME") or die("���������� ��������� ������� �� ��");
// ��������, �� ���������� �� ��� �����  ������������
	$query = "SELECT * FROM users WHERE email='$mail'";
	
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
		print "�� ������ email ��� ��������������� ������������. <br> �������� ������ email";
	}
	else 
	{
		$query = "INSERT INTO `users` ( `user`,`email`,`password`) VALUES  ( '$username','$mail', '$pass1');";
		$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());	
	
	//������ ������ ������������� ���� ������� � �������� ����� ��� ������ � ����� �� ������
    $query = "SELECT * FROM users WHERE email='$mail'";
    $result = mysql_query($query) or die("��- ������ �������: " . mysql_error());
    if ($row = mysql_fetch_assoc($result))
	{
		if (!mkdir ("$uploads_dir".$row['user_id'])) {print "���������� $uploads_dir".$row['user_id']." �� �������. ���������  ����� ������� � ��������� ������ �������"; exit;}
		header("Location: http://".$_SERVER['HTTP_HOST']."/foronliner/list.php");
	}
	}

?>
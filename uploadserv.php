<?php
require "auth.php"; // ������ ����������� � ������� ������
// ��������� ��������� ���������� 
$uploads_dir = 'uploaduserfiles/'; // ���������� ��� ���������� ������
$upload_max_filesize = 5*1024*1024; //��������� ����������� �� ������ ����� � 5 ��������
$filenamealias=strtotime("now"); // ��������� ����� ����� ����������� ��� UNIX timestamp
//--------------------------------------------------------------------------------------
   if($_FILES["filename"]["size"] > $upload_max_filesize)  
   {
     echo ("������ ����� ��������� 5 ��������");
     exit;
   }
// � ����� ������������ ����������� ���� ��������� �������, � ��������� ��� �������� � ��.
//  ���������� ���������� ����������� � ��������������� ������������ �������� ������ �� ����� ����������� ����� ������ ������������.
   if(move_uploaded_file($_FILES["filename"]["tmp_name"], "$uploads_dir".$_SESSION['user_id']."/$filenamealias"))
   {
     echo("���� ������� �������� <br>");
     echo("��� �����: ");
     echo($_FILES["filename"]["name"]);
     echo("<br>������ �����: ");
     echo($_FILES["filename"]["size"]);
     echo("<br>������� ��� ��������: ");
     echo($_FILES["filename"]["tmp_name"]);
     echo("<br>��� �����: ");
     echo($_FILES["filename"]["type"]);
   } else {
      echo("������ �������� �����");
	  }

	  $link = mysql_connect("localhost", "upload_files", "UF")
        or die("������ ����������: " . mysql_error());
    print "�������� �����������";
    mysql_select_db("upload_files") or die("���������� ��������� ������� �� ��");

// ���������� ��� ���������� ��� �������� � ��	
//--------------------------------------------------------------------------------------
$fullfilename="../uploaduserfiles/";
$DaTi=date("Y-m-d H:i:s");  
$uploadfile=$_FILES["filename"]["name"];
$uploadfilealias=$_FILES["filename"]["name"];
$ip_user=$_SERVER['REMOTE_ADDR'];
$browser_user=$_SERVER['HTTP_USER_AGENT'];
$user_id=$_SESSION['user_id'];	
//--------------------------------------------------------------------------------------
	
	//  ���������� ������ �������
 $query = "INSERT INTO `upload_files` ( `filename`,`filename_alias`, `datetime`, `IP`, `browser`, `comments_enabled`, `user_id`) VALUES 
 ( '$uploadfile','$filenamealias', '$DaTi', '$ip_user', '$browser_user', '1', '$user_id'); ";
 // ��� ���� file_id ��������� ��������������������, ������� � ������ ������� ��� ��������� �� �����
 
$result = mysql_query($query) or die("��- ������ �������: " . mysql_error());

	  ?>
</body>
</html>

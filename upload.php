<?
require "auth.php";
print "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
<title>�������� ����� �� ������</title>
</head>

<body>
<div>

   <form action=\"uploadserv.php\" method=\"post\" enctype=\"multipart/form-data\">
      <input type=\"file\" name=\"filename\"><br> 
	   <input type=\"checkbox\" name=\"comment_enabled\" id=\"comment_enabled\" /> 
       ����������� �������������������� ������������� ���������</label><br>
      <input type=\"submit\" value=\"���������\"><br>
      </form>

</div>
</body>
</html>";

?>
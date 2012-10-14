<?PHP
session_start();
include('../config.php');
$Password=htmlspecialchars($_POST["password"]);
$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
mysql_select_db($DB_dbname);
$Query=mysql_query('SELECT siteadminpassword FROM fw_settings;');
$Data=mysql_fetch_array($Query);
$Admin_password=$Data['siteadminpassword'];
if(md5($Password)==$Admin_password)
	{
		$_SESSION["adminauth"]=true;
		$LoginFlag=true;
	}else
	{
		$LoginFlag=false;
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вход в администраторский интерфейс</title>
</head>

<body>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#F4F4F4" style="padding:7px;">Вход в администраторский интерфейс</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:7px;"><p><?PHP
    if($LoginFlag==true)
		{
			echo('Вы успешно вошли в систему. Перейдите по этой <a href="index.php">ссылке для начала работы</a>.');
		};
	if($LoginFlag==false)
		{
			echo('Ошибка авторизации. <a href="index.php">Вернитесь и повторите попытку</a>.');
		};
	?></p></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF" style="padding:7px;"><p>Версия $SystemVersion<br />
      Четвертков Сергей 2012</p></td>
  </tr>
</table>
</body>
</html>
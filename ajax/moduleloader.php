<?PHP
error_reporting("E_ALL");
include('../includes/systeminfo.php');
include("../config.php");
$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
echo(mysql_error());
mysql_select_db($DB_dbname);
$CurrentModule=htmlspecialchars($_GET["current"]);
$Query=explode('/',$CurrentModule);
$ModuleTitle=trim($Query[0]);
if(($ModuleTitle==null)or($ModuleTitle=='index'))
	{
		//$Query[1]='indexpage';
		include("../modules/pages/main.php");
	}else{
include("../modules/$ModuleTitle/main.php");};

?>
<?PHP
include('../config.php');include('../includes/systeminfo.php');
$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
mysql_select_db($DB_dbname);

$SiteSettingsQuery=mysql_query('SELECT sitetitle,sitetemplate,site_language FROM fw_settings;');
$SiteSettings=mysql_fetch_array($SiteSettingsQuery);
$SiteTitle=$SiteSettings["sitetitle"];
$SiteTemplate=$SiteSettings["sitetemplate"];
$SiteLanguage=$SiteSettings["site_language"];
include("../langs/$SiteLanguage/lang.php");
if($ForVersion<>$SystemGlobalVersion)
	{
		echo($VERSION_compatible_error);
		//exit();
	};
session_start();
$AdminAuth=$_SESSION["adminauth"];
if($AdminAuth==false)
	{
		include("loginform.php");
		exit();
	};



$Action=htmlspecialchars($_GET["action"]);
if($Action==null)
	{
		$Action="hellopage";
	};
if($Action=="hellopage")
	{
		$PageContent='<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#FFFFFF" style="padding:15px;">'.$ADMIN_homepage_welcome.'</td>
  </tr>
  <tr>
    <td background="../images/admin/window_back.png" bgcolor="#F4F4F4" style="padding:10px;"><strong>'.$ADMIN_sitecontrol.':</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:35px;"><div style="width:100px; text-align:center; float:left;"><a href="?action=settings"><img src="../images/admin/settings.png">'.$ADMIN_settings.'</a></div><div style="width:100px; text-align:center; float:left;"><a href="?action=menueditor"><img src="../images/admin/menueditor.png">'.$ADMIN_menueditor.'</a></div></td>
  </tr>
  <tr>
    <td background="../images/admin/window_back.png" bgcolor="#F4F4F4" style="padding:10px;"><strong>'.$ADMIN_modules.':</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:35px;"><div id="modulesList"></div></td>
  </tr>
</table>
';
$InHead="<script type='text/javascript' src='../jquery.js'></script>    
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='ckeditor/adapters/jquery.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
	$('#modulesList').load('ajax/homepage_moduleslist.php');
	});
    $( '#content' ).ckeditor();
    </script>";
	};
	
if($Action=="module")
	{
		$PageContent='';
		$Mod=htmlspecialchars($_GET["mod"]);
		include("../modules/$Mod/admin.php");
	};
if($Action=="menueditor_create")
	{
		$LinkText=$_POST["text"];
		$Page=$_POST["page"];
		if($Page=="outside")
			{
				$Link=$_POST["url"];
				$Type='outside';
			}else
			{
				$Link=$Page;
				$Type='inside';
			};
		mysql_query('INSERT INTO fw_mainmenu VALUES ("","'.$LinkText.'","'.$Type.'","'.$Link.'","0","_self");');
		$PageContent='';
		$InHead='';
		$Action='menueditor';
	};
if($Action=="menueditor")
	{
		$Query=mysql_query('SELECT * FROM fw_pages');
		$OptionSet='<option value="outside"> - - -</option>';
		while($Data=mysql_fetch_array($Query))
			{
				$PageID=$Data['id'];
				$PageLink="#pages/$PageID";
				$PageTitle=$Data['title'];
				$OptionSet.='<option value="'.$PageLink.'">'.$PageTitle.'</option>';
			};
		$PageContent='<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#FFFFFF" style="padding:15px;">'.$ADMIN_menueditor_welcome.'</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4" style="padding:10px;"><strong>'.$ADMIN_menueditor_list.':</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:35px;">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4" style="padding:10px;"><strong>'.$ADMIN_menueditor_create.':</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:35px;"><form name="form1" method="post" action="?action=menueditor_create">
      <table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="32%">'.$ADMIN_menueditor_text.'</td>
          <td colspan="3">'.$ADMIN_menueditor_pageorlink.'</td>
          </tr>
        <tr>
          <td><label for="text">
            <input type="text" name="text" id="text" style="width:100%">
          </label></td>
          <td width="27%"><label for="page"></label>
            <select name="page" id="page" style="width:100%">
              '.$OptionSet.'
            </select></td>
          <td width="8%" style="text-align:center;"> '.$ADMIN_menueditor_or.'</td>
          <td width="33%">http://
            <label for="url"></label>
            <input type="text" name="url" id="url" style="width:60%;"></td>
        </tr>
      </table>
	  <center><input type="submit" value="'.$ADMIN_menueditor_createbutton.'" style="width:90%; height:45px;"> </center>
    </form></td>
  </tr>
</table>';
		$InHead='';
		
	};

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo($ADMIN_title); ?></title>
<style type="text/css">
a:link {
	color: #069;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #069;
}
a:hover {
	text-decoration: underline;
	color: #069;
}
a:active {
	text-decoration: none;
	color: #069;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
}
</style>
<?PHP echo($InHead); ?>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
  <tr>
    <td width="250" valign="top" bgcolor="#FFFFFF"style="padding:7px;"><ul>
      <li><a href="?action="><?PHP echo($ADMIN_homepage); ?></a>
        <ul>
          <li><a href="?action=settings"><?PHP echo($ADMIN_settings); ?></a></li>
          <li><a href="?action=menueditor"><?PHP echo($ADMIN_menueditor); ?></a></li>
        </ul>
      </li>
    </ul></td>
    <td bgcolor="#FFFFFF" style="padding:7px;"><?PHP echo($PageContent); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:7px;"><?PHP echo($ADMIN_version.':'.$SystemVersion); ?><br />
    <?PHP echo($ADMIN_build); ?>:</td>
    <td bgcolor="#FFFFFF" style="padding:7px;">FLYING WEB CMS</td>
  </tr>
</table>
</body>
</html>
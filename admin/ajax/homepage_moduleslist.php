<?PHP
include('../../config.php');include('../../includes/systeminfo.php');
$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
mysql_select_db($DB_dbname);

$SiteSettingsQuery=mysql_query('SELECT sitetitle,sitetemplate,site_language FROM fw_settings;');
$SiteSettings=mysql_fetch_array($SiteSettingsQuery);
$SiteTitle=$SiteSettings["sitetitle"];
$SiteTemplate=$SiteSettings["sitetemplate"];
$SiteLanguage=$SiteSettings["site_language"];
$dir = opendir ("../../modules");
  while ( $file = readdir ($dir))
  {
    if (( $file != ".") && ($file != ".."))
    {
      
	  include("../../modules/$file/langs/$SiteLanguage.php");
	  echo('<div style="width:80px; text-align:center;"><a href="?action=module&mod='.$file.'" title="'.$ModuleDescription.'"><img src="../modules/'.$file.'/icon.png">'.$ModuleTitle.'</a></div>');
    }
  }
  closedir ($dir);
?>
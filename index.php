<?PHP
session_start();
include('includes/systeminfo.php');
include("config.php");


$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
mysql_select_db($DB_dbname);

function ReadTextFile($FileURL)
	{
		$Return='';
		$File=file($FileURL);
		for($i=0;$i<count($File);$i++)
			{
				$Return.=$File[$i];
			};
		return $Return;
	};

$InHead="<script type='text/javascript' src='jquery.js'></script>


<script type='text/javascript'>
$(document).ready(function(){
	$('#pageContent').load('ajax/moduleloader.php');
	});
var default_content='';

$(document).ready(function(){
	
	checkURL();
	$('ul li a').click(function (e){

			checkURL(this.hash);

	});
	
	//filling in the default content
	default_content = $('#pageContent').html();
	
	
	setInterval('checkURL()',250);
	
});

var lasturl='';

function checkURL(hash)
{
	if(!hash) hash=window.location.hash;
	
	if(hash != lasturl)
	{
		lasturl=hash;
		
		// FIX - if we've used the history buttons to return to the homepage,
		// fill the pageContent with the default_content
		
		if(hash=='')
		$('#pageContent').html(default_content);
		
		else
		loadPage(hash);
	}
}


function loadPage(url)
{
	url=url.replace('#','');
	
	$('#loading').css('visibility','visible');
	
	$('#pageContent').load('ajax/moduleloader.php?current='+url);

};
</script>";
$SiteSettingsQuery=mysql_query('SELECT sitetitle,sitetemplate FROM fw_settings;');
$SiteSettings=mysql_fetch_array($SiteSettingsQuery);
$SiteTitle=$SiteSettings["sitetitle"];
$SiteTemplate=$SiteSettings["sitetemplate"];
$TemplateHTML=ReadTextFile("templates/$SiteTemplate/design.html");
$TemplateHTML=str_replace("</head>",$InHead,$TemplateHTML);
$TemplateHTML=str_replace("@SITETITLE@",$SiteTitle,$TemplateHTML);
$TemplateHTML=str_replace("@CONTENT@",'<div id="pageContent">Страница загружается. Ожидайте...</div>',$TemplateHTML);
echo($TemplateHTML);

?>
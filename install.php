<?PHP
include("config.php");


$DB_Connect=mysql_connect($DB_location,$DB_username,$DB_password);
mysql_select_db($DB_dbname);


//mysql_query('CREATE TABLE fw_settings (
//sitetitle text,
//sitetemplate text,
//siteadminpassword text,
//site_language text
//);');
//mysql_query('INSERT INTO fw_settings VALUES ("Проект THE FLYING WEB CMS","default","'.md5('sa12qw34').'","RU");');
//mysql_query('CREATE TABLE fw_pages (
//id char(20),
//title text,
//date integer,
//content text,
//PRIMARY KEY(id)
//);');
mysql_query('INSERT INTO fw_pages VALUES ("indexpage","Приветствие",131141,"<kf,kf,kfitxrf");');
echo(mysql_error());


?>
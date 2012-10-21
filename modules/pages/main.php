<?PHP
$PageID=trim($Query[1]);
if($PageID==null)
	{
		$Zapros2=mysql_query('SELECT * FROM fw_pages_set;');
		$PagesSettings=mysql_fetch_array($Zapros2);
		$HomePageID=$PagesSettings['homepage'];
		
		$PageID=$HomePageID;
		
	};

$Zapros=mysql_query('SELECT * FROM fw_pages;');
//echo(mysql_error());
while($Data=mysql_fetch_array($Zapros))
	{
		$ID=$Data['id'];
		//echo($ID);
		if($ID==$PageID)
			{
				$Title=$Data['title'];
				$Content=$Data['content'];
				echo($Title.'<hr>'.$Content);
			};
	};
?>
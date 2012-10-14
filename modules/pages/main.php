<?PHP
$PageID=trim($Query[1]);
if($PageID==null)
	{
		$PageID='index';
		
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
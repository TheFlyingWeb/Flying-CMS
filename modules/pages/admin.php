<?PHP
include("../modules/pages/langs/$SiteLanguage.php");
$View=htmlspecialchars($_GET["view"]);
if($View==null)
	{
		$View="main";
	};
	if($View=="sethome")
		{
			$PageID=$_GET['id'];
			$Zapros2=mysql_query('SELECT * FROM fw_pages_set;');
			$PagesSettings=mysql_fetch_array($Zapros2);
			echo(mysql_error());
			$ID_old=$PagesSettings['homepage'];
			mysql_query('UPDATE fw_pages_set SET homepage = "'.$PageID.'" WHERE homepage = "'.$ID_old.'";');
			echo(mysql_error());
			$View="main";
		};
if($View=="main")
	{
		$Zapros=mysql_query('SELECT * FROM fw_pages;');
		$Zapros2=mysql_query('SELECT * FROM fw_pages_set;');
		$PagesSettings=mysql_fetch_array($Zapros2);
		$HomePageID=$PagesSettings['homepage'];
		$PageContent.='<a href="?action=module&mod=pages&view=createpage">Создать новую страницу</a>
<hr><table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#F4F4F4" style=" padding:4px;">ID</td>
    <td bgcolor="#F4F4F4"style=" padding:4px;">Title</td>
    <td bgcolor="#F4F4F4"style=" padding:4px;">Date</td>
    <td bgcolor="#F4F4F4"style=" padding:4px;">HomeFlag</td>
    <td bgcolor="#F4F4F4"style=" padding:4px;">Действия</td>
  </tr>';
		while($Data=mysql_fetch_array($Zapros))
			{
				$ID=$Data['id'];
				
				$Title=$Data['title'];
				$Date=$Data['date'];
				$Content=$Data['content'];
				if($ID==$HomePageID)
					{
						$FlagContent='<font color="#00CC99">'.$Module_YES.'</font>';
					}else
					{
						$FlagContent='<font color="#CC3333">'.$Module_NO.'</font>';
					};
				//$HomeFlag=$Data['homeflag'];
				//if($HomeFlag==1)
					//{
					//	$FlagContent='<font color="#00CC99">'.$Module_YES.'</font>';
				//	}else
				//	{
				//		$FlagContent='<font color="#CC3333">'.$Module_NO.'</font>';
				//	};
				$PageContent.='<tr>
    <td bgcolor="#FFFFFF"style=" padding:4px;"><a href="../#pages/'.$ID.'" target="_blank">'.$ID.'</a></td>
    <td bgcolor="#FFFFFF"style=" padding:4px;">'.$Title.'</td>
    <td bgcolor="#FFFFFF"style=" padding:4px;">&nbsp;</td>
    <td bgcolor="#FFFFFF"style=" padding:4px;">'.$FlagContent.'</td>
    <td bgcolor="#FFFFFF"style=" padding:4px;"><a href="?action=module&mod=pages&view=editpage&id='.$ID.'">Редактировать</a><br>
      Удалить<br>
      <a href="?action=module&mod=pages&view=sethome&id='.$ID.'">'.$Module_SetHome.'</a></td>
  </tr>';
			};
		$PageContent.='</table>';
	};
if($View=="createpage")
	{
		$PageContent.='<form name="form1" method="post" action="?action=module&mod=pages&view=createpage2">
  <table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#F4F4F4">
        Идентификатор страницы:<br>
        <em>Будет использоваться в URL</em></td>
      <td bgcolor="#FFFFFF"><label for="id"></label>
      <input name="id" type="text" id="id" maxlength="25"></td>
    </tr>
    <tr>
      <td bgcolor="#F4F4F4">Заголовок страницы:</td>
      <td bgcolor="#FFFFFF"><label for="title"></label>
      <input name="title" type="text" id="title" maxlength="40"></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F4F4F4">Содержимое страницы:</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><label for="content"></label>
      <textarea name="ck_content" id="ck_content" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="Создать"></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( '."'ck_content'".' );
	};
</script>
';
		$InHead="<script type='text/javascript' src='ckeditor/ckeditor.js'></script>";
	};
if($View=="createpage2")
	{
		$ID=htmlspecialchars($_POST["id"]);
		$Title=htmlspecialchars($_POST["title"]);
		$Content=$_POST["ck_content"];
		mysql_query('INSERT INTO fw_pages VALUES ("'.$ID.'","'.$Title.'",'.time().',"'.$Content.'",0);');
		$PageContent.='';
		$InHead="";
	};
if($View=="editpage")
	{
		$ID=$_GET["id"];
		$Zapros=mysql_query('SELECT * FROM fw_pages WHERE id="'.$ID.'";');
		$Data=mysql_fetch_array($Zapros);
		$Title=$Data['title'];
		$Content=$Data['content'];
		$PageContent.='<form name="form1" method="post" action="?action=module&mod=pages&view=editpage2&id='.$ID.'">
  <table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#F4F4F4">
        Идентификатор страницы:<br>
        <em>Будет использоваться в URL</em></td>
      <td bgcolor="#FFFFFF">'.$ID.'</td>
    </tr>
    <tr>
      <td bgcolor="#F4F4F4">Заголовок страницы:</td>
      <td bgcolor="#FFFFFF"><label for="title"></label>
      <input name="title" type="text" id="title" maxlength="40" value="'.$Title.'"></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F4F4F4">Содержимое страницы:</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF">
      <textarea name="ck_content" id="ck_content" cols="45" rows="5">'.$Content.'</textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="Сохранить"></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( '."'ck_content'".' );
	};
</script>
';
		$InHead="<script type='text/javascript' src='ckeditor/ckeditor.js'></script>";
	};
if($View=="editpage2")
	{
		$ID=$_GET["id"];
		$NewTitle=htmlspecialchars($_POST["title"]);
		$NewContent=$_POST["ck_content"];
		mysql_query('UPDATE fw_pages SET title = "'.$NewTitle.'",
date = "'.time().'",
content ="'.$NewContent.'" WHERE fw_pages.id = "'.$ID.'";
');
echo(mysql_error());
		$Zapros=mysql_query('SELECT * FROM fw_pages WHERE id="'.$ID.'";');
		$Data=mysql_fetch_array($Zapros);
		$Title=$Data['title'];
		$Content=$Data['content'];
		$PageContent.='<form name="form1" method="post" action="?action=module&mod=pages&view=editpage2&id='.$ID.'">
  <table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#F4F4F4">
        Идентификатор страницы:<br>
        <em>Будет использоваться в URL</em></td>
      <td bgcolor="#FFFFFF">'.$ID.'</td>
    </tr>
    <tr>
      <td bgcolor="#F4F4F4">Заголовок страницы:</td>
      <td bgcolor="#FFFFFF"><label for="title"></label>
      <input name="title" type="text" id="title" maxlength="40" value="'.$Title.'"></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F4F4F4">Содержимое страницы:</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF">
      <textarea name="ck_content" id="ck_content" cols="45" rows="5">'.$Content.'</textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="Сохранить"></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( '."'ck_content'".' );
	};
</script>
';
		$InHead="<script type='text/javascript' src='ckeditor/ckeditor.js'></script>";
	};

?>
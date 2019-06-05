<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head></head>
<body>
	
<?php
	function echo_div($bo,$tar,$wd)
	{
		echo  "<div class=\"advanced_box\">";
		
		// bool
			if ($bo=="undefined")
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			elseif(!$bo)
			{
				echo "<select>";
				echo "<option value =\"AND\" selected>And</option>";
				echo "<option value =\"OR\">Or</option>";
				echo "</select>";
			}
			elseif ($bo=="AND")
			{
				echo "<select>";
				echo "<option value =\"AND\" selected>And</option>";
				echo "<option value =\"OR\">Or</option>";
				echo "</select>";
			}
			else
			{
				echo "<select>";
				echo "<option value =\"AND\">And</option>";
				echo "<option value =\"OR\" selected>Or</option>";
				echo "</select>";
			}

		// target
			echo "&nbsp;<select>";
			if (!$tar || $tar=="undefined")
			{
				echo "<option value =\"Title\" selected>Title</option>";
				echo "<option value =\"Authors_Name\">Author's Name</option>";
				echo "<option value =\"ConferenceName\">Conference</option>";
			}
			elseif ($tar=="Title")
			{
				echo "<option value =\"Title\" selected>Title</option>";
				echo "<option value =\"Authors_Name\">Author's Name</option>";
				echo "<option value =\"ConferenceName\">Conference</option>";
			}
			elseif ($tar=="Authors_Name")
			{
				echo "<option value =\"Title\">Title</option>";
				echo "<option value =\"Authors_Name\" selected>Author's Name</option>";
				echo "<option value =\"ConferenceName\">Conference</option>";
			}
			elseif ($tar=="ConferenceName")
			{
				echo "<option value =\"Title\">Title</option>";
				echo "<option value =\"Authors_Name\">Author's Name</option>";
				echo "<option value =\"ConferenceName\" selected>Conference</option>";
			}
			else
			{
				echo "<option value =\"Title\">Title</option>";
				echo "<option value =\"Authors_Name\">Author's Name</option>";
				echo "<option value =\"ConferenceName\" selected>Conference</option>";
			}
			echo "</select>";

		// word
		if($wd!="undefined")
			echo "&nbsp;<input type=\"text\" required value=\"$wd\">";
		else
			echo "&nbsp;<input type=\"text\" required>";


		echo "</div>";
	}

	$count=$_GET["count"];
	$add_del=$_GET["add_del"];

	if($add_del=='1')
	{
		if($count=="0")
		{
			echo_div("undefined","","");
		}
		else
		{
			$target=$_GET["target1"];
			$word=$_GET["word1"];	
			echo_div("undefined",$target,$word);
		}

		for ($i=2; $i <= $count; $i++)
		{ 
			$bool=$_GET[("bool".$i)];
			$target=$_GET[("target".$i)];
			$word=$_GET[("word".$i)];	
			echo_div($bool,$target,$word);
		}
		if($count>=1)
		{
			echo_div("","","");
		}
	}
	else
	{
		if($count=="0" || $count=="1")
		{
			$target=$_GET["target1"];
			$word=$_GET["word1"];	
			echo_div("undefined",$target,$word);
		}
		else
		{
			
			$target=$_GET["target1"];
			$word=$_GET["word1"];	
			echo_div("undefined",$target,$word);
		
			for ($i=2; $i <= $count-1; $i++)
			{ 
				$bool=$_GET[("bool".$i)];
				$target=$_GET[("target".$i)];
				$word=$_GET[("word".$i)];
				echo_div($bool,$target,$word);
			}
		}
	}

?>
</body>
</html>

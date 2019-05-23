<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<head>
	<title>Author</title>
</head>

<body>
	<h1>Author Information</h1>
	
	<?php
	// from search.php: get author_id
		$author_id = $_GET["author_id"];

		$link = mysqli_connect("127.0.0.1", "root", "", "lab01");

	// search and print the AuthorName corresponding to the given AuthorID
		mysqli_query($link, 'SET NAMES utf8');
		$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'");
		
	// return_to_homepage widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" width=\"30\"></a><br>";

	// judge whether find the author
		if ($author_name_res = mysqli_fetch_array($result))
		{
			// var_dump($author_name_res);
			$author_name=$author_name_res['AuthorName'];
			echo "Name: $author_name<br>";

		// search and print the most related AffiliationName to the given AuthorID
			$affi_id_name_result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");

			// while($row=mysqli_fetch_array($affi_id_name_result))
			// {
			// 	echo "<br>row<br>";
			// 	var_dump($row);
			// 	echo "<br>";
			// }

			// var_dump($affi_id_name_result);
			// echo "<br>";
			if($array_result=mysqli_fetch_array($affi_id_name_result))
			{
				// var_dump($array_result);
				// echo "<br>";
				$affiliation_name = $array_result['AffiliationName'];
				echo "Affiliation: $affiliation_name<br>";
			}
			else
			{
				echo "Affiliation not found!";
			}

			echo "<table class=\"result_table\" align=center><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";

		// search and print the papers of the AuthorID (in an ascending order of AuthorSequence)
			$paper_id_result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id'");
			if ($paper_id_result)
			{	
				while ($row = mysqli_fetch_array($paper_id_result))
				{
					$paper_id = $row['PaperID'];

					# 请增加对mysqli_query查询结果是否为空的判断
					$paper_info = mysqli_fetch_array(mysqli_query($link, "SELECT Title, ConferenceID from papers where PaperID='$paper_id'"));

				// print the PaperTitle
					if($paper_info)
					{
						$paper_title = $paper_info['Title'];
						$conference_id = $paper_info['ConferenceID'];

						echo "<tr>";
						echo "<td>$paper_title</td>";
					}
					else
						continue;

				// print all the AuthorName
					$author_name_result = mysqli_query($link, "SELECT B.AuthorName, B.AuthorID from paper_author_affiliation A Inner Join authors B where A.PaperID='$paper_id' and A.AuthorID=B.AuthorID Order by A.AuthorSequence");
					echo "<td>";
						foreach ($author_name_result as $author)
						{
							// echo "author:";
							// var_dump($author_result);
							// echo "<br>";
							$author_name=$author["AuthorName"];
							$author_id = $author["AuthorID"];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\">$author_name</a>";
							echo "; ";
						}
					echo "</td>";

				// print the ConferenceName
					$conference_name_result = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conference_id'"));
					echo "<td>";
						echo $conference_name_result['ConferenceName'];
					echo "</td>";

					# 请增加根据paper id在PaperAuthorAffiliations与Authors两个表中进行联合查询，找到根据AuthorSequenceNumber排序的作者列表，并且显示出来的部分

					# 请补充根据$conf_id查询conference name并显示的部分
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		else
		{
			echo "Name not found!";
		}

	?>
</body>

</html>
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
		mysqli_query($link, 'SET NAMES utf8');
		
	// return_to_homepage widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" width=\"30\"></a><br>";

	// search and print the AuthorName of the given AuthorID
		$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'");
		// judge whether find the author
		if ($author_name_res = mysqli_fetch_array($result))
		{
			// var_dump($author_name_res);
			$author_name=$author_name_res['AuthorName'];
			echo "<a name=\"skip_here\"></a>";
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

			echo "<table class=\"table__result\" align=center><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";

		// search and print the papers of the AuthorID (in an ascending order of AuthorSequence)
		// Turn Page Variables
		// Turn Page
			$page_limit=10;
			$page=$_GET["page"];
			$paper_id_count = mysqli_fetch_array(mysqli_query($link, "SELECT count(*) from paper_author_affiliation where AuthorID='$author_id'"))[0];
			$num_max = (int)$paper_id_count;
			$page_start_index=($page-1)*$page_limit;
		
		// Search the results of a certain range
			if($page_start_index+$page_limit-1>$num_max)
			{
				$temp=($num_max-$page_start_index);
				$paper_id_result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id' limit $page_start_index,$temp");
				// var_dump($page_start_index);
				// var_dump($temp);
				// var_dump($paper_id_result);
			}
			else
			{
				$paper_id_result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id' limit $page_start_index,$page_limit");
				// var_dump($page_start_index);
				// var_dump($paper_id_result);
			}

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
				echo "</table><br>";

			// Turn Page
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.<br>";
				// Turn to the First Page
				echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1#skip_here\">|<</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the Previous Page
				$prev=$page-1;
				if ($prev>=1)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$prev#skip_here\">PREV</a>";
						echo "&nbsp;&nbsp;";
				}
				// Show Page Numbers
				for($prev=$page-5; $prev < $page; $prev++)
				{ 
					if($prev<1)
						continue;
					echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$prev#skip_here\">$prev</a>";
					echo "&nbsp;&nbsp;";
				}
				echo "$page&nbsp;&nbsp;";
				for ($prev=$page+1; $prev <= $page+5; $prev++)
				{ 
					if(($prev-1)*$page_limit>=$num_max)
						continue;
					echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$prev#skip_here\">$prev</a>";
					echo "&nbsp;&nbsp;";
				}
				// Turn to the Next Page 
				$next=$page+1;
				if (($next-1)*$page_limit<$num_max)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$next#skip_here\">NEXT</a>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Last Page
				if($num_max%$page_limit==0)
					$next=$num_max/$page_limit;
				else
					$next=floor($num_max/$page_limit)+1;
				// var_dump($num_max);
				// var_dump($next);
				echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$next#skip_here\">>|</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/author.php#skip_here\">";
				echo "<input type=\"hidden\" name=\"author_id\" value=$author_id>";
				echo "Jump to: <input type=\"input\" name=\"page\" size=\"1\">&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_author);
			}
		}
		else
		{
			echo "Author not found!";
		}

	?>
</body>

</html>
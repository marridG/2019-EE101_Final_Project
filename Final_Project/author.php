<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<head>
	<title>Author</title>
</head>

<body>
	<img src="">
	<h1>Author Information</h1>

	<?php

	$Author_id = $_GET["author_id"];

// link to mysql to get the author's name and affiliation

		$link = mysqli_connect("127.0.0.1", "root", "", "lab01");
		mysqli_query($link, 'SET NAMES utf8');
		
	// return_to_homepage widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" width=\"30\"></a><br>";

	// search and print the AuthorName of the given AuthorID
		$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$Author_id'");
		// judge whether find the author
		if ($author_name_res = mysqli_fetch_array($result))
		{
			// var_dump($author_name_res);
			$author_name=$author_name_res['AuthorName'];
			echo "<a name=\"skip_here\"></a>";
			echo "Name: $author_name<br>";

		// search and print the most related AffiliationName to the given AuthorID
			$affi_id_name_result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$Author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");

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
		}


//link to solr to complete the chart


			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($Author_id);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Authors_ID:".$query."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			// echo "Name: ".$result['response']['docs'][0]['Authors_Name'][0];

				
			// print the result table
				
			
			if ($result['response']['docs'])
			{
				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";

				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";

					// print the Title
						echo "<td>";
						$title_new=$paper['Title'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_balnk\">$title_new</a>";
						echo ";";
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1\" target=\"_balnk\">$author</a>";
							echo "; ";
						}
						echo "</td>";

					// print ConferenceName
						echo "<td>";
						$conference_Name=$paper['ConferenceName'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_balnk\">$conference_Name</a>";
						echo ";";
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";
			}
			else
			{
				echo"<br></br>";
				echo "No record!";
			}
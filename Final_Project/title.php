<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<head>
	<title>Title</title>
</head>

<body>
	<img src="">
	<h1>PaperID Information</h1>

	<?php

	$title = $_GET["title"];
	$link = mysqli_connect("127.0.0.1", "root", "", "lab01");
		mysqli_query($link, 'SET NAMES utf8');

		echo "Paper Title: ".$title;

	$result=mysqli_fetch_array(mysqli_query($link, "SELECT PaperPublishYear from papers where Title='$title'"));
	echo "<br>";
	echo "</br>";

	echo "Paper publish year: ".$result['PaperPublishYear'];

	$result=mysqli_fetch_array(mysqli_query($link, "SELECT PaperID from papers where Title='$title'"));
	echo "<br></br>";
	echo "Paper ID: ".$result['PaperID'];
	echo "<br></br>";

	$result_PaperID=$result['PaperID'];;
	$author_name_result = mysqli_query($link, "SELECT B.AuthorName, B.AuthorID  from paper_author_affiliation A Inner Join authors B where A.PaperID='$result_PaperID' and A.AuthorID=B.AuthorID Order by A.AuthorSequence");


	echo "Authors: ";
	foreach ($author_name_result as $author)
		{
			$author_name=$author['AuthorName'];
			$author_id=$author['AuthorID'];
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_name</a>";
			echo ";";
		}

	echo "<br></br>";





	$result=mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceID from papers where Title='$title'"))['ConferenceID'];

	$conference_name_result = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$result'"));
	$tmp=$conference_name_result['ConferenceName'];
	 echo "Conference Name: ";
	echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$tmp&page=1\" target=\"_blank\">$tmp</a>";










// link to solr:

		// echo "<a name=\"skip_conference\"></a>";
		// echo "Paper Title: ".$title;


		// 	$ch = curl_init();
		// 	$timeout = 5;
		// 	$query = urlencode($title);
		// 	// $query = urlencode(str_replace(' ', '+', $author_name));
		// 	$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&wt=json";

		// 	curl_setopt ($ch, CURLOPT_URL, $url);
		// 	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// 	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		// 	$result = json_decode(curl_exec($ch), true);
		// 	curl_close($ch);


		// 		echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
		// 	// print the result table
		// 		foreach ($result['response']['docs'] as $paper)
		// 		{
		// 			// new line
		// 			echo "<tr>";

		// 			// print the Title
		// 				echo "<td>";
		// 				$title_new=$paper['Title'];
		// 				echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new</a>";
		// 				echo ";";
		// 				echo "</td>";

		// 			// print all the Authors_Name
		// 				echo "<td>";
		// 				foreach ($paper['Authors_Name'] as $idx => $author)
		// 				{
		// 					$author_id = $paper['Authors_ID'][$idx];
		// 					echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1\" target=\"_blank\">$author</a>";
		// 					echo "; ";
		// 				}
		// 				echo "</td>";

		// 			// print ConferenceName
		// 				echo "<td>";
		// 				$conference_Name=$paper['ConferenceName'];
		// 				echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
		// 				echo ";";
		// 				echo "</td>";
		// 			echo "</tr>";
		// 		}
		// 		echo "</table><br>";
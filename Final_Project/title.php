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
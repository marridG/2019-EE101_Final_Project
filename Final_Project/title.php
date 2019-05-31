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
	$this_paper_id=$result['PaperID'];
	echo "<br></br>";
	echo "Paper ID: ".$this_paper_id;
	echo "<br></br>";

	$result_PaperID=$result['PaperID'];;
	$author_name_result = mysqli_query($link, "SELECT B.AuthorName, B.AuthorID  from paper_author_affiliation A Inner Join authors B where A.PaperID='$result_PaperID' and A.AuthorID=B.AuthorID Order by A.AuthorSequence");


	echo "Authors: ";
	$paper_author_list=array();
	foreach ($author_name_result as $author)
		{
			$author_name=$author['AuthorName'];
			$author_id=$author['AuthorID'];
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_name</a>";
			echo ";";
			array_push($paper_author_list,$author["AuthorName"]);
		}
	echo "<br></br>";

	// $paper_author_list=array("deng cai","xiaofei he","jiawei han");


	$result=mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceID from papers where Title='$title'"))['ConferenceID'];

	$conference_name_result = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$result'"));
	$tmp=$conference_name_result['ConferenceName'];
	echo "Conference Name: ";
	echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$tmp&page=1\" target=\"_blank\">$tmp</a>";
	echo "<br><br>";

		// var_dump($paper_author_list);
		// echo "<br>";
		// echo "<br>";

	// Reference Papers
		echo $this_paper_id;
		$reference_paper_result = mysqli_query($link, "SELECT ReferenceID from paper_reference where PaperID='$this_paper_id' limit 0,10");
		var_dump($reference_paper_result);

	// Recommend Papers
		// Search
		$ch = curl_init();
		$timeout = 5;
		$query = urlencode(str_replace(' ', '+', $title));
		// Color Highlight #D9EE0A
		// $url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."^1+OR+Authors_Name:".$query."^0.7+OR+ConferenceName:".$query."^0.5&start=".($page_limit*($page-1))."&rows=".$page_limit."&wt=json&hl=on&hl.fl=Title,Authors_Name,ConferenceName&hl.simple.post=<%2Fb><%2Ffont>&hl.simple.pre=<font%20color%3D%23D9EE0A><b>";
		// No Color Highlight
		$url = "http://localhost:8983/solr/lab02/select?indent=on&start=0&rows=11&wt=json&q=Title:".$query."^1.5";
		foreach ($paper_author_list as $key => $author)
		{
			$query = urlencode(str_replace(' ', '+', $author));
			$weight=3-$key*0.5;
			if($weight<=0)
				break;
			$url=$url."+OR+Authors_Name:".$query."^".$weight."";
		}

		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);

		// var_dump($result);

		// Print
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/EE101-Final_Project/Final_Project/add-ons/05_test_show_hide.css\">";
		echo "<div id=\"box\">";
		echo "Related Papers:&nbsp;&nbsp;&nbsp;&nbsp;<button id=\"btn\">Show</button>";
    	echo "<div id=\"content\">";
		    echo "<div id=\"spread\">";
		    echo "<br>";
	            if($result && $result['response']['docs'])
				{
					foreach ($result['response']['docs'] as $idx => $info)
					{
						if(!$idx)
							continue;
						if($idx>=11)
							break;
						echo "<table id=\"table__recommend\"><tr>";
						echo "<td>[$idx]. </td><td>";
						foreach ($info["Authors_Name"] as $key => $value)
						{
							echo "$value";
							if($key!=count($info["Authors_Name"])-1)
								echo ",";
							else
								echo ".<br>";
						}
						$recommend_title=$info['Title'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$recommend_title\" target=\"_blank\">$recommend_title</a>.<br>";
						echo $info["ConferenceName"].",".$info["Year"];
						echo "</td></tr></table>";
						echo "<br>";
					}

				}
		    echo "</div>";
    	echo "</div>";
    	echo "<script src=\"/EE101-Final_Project/Final_Project/add-ons/05_test_show_hide.js\"></script>";
		echo "</div>";

	?>
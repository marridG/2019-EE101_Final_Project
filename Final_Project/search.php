<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<!--
Turn Page:
	http://www.php.cn/php-weizijiaocheng-401273.html
Form Value cannot contain spaces:
	https://blog.csdn.net/qq_35938548/article/details/77979900
Turn to the Original Location after Refreshing:
	https://www.jb51.net/article/99749.htm
Turn to an appointed location of a new page:
	https://zhidao.baidu.com/question/391858559861520045.html
-->

<head>
	<title>Search</title>
	<link rel ="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	<script src="/EE101-Final_Project/Final_Project/add-ons/01_Scroll_Page_to_Original.js"></script>
	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>
</head>

<body>
<div onscroll="SetH(this)">
	<h1>Search Result</h1>

	<?php
		// echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/EE101-Final_Project/Final_Project/table.css\"/>";
	// from index.php:
		// get paper_title, author_name, conference_name 
		$paper_title = $_GET["paper_title"];
		$author_name = $_GET["author_name"];
		$conference_name = $_GET["conference_name"];

	// Variables for Turning Pages
		$page_limit = 10;
		if(empty($_GET["page_title"])&&empty($_GET["page_author_name"])&&empty($_GET["page_conference"]))
		{
			session_start();
			$page_title = $_SESSION["page_title"];
			$page_author_name = $_SESSION["page_author_name"];
			$page_conference = $_SESSION["page_conference"];
		}
		else
		{
			$page_title = $_GET["page_title"];
			$page_author_name = $_GET["page_author_name"];
			$page_conference = $_GET["page_conference"];
		}
		// var_dump($page_title);
		// var_dump($page_author_name);
		// var_dump($page_conference);
		$paper_title_temp = urlencode($paper_title);
		$author_name_temp = urlencode($author_name);
		$conference_name_temp = urlencode($conference_name);

	// Search Widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" width=\"30\"></a>";
		// echo "<form class=\"search_return_to_homepage\"action='/EE101-Final_Project/Final_Project/index.php'><input type='submit' value='Return to Homepage'></form>";
		
		echo "<form id=\"search_form\" action=\"/EE101-Final_Project/Final_Project/search.php\">";
		echo "Paper Title: ";
		echo "<input type=\"text\" id=\"1_PT\" name=\"paper_title\" size=\"20%\" placeholder=\"Not Required\" value=\"$paper_title\">";
		echo "&nbsp;&nbsp;&nbsp;Author Name: ";
		echo "<input type=\"text\" id=\"2_AN\" name=\"author_name\" size=\"20%\" placeholder=\"Not Required\" value=\"$author_name\">";
		echo "&nbsp;&nbsp;&nbsp;Conference Name: ";
		echo "<input type=\"text\" id=\"3_CN\" name=\"conference_name\" size=\"10%\" placeholder=\"Not Required\" value=\"$conference_name\">";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"submit\" value=\"Search!\">";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"reset\" value=\"RECOVER\">";
		// echo "<input type=\"reset\" onclick=\"clear()\" value=\"CLEAR\">";
		echo "</form>";
		
		echo "<br>";

	// Search Title if given
		if ($paper_title)
		{
			echo "<a name=\"skip_title\"></a>";
			echo "Search for Title: ".$paper_title;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $paper_title));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&start=".$page_title."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if($result['response']['docs'])
			{
				echo "<table class=\"result_table\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
							echo $paper['Title'];
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\">$author</a>";
						echo "; ";
						}
					echo "</td>";

					// print the ConferenceName
						echo "<td>";
							echo $paper['ConferenceName'];
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Pages
				$num_max=$result["response"]["numFound"];
				// var_dump($num_max);
				echo "<table border=\"0\" align=center text-align=center><tr>";
				// Turn to the Previous Page
				$prev=$page_title-$page_limit;
				if ($prev>=0)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$prev&page_author_name=$page_author_name&page_conference=$page_conference#skip_title\">Previous Page</a>";
					echo "</td>";
				}
				echo "<td></td><td></td><td></td><td></td>";
					// Turn to the Next Page 
					$next=$page_title+$page_limit;
					if ($next<$num_max)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&
							author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$next&page_author_name=$page_author_name&page_conference=$page_conference#skip_title\">Next Page</a>";
					echo "</td>";
				}

				echo "</table><br><br><br>";
			}
			else
				echo "<br><br>No results!<br><br><br>";
		}

	// Search Authors_Name is given
		if ($author_name)
		{
			echo "<a name=\"skip_author_name\"></a>";
			echo "Search for Author's Name: ".$author_name;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($author_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Authors_Name:".$query."&start=".$page_author_name."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if ($result['response']['docs'])
			{
				echo "<a name=\"skip_author_name\"></a>";
				echo "<table class=\"result_table\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
							echo $paper['Title'];
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\">$author</a>";
							echo "; ";
						}
						echo "</td>";

					// print the ConferenceName
						echo "<td>";
							echo $paper['ConferenceName'];
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Page
				$num_max=$result["response"]["numFound"];
				// var_dump($num_max);
				echo "<table border=\"0\" align=center text-align=center><tr>";
				// Turn to the Previous Page
				$prev=$page_author_name-$page_limit;
				if ($prev>=0)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author_name=$prev&page_conference=$page_conference#skip_author_name\">Previous Page</a>";
					echo "</td>";
				}
				echo "<td></td><td></td><td></td><td></td>";
				// Turn to the Next Page 
				$next=$page_author_name+$page_limit;
				if ($next<$num_max)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author_name=$next&page_conference=$page_conference#skip_author_name\">Next Page</a>";
					echo "</td>";
				}

				echo "</table><br><br><br>";
			}
			else
				echo "<br><br>No results!<br><br><br>";
		}

	// Search ConferenceName if given
		if ($conference_name)
		{
			echo "<a name=\"skip_conferences_name\"></a>";
			echo "Search for Conference Name: ".$conference_name;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($conference_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=ConferenceName:".$query."&start=".$page_conference."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if($result['response']['docs'])
			{
				echo "<table class=\"result_table\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
							echo $paper['Title'];
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\">$author</a>";
							echo "; ";
						}
						echo "</td>";

					// print ConferenceName
						echo "<td>";
							echo $paper['ConferenceName'];
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Page
				$num_max=$result["response"]["numFound"];
				// var_dump($num_max);
				echo "<table border=\"0\" align=center text-align=center><tr>";
				// Turn to the Previous Page
				$prev=$page_conference-$page_limit;
				if ($prev>=0)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author_name=$page_author_name&page_conference=$prev#skip_conferences_name\">Previous Page</a>";
						echo "</td>";
				}
				echo "<td></td><td></td><td></td><td></td>";
					// Turn to the Next Page
				$next=$page_conference+$page_limit;
				if ($next<$num_max)
				{
					echo "<td>";
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author_name=$page_author_name&page_conference=$next#skip_conferences_name\">Next Page</a>";
						echo "</td>";
				}

				echo "</table><br><br><br>";
			}
			else
				echo "<br><br>No results!<br><br><br>";
		}

		// if nothing is given
		if (!$paper_title && !$author_name && !$conference_name)
		{
			echo "<br><br>ERROR:<br><br>Target not given!";
			echo "<br><br><br>";
		}
	
	?>
</div>
</body>

</html>
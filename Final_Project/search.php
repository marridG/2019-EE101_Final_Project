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
Hidden Form:
	https://blog.csdn.net/gavin_sw/article/details/1491298?utm_source=blogxgwz4
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
	// from index.php:
		// get paper_title, author_name, conference_name 
		$paper_title = $_GET["paper_title"];
		$author_name = $_GET["author_name"];
		$conference_name = $_GET["conference_name"];

	// Variables for Turning Pages
		$page_limit=10;
		$page_title = $_GET["page_title"];
		$page_author = $_GET["page_author"];
		$page_conference = $_GET["page_conference"];
		// }
		// var_dump($page_title);
		// var_dump($page_author);
		// var_dump($page_conference);
		$paper_title_temp = urlencode($paper_title);
		$author_name_temp = urlencode($author_name);
		$conference_name_temp = urlencode($conference_name);

	// Search Widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" width=\"30\"></a>";
		// echo "<form class=\"search_return_to_homepage\"action='/EE101-Final_Project/Final_Project/index.php'><input type='submit' value='Return to Homepage'></form>";
		
		echo "<form id=\"search_form\" action=\"/EE101-Final_Project/Final_Project/search.php\">";
		echo "<input type=\"hidden\" name=\"page_title\" value=\"1\"><input type=\"hidden\" name=\"page_author\" value=\"1\"><input type=\"hidden\" name=\"page_conference\" value=\"1\">";
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
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&start=".($page_limit*($page_title-1))."&wt=json";

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
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\" target=\"_balnk\">$author</a>";
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
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the First Page
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=1&page_author=$page_author&page_conference=$page_conference#skip_title\">|<</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the Previous Page
				$prev=$page_title-1;
				if ($prev>=1)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$prev&page_author=$page_author&page_conference=$page_conference#skip_title\">PREV</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Next Page 
				$next=$page_title+1;
				if (($next-1)*$page_limit<$num_max)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&
							author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$next&page_author=$page_author&page_conference=$page_conference#skip_title\">NEXT</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Last Page
				if($num_max%$page_limit==0)
					$next=$num_max/$page_limit;
				else
					$next=floor($num_max/$page_limit)+1;
				// var_dump($num_max);
				// var_dump($next);
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$next&page_author=$page_author&page_conference=$page_conference#skip_title\">>|</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Jump to Page
				echo "<form class=\"inline_form\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_title\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_author\" value=$page_author><input type=\"hidden\" name=\"page_conference\" value=$page_conference>";
				echo "Jump to: <input type=\"input\" name=\"page_title\" size=\"1\">&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_title);

				echo "<br><br><br>";
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
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Authors_Name:".$query."&start=".($page_limit*($page_author-1))."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if ($result['response']['docs'])
			{
				echo "<a name=\"skip_author_name\"></a>";
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
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\" target=\"_balnk\">$author</a>";
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
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the First Page
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=1&page_conference=$page_conference#skip_author_name\">|<</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the Previous Page
				$prev=$page_author-1;
				if ($prev>=1)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$prev&page_conference=$page_conference#skip_author_name\">PREV</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Next Page 
				$next=$page_author+1;
				if (($next-1)*$page_limit<$num_max)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$next&page_conference=$page_conference#skip_author_name\">NEXT</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Last Page
				if($num_max%$page_limit==0)
					$next=$num_max/$page_limit;
				else
					$next=floor($num_max/$page_limit)+1;
				// var_dump($num_max);
				// var_dump($next);
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$next&page_conference=$page_conference#skip_author_name\">>|</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Jump to Page
				echo "<form class=\"inline_form\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_author_name\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_title\" value=$page_title><input type=\"hidden\" name=\"page_conference\" value=$page_conference>";
				echo "Jump to: <input type=\"input\" name=\"page_author\" size=\"1\">&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_author);

				echo "<br><br><br>";
			}
			else
				echo "<br><br>No results!<br><br><br>";
		}

	// Search ConferenceName if given
		if ($conference_name)
		{
			echo "<a name=\"skip_conference_name\"></a>";
			echo "Search for Conference Name: ".$conference_name;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($conference_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=ConferenceName:".$query."&start=".($page_limit*($page_conference-1))."&wt=json";

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
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id\" target=\"_balnk\">$author</a>";
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
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the First Page
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=1#skip_conference_name\">|<</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				// Turn to the Previous Page
				$prev=$page_conference-1;
				if ($prev>=1)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$prev#skip_conference_name\">PREV</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Next Page
				$next=$page_conference+1;
				if (($next-1)*$page_limit<$num_max)
				{
					echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$next#skip_conference_name\">NEXT</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				// Turn to the Last Page
				if($num_max%$page_limit==0)
					$next=$num_max/$page_limit;
				else
					$next=floor($num_max/$page_limit)+1;
				// var_dump($num_max);
				// var_dump($next);
				echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$next#skip_conference_name\">>|</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				// Jump to Page
				echo "<form class=\"inline_form\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_conference_name\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_title\" value=$page_title><input type=\"hidden\" name=\"page_author\" value=$page_author>";
				echo "Jump to: <input type=\"input\" name=\"page_conference\" size=\"1\">&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_conference);

				echo "<br><br><br>";
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
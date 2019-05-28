<!DOCTYPE html> 
<html>
<meta charset="utf-8">

<head>
	<title>Search</title>
	<link rel ="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	<script src="/EE101-Final_Project/Final_Project/add-ons/01_Scroll_Page_to_Original.js"></script>
	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>
	<script src="/EE101-Final_Project/Final_Project/add-ons/03_Custom_Overflow_Extremum.js"></script>
</head>

<body>
<div onscroll="SetH(this)">
	<h1>Search Result</h1>

	<?php
	function Turn_Page_min_max_page($num_max,$page_limit,&$min_page,&$max_page,$page)
	{
		if($num_max<=90)
		{
			$min_page=1;
			if($num_max%$page_limit==0)
				$max_page=$num_max/$page_limit;
			else
				$max_page=floor($num_max/$page_limit)+1;
		}
		else
		{
			$min_page=$page-5;
			while($min_page<1)
				$min_page++;
			$max_page=$min_page+9;
			while(($max_page-1)*$page_limit>=$num_max)
				$max_page--;
			if($max_page-$min_page+1<10)
				$min_page=$max_page-9;
		}
		// var_dump($min_page);
		// var_dump($max_page);
	}

	// from index.php:
		// get paper_title, author_name, conference_name 
		$paper_title = $_GET["paper_title"];
		$author_name = $_GET["author_name"];
		$conference_name = $_GET["conference_name"];

	// Variables for Turning Pages
		$page_limit=10;
		$page_title = floor($_GET["page_title"]);
		$page_author = floor($_GET["page_author"]);
		$page_conference = floor($_GET["page_conference"]);
		// }
		// var_dump($page_title);
		// var_dump($page_author);
		// var_dump($page_conference);
		$paper_title_temp = urlencode($paper_title);
		$author_name_temp = urlencode($author_name);
		$conference_name_temp = urlencode($conference_name);

	// Search Widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" id=\"all__return_to_homepage_image\"></a>";
		
		echo "<form id=\"search_form\" action=\"/EE101-Final_Project/Final_Project/search.php\">";
		echo "<input type=\"hidden\" name=\"page_title\" value=\"1\"><input type=\"hidden\" name=\"page_author\" value=\"1\"><input type=\"hidden\" name=\"page_conference\" value=\"1\">";
		echo "Paper Title: ";
		echo "<input type=\"text\" id=\"1_PT\" name=\"paper_title\" class=\"search__Widget_title\" placeholder=\"Not Required\" value=\"$paper_title\">";
		echo "&nbsp;&nbsp;&nbsp;Author Name: ";
		echo "<input type=\"text\" id=\"2_AN\" name=\"author_name\" class=\"search__Widget_author_name\"  placeholder=\"Not Required\" value=\"$author_name\">";
		echo "&nbsp;&nbsp;&nbsp;Conference Name: ";
		echo "<input type=\"text\" id=\"3_CN\" name=\"conference_name\" class=\"search__Widget_conference_name\" placeholder=\"Not Required\" value=\"$conference_name\">";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"submit\" value=\"Search!\">";
		// echo "&nbsp;&nbsp;&nbsp;";
		// echo "<input type=\"reset\" value=\"RECOVER\">";
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
			// Color Highlight #D9EE0A
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&start=".($page_limit*($page_title-1))."&wt=json&hl=on&hl.fl=Title&hl.simple.post=<%2Fb><%2Ffont>&hl.simple.pre=<font%20color%3D%23D9EE0A><b>";
			// No Color Highlight
			// $url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&start=".($page_limit*($page_title-1))."&wt=json&hl=on&hl.fl=Title&hl.simple.post=<%2Fb>&hl.simple.pre=<b>";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if($result['response']['docs'])
			{
				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
						$title_new=$paper['Title'];
						$title_new_hl=$result['highlighting'][$paper['id']]['Title'][0];
						echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new_hl</a>";
						echo ";";
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author</a>";
						echo "; ";
						}
						echo "</td>";

					// print the ConferenceName
						echo "<td>";
						$conference_Name=$paper['ConferenceName'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
						echo ";";
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";
	
			// Turn Page
				$num_max=$result["response"]["numFound"];
				Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page_title);
				// Calculate the maximum of pages
				if($num_max%$page_limit==0)
					$page_MAX=$num_max/$page_limit;
				else
					$page_MAX=floor($num_max/$page_limit)+1;
				// print information
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br>";
				echo "<table class=\"table__Turn_Page\">";
				echo "<tr>";
				// Row One
					// Previous Page
					echo "<td>";
					$i=$page_title-1;
					if($i>=1)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\">";
					}
					echo "</td>";
					// Pages in the middle
					for($i=$min_page;$i<=$max_page;$i++)
					{
						if($i==$page_title)
							echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.jpg\" id=\"search__Turn_Page_selected\"></a></td>";
						else
							echo "<td><a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
					}
					// Next Page
					echo "<td>";
					$i=$page_title+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
					}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
				// Row Two
					// Turn to the Previous Page
					$i=$page_title-1;
					echo "<td>";
					if ($i>=1)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><<</a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
					// Show Page Numbers
					for($i=$min_page; $i <= $max_page; $i++)
					{ 
						echo "<td>";
						if($i==$page_title)
							echo "$page_title";
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\">$i</a>";
						echo "</td>";
					}
					// Turn to the Next Page
					echo "<td>";
					$i=$page_title+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$i&page_author=$page_author&page_conference=$page_conference#skip_title\">>></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
				
				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_title\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_author\" value=$page_author><input type=\"hidden\" name=\"page_conference\" value=$page_conference>";
				echo "Jump to: <input type=\"number\" name=\"page_title\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
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
			echo "<a name=\"skip_author\"></a>";
			echo "Search for Author's Name: ".$author_name;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($author_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Authors_Name:".$query."&start=".($page_limit*($page_author-1))."&wt=json&hl=on&hl.fl=Authors_Name&hl.simple.post=<%2Fb>&hl.simple.pre=<b>";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if ($result['response']['docs'])
			{
				echo "<a name=\"skip_author\"></a>";
				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
						$title_new=$paper['Title'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new</a>";
						echo ";";
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
							$author_hl=$result['highlighting'][$paper['id']]['Authors_Name'][0];
							if($author!=$author_name)
								echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author</a>";
							else
								echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_hl</a>";
							echo "; ";
						}
						echo "</td>";

						// echo "<td>";
						// echo $paper['ConferenceName'];
						// echo "</td>";

						echo "<td>";
						$conference_Name=$paper['ConferenceName'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
						echo ";";
						echo "</td>";


					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Page
				$num_max=$result["response"]["numFound"];
				Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page_author);
				// Calculate the maximum of pages
				if($num_max%$page_limit==0)
					$page_MAX=$num_max/$page_limit;
				else
					$page_MAX=floor($num_max/$page_limit)+1;
				// print information
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br>";
				echo "<table class=\"table__Turn_Page\">";
				echo "<tr>";
				// Row One
					// Previous Page
					echo "<td>";
					$i=$page_author-1;
					if($i>=1)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\">";
					}
					echo "</td>";
					// Pages in the middle
					for($i=$min_page;$i<=$max_page;$i++)
					{
						if($i==$page_title)
							echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.jpg\" id=\"search__Turn_Page_selected\"></a></td>";
						else
							echo "<td><a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
					}
					// Next Page
					echo "<td>";
					$i=$page_author+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
					}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
				// Row Two
					// Turn to the Previous Page
					$i=$page_author-1;
					echo "<td>";
					if ($i>=1)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><<</a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
					// Show Page Numbers
					for($i=$min_page; $i <= $max_page; $i++)
					{ 
						echo "<td>";
						if($i==$page_author)
							echo "$page_author";
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\">$i</a>";
						echo "</td>";
					}
					// Turn to the Next Page
					echo "<td>";
					$i=$page_author+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$i&page_conference=$page_conference#skip_author\">>></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
				
				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_author\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_title\" value=$page_title><input type=\"hidden\" name=\"page_conference\" value=$page_conference>";
				echo "Jump to: <input type=\"number\" name=\"page_author\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
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
			echo "<a name=\"skip_conference\"></a>";
			echo "Search for Conference Name: ".$conference_name;

			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($conference_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=ConferenceName:".$query."&start=".($page_limit*($page_conference-1))."&wt=json&hl=on&hl.fl=ConferenceName&hl.simple.post=<%2Fb>&hl.simple.pre=<b>";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if($result['response']['docs'])
			{
				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
						$title_new=$paper['Title'];
						echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new</a>";
						echo ";";
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author</a>";
							echo "; ";
						}
						echo "</td>";

					// print ConferenceName
						echo "<td>";
						$conference_Name=$paper['ConferenceName'];
						$conference_Name_hl=$result['highlighting'][$paper['id']]['ConferenceName'][0];
						echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name&page=1\" target=\"_blank\">$conference_Name_hl</a>";
						echo ";";
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Page
				$num_max=$result["response"]["numFound"];
				Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page_conference);
				// Calculate the maximum of pages
				if($num_max%$page_limit==0)
					$page_MAX=$num_max/$page_limit;
				else
					$page_MAX=floor($num_max/$page_limit)+1;
				// print information
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br>";
				echo "<table class=\"table__Turn_Page\">";
				echo "<tr>";
				// Row One
					// Previous Page
					echo "<td>";
					$i=$page_conference-1;
					if($i>=1)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\">";
					}
					echo "</td>";
					// Pages in the middle
					for($i=$min_page;$i<=$max_page;$i++)
					{
						if($i==$page_conference)
							echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.jpg\" id=\"search__Turn_Page_selected\"></a></td>";
						else
							echo "<td><a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
					}
					// Next Page
					echo "<td>";
					$i=$page_conference+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
						echo "</td><td>";
						echo "<a href=\"search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
					{
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\">";
						echo "</td><td>";
						echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
					}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
				// Row Two
					// Turn to the Previous Page
					$i=$page_conference-1;
					echo "<td>";
					if ($i>=1)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><<</a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
					// Show Page Numbers
					for($i=$min_page; $i <= $max_page; $i++)
					{ 
						echo "<td>";
						if($i==$page_conference)
							echo "$page_conference";
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\">$i</a>";
						echo "</td>";
					}
					// Turn to the Next Page
					echo "<td>";
					$i=$page_conference+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?paper_title=$paper_title_temp&author_name=$author_name_temp&conference_name=$conference_name_temp&page_title=$page_title&page_author=$page_author&page_conference=$i#skip_conference\">>></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";

				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" name=\"jump_to\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_conference\">";
				echo "<input type=\"hidden\" name=\"paper_title\" value=\"$paper_title\"><input type=\"hidden\" name=\"author_name\" value=\"$author_name\"><input type=\"hidden\" name=\"conference_name\" value=$conference_name><input type=\"hidden\" name=\"page_title\" value=$page_title><input type=\"hidden\" name=\"page_author\" value=$page_author>";
				echo "Jump to: <input type=\"number\" id=\"jump_to\" name=\"page_conference\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
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
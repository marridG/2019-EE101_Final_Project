<!DOCTYPE html> 
<html>
<meta charset="utf-8">

<head>
	<title>Search</title>
	<!-- Dependent Packages -->
	<script src="/EE101-Final_Project/Final_Project/add-ons/jquery/jquery-3.4.0.min.js"></script>

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
		$key_word = $_GET["key_word"];
		// $show_hide=$_GET["show_hide"];

	// Variables for Turning Pages
		// $page_limit=10;
		$page_limit=25;
		$page = floor($_GET["page"]);
		$key_word_temp = urlencode($key_word);

	// Search Widget
		echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" id=\"all__return_to_homepage_image\"></a>";
		
		echo "<form id=\"search_form\" action=\"/EE101-Final_Project/Final_Project/search.php\">";
		echo "<input type=\"hidden\" name=\"page\" value=\"1\">";
		echo "<input type=\"text\" id=\"key_word\" name=\"key_word\" class=\"search__Widget_title\" placeholder=\"Not Required\" value=\"$key_word\">";
		echo "<input type=\"submit\" value=\"Search!\">";
		// echo "&nbsp;&nbsp;&nbsp;";
		// echo "<input type=\"reset\" value=\"RECOVER\">";
		// echo "<input type=\"reset\" onclick=\"clear()\" value=\"CLEAR\">";
		echo "</form>";
		
		echo "<br>";

	// Test Multi-field Search
		if ($key_word)
		{
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $key_word));
			// Color Highlight #D9EE0A
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."^1+OR+Authors_Name:".$query."^0.7+OR+ConferenceName:".$query."^0.5&start=".($page_limit*($page-1))."&rows=".$page_limit."&wt=json&hl=on&hl.fl=Title,Authors_Name,ConferenceName&hl.simple.post=<%2Fb><%2Ffont>&hl.simple.pre=<font%20color%3D%23D9EE0A><b>";
			
			// No Color Highlight
			// $url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."&start=".($page_limit*($page-1))."&wt=json&hl=on&hl.fl=Title&hl.simple.post=<%2Fb>&hl.simple.pre=<b>";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			if($result['response']['docs'])
			{
				echo "<a name=\"skip_multi\"></a>";
				echo "Multi Field Search: ".$key_word;

				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
						echo "<td>";
						$title_new=$paper['Title'];
						if(array_key_exists("Title", $result['highlighting'][$paper['id']]))
						{
							$title_new_hl=$result['highlighting'][$paper['id']]['Title'][0];
							echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new_hl</a>";
						}
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_new&page=1\" target=\"_blank\">$title_new</a>";
						echo ";";
						echo "</td>";

					// print all the Authors_Name
						echo "<td>";
						foreach ($paper['Authors_Name'] as $idx => $author)
						{
							$author_id = $paper['Authors_ID'][$idx];
						if($author==$key_word && array_key_exists("Authors_Name", $result['highlighting'][$paper['id']]))
						{
							$author_hl=$result['highlighting'][$paper['id']]['Authors_Name'][0];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_hl</a>";
						}
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author</a>";
						echo "; ";
						}
						echo "</td>";

					// print the ConferenceName
						echo "<td>";
						$conference_Name=$paper['ConferenceName'];
						if(array_key_exists("ConferenceName", $result['highlighting'][$paper['id']]))
						{
							$conference_Name_hl=$result['highlighting'][$paper['id']]['ConferenceName'][0];
							echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name_hl</a>";
						}
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
						echo ";";
						echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";
	
			// Turn Page
				$num_max=$result["response"]["numFound"];
				Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page);
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
					$i=$page-1;
					if($i>=1)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

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
						if($i==$page)
							echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.jpg\" id=\"search__Turn_Page_selected\"></a></td>";
						else
							echo "<td><a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
					}
					// Next Page
					echo "<td>";
					$i=$page+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
					$i=$page-1;
					echo "<td>";
					if ($i>=1)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><<</a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
					// Show Page Numbers
					for($i=$min_page; $i <= $max_page; $i++)
					{ 
						echo "<td>";
						if($i==$page)
							echo "$page";
						else
							echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\">$i</a>";
						echo "</td>";
					}
					// Turn to the Next Page
					echo "<td>";
					$i=$page+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/search.php?key_word=$key_word_temp&page=$i#skip_multi\">>></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
				
				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/search.php#skip_multi\">";
				echo "<input type=\"hidden\" name=\"key_word\" value=\"$key_word\">";
				echo "Jump to: <input type=\"number\" name=\"page\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page);

				echo "<br><br><br>";
			}
		}

	// if nothing is given
		if (!$key_word)
		{
			echo "<br><br>ERROR:<br><br>Target not given!";
			echo "<br><br><br>";
		}
	?>
</div>
</body>

</html>
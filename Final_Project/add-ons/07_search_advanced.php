<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<head></head>
<body>

<?php
	// get from request: count
		$count = $_GET["count"];
		// var_dump($count);

	// Variables for Turning Pages
		$page_limit=10;
		// $page_limit=25;
		$page = floor($_GET["page"]);

		if ($count!='0')
		{
			$ch = curl_init();
			$timeout = 5;

			// Color Highlight #FF0000
			// $url = "http://localhost:8983/solr/lab02/select?indent=on&start=".($page_limit*($page-1))."&rows=".$page_limit."&wt=json&hl=on&hl.fl=Title,Authors_Name,ConferenceName&hl.simple.post=<%2Fb><%2Ffont>&hl.simple.pre=<font%20color%3D%23FF0000><b>";
			// No Color Highlight
			$url = "http://localhost:8983/solr/lab02/select?indent=on&start=".($page_limit*($page-1))."&rows=".$page_limit."&wt=json";
			// Search target url formation
				$url_q="&q=";
				$target=$_GET["target1"];
				$word=$_GET["word1"];
				if(!$word || $word=="undefined")
					$url_q=$url_q.$target.":*";
				else
					$url_q=$url_q.$target.":".urlencode(str_replace(' ', '+', $word));
				for ($i=2; $i <= $count; $i++)
				{ 
					$bool=$_GET[("bool".$i)];
					$target=$_GET[("target".$i)];
					$word=$_GET[("word".$i)];
					$url_q=$url_q."+".$bool."+";
					if(!$word || $word=="undefined")
						$url_q=$url_q.$target.":*";
					else
						$url_q=$url_q.$target.":".urlencode(str_replace(' ', '+', $word));
				}
				// echo "<br>$url_q";
			$url=$url.$url_q;
			echo "<br>";
			var_dump($url);

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);

			// var_dump($result);
	

			if($result['response']['docs'])
			{
				echo "Search Results";

				echo "<table class=\"table__result\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
				foreach ($result['response']['docs'] as $paper)
				{
					// new line
					echo "<tr>";
					// print the Title
					echo "<td>";
					$title_new=$paper['Title'];
					$title_for_show=urlencode(str_replace('', '', $title_new));
					echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show\" target=\"_blank\">$title_new</a>";
					echo "</td>";

					// print all the Authors_Name
					echo "<td>";
					foreach ($paper['Authors_Name'] as $idx => $author)
					{
						$author_id = $paper['Authors_ID'][$idx];
						echo "<a class=\"output_href\" id=\"author_name\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author</a>";
						echo "; ";
					}
					echo "</td>";

					// print the ConferenceName
					echo "<td>";
					$conference_Name=$paper['ConferenceName'];
					echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
					echo "</td>";
					echo "</tr>";
				}
				echo "</table><br>";

			// Turn Page
				$num_max=$result["response"]["numFound"];
				// Calculate the maximum of pages
				if($num_max%$page_limit==0)
					$page_MAX=$num_max/$page_limit;
				else
					$page_MAX=floor($num_max/$page_limit)+1;
				// echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br>";
				
				echo "<input type=\"hidden\" id=\"advanced_search_result_num_max\" value=$num_max>";
				echo "<input type=\"hidden\" id=\"advanced_search_result_page_limit\" value=$page_limit>";
				echo "<input type=\"hidden\" id=\"advanced_search_result_page_MAX\" value=$page_MAX>";
				// echo "<input type=\"hidden\" id=\"advanced_search_result_min_page\" value=$min_page>";
				// echo "<input type=\"hidden\" id=\"advanced_search_result_max_page\" value=$max_page>";
			}

			else
			{
				echo "<br><br>No Results!<br><br>";
				echo "<input type=\"hidden\" id=\"advanced_search_result_num_max\" value=0>";
			}
		}

	// if nothing is given
		else
		{
			echo "<br><br>ERROR:<br><br>Target not given!";
			echo "<br><br><br>";
		}
?>

</body>
</html>
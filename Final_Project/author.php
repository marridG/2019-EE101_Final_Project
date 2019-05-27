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

	$author_id = $_GET["author_id"];

	// Variables for Turning Pages
		$page_limit=10;
		$page = $_GET["page"];
		$author_id_temp = urlencode($author_id);

// link to mysql to get the author's name and affiliation

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
		}


//link to solr to complete the chart


			$ch = curl_init();
			$timeout = 5;
			$query = urlencode($author_id);
			// $query = urlencode(str_replace(' ', '+', $author_name));
			$url = "http://localhost:8983/solr/lab02/select?indent=on&q=Authors_ID:".$query."&start=".($page_limit*($page-1))."&wt=json";

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
							$author_id_result = $paper['Authors_ID'][$idx];
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_result&page=1\" target=\"_balnk\">$author</a>";
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

			// Turn Page
				$num_max=$result["response"]["numFound"];
				Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page);
				echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.<br>";
				echo "<table class=\"table__Turn_Page\">";
				echo "<tr>";
				// Row One
					// Previous Page
					echo "<td>";
					$i=$page-1;
					if($i>=1)
					{
						echo "<a href=\"author.php?author_id=$author_id_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"author.php?author_id=$author_id_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

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
							echo "<td><a href=\"author.php?author_id=$author_id_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
					}
					// Next Page
					echo "<td>";
					$i=$page+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"author.php?author_id=$author_id_temp&page=$i\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
						echo "</td><td>";
						echo "<a href=\"author.php?author_id=$author_id_temp&page=$i\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_temp&page=$i\"><<</a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
							echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_temp&page=$i\">$i</a>";
						echo "</td>";
					}
					// Turn to the Next Page
					echo "<td>";
					$i=$page+1;
					if (($i-1)*$page_limit<$num_max)
					{
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
						echo "</td><td>";
						echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_temp&page=$i\">>></a>";
					}
					else
						echo "<td></td>";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
				
				// echo "$author_id";
				// Jump to Page
				echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/author.php\">";
				echo "<input type=\"hidden\" name=\"author_id\" value=\"$author_id\">";
				echo "Jump to: <input type=\"input\" name=\"page\" size=\"1\">&nbsp;&nbsp;";
				echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_title);

				echo "<br><br><br>";
			}
			else
			{
				echo"<br></br>";
				echo "No record!";
			}
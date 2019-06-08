<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head></head>
<body>
	
<?php
	$num_max=(int)$_GET["num_max"];
	$page_limit=(int)$_GET["page_limit"];
	$page_MAX=(int)$_GET["page_MAX"];
	$min_page=(int)$_GET["min_page"];
	$max_page=(int)$_GET["max_page"];
	$page=(int)$_GET["page"];
	
	echo "Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br>";
	
	echo "<table class=\"table__Turn_Page\">";
	echo "<tr>";
	// Row One
		// Previous Page
		echo "<td>";
		$i=$page-1;
		if($i>=1)
		{
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";
			echo "</td><td>";
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.png\" id=\"search__Turn_Page_prev_page\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";

		}
		else
		{
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\">";
			echo "</td><td>";
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.png\" id=\"search__Turn_Page_prev_page\">";
		}
		echo "</td>";
		// Pages in the middle
		for($i=$min_page;$i<=$max_page;$i++)
		{
			if($i==$page)
				echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.png\" id=\"search__Turn_Page_selected\"></td>";
			else
				echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.png\" style=\"cursor:pointer;\" id=\"search__Turn_Page_not_selected\" onclick=\"submit_search($i,1)\"></td>";
		}
		// Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.png\" id=\"search__Turn_Page_next_page\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";
			echo "</td><td>";
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";
		}
		else
		{
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.png\" id=\"search__Turn_Page_next_page\">";
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
			echo "<a class=\"output_href\" href=\"#\" onclick=\"submit_search($i,1); return false;\">Prev</a>";
			echo "</td><td>";
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";
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
				echo "<a class=\"output_href\" href=\"#\" onclick=\"submit_search($i,1); return false;\">$i</a>";
			echo "</td>";
		}
		// Turn to the Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\" style=\"cursor:pointer;\" onclick=\"submit_search($i,1)\">";
			echo "</td><td>";
			echo "<a class=\"output_href\" href=\"#\" onclick=\"submit_search($i,1); return false;\">Next</a>";
		}
		else
			echo "<td></td>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	// Jump to Page;
		echo "<div id=\"advanced_search__jump_to__right_hand\">";
		echo "Jump to: <input type=\"number\" name=\"advanced_search_page\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
		echo "<button id=\"advanced_search__jump_to__submit\" onclick=\"jump_to_submit()\">Go!</button>";
		echo "</div>";	
	// // var_dump($page);

?>
</body>
</html>

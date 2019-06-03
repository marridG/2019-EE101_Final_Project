<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/Turn_page.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/conference.css">
<!-- font-family:'NewsGothicBT-Roman'的link -->
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/38414/5cf3e354f629d80aac8eb651.css' rel='stylesheet' type='text/css' />



<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/44802/5cf3c807f629d80aac8eb641.css' rel='stylesheet' type='text/css' />


<script type="text/javascript" src='echarts.js'></script>

<head>
	<title>Conference</title>
</head>

<body>
	<div class="heading">
	<a href="/EE101-Final_Project/Final_Project/index.php"> <img src="/EE101-Final_Project/Final_Project/pics/Acemap1.png" id="acemap"></a>	
	<h1 id="test">Your Best Academia Database!</h1>
	</div>
	<div id="all_charts">
	<div id="chart1" style="width: 400px; height:400px;position: absolute; left:80px;top: 350px;"></div>
	</div>
	<script type="text/javascript">
		var chart1 = echarts.init(document.getElementById('chart1'));
		var xAxisData = [];
var data1 = [];
var data2 = [];
for (var i = 0; i < 48; i++) {
    xAxisData.push(1970 + i);
    data1.push((Math.sin(i / 5) * (i / 50 -10) + i / 6) * 5+50);
}

option1 = {
    title: {
        text: 'Publish of Year',
    },
    legend: {
        data: ['publishNumber'],
        align: 'left'
    },
    toolbox: {
         y: 'bottom',
        feature: {
            magicType: {
                type: ['stack', 'tiled']
            },
            dataView: {},
            saveAsImage: {
                pixelRatio: 2
            }
        }
    },
    tooltip: {},
    xAxis: {
        data: xAxisData,
        silent: false,
        splitLine: {
            show: false
        }
    },
    yAxis: {
    },
    series: [{
        name: 'publishNumber',
        type: 'bar',
        data: data1,
        animationDelay: function (idx) {
            return idx * 10;
        }
    }
    ],
    animationEasing: 'elasticOut',
    animationDelayUpdate: function (idx) {
        return idx * 5;
    }
};
	chart1.setOption(option1);
	</script>
	<?php
	// from search.php: get conference_name

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

	$conference_name = $_GET["conference_name"];

		// Variables for Turing Pages
	$page_limit=10;
	$page=floor($_GET["page"]);
	$conference_name_temp = urlencode($conference_name);

		// echo "<a name=\"skip_conference\"></a>";
	echo "<h1 id=\"title\"> SEARCH RESULT: <br> &nbsp &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Conference Name: $conference_name </h1>";

	$ch = curl_init();
	$timeout = 5;
	$query = urlencode($conference_name);
			// $query = urlencode(str_replace(' ', '+', $author_name));
	$url = "http://localhost:8983/solr/lab02/select?indent=on&q=ConferenceName:".$query."&start=".($page_limit*($page-1))."&wt=json";

	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = json_decode(curl_exec($ch), true);
	curl_close($ch);


	if($result['response']['docs'])
	{

		echo "<table class=\"table__result\" id=\"conference_table\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			// print the result table
		foreach ($result['response']['docs'] as $paper)
		{
					// new line
			echo "<tr>";
					// print the Title
			echo "<td>";
			$title_new=$paper['Title'];
			$title_for_show=urlencode(str_replace('', '', $title_new));

			echo "<a class=\"output_href\" id=\"paper_title\" href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show&page=1\" target=\"_blank\">$title_new</a>";
			echo ";";
			echo "</td>";

					// print all the Authors_Name
			echo "<td>";
			foreach ($paper['Authors_Name'] as $idx => $author)
			{
				$author_id = $paper['Authors_ID'][$idx];
				echo "<a class=\"output_href\" id=\"author_name\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1\" target=\"_blank\">$author</a>";
				echo "; ";
			}
			echo "</td>";

					// print ConferenceName
			echo "<td>";
			$conference_name=$paper['ConferenceName'];
			echo "<a class=\"output_href\" id=\"conference_name\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name&page=1\" target=\"_blank\">$conference_name</a>";
			echo ";";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table><br>";



		// $paper_title = $paper['Title'];
		// $author_name = $paper['Authors_Name'];
		// $conference_name = $paper["ConferenceName"];


			// Turn Page
		$num_max=$result["response"]["numFound"];
		Turn_Page_min_max_page($num_max,$page_limit,$min_page,$max_page,$page);
				// Calculate the maximum of pages
		if($num_max%$page_limit==0)
			$page_MAX=$num_max/$page_limit;
		else
			$page_MAX=floor($num_max/$page_limit)+1;
				// print information
		echo "<p id=\"p1\">Found $num_max results.&nbsp;&nbsp;&nbsp;&nbsp;Each page: $page_limit items.&nbsp;&nbsp;&nbsp;&nbsp;Altogether: $page_MAX pages.<br></p>";
		echo "<table class=\"table__Turn_Page\">";
		echo "<tr>";
				// Row One
					// Previous Page
		echo "<td>";
		$i=$page-1;
		if($i>=1)
		{
			echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
			echo "</td><td>";
			echo "<a  href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/A.png\" id=\"search__Turn_Page_prev_page\"></a>";

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
				echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/C.png\" id=\"search__Turn_Page_selected\"></a></td>";
			else
				echo "<td><a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/C2.png\"  id=\"search__Turn_Page_not_selected\"></a></td>";
		}
					// Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/E1.png\" id=\"search__Turn_Page_next_page\"></a>";
			echo "</td><td>";
			echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
		/**/
		$i=$page-1;
		echo "<td>";
		if ($i>=1)
		{
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><<</a>";
			echo "</td><td>";
			echo "<a  href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
				echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\">$i</a>";
			echo "</td>";
		}
					// Turn to the Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
			echo "</td><td>";
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\">>></a>";
		}
		else
			echo "<td></td>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

				// Jump to Page
		echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/conference.php\">";
		echo "<input  type=\"hidden\" name=\"conference_name\" value=$conference_name>";
		echo "Jump to: <input class=\"junp_to\" type=\"number\" name=\"page\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\"  required>&nbsp;&nbsp;";
		echo "<input class=\"go\" type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page);

	}
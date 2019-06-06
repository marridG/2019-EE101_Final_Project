<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/Turn_page.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/conference.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- font-family:'NewsGothicBT-Roman'的link -->
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/38414/5cf3e354f629d80aac8eb651.css' rel='stylesheet' type='text/css' />

<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/28595/5cf4eaa7f629d80aac8eb66b.css' rel='stylesheet' type='text/css' />
<!-- font-family:'ActionJackson';的link
-->


<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/44802/5cf3c807f629d80aac8eb641.css' rel='stylesheet' type='text/css' />


<script type="text/javascript" src='\EE101-Final_Project\Final_Project\add-ons\echart\echarts3.js'></script>

<head>
	<title>Conference</title>
</head>

<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
    <a href="/EE101-Final_Project/Final_Project/index.php" class="navbar-brand">
            <img src="/EE101-Final_Project/Final_Project/pics/phantom_reverse.png" s alt="logo" style="width:70px;height:30px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsible">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsible">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a href="#" class="nav-link">link1</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">link1</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">link1</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">link1</a>
        </li>    
    </ul>
    
</nav>
	<div class="heading">	
		<h1 id="test">Your Best Academia Database!</h1>
	</div>
	<div id="all_charts">
		<div id="chart1" style="width: 400px; height:400px;position: absolute; left:80px;top: 350px;"></div>
	</div>
	<?php
	$ch = curl_init();
	$timeout = 5;
	$conference_name = $_GET["conference_name"];
//Search for specified year's paper number in a conference.
	echo "<script> var datas=new Array() ; </script> ";
	for ($year=1950; $year<2016 ; $year++) { 
		$keyword = $year;
		$query1 = urlencode(str_replace(' ', '+', $keyword));
		$query2 = urlencode(str_replace(' ', '+', $conference_name));
		$url = "http://localhost:8983/solr/lab02/select?q=Year%3A%20$query1%20%26%26%20ConferenceName%20%3A%20$query2&rows=98215";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		$data = json_decode(curl_exec($ch), true);	
		$value = $data['response']['numFound'];
		echo "<script> datas[$year-1950] = \"$value \" ; </script> ";
	}
	?>
	<script type="text/javascript">
		var chart1 = echarts.init(document.getElementById('chart1'));
		var xData = function() {
    	var data = [];
    	for (var i =1950; i <= 2016; i++) {
    		data.push(i + "");
    	}
    	return data;
    }();
		option1 = {
			backgroundColor: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
				offset: 0,
				color: '#c86589'
			},
			{
				offset: 1,
				color: '#06a7ff'
			}
			], false),
			title: {
				text: "Publish of Year",

				left: "center",
				bottom: "83%",
				textStyle: {
					color: "#fff",
					fontSize:16,
					fontFamily : 'Times New Roman',
				}
			},
			"tooltip": {
    		"trigger": "axis",
    		"axisPointer": {
    			"type": "shadow",
    			textStyle: {
    				color: "#fff"
    			}

    		},
    	},
    	"calculable": true,
			grid: {
				top: '20%',
				left: '10%',
				right: '10%',
				bottom: '15%',
				containLabel: true,
			},
			xAxis: [{
				type: 'category',
				boundaryGap: false,
				data: xData,
				axisLabel: {
					margin: 30,
					color: '#ffffff63'
				},
				axisLine: {
					show: false
				},
				axisTick: {
					show: true,
					length: 25,
					lineStyle: {
						color: "#ffffff1f"
					}
				},
				splitLine: {
					show: true,
					lineStyle: {
						color: '#ffffff1f'
					}
				},
    		"data": xData,
			}],
			yAxis: [{
				type: 'value',
				position: 'right',
				axisLabel: {
					margin: 20,
					color: '#ffffff63'
				},

				axisTick: {
					show: true,
					length: 15,
					lineStyle: {
						color: "#ffffff1f",
					}
				},
				splitLine: {
					show: true,
					lineStyle: {
						color: '#ffffff1f'
					}
				},
				axisLine: {
					lineStyle: {
						color: '#fff',
						width: 2
					}
				}
			}],
			"dataZoom": [{
    		"show": true,
    		"height": 30,
    		"xAxisIndex": [
    		0
    		],
    		bottom: 30,
    		"start": 50,
    		"end": 100,
    		handleIcon: 'path://M306.1,413c0,2.2-1.8,4-4,4h-59.8c-2.2,0-4-1.8-4-4V200.8c0-2.2,1.8-4,4-4h59.8c2.2,0,4,1.8,4,4V413z',
    		handleSize: '110%',
    		handleStyle:{
    			color:"#d3dee5",

    		},
    		textStyle:{
    			color:"#fff"},
    			borderColor:"#90979c"


    		}, {
    			"type": "inside",
    			"show": true,
    			"height": 15,
    			"start": 1,
    			"end": 35
    		}],
			series: [{
				name: 'Publish of Year',
				type: 'line',
				data : datas,
        smooth: true, //是否平滑曲线显示
        showAllSymbol: false,
        symbol: 'circle',
        symbolSize: 6,
        lineStyle: {
        	normal: {
                color: "#fff", // 线条颜色
            },
        },
        label: {
        	show: true,
        	position: 'top',
        	textStyle: {
        		color: '#fff',
        	}
        },
        itemStyle: {
        	color: "red",
        	borderColor: "#fff",
        	borderWidth: 3
        },
        areaStyle: {
        	normal: {
        		color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        			offset: 0,
        			color: '#eb64fb'
        		},
        		{
        			offset: 1,
        			color: '#3fbbff0d'
        		}
        		], false),
        	}
        }
    }]
};

// 		option1 = {
// 		    title: {
// 		        text: 'Publish of Year',
// 		    },
// 		    legend: {
// 		        data: ['publishNumber'],
// 		        align: 'right',
// 		        left: 'right'
// 		    },
// 		    toolbox: {
// 		         y: 'bottom',
// 		        feature: {
// 		            dataView: {},
// 		            saveAsImage: {
// 		                pixelRatio: 2
// 		            }
// 		        }
// 		    },
// 		    xAxis: {
// 		        data: xAxisData,
// 		        silent: false,
// 		        splitLine: {
// 		            show: true
// 		        }
// 		    },
// 		    yAxis: {
// 		    },
// 		    series: [{
// 		        name: 'publishNumber',
// 		        type: 'bar',
// 		        data: data1,
// 		        animationDelay: function (idx) {
// 		            return idx * 10;
// 		        }
// 		    }
// 		    ],
// 		    animationEasing: 'elasticOut',
// 		    animationDelayUpdate: function (idx) {
// 		    return idx * 5;
//     }
// };
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
		echo "<img src =\"/EE101-Final_Project/Final_Project/pics/A.png\" id=\"search__Turn_Page_prev_page\">";
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
			echo "<a class=\"output_href\" id=\"number\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_name_temp&page=$i\">$i</a>";
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
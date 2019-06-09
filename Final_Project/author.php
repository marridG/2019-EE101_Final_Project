<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/author.css">

<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>


<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echarts-all.js'></script> -->
<script type="text/javascript" src="/EE101-Final_Project/Final_Project/add-ons/echart/echarts3.js"></script>

<head>
	<title>Author</title>
</head>

<body>

    <style>
        .navbar-brand
        {
            font-family: 书体坊兰亭体;
            src: url("/EE101-Final_Project/Final_Project/font/书体坊兰亭体I.ttf");
            margin: 0 0 5px 0;


            vertical-align: 10%;
            float: left;
            width: 50px;
            height: 100px;
            font-size:60px;
        }
        body
        {
            background-color: #f9e9c3;
        }
    </style>

    <nav class="nav navbar-default navbar-fixed-top" style="height: 70px;" role="navigation">
        <div class="navbar-header">
            <a href="/EE101-Final_Project/Final_Project/index.php" class="navbar-brand">Phantom</a>
        </div>
        <div>
            <ul class="nav nav-right">
                <li style="display: inline;margin: 0 0 0 35%;margin-top: 20px;"><input class="n-button" type="text" id="key_word" name="key_word" placeholder="Welcome To ACEMAP Academia Searching"></li>
                <li style="display: inline;"><a style="width: 400px;display: inline;" href="/EE101-Final_Project/Final_Project/index.php"><img style="width: 45px;" src="/EE101-Final_Project/Final_Project/pics/search.png"></a></li>
                
            </ul>
        </div>
        
    </nav>


	<!-- <div class="spinner">
		<div class="rect1"></div>
		<div class="rect2"></div>
		<div class="rect3"></div>
		<div class="rect4"></div>
		<div class="rect5"></div>
	</div>  
	<script type="text/javascript">
		(function($)
		{
			$(window).load(function()
			{
				$(".spinner").fadeOut();
			});

			$(document).ready(function(){});
		})(jQuery);
	</script> -->


	<a href="/EE101-Final_Project/Final_Project/index.php"> <img src="/EE101-Final_Project/Final_Project/pics/phantom.png" id="acemap"></a>	
	<h1>Author Information</h1>
	<div id="chart1" style="width: 400px; height: 400px" class="chart" ></div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<div id="chart2" style="width: 400px; height: 400px" class="chart" ></div>

</body>
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
$page = floor($_GET["page"]);

	// Variables for Faster Page Loading
$affiliation_name=$_GET["author_affi"];
$affiliation_name_temp="";

// link to mysql to get the author's name and affiliation

$link = mysqli_connect("127.0.0.1", "root", "", "lab01");
mysqli_query($link, 'SET NAMES utf8');

	// return_to_homepage widget
echo "<a href=\"/EE101-Final_Project/Final_Project/index.php\" class=\"search_return_to_homepage_image\"><img src =\"/EE101-Final_Project/Final_Project/pics/Homepage_icon-without_background.jpg\" id=\"all__return_to_homepage_image\"></a><br>";

	// search and print the AuthorName of the given AuthorID
$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'limit 1");
		// judge whether find the author
if ($author_name_res = mysqli_fetch_row($result))
{
			// var_dump($author_name_res);
	$author_name=$author_name_res[0];
	echo "<a name=\"skip\"></a>";
	echo "Name: $author_name<br>";

	// search and print the most related AffiliationName to the given AuthorID
	if(!$affiliation_name)
	{
		$affi_id_row=mysqli_fetch_row(mysqli_query($link,"SELECT AffiliationID, count(*) AS count FROM paper_author_affiliation where AuthorID='$author_id'GROUP BY AffiliationID ORDER BY count DESC LIMIT 1"));


		//	$affi_id_row2=mysqli_fetch_row(mysqli_query($link,"SELECT AffiliationID, count( AffiliationID) AS count FROM paper_author_affiliation where AuthorID='$author_id'GROUP BY AffiliationID ORDER BY count DESC LIMIT 2"));
		$affi_id=$affi_id_row[0];
		$affi_id_name_result=mysqli_query($link,"SELECT AffiliationName from affiliations where AffiliationID='$affi_id'");

		//	$affi_id_name_result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");

				// while($row=mysqli_fetch_array($affi_id_name_result))
				// {
				// 	echo "<br>row<br>";
				// 	var_dump($row);
				// 	echo "<br>";
				// }

				// var_dump($affi_id_name_result);
				// echo "<br>";
		if($array_result=mysqli_fetch_row($affi_id_name_result))
		{
					// var_dump($array_result);
					// echo "<br>";
			$affiliation_name = $array_result[0];
			echo " Affiliation: $affiliation_name<br>";
		}
		else
		{
			$affiliation_name="-1";
			echo " Affiliation not found!";
		}
	}
	else
	{
		if($affiliation_name=="-1")
			echo " Affiliation not found!<br>";
		else
			echo " Affiliation: $affiliation_name<br>";
	}
	$affiliation_name_temp=urlencode($affiliation_name);
}
		// echo "$affiliation_name";
		// var_dump($affiliation_name_temp);

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
	echo "<table class=\"table__result\" id=\"author_table\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";

	foreach ($result['response']['docs'] as $paper)
	{
					// new line
		echo "<tr>";

					// print the Title
		echo "<td>";
		$title_new=$paper['Title'];
		$title_for_show=urlencode(str_replace('', '', $title_new));
		echo "<a class=\"output_href\"  href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show&page=1\" target=\"_blank\">$title_new</a>";
		echo ";";
		echo "</td>";

					// print all the Authors_Name
		echo "<td>";
		foreach ($paper['Authors_Name'] as $idx => $author)
		{
			$author_id_result = $paper['Authors_ID'][$idx];
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_result&page=1&author_affi=#skip\" target=\"_blank\">$author</a>";
			echo "; ";
		}
		echo "</td>";

					// print ConferenceName
		echo "<td>";
		$conference_Name=$paper['ConferenceName'];
		echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$conference_Name&page=1\" target=\"_blank\">$conference_Name</a>";
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
		echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
		echo "</td><td>";
		echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.png\" id=\"search__Turn_Page_prev_page\"></a>";

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
			echo "<td><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_selected.png\" id=\"search__Turn_Page_selected\"></a></td>";
		else
			echo "<td><a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.png\"  id=\"search__Turn_Page_not_selected\"></a></td>";
	}
					// Next Page
	echo "<td>";
	$i=$page+1;
	if (($i-1)*$page_limit<$num_max)
	{
		echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.png\" id=\"search__Turn_Page_next_page\"></a>";
		echo "</td><td>";
		echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
		echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><<</a>";
		echo "</td><td>";
		echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\">$i</a>";
		echo "</td>";
	}
					// Turn to the Next Page
	echo "<td>";
	$i=$page+1;
	if (($i-1)*$page_limit<$num_max)
	{
		echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
		echo "</td><td>";
		echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp#skip\">>></a>";
	}
	else
		echo "<td></td>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";

				// echo "$author_id";
				// Jump to Page
	echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/author.php#skip\">";
	echo "<input type=\"hidden\" name=\"author_id\" value=\"$author_id\"><input type=\"hidden\" name=\"author_affi\" value=\"$affiliation_name\">";
	echo "Jump to: <input type=\"number\" name=\"page\" class=\"all__Turn_Page_jump_to_number\" max=$page_MAX min=\"1\" required>&nbsp;&nbsp;";
	echo "<input type=\"submit\" value=\"Go!\"></form>";
				// var_dump($page_title);

				// echo "<br><br><br>";

}
else
{
	echo"<br></br>";
	echo "No record!";
}

$ch = curl_init();
$timeout = 5;

	//Search for specified year's paper number in a conference.
echo "<script> var datas=new Array() ; </script> ";
for ($year=1950; $year<=2016 ; $year++) { 
	$keyword = $year;
		// $author_id = ;
	$query1 = urlencode(str_replace(' ', '+', $keyword));
	$query2 = urlencode(str_replace(' ', '+', $author_id));
	$url = "http://localhost:8983/solr/lab02/select?q=Year%3A%20$query1%20%26%26%20Authors_ID%20%3A%20$query2&rows=98215";
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$data = json_decode(curl_exec($ch), true);	
	$value = $data['response']['numFound'];
	echo "<script> datas[$year-1950] = \"$value \" ; </script> ";
}

	//Search for specified paper's citation frequency in a conference.
$conferences = array("AAAI", "CVPR", "ACL", "IJCAI", "NIPS","WWW","ICCV", "ICML", "SIGKDD", "SIGIR", "ECCV", "NAACL" ,"EMNLP");
echo "<script> var datas2 = new Array(); </script> ";
for($i = 0;$i < 13;$i++) {
	$keyword = $conferences[$i];
	$query1 = urlencode(str_replace(' ', '+', $keyword));
	$query2 = urlencode(str_replace(' ', '+', $author_id));
	$url = "http://localhost:8983/solr/lab02/select?q=ConferenceName%3A%20$query1%20%26%26%20Authors_ID%20%3A%20$query2&rows=98215";
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$data = json_decode(curl_exec($ch), true);	
	$value = $data['response']['numFound'];
	
	echo "<script> datas2[$i] = \" $value \" ; </script> ";
}
curl_close($ch);
?>

<script type="text/javascript">
    // 初始化图表标签
    var chart1 = echarts.init(document.getElementById('chart1'));
    var chart2 = echarts.init(document.getElementById('chart2'));
    var xData = function() {
    	var data = [];
    	for (var i =1950; i <= 2016; i++) {
    		data.push(i + "");
    	}
    	return data;
    }();

    var option1 = {
    	backgroundColor: "#344b58",
    	"title": {
    		"text": "Papernumber of Year",
    		// x: "4%",
    		left: 'center',

    		textStyle: {
    			color: '#fff',
    			fontSize: '18',
    			fontFamily: 'Times New Roman'
    		},
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
    	"grid": {
    		"borderWidth": 0,
    		"top": 110,
    		"bottom": 95,
    		textStyle: {
    			color: "#fff"
    		}
    	},
    	"legend": {
    		x: '4%',
    		top: '11%',
    		textStyle: {
    			color: '#90979c',
    		},
    		"data": ['PaperNum']
    	},


    	"calculable": true,
    	"xAxis": [{
    		"type": "category",
    		"axisLine": {
    			lineStyle: {
    				color: '#90979c'
    			}
    		},
    		"splitLine": {
    			"show": false
    		},
    		"axisTick": {
    			"show": false
    		},
    		"splitArea": {
    			"show": false
    		},
    		"axisLabel": {
    			"interval": 10,

    		},
    		"data": xData,
    	}],
    	"yAxis": [{
    		"type": "value",
    		"splitLine": {
    			"show": false
    		},
    		"axisLine": {
    			lineStyle: {
    				color: '#90979c'
    			}
    		},
    		"axisTick": {
    			"show": false
    		},
    		"axisLabel": {
    			"interval": 0,

    		},
    		"splitArea": {
    			"show": false
    		},

    	}],
    	"dataZoom": [{
    		"show": true,
    		"height": 30,
    		"xAxisIndex": [
    		0
    		],
    		bottom: 30,
    		"start": 50,
    		"end": 110,
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
    		"series": [{
    			"name": "PaperNum",
    			"type": "bar",
    			"stack": "总量",
    			"barMaxWidth": 35,
    			"barGap": "10%",
    			"itemStyle": {
    				"normal": {
    					"color": "#77BED3",
    					"label": {
    						"show": false,
    						"textStyle": {
    							"color": "#fff"
    						},
    						"position": "insideTop",
    						formatter: function(p) {
    							return p.value > 0 ? (p.value) : '';
    						}
    					}
    				}
    			},
    			"markPoint": {
    				data: [
    				{type: 'max', name: '最大值',itemStyle:{color:'red'}}
    				]
    			},
    			markLine:{
    				data:[
    				{type:'average',name:'平均值',itemStyle:{
    					normal:{
    						color:'green'
    					}
    				}}
    				]
    			},
    			"data": datas,
    		}]
    	};


// function createRandomItemStyle() {
//         return {
//             normal: {
//                 color: 'rgb(' + [
//                 Math.round(Math.random() * 160),
//                 Math.round(Math.random() * 160),
//                 Math.round(Math.random() * 160)
//                 ].join(',') + ')'
//             }
//         };
//     }

    	var option2 = {
    		backgroundColor: '#EDEFAB',
    		title: {
    			text: 'Publish in Conferences',
    			left: 'center',
    			top: 20,
    			textStyle: {
    				color: 'black',
    				fontFamily: 'Times New Roman'
    			}
    		},

    		tooltip: {
    			trigger: 'item',
    			formatter: "{b} : {c} ({d}%)"
    		},

    		visualMap: {
    			show: false,
    			min: 0,
    			max: Math.max(datas2[0],datas2[1],datas2[2],datas2[3],datas2[4],datas2[5],datas2[6],datas2[7],datas2[8],datas2[9],datas2[10], datas2[11],datas2[12])+80,
    			inRange: {
    				colorLightness: [0.3, 1]
    			}
    		},
    		series: [{
    			name: 'conference',
    			type: 'pie',
    			radius: '60%',
    			center: ['50%', '50%'],
    			data: [{
    				value: datas2[0] == 0 ? null: datas2[0],
    				name: 'AAAI',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[0] == 0 ? null: datas2[0],
    				name: 'CVPR',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[2] == 0 ? null: datas2[2],
    				name: 'ACL',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[3] == 0 ? null: datas2[3],
    				name: 'IJCAI',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[4] == 0 ? null: datas2[4],
    				name: 'NIPS',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[5] == 0 ? null: datas2[5],
    				name: 'WWW',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[6] == 0 ? null: datas2[6],
    				name: 'ICCV',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[7] == 0 ? null: datas2[7],
    				name: 'ICML',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[8] == 0 ? null: datas2[8],
    				name: 'SIGKDD',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[9] == 0 ? null: datas2[9],
    				name: 'SIGIR',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[10] == 0 ? null: datas2[10],
    				name: 'ECCV',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[11] == 0 ? null: datas2[11],
    				name: 'NAACL',
                // itemStyle: createRandomItemStyle()
    			},
    			{
    				value: datas2[12] == 0 ? null: datas2[12],
    				name: 'EMNLP',
                // itemStyle: createRandomItemStyle()
    			}
    			].sort(function(a, b) {
    				return a.value - b.value
    			}),
        label: {
        	normal: {
        		formatter: ['{b|{b}}'],
        		rich: {
        			b: {
        				color: '#3E8AA7',
        				fontSize: 15,
        				height: 40
        			},
        		},
        	}
        },
        labelLine: {
        	normal: {
        		lineStyle: {
        			color: 'rgb(98,137,169)',
        		},
        		smooth: 0.2,
        		length: 10,
        		length2: 20,

        	}
        },
        itemStyle: {
        	normal: {	
        		color : '#940B0B',
        		// shadowColor : 'red',
        		shadowColor: 'rgba(0, 0, 0, 0.5)',
        		shadowBlur: 50
        	}
        }
    }]
};
chart1.setOption(option1);
chart2.setOption(option2);
</script>
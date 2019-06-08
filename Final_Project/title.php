<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/title.css">
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echart/echarts2.js'></script> -->
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src='\EE101-Final_Project\Final_Project\add-ons\echart\echarts3.js'></script>
<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echart/echarts-all.js'></script> -->

<head>
	<title>Title</title>
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
    </style>

    <nav class="nav navbar-default" style="height: 70px;" role="navigation">
        <div class="navbar-header">
            <a href="/EE101-Final_Project/Final_Project/index.php" class="navbar-brand">Phantom</a>
        </div>
        <div>
            <ul class="nav nav-right">
                <li style="display: inline;margin: 0 0 0 30%;"><input class="n-button" type="text" id="key_word" name="key_word" placeholder="Welcome To ACEMAP Academia Searching"></li>
                <li style="display: inline;"><a style="width: 100px; display: inline;" href="/EE101-Final_Project/Final_Project/index.php"><img style="width: 45px;" src="/EE101-Final_Project/Final_Project/pics/search.png"></a></li>
                
            </ul>
        </div>
        
    </nav>
    <!-- <nav class="navbar navbar-default" role="navigation">

        <div class="navbar-header">
            <a class="navbar-brand nav-left" href="#" style="display: inline;">Phantom</a>
        </div>


        <div>
            <ul class="nav nav-pills nav-left">
                <li class="choice"><a href="#">Phantom</a></li>
                <li class="choice"><a href="#">SVN</a></li>
                <li class="choice"><a href="#">iOS</a></li>
                <li class="choice"><a href="#">VB.Net</a></li>
                <li class="choice"><a href="#">Java</a></li>
                <li class="choice"><a href="#">PHP</a></li>
            </ul>
        </div>
    </nav>
--> 	

<h1>Paper Information</h1>
<br><br>
<div id="chart1" style="width:500px;height:500px;margin: 200px 0 0 250px;padding: 0 0 0 0;"></div>
<div id="chart2" style="width:500px;height:500px;"></div>
<?php
        //Search for specified year's paper citaton number.

$ch = curl_init();
$timeout = 5;

$title = $_GET["title"];
$query0 = urlencode(str_replace(' ', '+', $title));
$url = "http://localhost:8983/solr/lab02/select?fl=PaperID&q=Title%3A$query0&rows=1";
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data_ID = json_decode(curl_exec($ch), true); 
$PaperID = $data_ID['response']['docs'][0]['PaperID'];
echo "<script> var datas=new Array() ; </script> ";
for ($year=1950; $year<=2016 ; $year++) { 
    $keyword = $year;
    $query1 = urlencode(str_replace(' ', '+', $keyword));
    $query2 = urlencode(str_replace(' ', '+', $PaperID));
    $url = "http://localhost:8983/solr/lab02/select?q=ReferenceID%20%3A%20$query2%20%26%26%20Year%3A%20$query1&rows=98215";
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = json_decode(curl_exec($ch), true);  
    $value = $data['response']['numFound'];
    echo "<script> datas[$year-1950] = \"$value \" ; </script> ";
}
curl_close($ch);

?>

<script type="text/javascript">
    // 初始化图表标签
    var chart1 = echarts.init(document.getElementById('chart1'));
    var chart2 = echarts.init(document.getElementById('chart2'));
    // Generate data
    var category = [];
    var lineData = [];
    var xData = function() {
        var data = [];
        for (var i =1950; i <= 2016; i++) {
            data.push(i + "");
        }
        return data;
    }();
// option
option1 = {
    backgroundColor: '#0f375f',
    "calculable": true,
    
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow',
            label: {
                show: true,
                backgroundColor: '#333'
            }
        },
        formatter: "Number of Citations:{c} "
    },
    grid: {
        top: '20%',
        left: '10%',
        right: '10%',
        bottom: '15%',
        containLabel: true,
    },
    legend: {
        data: ['Yearly Citations'],
        textStyle: {
            color: '#ccc'
        }
    },
    xAxis: {
        axisLine: {
            lineStyle: {
                color: '#ccc'
            }
        },
        data: xData,
    },
    yAxis: {
        splitLine: {
            show: false
        },
        axisLine: {
            lineStyle: {
                color: '#ccc'
            }
        }
    },
    dataZoom: [{
        "show": true,
        "height": 30,
        "xAxisIndex": [
        0
        ],
        bottom: 30,
        "start": 75,
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
            name: 'Yearly Citations',
            type: 'line',
            smooth: 0.35,
            showAllSymbol: false,
            symbol: 'emptyCircle',
            symbolSize: 15,
            data:datas,
            itemStyle: {
                normal:{
                    color:'#386db3',
                    lineStyle:{color:'#386db3'}
                }
            }
        }, {
            type: 'bar',
            barGap: '-100%',
            barWidth: 12,
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [{
                            offset: 0.2,
                            color: 'rgba(20,200,212,0.5)'
                        },
                        {
                            offset: 0.5,
                            color: 'rgba(20,200,212,0.2)'
                        },
                        {
                            offset: 1,
                            color: 'rgba(20,200,212,0)'
                        }
                        ]
                        )
                }
            },
            z: -12,
            data: datas
        }, {
            type: 'pictorialBar',
            symbol: 'rect',
            itemStyle: {
                normal: {
                    color: '#0f375f'
                }
            },
            symbolRepeat: true,
            symbolSize: [12, 2],
            symbolMargin: 2,
            z: -10,
            data: datas
        }]
    };

    function createRandomItemStyle() {
        return {
            normal: {
                color: 'rgb(' + [
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160)
                ].join(',') + ')'
            }
        };
    }
    option2= {
        title: {
            text: 'Word Cloud'
        },
        series: [{
            name: 'Word Cloud',
            type: 'wordCloud',
            size: ['80%', '80%'],
            textRotation : [0, 45, 90, -45],
            textPadding: 0,
            autoSize: {
                enable: true,
                minSize: 14
            },
            data: [
            {
                name: "Sam S Club",
                value: 10000,
                itemStyle: {
                    normal: {
                        color: 'black'
                    }
                }
            },
            {
                name: "Macys",
                value: 6181,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Amy Schumer",
                value: 4386,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Jurassic World",
                value: 4055,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Charter Communications",
                value: 2467,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Chick Fil A",
                value: 2244,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Planet Fitness",
                value: 1898,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Pitch Perfect",
                value: 1484,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Express",
                value: 1112,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Home",
                value: 965,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Johnny Depp",
                value: 847,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Lena Dunham",
                value: 582,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Lewis Hamilton",
                value: 555,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "KXAN",
                value: 550,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Mary Ellen Mark",
                value: 462,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Farrah Abraham",
                value: 366,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Rita Ora",
                value: 360,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Serena Williams",
                value: 282,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "NCAA baseball tournament",
                value: 273,
                itemStyle: createRandomItemStyle()
            },
            {
                name: "Point Break",
                value: 265,
                itemStyle: createRandomItemStyle()
            }
            ]
        }]
    };

    chart1.setOption(option1);
    chart2.setOption(option2);
</script>

<?php

$title = $_GET["title"];
$link = mysqli_connect("127.0.0.1", "root", "", "lab01");
mysqli_query($link, 'SET NAMES utf8');

echo "Paper Title: ".$title;

$result=mysqli_fetch_row(mysqli_query($link, "SELECT * from papers where Title='$title'limit 1"));
echo "<br>";
echo "</br>";

echo "Paper publish year: ".$result[2];

//	$result=mysqli_fetch_array(mysqli_query($link, "SELECT PaperID from papers where Title='$title'"));
$this_paper_id=$result[0];
echo "<br></br>";
echo "Paper ID: ".$this_paper_id;
echo "<br></br>";

$result_PaperID=$result[0];
$author_name_result = mysqli_query($link, "SELECT B.AuthorName, B.AuthorID  from paper_author_affiliation A Inner Join authors B where A.PaperID='$result_PaperID' and A.AuthorID=B.AuthorID Order by A.AuthorSequence");


echo "Authors: ";
$paper_author_list=array();
foreach ($author_name_result as $author)
{
 $author_name=$author['AuthorName'];
 $author_id=$author['AuthorID'];
 echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_name</a>";
 echo ";";
 array_push($paper_author_list,$author["AuthorName"]);
}
echo "<br></br>";

	// $paper_author_list=array("deng cai","xiaofei he","jiawei han");


$result=mysqli_fetch_row(mysqli_query($link, "SELECT ConferenceID from papers where Title='$title'limit 1"))[0];

$conference_name_result = mysqli_fetch_row(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$result'limit 1"));
$tmp=$conference_name_result[0];
echo "Conference Name: ";
echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$tmp&page=1\" target=\"_blank\">$tmp</a>";
echo "<br><br>";

		// var_dump($paper_author_list);
		// echo "<br>";
		// echo "<br>";

	// Reference Papers
	//	echo $this_paper_id;
$reference_paper_result = mysqli_query($link, "SELECT ReferenceID from paper_reference where PaperID='$this_paper_id'");

$tmp=mysqli_fetch_row($reference_paper_result)[0];

echo"Reference: ";
if($tmp)
{		   
  echo "<div class=\"TextLeft\">";
  $coun=1;
  $Reference_paper=mysqli_fetch_row(mysqli_query($link,"SELECT Title from papers where PaperID='$tmp'limit 1"));
  $title_for_show=urlencode(str_replace('', '', $Reference_paper[0]));
  echo"[$coun] ";
  echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show&page=1\" target=\"_blank\">$Reference_paper[0]</a>";
  echo"<br></br>";
  $coun+=1;
  
  
  while($row=mysqli_fetch_row($reference_paper_result))
  {
    $Reference_paper=mysqli_fetch_row(mysqli_query($link,"SELECT Title from papers where PaperID='$row[0]'limit 1"));
    $title_for_show=urlencode(str_replace('', '', $Reference_paper[0]));
    echo"[$coun] ";
 			// 	$timeout = 5;
				// $ch = curl_init();
				// $url = "http://localhost:8983/solr/lab02/select?indent=on&start=0&rows=11&wt=json&q=Title:".$Reference_paper[1];
				// curl_setopt ($ch, CURLOPT_URL, $url);
				// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				// $result = json_decode(curl_exec($ch), true);
				// curl_close($ch);
				// $year_year=$result['response']['doc']['Year'];
				// var_dump($result);
				// echo $year_year;
    echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show&page=1\" target=\"_blank\">$Reference_paper[0]</a>";
    echo"<br></br>";
    $coun+=1;
}
echo "</div>";


}
else  echo"no record!";


	// Recommend Papers
		// Search
$ch = curl_init();
$timeout = 5;
$query = urlencode(str_replace(' ', '+', $title));
		// Color Highlight #D9EE0A
		// $url = "http://localhost:8983/solr/lab02/select?indent=on&q=Title:".$query."^1+OR+Authors_Name:".$query."^0.7+OR+ConferenceName:".$query."^0.5&start=".($page_limit*($page-1))."&rows=".$page_limit."&wt=json&hl=on&hl.fl=Title,Authors_Name,ConferenceName&hl.simple.post=<%2Fb><%2Ffont>&hl.simple.pre=<font%20color%3D%23D9EE0A><b>";
		// No Color Highlight
$url = "http://localhost:8983/solr/lab02/select?indent=on&start=0&rows=11&wt=json&q=Title:".$query."^1.5";
foreach ($paper_author_list as $key => $author)
{
 $query = urlencode(str_replace(' ', '+', $author));
 $weight=3-$key*0.5;
 if($weight<=0)
    break;
$url=$url."+OR+Authors_Name:".$query."^".$weight."";
}

curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

$result = json_decode(curl_exec($ch), true);
curl_close($ch);

		// var_dump($result);

		// Print
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/EE101-Final_Project/Final_Project/add-ons/05_test_show_hide.css\">";
echo "<div id=\"box\">";
echo "Related Papers:&nbsp;&nbsp;&nbsp;&nbsp;<button id=\"btn\">Show</button>";
echo "<div id=\"content\">";
echo "<div id=\"spread\">";
echo "<br>";
if($result && $result['response']['docs'])
{
   foreach ($result['response']['docs'] as $idx => $info)
   {
     if(!$idx)
         continue;
     if($idx>=11)
         break;
     echo "[$idx]. ";
     foreach ($info["Authors_Name"] as $key => $value)
     {
         echo "$value";
         if($key!=count($info["Authors_Name"])-1)
            echo ",";
        else
            echo ".";
    }
    $recommend_title=$info['Title'];
    $title_for_show=urlencode(str_replace('', '', $recommend_title));
    echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show\" target=\"_blank\">$recommend_title</a>.";
    echo $info["ConferenceName"].",".$info["Year"];
    echo "<br>";
						// echo "<table id=\"table__recommend\"><tr>";
						// echo "<td>[$idx]. </td><td>";
						// foreach ($info["Authors_Name"] as $key => $value)
						// {
						// 	echo "$value";
						// 	if($key!=count($info["Authors_Name"])-1)
						// 		echo ",";
						// 	else
						// 		echo ".<br>";
						// }
						// $recommend_title=$info['Title'];
						// $title_for_show=urlencode(str_replace('', '', $recommend_title));
						// echo "<a href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show\" target=\"_blank\">$recommend_title</a>.<br>";
						// echo $info["ConferenceName"].",".$info["Year"];
						// echo "</td></tr></table>";
    echo "<br>";
}

}
echo "</div>";
echo "</div>";
echo "<script src=\"/EE101-Final_Project/Final_Project/add-ons/05_test_show_hide.js\"></script>";
echo "</div>";

?>
<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/title.css">
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
<script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echart/echarts-all.js'></script>

<head>
	<title>Title</title>
</head>

<body>
	<a href="/EE101-Final_Project/Final_Project/index.php"> <img src="/EE101-Final_Project/Final_Project/pics/phantom.png" id="acemap"></a>    	
	<h1 id="test">Your Best Academia Database!</h1>

	<h1>Paper Information</h1>
    <br><br>
    <div id="chart1" style="width:1000px;height:1000px;"></div>
    <div id="chart2" style="width:1000px;height:1000px;"></div>
    <script type="text/javascript">
    // 初始化图表标签
    var chart1 = echarts.init(document.getElementById('chart1'));
    var chart2 = echarts.init(document.getElementById('chart2'));
    option1 = {
        title: {
            text: 'Yearly Citations',
            subtext: 'Default layout',
            top: 'top',
            left: 'center'
        },
        xAxis: {
            type: 'category',
            data: ['*-1980', '1990-1998', '1999-2006', '2007-2013', '2014-2016']
        },  
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [820, 932, 901, 934, 1290, 1330, 1320],
            type: 'line',
            smooth: true
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
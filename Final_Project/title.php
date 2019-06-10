<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/title.css">
<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
	<!-- ChannelSlanted2的link -->
<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echart/echarts2.js'></script> -->
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src='\EE101-Final_Project\Final_Project\add-ons\echart\echarts3.js'></script>
<script type="text/javascript" src="\EE101-Final_Project\Final_Project\add-ons\echart\dataTool.min.js"></script>
<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echart/echarts-all.js'></script> -->

<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/46721/5cf220b2f629d80774a3a1b2.css' rel='stylesheet' type='text/css' />
    <!--    Regencie的link -->

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
        body
        {
            background-color: #f9e9c3;
        }
    </style>

<nav class="nav navbar-default navbar-fixed-top" style="height: 70px;margin: 0 0 0 0;" role="navigation">
    <div class="navbar-header">
        <a href="/EE101-Final_Project/Final_Project/index.php" class="navbar-brand">Phantom</a>
    </div>
    <div>
        <ul class="nav nav-right">
            <li style="display: inline;margin: 0 0 0 35%;"><form id="search_form" action="/EE101-Final_Project/Final_Project/search.php"><input class="n_button" type="text" id="key_word" name="key_word" placeholder="Welcome To Phantom Academia Searching" style="margin: 0 0 0 60%;"><input  type="hidden" name="page" value="1"><input class="input_search" id="submit" type="submit" value="Search"></form></li>
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
<div class="charts">
<div id="chart1" style="width:400px;height:400px;"></div>
<br><br>
<div id="chart2" style="width:400px;height:400px;"></div>
</div>
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

<?php
    $ch = curl_init();
    $timeout = 5;

// Change title to paperid.
    $title = $_GET["title"];
    echo "<script>
        var categories = [{name: 'Paper'},{name: 'Level One Citations'},{name: 'Level Two Citations'}];
        var name;
        var value;
        var label;
        var graph = {};
        graph.nodes = [{category: 'Paper', name: '0', value: 100 , label: '$title'}];
        graph.links = [];
        </script>
        ";
    $query0 = urlencode(str_replace(' ', '+', $title));
    $url = "http://localhost:8983/solr/lab02/select?fl=PaperID&q=Title%3A$query0&rows=1";
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data_ID = json_decode(curl_exec($ch), true); 
    $PaperID = $data_ID['response']['docs'][0]['PaperID'];

// Search for reference ID
    $keyword = $PaperID;
    $query1 = urlencode($keyword);
    // $query2 = urlencode($ConferenceName);
    $url = "http://localhost:8983/solr/lab02/select?fl=ReferenceID&q=PaperID%20%3A%20$query1%20&rows=98215";
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = json_decode(curl_exec($ch), true);  
    // var_dump($data);
    $ReferenceID = $data['response']['docs'][0]['ReferenceID'];
    $Number = count($ReferenceID);
    $k = 2+$Number;
    // echo("<br>");    
    $get = array();
    $get[0] = $ReferenceID;

    // var_dump($ReferenceID);
    // echo("<br>");
    // var_dump($get[0]);

    foreach ($ReferenceID as $i => $keyword) {

    //Search for the title of Citations.
        $query1 = urlencode($keyword);
        // $query2 = urlencode($ConferenceName);
        $url = "http://localhost:8983/solr/lab02/select?fl=Title&q=PaperID%20%3A%20$query1%20&rows=98215";
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = json_decode(curl_exec($ch), true);  
        // var_dump($data);
        if ($data['response']['docs']) {
            $title = $data['response']['docs'][0]['Title'];
            $p = $i+1;
            // var_dump($p);
            echo "<script>
            graph.nodes.push({category: 'Level One Citations', name: '$p', value: 45 , label: '$title'});
            </script>
            "; 
        }
        

    //Search for the Refernece of Level One Citations.
        $url = "http://localhost:8983/solr/lab02/select?fl=ReferenceID&q=PaperID%20%3A%20$query1%20&rows=98215";
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = json_decode(curl_exec($ch), true);  
        // var_dump($data);
        if ($data['response']['docs']) {
            $ReferenceID = $data['response']['docs'][0]['ReferenceID'];
            $get[$p] = $ReferenceID;
            echo "<script>
            graph.links.push({source:'0', target:'$p',value:200});
            </script>";
        }


        // echo("<br>");
        // echo("<br>");
        // var_dump($get[$i+1]);

    //Search for the Level Two ReferenceID's Title.
        foreach ($ReferenceID as $j => $keyword) {
            $query1 = urlencode($keyword);
            $url = "http://localhost:8983/solr/lab02/select?fl=Title&q=PaperID%20%3A%20$query1%20&rows=1";
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = json_decode(curl_exec($ch), true);  
            // echo("<br>");
            // echo("<br>");
            // echo("<br>");
            // var_dump($data);
            
            if($data['response']['docs'])
            {
                $title = $data['response']['docs'][0]['Title'];
                
                echo "
                <script> 
                graph.nodes.push({category: 'Level Two Citations', name: '$k', value: 25 , label: '$title'});
                graph.links.push({source: '$p', target: '$k', value: 50});
                </script>
                ";
                $k++;
            }
        }
    }
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
// options
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

    var option2 = {
        title: {
        text: "Papers' Citation Relationship",//标题
        top: 'bottom',//相对在y轴上的位置
        left: 'center'//相对在x轴上的位置
      },
        tooltip : {//提示框，鼠标悬浮交互时的信息提示
        trigger: 'item',//数据触发类型
        formatter: function(params){//触发之后返回的参数，这个函数是关键
          console.log(params);
          if (params.data.category !=undefined) {//如果触发节点
            return 'Paper :<br>'+params.data.label;//返回标签
          }else {//如果触发边
            return ' ';
          }
        }
      },
      //全局颜色，图例、节点、边的颜色都是从这里取，按照之前划分的种类依序选取
      color:['rgb(194,53,49)','rgb(178,144,137)','rgb(97,160,168)'],
      //图例，每个图表最多仅有一个图例
      legend: [{
            // selectedMode: 'single',
            data: categories.map(function (a) {
                return a.name;
            })
        }],
      //sereis的数据: 用于设置图表数据之用
      series : [
        {
          name: 'Paper Citations',//系列名称
          type: 'graph',//图表类型
          layout: 'force',//echarts3的变化，force是力向图，circular是和弦图
          draggable: true,//指示节点是否可以拖动
          data: graph.nodes,//节点数据
          links: graph.links,//边、联系数据
          categories: categories,//节点种类
          symbolSize: (value,params) => {
            // console.log(value);
            // console.log(params);
            return value/2;
          },
          focusNodeAdjacency:true,//当鼠标移动到节点上，突出显示节点以及节点的边和邻接节点
          roam: true,//是否开启鼠标缩放和平移漫游。默认不开启。如果只想要开启缩放或者平移，可以设置成 'scale' 或者 'move'。设置成 true 为都开启

          label: {//图形上的文本标签，可用于说明图形的一些数据信息
            normal: {
              show : false,//显示
              position: 'right',//相对于节点标签的位置
              //回调函数，你期望节点标签上显示什么
              formatter: function(params){
                return params.data.label;
              },
            }
          },
          //节点的style
          itemStyle: {
                    normal: {
                        borderColor: '#fff',
                        // radius : 100,
                        borderWidth: 1,
                        shadowBlur: 10,
                        shadowColor: 'rgba(0, 0, 0, 0.3)'
                    }
                },
          // 关系边的公用线条样式
          lineStyle: {
            normal: {
              show : true,
              color: 'source',//决定边的颜色是与起点相同还是与终点相同
              curveness: 0.3//边的曲度，支持从 0 到 1 的值，值越大曲度越大。
            }
          },
          force: {
            edgeLength: [100,200],//线的长度，这个距离也会受 repulsion，支持设置成数组表达边长的范围
            repulsion: 100//节点之间的斥力因子。值越大则斥力越大
          }
        }
      ]
    };

    chart1.setOption(option1);
    chart2.setOption(option2);
</script>

<?php

$title = $_GET["title"];
$link = mysqli_connect("127.0.0.1", "root", "", "lab01");
mysqli_query($link, 'SET NAMES utf8');


echo "<P id=\"paper_title\">Paper Title: $title</p>";

$result=mysqli_fetch_row(mysqli_query($link, "SELECT * from papers where Title='$title'limit 1"));
echo "<br>";
echo "</br>";
echo "<div class=\"whole_result\">";
echo "<P class=\"output\" id=\"paper_publish_year\">Paper publish year: $result[2]</p>";

//	$result=mysqli_fetch_array(mysqli_query($link, "SELECT PaperID from papers where Title='$title'"));
$this_paper_id=$result[0];
echo "<br></br>";
echo "<P class=\"output\" id=\"paperid\"> Paper ID: $this_paper_id</p>";
echo "<br></br>";

$result_PaperID=$result[0];
$author_name_result = mysqli_query($link, "SELECT B.AuthorName, B.AuthorID  from paper_author_affiliation A Inner Join authors B where A.PaperID='$result_PaperID' and A.AuthorID=B.AuthorID Order by A.AuthorSequence");


echo "<P class=\"output\" id=\"authors\">Authors: ";
$paper_author_list=array();
foreach ($author_name_result as $author)
{
   $author_name=$author['AuthorName'];
   $author_id=$author['AuthorID'];
   echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=1&author_affi=\" target=\"_blank\">$author_name</a>";
   echo ";";
   array_push($paper_author_list,$author["AuthorName"]);
}
echo "</p>";
echo "<br></br>";

	// $paper_author_list=array("deng cai","xiaofei he","jiawei han");


$result=mysqli_fetch_row(mysqli_query($link, "SELECT ConferenceID from papers where Title='$title'limit 1"))[0];

$conference_name_result = mysqli_fetch_row(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$result'limit 1"));
$tmp=$conference_name_result[0];
echo "<P class=\"output\" id=\"conferences\">Conference Name: ";
echo "<a href=\"/EE101-Final_Project/Final_Project/conference.php?conference_name=$tmp&page=1\" target=\"_blank\">$tmp</a>";
echo "</p>";
echo "<br><br>";

		// var_dump($paper_author_list);
		// echo "<br>";
		// echo "<br>";

	// Reference Papers
	//	echo $this_paper_id;
$reference_paper_result = mysqli_query($link, "SELECT ReferenceID from paper_reference where PaperID='$this_paper_id'");

$tmp=mysqli_fetch_row($reference_paper_result)[0];

echo"<P class=\"output\" id=\"references\">Reference: ";
if($tmp)
{		   
  echo "<div class=\"TextLeft\">";
  $coun=1;
  $Reference_paper=mysqli_fetch_row(mysqli_query($link,"SELECT Title from papers where PaperID='$tmp'limit 1"));
  $title_for_show=urlencode(str_replace('', '', $Reference_paper[0]));
  echo"[$coun] ";
  echo "<a class=\"output_href\" id=\"output_href_title\" href=\"/EE101-Final_Project/Final_Project/title.php?title=$title_for_show&page=1\" target=\"_blank\">$Reference_paper[0]</a>";
  echo "</p>";
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
$url = "http://localhost:8983/solr/lab02/select?indent=on&start=0&rows=11&wt=json&q=ReferenceID:".$PaperID."^5+OR+Title:".$query."^2.5";
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
//echo "<div id=\"box\">";
echo "<div class=\"output\" id=\"related_paper\">Related Papers: <button id=\"btn\">Show</button></div>";
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
// echo "</div>";

?>
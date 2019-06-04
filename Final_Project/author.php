<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/author.css">

<!-- <script type="text/javascript" src='/EE101-Final_Project/Final_Project/add-ons/echarts-all.js'></script> -->
<script type="text/javascript" src="/EE101-Final_Project/Final_Project/add-ons/echart/echarts3.js"></script>

<head>
	<title>Author</title>
</head>

<body>
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
	$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'");
		// judge whether find the author
	if ($author_name_res = mysqli_fetch_row($result))
	{
			// var_dump($author_name_res);
		$author_name=$author_name_res[0];
		echo "<a name=\"skip_here\"></a>";
		echo "Name: $author_name<br>";

		// search and print the most related AffiliationName to the given AuthorID
		if(!$affiliation_name)
		{
			$affi_id_name_result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");

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
				$affiliation_name = $array_result[1];
				echo "class=\"affiliation\" Affiliation: $affiliation_name<br>";
			}
			else
			{
				$affiliation_name="-1";
				echo "class=\"affiliation\" Affiliation not found!";
			}
		}
		else
		{
			if($affiliation_name=="-1")
				echo "class=\"affiliation\" Affiliation not found!<br>";
			else
				echo "class=\"affiliation\" Affiliation: $affiliation_name<br>";
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
				echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id_result&page=1&author_affi=\" target=\"_blank\">$author</a>";
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
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
			echo "</td><td>";
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_prev.jpg\" id=\"search__Turn_Page_prev_page\"></a>";

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
				echo "<td><a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_not_selected.jpg\"  id=\"search__Turn_Page_not_selected\"></a></td>";
		}
					// Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_next.jpg\" id=\"search__Turn_Page_next_page\"></a>";
			echo "</td><td>";
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\" id=\"search__Turn_Page_prev_page\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><<</a>";
			echo "</td><td>";
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
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
				echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\">$i</a>";
			echo "</td>";
		}
					// Turn to the Next Page
		echo "<td>";
		$i=$page+1;
		if (($i-1)*$page_limit<$num_max)
		{
			echo "<a href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\"><img src =\"/EE101-Final_Project/Final_Project/pics/Turn_Page_empty.jpg\" id=\"search__Turn_Page_empty\"></a>";
			echo "</td><td>";
			echo "<a class=\"output_href\" href=\"/EE101-Final_Project/Final_Project/author.php?author_id=$author_id&page=$i&author_affi=$affiliation_name_temp\">>></a>";
		}
		else
			echo "<td></td>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
				// echo "$author_id";
				// Jump to Page
		echo "<form id=\"form__jump_to__right_hand\" action=\"/EE101-Final_Project/Final_Project/author.php\">";
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

	for ($year=1950; $year<2016 ; $year++) { 
		$keyword = $year;
		// $author_id = ;
		$query1 = urlencode(str_replace(' ', '+', $keyword));
		$query2 = urlencode(str_replace(' ', '+', $author_id));
		$url = "http://localhost:8983/solr/lab02/select?q=Year%3A%20$query1%20%26%26%20Authors_ID%20%3A%20$query2&rows=98215";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		$data = json_decode(curl_exec($ch), true);	
		
	}

	curl_close($ch);
	?>

<script type="text/javascript">
    // 初始化图表标签
    var chart1 = echarts.init(document.getElementById('chart1'));
    var chart2 = echarts.init(document.getElementById('chart2'));
    var xData = function() {
    var data = [];
    for (var i =1950; i < 2016; i++) {
        data.push(i + "");
    }
    return data;
}();

var option1 = {
    backgroundColor: "#344b58",
    "title": {
        "text": "16年1月-16年11月充值客单分析",
        "subtext": "BY MICVS",
        x: "4%",

        textStyle: {
            color: '#fff',
            fontSize: '22'
        },
        subtextStyle: {
            color: '#90979c',
            fontSize: '16',

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
        "data": ['老用户', '新用户', '总']
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
            "interval": 0,

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
        "start": 10,
        "end": 80,
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
            "name": "老用户",
            "type": "bar",
            "stack": "总量",
            "barMaxWidth": 35,
            "barGap": "10%",
            "itemStyle": {
                "normal": {
                    "color": "rgba(255,144,128,1)",
                    "label": {
                        "show": true,
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
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
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
            "data": [
                198.66,
                330.81,
                151.95,
                160.12,
                222.56,
                229.05,
                128.53,
                250.91,
                224.47,
                473.99,
                126.85,
                260.50
            ],
        },

        {
            "name": "新用户",
            "type": "bar",
            "stack": "总量",
            "itemStyle": {
                "normal": {
                    "color": "rgba(0,191,183,1)",
                    "barBorderRadius": 0,
                    "label": {
                        "show": true,
                        "position": "top",
                        formatter: function(p) {
                            return p.value > 0 ? (p.value) : '';
                        }
                    }
                }
            },
            "data": [
                82.89,
                67.54,
                62.07,
                59.43,
                67.02,
                67.09,
                35.66,
                71.78,
                81.61,
                78.85,
                79.12,
                72.30
            ]
        }, {
            "name": "总",
            "type": "line",
            "stack": "总量",
            symbolSize:20,
            symbol:'circle',
            "itemStyle": {
                "normal": {
                    "color": "rgba(252,230,48,1)",
                    "barBorderRadius": 0,
                    "label": {
                        "show": true,
                        "position": "top",
                        formatter: function(p) {
                            return p.value > 0 ? (p.value) : '';
                        }
                    }
                }
            },
            "data": [
                281.55,
                398.35,
                214.02,
                219.55,
                289.57,
                296.14,
                164.18,
                322.69,
                306.08,
                552.84,
                205.97,
                332.79
            ]
        },
    ]
}
    // var option1={
    //     //定义一个标题
    //     title:{
    //         text:'Publish Year'
    //     },
    //     legend:{
    //         data:['Year']
    //     },
    //     //X轴设置
    //     xAxis:{
    //     }
    //     yAxis:{
    //     },
    //     //name=legend.data的时候才能显示图例
    //     series:[{
    //             name:'Year',
    //             type:'bar',
    //             color:'blue',
    //             data:[200,312,431,241,175,275,369],
    //             markPoint: {
    //                 data: [
    //                     {type: 'max', name: '最大值'},
    //                     {type: 'min', name: '最小值'}
    //                 ]
    //             },
    //             markLine:{
    //                 data:[
    //                     {type:'average',name:'平均值',itemStyle:{
    //                         normal:{
    //                             color:'green'
    //                         }
    //                     }}
    //                 ]
    //             }
    //         }
    //         ]

    // };
//     var option2 = {
//     backgroundColor: '#D6FCF1',

//     title: {
//         text: 'Paper\'s Conferences',
//         left: 'center',
//         top: 20,
//         textStyle: {
//             color: 'pink'
//         }
//     },

//     // tooltip : {
//     //     trigger: 'item',
//     //     formatter: "{a} <br/>{b} : {c} ({d}%)"
//     // },

//     visualMap: {
//         show: true,
//         min: 80,
//         max: 600,
//         inRange: {
//             colorLightness: [0, 1]
//         }
//     },
//     series : [
//         {
//             name:'ConferenceName',
//             type:'pie',
//             radius : '55%',
//             center: ['50%', '50%'],
//             data:[
//                 {value:335, name:'SIGKDD'},
//                 {value:310, name:'IJCAI'},
//                 {value:274, name:'AAAI'},
//                 {value:235, name:'CVPR'},
//                 {value:400, name:'ACL'},
//                 {value:200, name:'NIPS'},
//                 {value:200, name:'WWW'},
//                 {value:335, name:'ICCV'},
//                 {value:335, name:'ICML'},
//                 {value:335, name:'EMNLP'},
//                 {value:335, name:'SIGIR'},
//                 {value:335, name:'ECCV'},
//                 {value:335, name:'NAACL'},
//             ].sort(function (a, b) { return a.value - b.value; }),
//             roseType: 'radius',
//             label: {
//                 normal: {
//                     textStyle: {
//                         color: 'rgba(0 , 0 , 0, 1.0)'
//                     }
//                 }
//             },
//             labelLine: {
//                 normal: {
//                     lineStyle: {
//                         color: 'rgba(255, 255, 0, 2.0)'
//                     },
//                     smooth: 0.2,
//                     length: 20,
//                     length2: 2
//                 }
//             },
//             itemStyle: {
//                 normal: {
//                     color: '#c23531',
//                     shadowBlur: 200,
//                     shadowColor: 'rgba(0, 0, 0, 0.5)'
//                 }
//             },

//             animationType: 'scale',
//             animationEasing: 'elasticOut',
//             animationDelay: function (idx) {
//                 return Math.random() * 200;
//             }
//         }
//     ]
// };
var option2 = {
    backgroundColor: '#2c343c',
    title: {
        text: '南丁格尔玫瑰图',
        left: 'center',
        top: 20,
        textStyle: {
            color: '#ccc'
        }
    },

    tooltip: {
        trigger: 'item',
        formatter: "{b} : {c} ({d}%)"
    },

    visualMap: {
        show: false,
        min: 500,
        max: 600,
        inRange: {
            //colorLightness: [0, 1]
        }
    },
    series: [{
        name: '访问来源',
        type: 'pie',
        radius: '50%',
        center: ['50%', '50%'],
        color: ['rgb(131,249,103)', '#FBFE27', '#FE5050', '#1DB7E5'], //'#FBFE27','rgb(11,228,96)','#FE5050'
        data: [{
                value: 285,
                name: '黑名单查询'
            },
            {
                value: 410,
                name: '红名单查询'
            },
            {
                value: 274,
                name: '法人行政处罚'
            },
            {
                value: 235,
                name: '其它查询'
            }
        ].sort(function(a, b) {
            return a.value - b.value
        }),
        roseType: 'radius',

        label: {
            normal: {
                formatter: ['{c|{c}次}', '{b|{b}}'].join('\n'),
                rich: {
                    c: {
                        color: 'rgb(241,246,104)',
                        fontSize: 20,
                        fontWeight:'bold',
                        lineHeight: 5
                    },
                    b: {
                        color: 'rgb(98,137,169)',
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
                shadowColor: 'rgba(0, 0, 0, 0.8)',
                shadowBlur: 50,
            }
        }
    }]
};
    chart1.setOption(option1);
    chart2.setOption(option2);
</script>
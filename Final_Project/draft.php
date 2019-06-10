<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src='\EE101-Final_Project\Final_Project\add-ons\echart\echarts3.js'></script>

	<title>Try to form data of the force directed graph.</title>
</head>


<body>
<div id="chart" style="width:400px;height:400px;"></div>

<?php
	$ch = curl_init();
	$timeout = 5;

// Change title to paperid.
	// $title = $_GET["title"];
	$title = 'data mining';
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
		$title = $data['response']['docs'][0]['Title'];
		$p = $i+1;
		// var_dump($p);
		echo "<script>
		graph.nodes.push({category: 'Level One Citations', name: '$p', value: 65 , label: '$title'});
		</script>
		";

	//Search for the Refernece of Level One Citations.
		$url = "http://localhost:8983/solr/lab02/select?fl=ReferenceID&q=PaperID%20%3A%20$query1%20&rows=98215";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = json_decode(curl_exec($ch), true);	
		// var_dump($data);
		$ReferenceID = $data['response']['docs'][0]['ReferenceID'];
		$get[$p] = $ReferenceID;
		echo "<script>
		graph.links.push({source:'0', target:'$p',value:200});
		</script>";


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
				graph.nodes.push({category: 'Level Two Citations', name: '$k', value: 40 , label: '$title'});
				graph.links.push({source: '$i', target: '$k', value: 50});
				</script>
				";
				$k++;
				// var_dump($k);
				// echo("<br>");
			}
		}
	}


	
	// echo("
	// 	<script>
	// 	alert(nodes[0].label);
	// 	</script>");
	curl_close($ch);

?>

<script type="text/javascript">
	var chart = echarts.init(document.getElementById('chart'));
	var option = {
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
 
    chart.setOption(option);

</script>

</body>
</html>
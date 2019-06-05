<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/index_search_advanced.css">
<script type="text/javascript" src="/EE101-Final_Project/Final_Project/add-ons/jquery/jquery-3.4.0.min.js"></script>

<head>
	<title>Advanced Search</title>
</head>

<body>
	<!-- Advanced Search -->
	<div>
	<a href="/EE101-Final_Project/Final_Project/index.php"> <img src="/EE101-Final_Project/Final_Project/pics/phantom.png" id="acemap"></a>	
	<h1 id="test">Your Best Academia Database!</h1>
	</div>
	<div id="all_charts">
	<div id="chart1" style="width: 400px; height:400px;position: absolute; left:80px;top: 350px;"></div>
	</div>

	<script type="text/javascript">	// add/delete rows
		function show_boxes(add_del)
		{
			// var add_del=1;
			var xmlhttp;
			if (window.XMLHttpRequest)	//  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
				xmlhttp=new XMLHttpRequest();
			else	// IE6, IE5 浏览器执行代码
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("advanced_boxes_root").innerHTML=xmlhttp.responseText;
				}
			}
		
			// get url and GET
			var url="/EE101-Final_Project/Final_Project/add-ons/07_advanced_search_boxes.php?add_del="+add_del;
			var elements_boxes=$(".advanced_box");
			var i=0;
			var count=0;
			if(elements_boxes.length>=1)
			{
				var box_children=$(".advanced_box")[0].childNodes;
				url=url+"&bool1="+box_children[0].value+"&target1="+box_children[1].value+"&word1="+box_children[3].value.replace(/ /g, "+");
				for (i=1;i<=elements_boxes.length-1;i++)
				{
					box_children=$(".advanced_box")[i].childNodes;
					url=url+"&bool"+(i+1)+"="+box_children[0].value+"&target"+(i+1)+"="+box_children[2].value+"&word"+(i+1)+"="+box_children[4].value.replace(/ /g, "+");
				} 
				count=elements_boxes.length;
				// console.log(count);
				url=url+"&count="+count;
			}
			else
			{
				url=url+"&count=0";
			}
			console.log(url);

			// request
			xmlhttp.open("GET",url, true);
			xmlhttp.send();
		}

		function submit_search()
		{
			var xmlhttp;
			if (window.XMLHttpRequest)	//  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
				xmlhttp=new XMLHttpRequest();
			else	// IE6, IE5 浏览器执行代码
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("advanced_search_result").innerHTML=xmlhttp.responseText;
				}
			}

			// get url and GET
			var url="/EE101-Final_Project/Final_Project/search_advanced.php?page=1";
			var elements_boxes=$(".advanced_box");
			var i=0;
			var count=0;
			if(elements_boxes.length>=1)
			{
				var box_children=$(".advanced_box")[0].childNodes;
				url=url+"&bool1="+box_children[0].value+"&target1="+box_children[1].value+"&word1="+box_children[3].value.replace(/ /g, "+");
				for (i=1;i<=elements_boxes.length-1;i++)
				{
					box_children=$(".advanced_box")[i].childNodes;
					url=url+"&bool"+(i+1)+"="+box_children[0].value+"&target"+(i+1)+"="+box_children[2].value+"&word"+(i+1)+"="+box_children[4].value.replace(/ /g, "+");
				} 
				count=elements_boxes.length;
				// console.log(count);
				url=url+"&count="+count;
			}
			else
			{
				url=url+"&count=0";
			}
			console.log("search!:\n"+url);

			// request
			xmlhttp.open("GET",url, true);
			xmlhttp.send();
		}
	</script>
	
	<div class="advanced_ancestor">
		<!-- add -->
		<button onclick="show_boxes(1)" style="width: 50px;height: 50px;"></button>
		<!-- delete -->
		<button onclick="show_boxes(0)" style="width: 50px;height: 50px;"></button>
		<div id="advanced_boxes_root"></div>
		<!-- <form action="/EE101-Final_Project/Final_Project/search_advanced.php" target="_blank">
			<input type="hidden" id="submit_url" value="">
			<input type="submit" onclick="submit_search()" value="Search!">
		</form> -->
		<button onclick="submit_search()" style="width: 50px;height: 50px;">Search!</button>
		<div id="advanced_search_result"></div>
</body>
</html>
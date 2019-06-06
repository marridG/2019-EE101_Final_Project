<!DOCTYPE html> 
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/index_search_advanced.css">
<script type="text/javascript" src="/EE101-Final_Project/Final_Project/add-ons/jquery/jquery-3.4.0.min.js"></script>
<script src="/EE101-Final_Project/Final_Project/add-ons/01_Scroll_Page_to_Original.js"></script>

<head>
	<title>Advanced Search</title>
</head>

<body><!-- Advanced Search -->
<div onscroll="SetH(this)">
	<div id="advanced_search_head">
		<a href="/EE101-Final_Project/Final_Project/index.php"> <img src="/EE101-Final_Project/Final_Project/pics/phantom.png" id="acemap"></a>	
		<h1 id="test">Your Best Academia Database!</h1>
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
			
			// (1) show del_box button
			// (2) get url and GET
			var url="/EE101-Final_Project/Final_Project/add-ons/07_advanced_search_boxes.php?add_del="+add_del;
			var elements_boxes=$(".advanced_box");
			var i=0;

			// change delete_box button display status
				if(add_del=="1")
					document.getElementById("advanced_search_del_box").style.display="inline";
				else if(elements_boxes.length=="2")
					document.getElementById("advanced_search_del_box").style.display="none";

			// get url
				if(elements_boxes.length>=1)
				{
					var box_children=$(".advanced_box")[0].childNodes;
					// console.log(box_children);
					url=url+"&bool1="+box_children[0].value+"&target1="+box_children[1].value+"&word1="+box_children[3].value.replace(/ /g, "+");
					// console.log(box_children[3].value);
					// console.log(box_children[3].value=="");
					// console.log(box_children[3].value=="undefined");
					// console.log(!box_children[3].value);
					for (i=1;i<=elements_boxes.length-1;i++)
					{
						box_children=$(".advanced_box")[i].childNodes;
						url=url+"&bool"+(i+1)+"="+box_children[0].value+"&target"+(i+1)+"="+box_children[2].value+"&word"+(i+1)+"="+box_children[4].value.replace(/ /g, "+");
					} 
					var count=elements_boxes.length;
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

		function submit_search(page)
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
					var num_max=document.getElementById("advanced_search_result_num_max").value;
					var page_limit;
					var min_page;
					var max_page;
					var page_MAX;
					if(num_max!=0)
					{
						// alert("not null");
						page_limit=document.getElementById("advanced_search_result_page_limit").value;
						page_MAX=document.getElementById("advanced_search_result_page_MAX").value;
					}
					// if(page==1)
						turn_page(num_max,page_limit,page);
				}
			}

			// get url and GET
			var url="/EE101-Final_Project/Final_Project/add-ons/07_search_advanced.php?page="+page;
			var elements_boxes=$(".advanced_box");
			var i=0;
			if(elements_boxes.length>=1)
			{
				var box_children=$(".advanced_box")[0].childNodes;
				if(!box_children[3].value)
				{
					alert("Pleae fill in the 1-st blank.");
					return;
				}
				url=url+"&bool1="+box_children[0].value+"&target1="+box_children[1].value+"&word1="+box_children[3].value.replace(/ /g, "+");
				for (i=1;i<=elements_boxes.length-1;i++)
				{
					box_children=$(".advanced_box")[i].childNodes;
					url=url+"&bool"+(i+1)+"="+box_children[0].value+"&target"+(i+1)+"="+box_children[2].value+"&word"+(i+1)+"="+box_children[4].value.replace(/ /g, "+");
					// console.log(i+" "+box_children[4].value+" "+!box_children[4].value);
					// console.log("---END---")
					if(!box_children[4].value)
					{
						if(i+1==2)
							alert("Pleae fill in the 2-nd blank.");
						else if(i+1==3)
							alert("Pleae fill in the 3-rd blank.");
						else
							alert("Pleae fill in the "+(i+1)+"-th blank.");
						return;
					}
				} 
				var count=elements_boxes.length;
				// console.log(count);
				url=url+"&count="+count;
			}
			else
			{
				url=url+"&count=0";
			}
			// console.log("search!:\n"+url);

			// request
			xmlhttp.open("GET",url, true);
			xmlhttp.send();
		}

		function turn_page(num_max,page_limit,page)
		{
			var page_MAX;
			var min_page;
			var max_page;
			// Calculate page_MAX, min_page, max_page
				if(num_max%page_limit==0)
					page_MAX=num_max/page_limit;
				else
					page_MAX=Math.floor(num_max/page_limit)+1;
				if(num_max<=90)
				{
					min_page=1;
					if(num_max%page_limit==0)
						max_page=num_max/page_limit;
					else
						max_page=Math.floor(num_max/page_limit)+1;
				}
				else
				{
					min_page=page-5;
					while(min_page<1)
						min_page++;
					max_page=min_page+9;
					while((max_page-1)*page_limit>=num_max)
						max_page--;
					if(max_page-min_page+1<10)
						min_page=max_page-9;
				}
				
			// console.log(num_max,page_limit,page_MAX,min_page,max_page,page);
			if(num_max==0)
			{
				document.getElementById("advanced_search_result_turn_page").innerHTML="";
				return;
			}

			var xmlhttp;
			if (window.XMLHttpRequest)	//  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
				xmlhttp=new XMLHttpRequest();
			else	// IE6, IE5 浏览器执行代码
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("advanced_search_result_turn_page").innerHTML=xmlhttp.responseText;
				}
			}

			// get url and GET
			var url="/EE101-Final_Project/Final_Project/add-ons/07_advanced_search_pages.php?num_max="+num_max+"&page_limit="+page_limit+"&page_MAX="+page_MAX+"&min_page="+min_page+"&max_page="+max_page+"&page="+page;
			// console.log("page\n"+url);

			// request
			xmlhttp.open("GET",url, true);
			xmlhttp.send();
		}

		function jump_to_submit()
		{
			var new_page=document.getElementsByName("advanced_search_page")[0].value;
			console.log(new_page);
			if(!new_page)
			{
				alert("Please enter the new page number.");
				return;
			}
			submit_search(new_page);
		}
	</script>
	
	<div class="advanced_ancestor">
		<div id="advanced_ancestor_margin"></div>
		<br><br><br><br><br><br><br><br>
		<!-- boxes -->
		<div id="advanced_boxes_root">
			<!-- initial box -->
			<div class="advanced_box">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;
				<select id="advanced_search_target_select">
					<option value ="Title" selected>Title</option>
					<option value ="Authors_Name">Author</option>
					<option value ="ConferenceName">Conference</option>
				</select>
				&nbsp;
				<input type="text" id="advanced_search_word_input_text" required>
			</div>
		</div>
		<!-- add -->
		<button id="advanced_search_add_box" onclick="show_boxes(1)">+</button>
		<!-- delete -->
		<button id="advanced_search_del_box" onclick="show_boxes(0)">-</button>
		
		<!-- submit -->
		<br><br>
		<button id="advanced_search_submit" onclick="submit_search(1)">Search!</button>
	</div>
	<div id="advanced_search_result_ancestor">
	<!-- result -->
		<br><br><br>
		<div id="advanced_search_result"></div>
		<!-- turn page -->
		<div id="advanced_search_result_turn_page"></div>
	</div>
</div>
</body>
</html>
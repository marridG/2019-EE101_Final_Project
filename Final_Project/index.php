<html>
<meta charset="utf-8">

<head>
	<img src="/EE101-Final_Project/Final_Project/pics/acemap.png" class="head_pic">
	<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/46818/5cecf0ccf629d80af8efaac8.css' rel='stylesheet' type='text/css' />

	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>

</head>

<body class="body__homepage">
	<h2 class="h1">Best Academia Searching For You!</h1>

	<form action="/EE101-Final_Project/Final_Project/search.php" target="_blank">	
	 	<input type="hidden" name="page_title" value="1">
		<input type="hidden" name="page_author" value="1">
		<input type="hidden" name="page_conference" value="1">
		Paper Title:<br>
			<input class="input_button" type="text" id="1_PT" name="paper_title" placeholder="Not Required">
		<br>
		Author Name:<br>
			<input class="input_button" type="text" id="2_AN" name="author_name" placeholder="Not Required">
		<br>
		Conference Name:<br>
			<input class="input_button" type="text" id="3_CN" name="conference_name" placeholder="Not Required">
		<br>
		
		<!-- * Please notice that at least one information above should be given.
		<br><br> -->
		
		<br>
		<input type="submit" value="SEARCH">
		<!-- <input type="reset" onclick="clear()" value="CLEAR"> -->
		<br><br>
		<input type="reset" value="RESET">
	</form>

	<!-- <?php
		echo "<input type=\"reset\" onclick=clear() value=\"CLEAR\">";
	?> -->

</body>

</html>

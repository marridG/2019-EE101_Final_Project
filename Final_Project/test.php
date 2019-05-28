<html>
<meta charset="utf-8">

<head>
	<img src="/EE101-Final_Project/Final_Project/pics/acemap.png" class="head_pic">
	<style type="text/css">
		background-image: url("/EE101-Final_Project/Final_Project/pics/cover1.jpg");
		

	</style>
	<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/28831/5cecf17cf629d80af8efaaca.css' rel='stylesheet' type='text/css' />
	

	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>

</head>

<body class="body__homepage">
	<h6 class="h1">Best Academia Searching For You!</h6>

	<form action="/EE101-Final_Project/Final_Project/search.php" target="_blank">	
	 	<input type="hidden" name="page_title" value="1">
		<input type="hidden" name="page_author" value="1">
		<input type="hidden" name="page_conference" value="1">
		Paper Title:<br><br>
			<input class="input_button" type="text" id="1_PT" name="paper_title" placeholder="Not Required">
		<br><br>
		Author Name:<br><br>
			<input class="input_button" type="text" id="2_AN" name="author_name" placeholder="Not Required">
		<br><br>
		Conference Name:<br><br>
			<input class="input_button" type="text" id="3_CN" name="conference_name" placeholder="Not Required">
		<br>
		
		<!-- * Please notice that at least one information above should be given.
		<br><br> -->
		
		<br>
		<input class="input_button"  type="submit" value="SEARCH" > 	
		&ensp;
		&ensp;
		&ensp;
		<input  class="input_button" type="reset" value="RESET">
     
		<!-- <input type="reset" onclick="clear()" value="CLEAR"> -->
	</form>

	<!-- <?php
		echo "<input type=\"reset\" onclick=clear() value=\"CLEAR\">";
	?> -->

</body>

</html>

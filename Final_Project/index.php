<!DOCTYPE html> 
<html>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
<head>
<!-- Dependent Packages -->
	<script src="/EE101-Final_Project/Final_Project/add-ons/jquery/jquery-3.4.0.min.js"></script>

	<img src="/EE101-Final_Project/Final_Project/pics/acemap.png" class="head_pic">
	
<!-- Project Size CSS File -->
	<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/45817/5cecef5bf629d80af8efaac6.css' rel='stylesheet' type='text/css' />
<!-- 	ChannelSlanted2的link -->
	<link href='http://cdn.webfont.youziku.com/webfonts/nomal/129558/28831/5cecf17cf629d80af8efaaca.css' rel='stylesheet' type='text/css' />
	
<!-- Clear Input Form (Under Construction) -->
	<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/add-ons/04_Clear_Input_Form.css">
	
<!-- Test -->
	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>

</head>

<body class="body__homepage">
	<h6 class="h1">Best Academia Searching For You!</h6>

	<form action="/EE101-Final_Project/Final_Project/search.php" target="_blank">	
	 	<input type="hidden" name="page" value="1">
		
		<input class="input_button" type="text" id="key_word" name="key_word" placeholder="Not Required">
		
		<!-- * Please notice that at least one information above should be given.
		<br><br> -->
	
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

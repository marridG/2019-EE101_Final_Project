<html>
<meta charset="utf-8">

<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="/EE101-Final_Project/Final_Project/simple-.css">
	<script src="/EE101-Final_Project/Final_Project/add-ons/02_Clear_Form.js"></script>
</head>

<body class="body__homepage">
	<h1>Homepage</h1>

	<form action="/EE101-Final_Project/Final_Project/search.php" target="_blank">	
		<input type="hidden" name="page_title" value="1">
		<input type="hidden" name="page_author" value="1">
		<input type="hidden" name="page_conference" value="1">
		Paper Title:<br>
			<input type="text" id="1_PT" name="paper_title" placeholder="Not Required">
		<br><br>
		Author Name:<br>
			<input type="text" id="2_AN" name="author_name" placeholder="Not Required">
		<br><br>
		Conference Name:<br>
			<input type="text" id="3_CN" name="conference_name" placeholder="Not Required">
		<br>
		
		<!-- * Please notice that at least one information above should be given.
		<br><br> -->
		
		<br>
		<input type="reset" value="RESET">
		<!-- <input type="reset" onclick="clear()" value="CLEAR"> -->
		<br><br><br>
		<input type="submit" value="I'm Feeling Lucky~">
	</form>

	<!-- <?php
		echo "<input type=\"reset\" onclick=clear() value=\"CLEAR\">";
	?> -->

</body>

</html>

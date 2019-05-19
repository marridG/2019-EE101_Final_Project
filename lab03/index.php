<html>
<meta charset="utf-8">

<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="/lab03/simple-.css">
	<script src="/lab03/add-ons/02_Clear_Form.js"></script>
<!-- 
	php 值传递
	http://www.cnblogs.com/yangwenxin/p/5825511.html -->

</head>

<body class="homepage_body">
	<h1>Homepage</h1>

	<form action="/lab03/search.php">	
		Paper Title:<br>
			<input type="text" id="1_PT" name="paper_title" placeholder="Not Required">
		<br><br>
		Author Name:<br>
			<input type="text" id="2_AN" name="author_name" placeholder="Not Required">
		<br><br>
		Conference Name:<br>
			<input type="text" id="3_CN" name="conference_name" placeholder="Not Required">
		<br>
		
<!-- 		* Please notice that at least one information above should be given.
		<br><br> -->
		
	<?php
		session_start();
		$page_title = 0;
		$page_author_name = 0;
		$page_conference = 0;
		$_SESSION['page_title'] = $page_title;
		$_SESSION['page_author_name'] = $page_author_name;
		$_SESSION['page_conference'] = $page_conference;
	 ?>

		<!-- [Advanced] Start Page of Results for:<br>
		<table border="0" align=center>
			<tr>
				<td>Paper Title:</td>
				<td><input type="text" name="page_title" size="3" value=0></td>
			</tr>
			<tr>
				<td>Author Name:</td>
				<td><input type="text" name="page_author_name" size="3" value=0></td>
			</tr>
			<tr>
				<td>Conference Name:</td>
				<td><input type="text" name="page_conference" size="3" value=0></td>
			</tr>
		</table> -->
		<!-- <input type="reset" value="RESET"> -->
		<br>
		<input type="reset" onclick="clear()" value="CLEAR">
		<br><br><br>
		<input type="submit" value="I'm Feeling Lucky~">
	</form>

<!-- 	<?php
		echo "<input type=\"reset\" onclick=clear() value=\"CLEAR\">";
	?> <--></-->

</body>

</html>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	
	<?php 
		$name=$_GET["name"];
		$address=$_GET["address"];
		$word=$_GET["word"];

		// var_dump($name);
		// var_dump($address);
		// var_dump($word);
		// echo "node 07_mail_to.js \"".$name."\" ".$address." \"".$word."\"";
		print(exec('cd C:\xampp\htdocs\EE101-Final_Project\Final_Project\add-ons'));
		exec("node 07_mail_to.js \"".$name."\" ".$address." \"".$word."\"");
	 ?>

</body>
</html>
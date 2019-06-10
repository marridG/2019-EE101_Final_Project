<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	
	<?php 
		$name=$_GET["name"];
		$address=$_GET["address"];
		$subject=$_GET["subject"];
		$word=$_GET["word"];

		// acuqire the time
		date_default_timezone_set('PRC');
		$time=date('Y-m-d H:i:s', time());

		$log="=== UTC/GMT+08:00 ".$time." ===\r\nName: ".$name."\r\nEmail Address: ".$address."\r\nSubject: ".$subject."\r\nFeedback: ".$word."\r\n";
		$log_end="******** END ********\r\n\r\n";
		$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
		$fp = fopen("$DOCUMENT_ROOT/EE101-Final_Project/Final_Project/feedback/feedback.txt",'a');	// append content to file
		fwrite($fp,$log.$log_end);
		fclose($fp);

		// var_dump($name);
		// var_dump($address);
		// var_dump($word);
		// echo "node 07_mail_to.js \"".$name."\" ".$address." \"".$word."\"";
		print(exec('cd C:\xampp\htdocs\EE101-Final_Project\Final_Project\add-ons'));
		exec("node 07_mail_to.js \"".$name."\" ".$address." \"UTC/GMT+08:00<br>".date("Y-m-d")."\"");
	 ?>

</body>
</html>
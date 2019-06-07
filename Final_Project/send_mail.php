<!DOCTYPE html> 
<html>
<meta charset="utf-8">

<head>
	<title>Send_Mail</title>
	<!-- Dependent Packages -->
	<script src="/EE101-Final_Project/Final_Project/add-ons/jquery/jquery-3.4.0.min.js"></script>

</head>

<body>
	
	<script type="text/javascript">
		function send_mail()	// change show boxes request
		{
			send_mail_btn=$("#send_mail")[0];
			send_mail_btn.disabled = 'disabled';
			var xmlhttp;
			if (window.XMLHttpRequest)	//  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
				xmlhttp=new XMLHttpRequest();
			else	// IE6, IE5 浏览器执行代码
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					// document.getElementById("advanced_search_result_turn_page").innerHTML=xmlhttp.responseText;
					alert("ok");
					send_mail_btn.disabled = '';
					send_mail_btn.innerHTML="send mail";
				}
			}
			
			var address=$("#send_mail_address")[0].value;
			if(!address)
			{
				alert("Please fill in your address.");
				send_mail_btn.disabled = '';
				return;
			}
			else
				send_mail_btn.innerHTML="sending...";
			var url="/EE101-Final_Project/Final_Project/add-ons/07_mail_to.php?name=John+smith&address="+address+"&word=I+think+that";
			
			// request
				xmlhttp.open("GET",url, true);
				xmlhttp.send();
		}
	</script>

	<input type="text" id="send_mail_address">
	<button onclick="send_mail()" id="send_mail">send mail</button>

</body>

</html>
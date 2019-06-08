var arguments = process.argv.splice(2);
// console.log('所传递的参数是：', arguments);

// console.log(arguments[0]);	// name
// console.log(arguments[1]);	// address
// console.log(arguments[2]);	// word

// //////////////////////////
// // print process.argv
// process.argv.forEach(function (val, index, array) {
//   console.log(index + ': ' + val);
// });

// // QQ Mail
// 	var email   = require("./nodejs/node_modules/emailjs");
// 	var server  = email.server.connect({
// 	    user:    "2674288007@qq.com",
// 	    password:"hibfghedzfpvdjed",
// 	    host:    "smtp.qq.com",
// 	    ssl:     true                   // using ssl
// 	});

// 	console.log(server);
// 	//开始发送邮件
// 	server.send({
// 	    text:    arguments[0]+": Thanks for your advice.",       // Content
// 	    from:    "2674288007@qq.com",        // From
// 	    to:      arguments[1],       // To
// 	    subject: "Phantom: Thanks for contact."
// 	}, function(err, message) {
// 	    //回调函数
// 	    console.log(err || message);
// 	});


// SJTU Mail
	var email   = require("./nodejs/node_modules/emailjs");
	var server  = email.server.connect({
	    user:    "marridG@sjtu.edu.cn",
	    password:"****",
	    host:    "smtp.sjtu.edu.cn",
	    ssl:     true                   // using ssl
	});

	heading=arguments[0]+": <br><br>";
	body="Greetings.<br><br>Thanks for your precious advice. We will contact you soon.<br><br><br>";
	breaker="<hr style=\"width:200px; margin:0 0 0 0;\"";
	signature="Best wishes,<br>Phantom Operations Group<br>"+arguments[2];
	// console.log(server);
	//开始发送邮件
	server.send({
	    text:    heading+body+breaker+signature,       // Content
	    from:    "marridG@sjtu.edu.cn",        // From
	    to:      arguments[1],       // To
	    subject: "Phantom: Thanks for Your Feedback.",
	    attachment:
	    [
	    	{data:"<html>"+heading+body+breaker+signature+"</html>",alternative:true}
	    ]
	}, function(err, message) {
	    //回调函数
	    console.log(err || message);
	});

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

	console.log(server);
	//开始发送邮件
	server.send({
	    text:    arguments[0]+": Thanks for your advice.",       // Content
	    from:    "marridG@sjtu.edu.cn",        // From
	    to:      arguments[1],       // To
	    subject: "Phantom: Thanks for contact."
	}, function(err, message) {
	    //回调函数
	    console.log(err || message);
	});

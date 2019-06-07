var arguments = process.argv.splice(2);
console.log('所传递的参数是：', arguments);

// console.log(arguments[0]);	// name
// console.log(arguments[1]);	// address
// console.log(arguments[2]);	// word

// //////////////////////////
// // print process.argv
// process.argv.forEach(function (val, index, array) {
//   console.log(index + ': ' + val);
// });

// QQ Mail
	var email   = require("./nodejs/node_modules/emailjs");
	var server  = email.server.connect({
	    user:    "2674288007@qq.com",      // 你的QQ用户
	    password:"hibfghedzfpvdjed",           // 注意，不是QQ密码，而是刚才生成的授权码
	    host:    "smtp.qq.com",         // 主机，不改
	    ssl:     true                   // 使用ssl
	});

	console.log(server);
	//开始发送邮件
	server.send({
	    text:    arguments[0]+": Thanks for your advice.",       //邮件内容
	    from:    "2674288007@qq.com",        //谁发送的
	    to:      arguments[1],       //发送给谁的
	    subject: "Phantom: Thanks for contact."          //邮件主题
	}, function(err, message) {
	    //回调函数
	    console.log(err || message);
	});

// // Gmail
// 	var email   = require("./nodejs/node_modules/emailjs");
// 	var server  = email.server.connect({
// 	    user:    "arealier@gmail.com",      // 你的QQ用户
// 	    password:"****",           // 注意，不是QQ密码，而是刚才生成的授权码
// 	    host:    "smtp.gmail.com",         // 主机，不改
// 	    ssl:     true                   // 使用ssl
// 	});

// 	console.log(server);
// 	//开始发送邮件
// 	server.send({
// 	    text:    arguments[0]+": Thanks for your advice.",       //邮件内容
// 	    from:    "arealier@gmail.com",        //谁发送的
// 	    to:      arguments[1],       //发送给谁的
// 	    subject: "Phantom: Thanks for contact."          //邮件主题
// 	}, function(err, message) {
// 	    //回调函数
// 	    console.log(err || message);
// 	});
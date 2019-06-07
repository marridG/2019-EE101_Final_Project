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
	    text:    "邮件内容",       //邮件内容
	    from:    "2674288007@qq.com",        //谁发送的
	    to:      "marridG@sjtu.edu.cn",       //发送给谁的
	    subject: "邮件主题"          //邮件主题
	}, function(err, message) {
	    //回调函数
	    console.log(err || message);
	});
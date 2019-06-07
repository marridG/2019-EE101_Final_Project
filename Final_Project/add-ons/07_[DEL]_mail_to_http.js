// var http = require('http');
// http.createServer(function (req, res) {
//     res.writeHead(200, {'Content-Type': 'text/plain'});
//     res.end('Hello World\n');
// }).listen(1337, "127.0.0.1");
// console.log('Server running at http://127.0.0.1:1337/');

//引入http模块
var http=require('http');
//2.使用http模块创建一个服务
var server=http.createServer(function(req,res){//请求，响应
  console.log('开启服务');
  //响应有两个方法
  res.write('succ');//响应的内容
  res.end();//响应结束
});
//3.监听一个端口号（需要打开xampp服务）
server.listen(8080);
//4.打开浏览器输入127.0.0.1:8080，同时在window+r--cmd中执行server.js文件

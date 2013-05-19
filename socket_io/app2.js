var http    =   require('http');
var fs      =   require('fs');
var net     =   require('net');
var io      =   require('socket.io');
var express =   require('express');

var HOST = '127.0.0.1';
var PORT = 6969;

var client = new net.Socket();

client.connect(PORT, HOST, function() {
	console.log('CONNECTED TO: ' + HOST + ':' + PORT);
});

/*var app = http.createServer(function (req, res) {
    fs.readFile('./app2.html', 'utf-8', function(error, content) {
        res.writeHead(200, {'Content-Type' : 'text/html'});
        res.end(content);
    });
});
*/

var exp = express();
var app = http.createServer(exp);
exp.use(express.static(__dirname + '/public'));
exp.get('/', function (req, res) {
  res.sendfile(__dirname + '/app2.html');
});

io = io.listen(app); 

//client connect
io.sockets.on('connection', function (socket) {

    client.on('data', function(data) {
		socket.emit('getNew', {'message' : data.toString() });
	});
	
    socket.on('postNew', function (message) {
        client.write(message.message);
        socket.broadcast.emit('getNew', {'message' : message.message });
    });
    
});

app.listen(8080);
console.log('Server running at http://localhost:8080/');

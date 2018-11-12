var express = require('express');
var app = express();
var path = require('path');
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var redis = require('socket.io-redis');
var cluster  = require('cluster');
var port = process.env.PORT || 9090;
var serverName = process.env.NAME || 'Unknown';

// io.adapter(redis({ host: 'localhost', port: 6379 }));

// server.listen(port, function () {
//   console.log('Server listening at port %d', port);
//   console.log('Hello, I\'m %s, how can I help?', serverName);
// });

// app.use(express.static(path.join(__dirname, 'public')));


// // creating namespace called track_provider on socket server
// var trackProvider = io.on('connection', function (clientSocket) {
//     // requesting to join a room in namespace then send to all in room that new member joined
//     clientSocket.on('joining', (roomName, fn) => {
//         clientSocket.join(roomName, () => {
//             trackProvider.to(roomName).emit('toEveryOneOnRoom', 'new member joined to room');
//         });
//         // call back function to current member that he joined
//         fn('you have joined room number: ' + roomName + '  with id: ' + clientSocket.id);

//         clientSocket.on('sending-provider-location', (roomName, locationJson, fn) => {
//             trackProvider.to(roomName).emit('current-provider-location', locationJson);
//             fn('location has been sent.');
//         });
//     });
//     // on leaving the room
//     clientSocket.on('leaving', (roomName, fn) => {
//         clientSocket.leave(roomName, () => {
//             trackProvider.to(roomName).emit('toEveryOneOnRoom', clientSocket.id + ' leaved the room');
//         });
//         fn('you have leaved room number: ' + roomName);
//     });
//     // on disconnecting from server
//     clientSocket.on('disconnect', (reason) => {
//         setTimeout(() => {
//             clientSocket.broadcast.emit('toEveryOneOnServer', clientSocket.id + ' disconnected for ' + reason);
//             clientSocket.disconnect(true);
//         }, 5000);
//     });
//     console.log('New one is connected');
// });
// console.log('your on port ' + port);

var cluster  = require('cluster'), _portSocket  = 8080, _portRedis   = 6379, _HostRedis   = 'localhost';

if (cluster.isMaster) {	
	var server = require('http').createServer(), socketIO = require('socket.io').listen(server), redis = require('socket.io-redis');	
	socketIO.adapter(redis({ host: _HostRedis, port: _portRedis }));
	
	var numberOfCPUs = require('os').cpus().length;
	for (var i = 0; i < numberOfCPUs; i++) {
		cluster.fork();		
	}
	
	cluster.on('fork', function(worker) {
        console.log('Travailleur %s créer', worker.id);
    });
    cluster.on('online', function(worker) {
         console.log('Travailleur %s en ligne', worker.id);
    });
    cluster.on('listening', function(worker, addr) {
        console.log('Travailleur %s écoute sur %s:%d', worker.id, addr.address, addr.port);
    });
    cluster.on('disconnect', function(worker) {
        console.log('Travailleur %s déconnecter', worker.id);
    });
    cluster.on('exit', function(worker, code, signal) {
        console.log('Travailleur %s mort (%s)', worker.id, signal || code);
        if (!worker.suicide) {
            console.log('Nouveau travailleur %s créer', worker.id);
            cluster.fork();
        }
    });
}

if (cluster.isWorker) {	

	var http = require('http');
	
	http.globalAgent.maxSockets = Infinity;	
	
	var app = require('express')(), ent = require('ent'), fs  = require('fs'), server = http.createServer(app).listen(_portSocket), socketIO = require('socket.io').listen(server), redis = require('socket.io-redis');
	
	socketIO.adapter(redis({ host: _HostRedis, port: _portRedis }));
	
	app.get('/', function (req, res) { res.emitfile(__dirname + '/interface.php');});
	
	socketIO.sockets.on('connection', function(socket, pseudo) {

		socket.setNoDelay(true);
		
		socket.on('nouveau_client', function(pseudo) {
			pseudo = ent.encode(pseudo);			
			socket.pseudo = pseudo;
			try {
				socket.broadcast.to(socket.room).emit('nouveau_client', pseudo);
			} catch(e) {
				socket.to(socket.room).emit('nouveau_client', pseudo);
			}
			console.log('L\'utilisateur : '+socket.pseudo+' s\'est connecter');
		});	

		socket.on('message', function(data) {
			socket.broadcast.to(socket.room).emit('dispatch', data);
		});	

		socket.on('exit', function(data) { socket.close();});
		
		socket.on('room', function(newroom) {
			socket.room = newroom;
			socket.join(newroom);	
			console.log('Le membre '+socket.pseudo+' a rejoint le domaine '+socket.room);
			socket.broadcast.to(socket.room).emit('dispatch', 'L\'utilisateur : '+socket.pseudo+' a rejoint le domaine : '+socket.room);
		});
	});
	
}

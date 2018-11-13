var express = require('express');
var app = express();
var path = require('path');
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var redis = require('socket.io-redis');
var port = process.env.PORT || 9090;
var serverName = process.env.NAME || 'Unknown';

io.adapter(redis({ host: 'localhost', port: 6379 }));

server.listen(port, function () {
  console.log('Server listening at port %d', port);
  console.log('Hello, I\'m %s, how can I help?', serverName);
});

app.use(express.static(path.join(__dirname, 'public')));


// creating namespace called track_provider on socket server
var trackProvider = io.on('connection', function (clientSocket) {
    // requesting to join a room in namespace then send to all in room that new member joined
    clientSocket.on('joining', (roomName, fn) => {
        clientSocket.join(roomName, () => {
            trackProvider.to(roomName).emit('toEveryOneOnRoom', 'new member joined to room');
        });
        // call back function to current member that he joined
        fn('you have joined room number: ' + roomName + '  with id: ' + clientSocket.id);

        clientSocket.on('sending-provider-location', (roomName, locationJson, fn) => {
            trackProvider.to(roomName).emit('current-provider-location', locationJson);
            fn('location has been sent.');
        });
    });
    // on leaving the room
    clientSocket.on('leaving', (roomName, fn) => {
        clientSocket.leave(roomName, () => {
            trackProvider.to(roomName).emit('toEveryOneOnRoom', clientSocket.id + ' leaved the room');
        });
        fn('you have leaved room number: ' + roomName);
    });
    // on disconnecting from server
    clientSocket.on('disconnect', (reason) => {
        setTimeout(() => {
            clientSocket.broadcast.emit('toEveryOneOnServer', clientSocket.id + ' disconnected for ' + reason);
            clientSocket.disconnect(true);
        }, 5000);
    });
    console.log('New one is connected');
});
console.log('your on port ' + port);

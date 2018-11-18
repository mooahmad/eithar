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
            var now = new Date().getDay + '-' +new Date().getMonth + '-' + new Date().getFullYear+ ' ' +new Date().getHours() + ':' + new Date().getMinutes + ':' +new Date().getSeconds;
            trackProvider.to(roomName).emit('toEveryOneOnRoom', 'new member joined to room' + roomName + 'at ' + now);
            console.log(clientSocket.id + ' joined to room' + roomName + 'at ' + now);
        });
        // call back function to current member that he joined
        if(fn)
        fn('you have joined room number: ' + roomName + '  with id: ' + clientSocket.id);

        clientSocket.on('sending-provider-location', (roomName, locationJson, fn) => {
            var now = new Date().getDay + '-' +new Date().getMonth + '-' + new Date().getFullYear+ ' ' +new Date().getHours() + ':' + new Date().getMinutes + ':' +new Date().getSeconds;
            trackProvider.to(roomName).emit('current-provider-location', locationJson);
            if(fn)
            fn('location '+ JSON.stringify(locationJson) + ' has been sent at ' + now );
            console.log(clientSocket.id + ' location '+ JSON.stringify(locationJson) + ' has been sent at ' + now);
        });
    });
    // on leaving the room
    clientSocket.on('leaving', (roomName, fn) => {
        clientSocket.leave(roomName, () => {
            trackProvider.to(roomName).emit('toEveryOneOnRoom', clientSocket.id + ' leaved the room');
        });
        if(fn)
        fn('you have leaved room number: ' + roomName);
        console.log(clientSocket.id + ' have leaved room number: ' + roomName);
    });
    // on disconnecting from server
    clientSocket.on('disconnect', (reason) => {
        setTimeout(() => {
            clientSocket.broadcast.emit('toEveryOneOnServer', clientSocket.id + ' disconnected for ' + reason);
            clientSocket.disconnect(true);
        }, 1000);
    });
    console.log('New one is connected');
});
console.log('your on port ' + port);

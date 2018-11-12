const express = require('express')();
const app = require('http').Server(express);
const io = require('socket.io')(app, {
    serveClient: true,
    cookie: true,
    transports: ['websocket']
  });
const redisAdapter = require('socket.io-redis');
io.adapter(redisAdapter({ host: 'localhost', port: 6379 }));
const prodPort = 9090;
const devPort = 9090;
const testPort = 9090;
var port = devPort;
process.argv.forEach(function (val, index, array) {
    if (val === "-prod")
        port = prodPort;
    if (val === "-test")
        port = testPort;
});
app.listen(port, '0.0.0.0');
io.attach(app);


// creating namespace called track_provider on socket server
var trackProvider = io.of('/track_provider').on('connection', function (clientSocket) {
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
    clientSocket.on('message', function (msg) {
        clientSocket.send(msg);
     });
});
console.log('your on port ' + port);

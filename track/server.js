var express = require('express');
var app = require('http').createServer(express);
var io = require('socket.io')(app);
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
});
console.log('your on port ' + port);

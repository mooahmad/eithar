const Koa = require('koa')
const koaStatic = require('koa-static')
const ClusterWS = require('clusterws')

// Create ClusterWS with 2 workers (why 2 just for this example usually you will get amount of cpus)
var cws = new ClusterWS({
    worker: Worker,
    workers: 10,
    host: '0.0.0.0',
    port: process.env.PORT || 9090
})

// Our worker code
function Worker() {
    const socketServer = this.server
    const httpServer = this.wss

    // Koa logic
    var app = new Koa()
    app.use(koaStatic('public'))
    
    // Connect ClusterWS http handler and Koa module
    httpServer.on('request', app.callback())

    // Socket part (listen on connection to the socket)
    var trackProvider = socketServer.of('/track_provider').on('connection', function (clientSocket) {
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
}
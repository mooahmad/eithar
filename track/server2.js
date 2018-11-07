const Koa = require('koa')
const koaStatic = require('koa-static')
const ClusterWS = require('clusterws')

// Create ClusterWS with 2 workers (why 2 just for this example usually you will get amount of cpus)
var cws = new ClusterWS({
    worker: Worker,
    workers: 2,
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
    socketServer.on('connection', (socket) => {
        // On connection publish message that user is connected to everyone who is subscribed to chat channel
        
        // On disconnect  send everyone that user is disconnected
        socket.on('disconnect', () => {
            socketServer.publish('chat', { id: 'global', text: 'User is disconnected' })
        })
    })
}
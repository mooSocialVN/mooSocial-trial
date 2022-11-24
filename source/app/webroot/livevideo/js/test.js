// Setup basic express server

const express = require('express');
var cors = require('cors');
const app = express();
//const server = require('http').createServer(app);
const config = require("./mooConfig");


// For https
/*
var fs = require('fs');
var privateKey = fs.readFileSync( '/private/etc/apache2/server.key' );
var certificate = fs.readFileSync( '/private/etc/apache2/server.crt');

var server = require('https').createServer({
    key: privateKey,
    cert: certificate,
    //password:123456
}, app)
*/
// End For https

// For https GoDaddy SSL certs
/* Note: Node requires each certificate in the CA chain to be passed separately in an array
 * GoDaddy provides a cerficate file (gd_bundle.crt) probably looks like this
 * -----BEGIN CERTIFICATE-----
 * MIIE3jCCA...
 * -----END CERTIFICATE-----
 * -----BEGIN CERTIFICATE-----
 * MIIEADCCA...
 * -----END CERTIFICATE-----
 * Each certificate needs to be put in its own file (ie gd1.crt and gd2.crt) and read separately
*/
var fs = require('fs');
var server = require('https').createServer({
    key: fs.readFileSync('/etc/httpd/ssl/socialloft.key'),
    cert: fs.readFileSync('/etc/httpd/ssl/735ff4861e4de73d.crt'),
    ca: [fs.readFileSync('/etc/httpd/ssl/gd_bundle-g2-g1.crt')]
}, app)
app.use(cors());
// End For https GoDaddy SSL certs
const io = require('socket.io')(server);

if (config.isEnableRedis()){
    io.adapter(config.getRedisAdapter());
}

const port = process.env.PORT || 3100;

const mooEmitter = require('./mooEmitter');
const mooSocket = require('./mooSocket');
const mooNotification = require('./mooNotification');
mooNotification.setIO(io);

const auth = require("./mooAuth");
const user = require('./user/mooUser');
const log = require("./mooLog");

const booting = require("./mooBooting");



// Router
app.get('/',function(req,res){
    res.json("Chat server is running");
});

app.get('/refreshUserRole.json',require("./controller/refreshUserRole").index);
app.get('/refreshFriendList.json',require("./controller/refreshFriendList").index);
app.get('/removeCacheDbUser.json',require("./controller/removeCacheDbUser").index);
app.get('/refreshConfig.json',require("./controller/refreshConfig").index);
// Socket
require('./mooConfig').getMooConfig(async function (host, login, password, database, prefix, sourceSql, mysqlPort,salt) {
    // Setup moosocial integration
    require("./mooDB").config(host, login, password, database, prefix, sourceSql, mysqlPort);
    //require("./mooBooting").run();
    await booting.run();
    mooEmitter.emit('mooConfigSuccess',host, login, password, database, prefix, sourceSql, mysqlPort,io,salt,app);
    server.listen(port, function () {

        log.info(`Server listening at port ${port}` );

    });

// Routing
    app.use(express.static(__dirname + '/public'));


    io.on('connection', async function (socket) {
        // Hacking for all "on" event to make sure the socked is authenticated
        socket.isLogged = false;
        socket.userId = 0;
        socket.myFriendsId = [];
        socket.myBlockersId = [];
        socket.roomsId = {actived: []};
        var onevent = socket.onevent;

        socket.onevent = function (packet) {
            console.log("event ",packet.data[0],socket.userId)
            if (socket.isLogged) {
                //console.log(packet.data[0],packet.data)
                onevent.call(this, packet);
            }else{
                if(packet.hasOwnProperty('data')){
                    if (packet.data instanceof Array) {

                        if(packet.data.length > 0){

                            switch(packet.data[0]) {
                                case 'ping':
                                case 'getServerInfo':
                                case 'getMonitorMessages':
                                case 'getUsers':
                                case 'getRooms':
                                case 'authViaPassword':
                                case 'authViaToken':
                                case 'authRefreshToken':
                                case 'saveFcmTokenStatus':
                                    onevent.call(this, packet);
                                    break;
                                default:

                            }
                        }
                    }



                }
            }

        };
        // End hacking

        await auth.execute(socket);

        socket.on("ping", function () {
            console.log('pingggggggggggggggggggggggggggggggggggggggggggggg');
            mooEmitter.emit('pong');
        });

        socket.on("authViaPassword", function (email,pass,device_id) {
            auth.viaPassword(this,email,pass,salt,device_id);
        });
        socket.on("authViaToken", function (accessToken,device_id) {
            auth.viaToken(this,accessToken,device_id);
        });
        socket.on("authRefreshToken", function (refreshToken,device_id) {
            auth.refreshToken(this,refreshToken,device_id);
        });
        user.init(io);
        mooEmitter.emit('io_connection',io,socket);

        // User init
        socket.on("getUsersOnline", function (ids) {
            user.getUsersOnline(this,ids);
        });
        socket.on("getMyFriendsOnline", function () {
            user.getMyFriendsOnline(this);
        });
        socket.on("getMyFriends", function (ids) {
            user.getMyFriendsLimit(this,ids);
        });
        socket.on("getUsers", function (ids) {
            user.getUsers(this,ids);
        });
        socket.on("getUsersByRoomIdsAtBooting", function (rIds) {
            user.getUsersInRooms(this,rIds);
        });

        socket.on("setOffline", function () {
            user.setOffline(this);
        });
        socket.on("setOnline", function () {
            user.setOnline(this);
        });

        socket.on("getUserMe", function () {
            user.getUserMe(this);
        });

        socket.on("searchFriend", function (name) {
            user.searchFriend(this,name);
        });
        socket.on("changeUserOnlineStatus", function (status) {
            user.changeUserOnlineStatus(this,status);
        });
        socket.on("stunTurnServer", function (token) {
            mooNotification.stunTurnServer(this, token);
        });
        // End user init

        // when` the user disconnects.. perform this
        socket.on('disconnect', function () {
            mooEmitter.emit('io_disconnect',io,socket);
            mooSocket.removeCallBySocket(socket.id);

            var userId = socket.userId;

            mooSocket.sub1FromNumberUsersSocket(userId,socket.device_id).then(function () {
                setTimeout(function () {
                    mooSocket.isUserLatestConnecting(socket).then(function (right) {
                        if (right) {
                            mooNotification.imOffline(userId);
                            // Hacking for display all users
                            //user.imOffline(userId);
                            // End hacking
                        }
                    });

                }, 1100);
            });
        });


    });
});



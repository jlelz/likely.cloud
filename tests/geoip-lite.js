var ip;

var http = require('http');

var geoip = require('geoip-lite');

http.createServer(function (req, res) {

    if (req.headers['x-forwarded-for']) {

        ip = req.headers['x-forwarded-for'].split(",")[0];

    } else if (req.connection && req.connection.remoteAddress) {

        ip = req.connection.remoteAddress;

    } else {

        ip = req.ip;

    }

    var geo = geoip.lookup(ip);

    res.writeHead(200, {'Content-Type': 'text/plain'});

    res.end(JSON.stringify(geo));

    console.log(geo);
    
}).listen(50451);

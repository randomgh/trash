import express from 'express';
import cors from 'cors';
import http from 'http';
import bodyParser from 'body-parser';
import helmet from 'helmet';
import dotenv from 'dotenv';

import webhook from './webhook';

dotenv.config();

const app = express();

app.set('port', normalizePort(process.env.PORT || 80));

app.use(helmet());

app.use(cors({ origin: true }));

// TODO: Set allowed origins

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    next();
});

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use(webhook({
    project: process.env.PROJECT,
    secret: process.env.SECRET
}));

app.use((req, res) => {
    res.status(404).send({
        error: {},
        message: 'Not found'
    });
});

app.use((err, req, res) => {
    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};

    res.status(err.status || 500).send({
        error: err || {},
        message: err.message || 'Server error'
    });
});

const server = http.createServer(app).listen(app.get('port'), err => {
    const bind = `Port ${app.get('port')}`;

    if (err) {
        if (err.syscall !== 'listen') throw err;

        switch (err.code) {
            case 'EACCES':
                console.error(`${bind} requires elevated privileges`);
                process.exit(1);
            case 'EADDRINUSE':
                console.error(`${bind} is already in use`);
                process.exit(1);
            default:
                throw err;
        }
    } else {
        console.info(`Listening on ${bind}`);
    }
});
server.timeout = process.env.TIMEOUT;

function normalizePort(val) {
    const port = parseInt(val, 10);

    switch (true) {
        case isNaN(port):
            return val;
        case port >= 0:
            return port;
        default:
            return false;
    }
}
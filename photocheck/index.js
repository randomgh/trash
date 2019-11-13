import express from 'express';
import http from 'http';
import path from 'path';
import cors from 'cors';
import cookieParser from 'cookie-parser';
import bodyParser from 'body-parser';
import helmet from 'helmet';
import session from 'express-session';
import MongoDBSession from 'connect-mongodb-session';
import mongoose from 'mongoose';
import dotenv from 'dotenv';

import * as routes from './api/routes';

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

const mongoURL = `${process.env.DB_PROTOCOL ? `${process.env.DB_PROTOCOL}://` : ''}${process.env.DB_USER ? `${process.env.DB_USER}${process.env.DB_PASSWORD ? `:${process.env.DB_PASSWORD}` : ''}@` : ''}${process.env.DB_HOST}${process.env.DB_PORT ? `:${process.env.DB_PORT}` : ''}${process.env.DB_NAME ? `/${process.env.DB_NAME}` : ''}${process.env.DB_QUERY ? `?${process.env.DB_QUERY}` : ''}`;

mongoose.Promise = Promise;

mongoose.connect(mongoURL, {
    useNewUrlParser: true,
    dbName: process.env.DB_NAME
}).then(() => {
    console.info(`Database connected at ${mongoURL}`);

    return true;
}).catch(err => {
    console.error('Error connecting to the database.', err);
    process.exit(1);
});

const MongoDBStore = MongoDBSession(session),
      mongoStore = new MongoDBStore({
          uri: mongoURL,
          collection: process.env.SESSION_COLLECTION
      });

mongoStore.on('error', err => {
    console.error('MongoDB session error.', err);
    process.exit(1);
});

app.use(session({
    secret: process.env.SESSION_SECRET,
    cookie: {
        maxAge: 1000 * 60 * 60 * 24 * parseInt(process.env.SESSION_COOKIE_ADE)
    },
    store: mongoStore,
    resave: true,
    saveUninitialized: true
}));

app.use(cookieParser());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

for(let route in routes){
    app.use(`${process.env.API_URL}/${route}`, routes[route]);
}

app.use(process.env.UPLOADS_URL, express.static(path.resolve(process.env.UPLOADS_DIR)));

app.use(process.env.WWW_URL, express.static(path.join(__dirname, `.${process.env.WWW_DIR}`)));

app.get('*', (req, res) => {
    res.sendFile(path.join(__dirname, `.${process.env.WWW_DIR}/index.html`));
});

app.use((req, res) => {
    res.status(404).send({
        errors: [{
            code: 0,
            message: 'Not found'
        }],
        meta: {
            status: 404
        }
    });
});

app.use((err, req, res) => {
    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};

    res.status(err.status || 500).send({
        errors: [{
            code: 0,
            message: err.message || 'Server error'
        }],
        meta: {
            status: err.status || 500
        }
    });
});

http.createServer(app).listen(app.get('port'), err => {
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
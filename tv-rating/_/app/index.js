import path from 'path';
import http from 'http';
import cors from 'cors';
import express from 'express';
import helmet from 'helmet';
import cookieParser from 'cookie-parser';
import bodyParser from 'body-parser';
import session from 'express-session';
import mongoose from 'mongoose';
import MongoDBSession from 'connect-mongodb-session';
import graphqlHTTP from 'express-graphql';
import { makeExecutableSchema } from 'graphql-tools';
import dotenv from 'dotenv';

import project from '../package.json';

import { typeDefs, resolvers } from './objects';

dotenv.config();

const ENV = process.env.NODE_ENV || 'production',
      PORT = process.env.PORT || 80,
      VERSION = project.version || '0.0.0',
      BASE_PATH = `${process.env.API_URL}/v${VERSION}`;

const app = express();

app.set('port', PORT);

app.use(helmet());
app.use(cors({ origin: true }));

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

    next();
});

app.use(cookieParser());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());


const mongoURL = `${process.env.DB_PROTOCOL ? `${process.env.DB_PROTOCOL}://` : ''}${process.env.DB_USER ? `${process.env.DB_USER}${process.env.DB_PASSWORD ? `:${process.env.DB_PASSWORD}` : ''}@` : ''}${process.env.DB_HOST}${process.env.DB_PORT ? `:${process.env.DB_PORT}` : ''}${process.env.DB_NAME ? `/${process.env.DB_NAME}` : ''}${process.env.DB_QUERY ? `?${process.env.DB_QUERY}` : ''}`;

mongoose.Promise = Promise;

mongoose.connect(mongoURL, {
    useCreateIndex: true,
    useNewUrlParser: true,
    dbName: process.env.DB_NAME
}).then(() => {
    console.info(`Database connected at ${mongoURL}`);

    return true;
}).catch(err => {
    console.error('Error connecting to the database.', err);
    process.exit(1);
});

const mongoStore = new (MongoDBSession(session))({
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

app.use(BASE_PATH, graphqlHTTP({
    schema: makeExecutableSchema({
        typeDefs,
        resolvers
    }),
    graphiql: true
}));

app.use(process.env.UPLOADS_URL, express.static(path.join(__dirname, process.env.UPLOADS_DIR)));

app.use(process.env.WWW_URL, express.static(path.join(__dirname, process.env.WWW_DIR)));

app.get('*', (req, res) => {
    res.sendFile(path.join(__dirname, `${process.env.WWW_DIR}/index.html`));
});

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
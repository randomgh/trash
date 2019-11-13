import jwt from 'express-jwt';
import dotenv from 'dotenv';

dotenv.config();

const getTokenFromHeaders = (req) => {
    const { headers: { authorization } } = req;

    if (authorization) {
        const [header, value] = authorization.split(' ');

        if (header === 'Token') return value;
    }

    return null;
};

export default {
    required: jwt({
        secret: process.env.SESSION_SECRET,
        userProperty: 'payload',
        getToken: getTokenFromHeaders,
    }),

    optional: jwt({
        secret: process.env.SESSION_SECRET,
        userProperty: 'payload',
        getToken: getTokenFromHeaders,
        credentialsRequired: false,
    })
};
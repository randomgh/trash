import dotenv from 'dotenv';
import { ApolloClient } from 'apollo-client';
import { createHttpLink } from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';

dotenv.config();

const client = new ApolloClient({
    link: createHttpLink({
        uri: process.env.API
    }),
    cache: new InMemoryCache()
});

export default client;
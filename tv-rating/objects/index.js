import fs from 'fs';
import path from 'path';

const { models, typeDefs, resolvers } = fs.readdirSync(path.resolve(__dirname), {
        withFileTypes: true
    }).filter(entity => entity.isDirectory()).reduce((objects, { name: entity }) => {
        const { model, typeDef, resolvers } = require(`./${entity}/index.js`),
              { Query: newQuery, Mutation: newMutation, ...newObjects } = resolvers,
              { Query, Mutation, ...Objects } = objects.resolvers;

        objects.models[entity] = model;
        objects.typeDefs.push(typeDef);
        objects.resolvers = {
            Query: { ...Query, ...newQuery },
            Mutation: { ...Mutation, ...newMutation },
            ...{ ...Objects, ...newObjects }
        };

        return objects;
    }, {
        models: {},
        typeDefs: [`
            schema {
                query: Query
                mutation: Mutation
            }
            
            type Query {
                i: Int
            }
  
            type Mutation {
                i: Int
            }
        `],
        resolvers: {
            Query: {},
            Mutation: {}
        }
    });

export { models, typeDefs, resolvers };
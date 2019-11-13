import dotenv from 'dotenv';

import * as models from '../models';

import { projection } from '../helpers';

dotenv.config();

export default {
    search: async (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
              options = projection(parameters, {
                  skip: ['page', 'offset'],
                  limit: ['page', 'limit']
              }),
              errors = [],
              data = {};

        let { q, resources } = parameters;

        resources = resources ? resources.split(',') : ['types', 'genres', 'roles', 'channels', 'broadcasts', 'persons'];

        for (let resource of resources) {
            let Model,
                fields,
                schema;

            switch (resource) {
                case 'types':
                    Model = models['Type'];
                    fields = ['name'];
                    schema = '_id name';
                    break;
                case 'genres':
                    Model = models['Genre'];
                    fields = ['name'];
                    schema = '_id slug name image';
                    break;
                case 'roles':
                    Model = models['Role'];
                    fields = ['name'];
                    schema = '_id slug name';
                    break;
                case 'channels':
                    Model = models['Channel'];
                    fields = ['name'];
                    schema = '_id slug name image';
                    break;
                case 'broadcasts':
                    Model = models['Broadcast'];
                    fields = ['name'];
                    schema = '_id name image';
                    break;
                case 'persons':
                    Model = models['Person'];
                    fields = ['name.first', 'name.last'];
                    schema = '_id name full_name image';
                    break;
            }

            if (!Model) {
                errors.push({
                    code: 'parameter_invalid',
                    data: resource,
                    message: 'Resource model not found.'
                });

                continue;
            }

            await Model.find({ $or: fields.map(field => {
                    return { [field]: { $regex: q, $options: 'i' } };
                }) }, schema, options).then(docs => {
                return data[resource] = docs;
            }).catch(err => {
                return errors.push({
                    code: 0,
                    message: err.message
                });
            });
        }

        return res.status(200).json({
            errors,
            data,
            meta: {
                status: 200
            }
        });
    }
};
import dotenv from 'dotenv';

import { User } from '../models';
import { projection } from '../helpers';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
            schema = projection(parameters, {
                _id: '_id',
                name: {
                    first: ['name', 'first'],
                    last: ['name', 'last']
                },
                image: 'image'
            }),
            options = projection(parameters, {
                skip: ['page', 'skip'],
                limit: ['page', 'limit']
            }),
            errors = [];

        // TODO: Validate input

        let total;

        User.find(schema, null, options).exec().then(count => {
            total = count;

            return User.find(schema, null, options).exec();
        }).then(docs => {
            return res.status(200).json({
                errors,
                data: docs,
                meta: {
                    status: 200,
                    pagination: {
                        ...options,
                        count: docs.length,
                        total
                    }
                }
            });
        }).catch(err => {
            // TODO: Specify code

            errors.push({
                code: 0,
                message: err.message
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    getOne: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
            schema = projection(parameters, {
                _id: '_id',
                name: {
                    first: ['name', 'first'],
                    last: ['name', 'last']
                },
                image: 'image'
            }),
            options = {},
            errors = [];

        // TODO: Validate input

        User.findOne(schema, null, options).exec().then(doc => {
            return res.status(200).json({
                errors,
                data: doc,
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            if (err.kind === 'ObjectId') {
                // TODO: Specify code

                errors.push({
                    code: 0,
                    message: err.message
                });

                return res.status(404).json({
                    errors,
                    meta: {
                        status: 404
                    }
                });
            }

            // TODO: Specify code

            errors.push({
                code: 0,
                message: err.message
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    create: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
            schema = projection(parameters, {
                name: {
                    first: ['name', 'first'],
                    last: ['name', 'last']
                }
            }),
            options = {},
            errors = [];

        // TODO: Validate input
        // TODO: Move & rename image

        if(req.file) schema.image = `${process.env.UPLOADS_URL}/users/${req.file.filename}`;

        const model = new User(schema);

        model.save(options).then(doc => {
            return res.status(201).json({
                errors,
                data: doc,
                meta: {
                    status: 201
                }
            });
        }).catch(err => {
            // TODO: Specify code

            errors.push({
                code: 0,
                message: err.message
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    update: (req, res) => {
        const { _id, ...parameters } = { ...req.query, ...req.body, ...req.params },
            schema = projection(parameters, {
                name: {
                    first: ['name', 'first'],
                    last: ['name', 'last']
                }
            }),
            options = {
                new: true
            },
            errors = [];

        // TODO: Validate input
        // TODO: Move & rename image

        if(req.file) schema.image = `${process.env.UPLOADS_URL}/users/${req.file.filename}`;

        User.findByIdAndUpdate(_id, schema, options).exec().then(doc => {
            return res.status(202).json({
                errors,
                data: doc,
                meta: {
                    status: 202
                }
            });
        }).catch(err => {
            if (err.kind === 'ObjectId') {
                // TODO: Specify code

                errors.push({
                    code: 0,
                    message: err.message
                });

                return res.status(404).json({
                    errors,
                    meta: {
                        status: 404
                    }
                });
            }

            // TODO: Specify code

            errors.push({
                code: 0,
                message: err.message
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    delete: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
            schema = projection(parameters, {
                _id: '_id',
                name: {
                    first: ['name', 'first'],
                    last: ['name', 'last']
                },
                image: 'image'
            }),
            options = {},
            errors = [];

        // TODO: Validate input

        User.findOneAndRemove(schema, options).exec().then(doc => {
            return res.status(202).json({
                errors,
                data: doc,
                meta: {
                    status: 202
                }
            });
        }).catch(err => {
            if (err.kind === 'ObjectId') {
                // TODO: Specify code

                errors.push({
                    code: 0,
                    message: err.message
                });

                return res.status(404).json({
                    errors,
                    meta: {
                        status: 404
                    }
                });
            }

            // TODO: Specify code

            errors.push({
                code: 0,
                message: err.message
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    }
};
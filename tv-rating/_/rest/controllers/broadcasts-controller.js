import dotenv from 'dotenv';

import { Broadcast, Schedule } from '../models';
import { projection } from '../helpers';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
              schema = projection(parameters, {
                  _id: '_id',
                  name: 'name',
                  synopsis: 'synopsis',
                  description: 'description',
                  image: 'image',
                  type: 'type'
              }),
              options = projection(parameters, {
                  skip: ['page', 'skip'],
                  limit: ['page', 'limit']
              }),
              errors = [];

        // TODO: Validate input

        let total;

        return Broadcast.countDocuments(schema).exec().then(count => {
            total = count;

            return Broadcast.find(schema, null, options).exec();
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
                  name: 'name',
                  synopsis: 'synopsis',
                  description: 'description',
                  image: 'image',
                  type: 'type'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        let broadcast;

        return Broadcast.findOne(schema, null, options).exec().then(doc => {
            broadcast = doc;

            return Schedule.find({
                broadcast: broadcast._id
            }).populate(['channel', 'members.person']).exec();
        }).then(docs => {
            return res.status(200).json({
                errors,
                data: {
                    ...broadcast.toObject(),
                    schedule: docs
                },
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
                  name: 'name',
                  synopsis: 'synopsis',
                  description: 'description',
                  type: 'type'
              }),
              options = {},
              errors = [];

        // TODO: Validate input
        // TODO: Move & rename image

        if(req.file) schema.image = `${process.env.UPLOADS_URL}/broadcast/${req.file.filename}`;

        const model = new Broadcast(schema);

        return model.save(options).then(doc => {
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
                  name: 'name',
                  synopsis: 'synopsis',
                  description: 'description',
                  type: 'type'
              }),
              options = {
                  new: true
              },
              errors = [];

        // TODO: Validate input
        // TODO: Move & rename image

        if(req.file) schema.image = `${process.env.UPLOADS_URL}/broadcast/${req.file.filename}`;

        Broadcast.findByIdAndUpdate(_id, schema, options).exec().then(doc => {
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
                  name: 'name',
                  synopsis: 'synopsis',
                  description: 'description',
                  image: 'image',
                  type: 'type'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        Broadcast.findOneAndRemove(schema, options).exec().then(doc => {
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
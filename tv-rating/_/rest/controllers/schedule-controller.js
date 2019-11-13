import dotenv from 'dotenv';

import { Schedule } from '../models';
import { projection } from '../helpers';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
              schema = projection(parameters, {
                  _id: '_id',
                  starts: 'starts',
                  ends: 'ends',
                  channel: 'channel',
                  broadcast: 'broadcast'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        Schedule.find(schema, null, options).exec().then(docs => {
            return res.status(200).json({
                errors,
                data: docs,
                meta: {
                    status: 200
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
                  starts: 'starts',
                  ends: 'ends',
                  channel: 'channel',
                  broadcast: 'broadcast'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        Schedule.findOne(schema, null, options).exec().then(doc => {
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
                  starts: 'starts',
                  ends: 'ends',
                  channel: 'channel',
                  broadcast: 'broadcast'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        const model = new Schedule(schema);

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
                  starts: 'starts',
                  ends: 'ends',
                  channel: 'channel',
                  broadcast: 'broadcast'
              }),
              options = {
                  new: true
              },
              errors = [];

        // TODO: Validate input

        Schedule.findByIdAndUpdate(_id, schema, options).exec().then(doc => {
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
                  starts: 'starts',
                  ends: 'ends',
                  channel: 'channel',
                  broadcast: 'broadcast'
              }),
              options = {},
              errors = [];

        // TODO: Validate input

        Schedule.findOneAndRemove(schema, options).exec().then(doc => {
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
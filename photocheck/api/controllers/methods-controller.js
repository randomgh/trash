import dotenv from 'dotenv';

import { Method } from '../models';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params };

        Method.find(parameters).then(docs => {
            return res.status(200).json({
                data: docs,
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            return res.status(500).json({
                errors: [{
                    code: 0,
                    message: err.message || 'DB error.'
                }],
                meta: {
                    status: 500
                }
            });
        });
    },

    getOne: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params };

        Method.find(parameters).then(docs => {
            if (!docs || docs.length === 0) {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: 'Method not found.'
                    }],
                    meta: {
                        status: 404
                    }
                });
            }

            return res.status(200).json({
                data: docs[0],
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            if (err.kind === 'ObjectId' || err.name === 'NotFound') {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: err.message || 'Method not found.'
                    }],
                    meta: {
                        status: 404
                    }
                });
            }

            return res.status(500).json({
                errors: [{
                    code: 0,
                    message: 'DB error.'
                }],
                meta: {
                    status: 500
                }
            });
        });
    },

    create: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params };

        Method.create(Object.keys(parameters.methods).map(slug => {
            return {
                slug,
                name: parameters.methods[slug]
            };
        }), (err, requests) => {
            if (err) {
                return res.status(500).json({
                    errors: [{
                        code: 0,
                        message: err.message || 'DB error.'
                    }],
                    meta: {
                        status: 500
                    }
                });
            }

            return res.status(200).json({
                data: requests,
                meta: {
                    status: 200
                }
            });
        });
    },

    delete: (req, res) => {

    }
};
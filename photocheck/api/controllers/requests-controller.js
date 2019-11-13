import dotenv from 'dotenv';

import { Request, File } from '../models';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params };

        Request.find(parameters).then(docs => {
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

        Request.find(parameters).then(docs => {
            if (!docs || docs.length === 0) {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: 'Request not found.'
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
                        message: err.message || 'Request not found.'
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


        File.insertMany(req.files.map(file => {
            return {
                file_name:     file.filename,
                original_name: file.originalname,
                mime_type:     file.mimetype,
                size:          file.size
            };
        }), (err, files) => {
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

            return Request.create({
                name:  req.body.name,
                files: files.map(file => file._id)
            }, (err, requests) => {
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
        });
    },

    delete: (req, res) => {
        const { _id, ...parameters } = { ...req.query, ...req.body, ...req.params };

        Request.findByIdAndRemove(_id).then(doc => {
            if (!doc) {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: 'Request not found.'
                    }],
                    meta: {
                        status: 404
                    }
                });
            }


            return res.status(200).json({
                data: doc,
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            if (err.kind === 'ObjectId' || err.name === 'NotFound') {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: err.message || 'Request not found.'
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
    }
};
import fetch from 'node-fetch';
import dotenv from 'dotenv';

import { Report } from '../models';

dotenv.config();

export default {
    getAll: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params };

        Report.find(parameters).then(docs => {
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

        Report.find(parameters).then(docs => {
            if (!docs || docs.length === 0) {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: 'Report not found.'
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
                        message: err.message || 'Report not found.'
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

        Report.find({
            file:   parameters.file_id,
            method: parameters.method_id
        }).then(docs => {
            if (!docs || docs.length === 0) {
                return fetch(`${process.env.SERVICE_URL}${parameters.method_slug}?request=${parameters.request_id}&file_id=${parameters.file_id}&file_name=${parameters.file_name}&mime=${parameters.file_mime}`, {
                    headers: {
                        Accept: 'application/json',
                    }
                }).then(result => result.json()).then(result => {
                    return Report.create({
                        file:   parameters.file_id,
                        method: parameters.method_id,
                        result
                    }, (err, report) => {
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
                            data: report,
                            meta: {
                                status: 200
                            }
                        });
                    });
                }).catch(err => {
                    return res.status(500).json({
                        errors: [{
                            code: 0,
                            message: err.message || 'Fetch error.'
                        }],
                        meta: {
                            status: 500
                        }
                    });
                });
                /*
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: 'Report not found.'
                    }],
                    meta: {
                        status: 404
                    }
                });
                */
            }

            return res.status(200).json({
                data: docs[0],
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            /*
            if (err.kind === 'ObjectId' || err.name === 'NotFound') {
                return res.status(404).json({
                    errors: [{
                        code: 0,
                        message: err.message || 'Report not found.'
                    }],
                    meta: {
                        status: 404
                    }
                });
            }
            */
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

    delete: (req, res) => {

    }
};
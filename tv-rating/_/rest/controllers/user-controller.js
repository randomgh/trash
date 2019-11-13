import dotenv from 'dotenv';
import generator from 'generate-password';

import { User } from '../models';

import { projection, mail } from '../helpers';

dotenv.config();

export default {
    register: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params },
              errors = [];

        // TODO: Validate input

        const user = new User(projection(options, {
            email: 'email',
            password: 'password'
        }));

        return user.save().then(user => {
            mail({
                to: options.email,
                subject: 'Registration',
                html: `<h2>Слава богу, ты пришел!</h2><p><span>UID:</span> <b>${user._id}</b></p>`
            }).then(info => {
                return res.status(201).json(response(201, projection(user, {
                    _id: 'id',
                    email: 'email'
                }), errors));
            }).catch(err => {
                errors.push({
                    code: 'email',
                    message: 'Mail error: sending email error.'
                });

                return res.status(207).json(response(207, projection(user, {
                    _id: 'id',
                    email: 'email'
                }), errors));
            });
        }).catch(err => {
            if (err.code === 11000) {
                errors.push({
                    code: 'item_conflict',
                    message: 'DB error: item exists.'
                });

                return res.status(400).json({
                    errors,
                    meta: {
                        status: 400
                    }
                });
            }

            errors.push({
                code: 'unknown',
                data: err,
                message: 'DB error: saving items error.'
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    profile: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params };

        // TODO: Validate input

    },

    invite: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params },
              errors = [];

        // TODO: Validate input

        options.password = generator.generate({
            length: 10,
            numbers: true,
            symbols: false,
            strict: true
        });

        const user = new User(projection(options, {
            email: 'email',
            password: 'password'
        }));

        return user.save().then(user => {
            mail({
                to: options.email,
                subject: 'Invitation',
                html: `<h2>Пропуск</h2><p><span>Password:</span> <b>${options.password}</b></p>`
            }).then(info => {
                return res.status(201).json(response(201, projection(user, {
                    _id: 'id',
                    email: 'email'
                }), errors));
            }).catch(err => {
                errors.push({
                    code: 'email',
                    message: 'Mail error: sending email error.'
                });

                return res.status(207).json(response(207, projection(user, {
                    _id: 'id',
                    email: 'email'
                }), errors));
            });
        }).catch(err => {
            if (err.code === 11000) {
                errors.push({
                    code: 'item_conflict',
                    message: 'DB error: item exists.'
                });

                return res.status(400).json({
                    errors,
                    meta: {
                        status: 400
                    }
                });
            }

            errors.push({
                code: 'unknown',
                data: err,
                message: 'DB error: saving items error.'
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    authenticate: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params };

        // TODO: Validate input

    },

    debunk: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params };

        // TODO: Validate input

    },

    recovery: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params },
              errors = [];

        // TODO: Validate input

        return User.find(projection(options, {
            email: 'email'
        })).then(users => {
            if (!users || !users.length) {
                errors.push({
                    code: 'not_found',
                    message: 'DB error: finding items error.'
                });

                return res.status(400).json({
                    errors,
                    meta: {
                        status: 400
                    }
                });
            }

            const password = generator.generate({
                length: 10,
                numbers: true,
                symbols: false,
                strict: true
            });

            users[0].password = password;

            mail({
                to: users[0].email,
                subject: 'Recovery',
                html: `<h2>Слабо запомнить?</h2><p><span>Password:</span> <b>${password}</b></p>`
            }).then(info => {
                return res.status(201).json(response(201, projection(users[0], {
                    _id: 'id',
                    email: 'email'
                }), errors));
            }).catch(err => {
                errors.push({
                    code: 'email',
                    message: 'Mail error: sending email error.'
                });

                return res.status(207).json(response(207, projection(users[0], {
                    _id: 'id',
                    email: 'email'
                }), errors));
            });
        }).catch(err => {
            errors.push({
                code: 'unknown',
                data: err,
                message: 'DB error: saving items error.'
            });

            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    },

    password: (req, res) => {
        const options = { ...req.query, ...req.body, ...req.params };

        // TODO: Validate input

    }
};
import dotenv from 'dotenv';

import Type from '../models/type-model';
import Genre from '../models/genre-model';
import Role from '../models/role-model';
import Person from '../models/person-model';
import Broadcast from '../models/broadcast-model';
import Channel from '../models/channel-model';
import Schedule from '../models/schedule-model';

import * as parsers from '../parsers';

dotenv.config();

export default {
    parse: (req, res) => {
        const parameters = { ...req.query, ...req.body, ...req.params },
              errors = [];

        // TODO: Validate input

        const parser = new parsers[parameters._id]();

        parser.parse(parameters.before ? parameters.before : 0, parameters.after ? parameters.after : 0).then(async results => {
            const docs = {};

            for (let i in results) {
                if (['types', 'genres', 'persons', 'broadcasts', 'channels', 'schedule'].includes(i)) {
                    console.log('filtering', i, results[i].length);

                    results[i] = results[i].filter((item, itemIndex) => {
                        return results[i].findIndex((result, resultIndex) => {
                            return item.provider_id === result.provider_id && itemIndex !== resultIndex;
                        }) === -1;
                    });
                }

                docs[i] = [];
            }

            console.log('types', results.types.length);

            await Type.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing types error.'
                });
            });
            await Type.insertMany(results.types).exec().then(data => {
                return docs.types = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving types error.'
                });
            });

            console.log('genres', results.genres.length);

            await Genre.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing genres error.'
                });
            });
            await Genre.insertMany(results.genres).exec().then(data => {
                return docs.genres = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving genres error.'
                });
            });

            console.log('roles', results.roles.length);

            await Role.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing roles error.'
                });
            });
            await Role.insertMany(results.roles).exec().then(data => {
                return docs.roles = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving roles error.'
                });
            });

            console.log('persons', results.persons.length);

            await Person.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing persons error.'
                });
            });
            await Person.insertMany(results.persons).exec().then(data => {
                return docs.persons = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving persons error.'
                });
            });

            console.log('channels', results.channels.length);

            await Channel.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing channels error.'
                });
            });
            await Channel.insertMany(results.channels.map((channel, index) => {
                let { genres, ...options } = channel;

                if (genres) {
                    let foundGenre;

                    options.genres = genres.map(item => {
                        foundGenre = docs.genres.find(genre => {
                            return genre.provider_id === item;
                        });

                        return foundGenre ? foundGenre._id : null;
                    }).filter(item => !!item);
                }

                return options;
            })).exec().then(data => {
                return docs.channels = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving channels error.'
                });
            });

            console.log('broadcasts', results.broadcasts.length);

            await Broadcast.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing broadcasts error.'
                });
            });
            await Broadcast.insertMany(results.broadcasts.map((broadcast, index) => {
                let { type, genres/*, members*/, ...options } = broadcast;

                if (type) {
                    let foundType = docs.types.find(item => {
                        return item.provider_id === type;
                    });

                    if (foundType) {
                        options.type = foundType._id;
                    }
                }

                if (genres) {
                    let foundGenre;

                    options.genres = genres.map(item => {
                        foundGenre = docs.genres.find(genre => {
                            return genre.provider_id === item;
                        });

                        return foundGenre ? foundGenre._id : null;
                    }).filter(item => !!item);
                }
                /*
                                if (members) {
                                    let foundRole,
                                        foundPerson;

                                    options.members = members.map(item => {
                                        foundRole = docs.roles.find(role => {
                                            return role.slug === item.role;
                                        });

                                        foundPerson = docs.persons.find(person => {
                                            return person.provider_id === item.person;
                                        });

                                        return {
                                            role: foundRole ? foundRole._id : null,
                                            person: foundPerson ? foundPerson._id : null
                                        };
                                    }).filter(item => !!item.role && !!item.person);
                                }
                */
                return options;
            })).exec().then(data => {
                return docs.broadcasts = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving broadcasts error.'
                });
            });

            console.log('schedule', results.schedule.length);

            await Schedule.deleteMany({}).exec().catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: clearing schedule error.'
                });
            });
            await Schedule.insertMany(results.schedule.map(schedule => {
                let { broadcast, channel, members, ...options } = schedule;

                if (broadcast) {
                    let foundBroadcast = docs.broadcasts.find(item => {
                        return item.provider_id === broadcast;
                    });

                    if (foundBroadcast) {
                        options.broadcast = foundBroadcast._id;
                    }
                }

                if (channel) {
                    let foundChannel = docs.channels.find(item => {
                        return item.provider_id === channel;
                    });

                    if (foundChannel) {
                        options.channel = foundChannel._id;
                    }
                }

                if (members) {
                    let foundRole,
                        foundPerson;

                    options.members = members.map(item => {
                        foundRole = docs.roles.find(role => {
                            return role.slug === item.role;
                        });

                        foundPerson = docs.persons.find(person => {
                            return person.provider_id === item.person;
                        });

                        return {
                            role: foundRole ? foundRole._id : null,
                            person: foundPerson ? foundPerson._id : null
                        };
                    }).filter(item => !!item.role && !!item.person);
                }

                return options;
            }).filter(schedule => !!schedule.broadcast && !!schedule.channel)).exec().then(data => {
                return docs.schedule = data;
            }).catch(err => {
                errors.push({
                    code: 0,
                    data: err,
                    message: 'DB error: saving schedule error.'
                });
            });

            console.log('parsed');

            for (let i in docs) {
                console.log(i, docs[i].length);
            }

            console.log(errors);

            return res.status(200).json({
                errors,
                data: docs,
                meta: {
                    status: 200
                }
            });
        }).catch(err => {
            return res.status(500).json({
                errors,
                meta: {
                    status: 500
                }
            });
        });
    }
};
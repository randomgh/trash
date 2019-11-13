import path from 'path';
import PostmanParser from './postman-parser';
import dotenv from 'dotenv';

import projection from '../helpers/projection-helper';
import download from '../helpers/download-helper';
import sleep from '../helpers/sleep-helper';

import Collection from './postman/spbtv.postman_collection';
import Environment from './postman/spbtv.postman_environment';

dotenv.config();

class SPBTV extends PostmanParser {

    types = [];
    genres = [];
    roles = [];
    persons = [];
    broadcasts = [];
    channels = [];
    schedule = [];

    constructor() {
//        console.log('spbtv');

        super(Collection, Environment);
    }

    static zero(value) {
        return value < 10 && value >= 0 ? `0${value}` : `${value}`;
    }

    page(folder, limit = 0, offset = 0, delay = 1000, environment = {}) {
//        console.log('page', folder, limit, offset);

        return new Promise((resolve, reject) => {
            super.parse(folder, {
                ...environment,
                'page[limit]': limit,
                'page[offset]': offset
            }, delay).then(summary => {
                return resolve(summary);
            }).catch(err => {
                return reject(err);
            });
        });
    }

    pages(folder, limit = 100, delay = 1000, environment = {}) {
//        console.log('pages', folder, limit);

        return new Promise(async (resolve, reject) => {
            let page = 0,
                loaded = false,
                pages = [];

            while (!loaded) {
                loaded = await this.page(folder, limit, limit * page++, delay, environment).then(summary => {
                    for (let response of summary.responses) {
                        pages.push(...response.data);
                    }

                    return summary.responses.some((response, i) => {
//                        console.log(response.meta.pagination);

                        return response.meta.pagination.offset + response.meta.pagination.count === response.meta.pagination.total;
                    });
                }).catch(err => {
                    return reject(err);
                });

                await sleep(delay);
            }

            resolve(pages);
        });
    }

    parse(before = 0, after = 0) {
        console.log('parse');

        return new Promise(async (resolve, reject) => {
            this.types = await this.parseTypes(await this.pages('types', 100, 100).catch(err => {
                return reject(err);
            })).catch(err => {
                return reject(err);
            });

            this.genres = await this.parseGenres(await this.pages('genres', 100, 100).catch(err => {
                return reject(err);
            })).catch(err => {
                return reject(err);
            });

            const { channels, genres } = await this.parseChannels(await this.pages('channels', 100, 100).catch(err => {
                return reject(err);
            })).catch(err => {
                return reject(err);
            });

            this.channels.push(...channels.filter((channel, index) => this.channels.findIndex(item => item.slug === channel.slug || item.provider_id === channel.provider_id) === -1));
            this.genres.push(...genres.filter((genre, index) => this.genres.findIndex(item => item.slug === genre.slug || item.provider_id === genre.provider_id) === -1));
/*
            const { types, genres, roles, persons, broadcasts } = await this.parseBroadcasts(await this.pages('broadcasts', 20, 100).catch(err => {
                return reject(err);
            })).catch(err => {
                return reject(err);
            });

            this.types.push(...types.filter((type, index) => this.types.findIndex(item => item.provider_id === type.provider_id) === -1));
            this.genres.push(...genres.filter((genre, index) => this.genres.findIndex(item => item.slug === genre.slug || item.provider_id === genre.provider_id) === -1));
            this.roles.push(...roles.filter((role, index) => this.roles.findIndex(item => item.slug === role.slug) === -1));
            this.persons.push(...persons.filter((person, index) => this.persons.findIndex(item => item.provider_id === person.provider_id) === -1));
            this.broadcasts.push(...broadcasts.filter((broadcast, index) => this.broadcasts.findIndex(item => item.provider_id === broadcast.provider_id) === -1));
*/
            for (let i in this.channels) {
                for (let j = -before; j <= after; j++) {
                    const date = new Date();
                    date.setDate(new Date().getDate() + j);

                    console.log('schedule', parseInt(i) + 1, 'of', this.channels.length, this.channels[i].slug, `${date.getFullYear()}-${SPBTV.zero(date.getMonth() + 1)}-${SPBTV.zero(date.getDate())}`);

                    const { types, genres, roles, persons, broadcasts, schedule } = await this.parseSchedule(await super.parse('schedule', {
                        channel_id: this.channels[i].provider_id,
                        pivot_date: `${date.getFullYear()}-${SPBTV.zero(date.getMonth() + 1)}-${SPBTV.zero(date.getDate())}`
                    }, 100).then(summary => {
                        const schedule = [];

                        for (let response of summary.responses) {
                            schedule.push(...response.data);
                        }

                        return schedule;
                    }).catch(err => {
                        return reject(err);
                    })).catch(err => {
                        return reject(err);
                    });

                    this.types.push(...types.filter((type, index) => this.types.findIndex(item => item.provider_id === type.provider_id) === -1));
                    this.genres.push(...genres.filter((genre, index) => this.genres.findIndex(item => item.slug === genre.slug || item.provider_id === genre.provider_id) === -1));
                    this.roles.push(...roles.filter((role, index) => this.roles.findIndex(item => item.slug === role.slug) === -1));
                    this.persons.push(...persons.filter((person, index) => this.persons.findIndex(item => item.provider_id === person.provider_id) === -1));
                    this.broadcasts.push(...broadcasts.filter((broadcast, index) => this.broadcasts.findIndex(item => item.provider_id === broadcast.provider_id) === -1));
                    this.schedule.push(...schedule.filter((schedule, index) => this.schedule.findIndex(item => item.provider_id === schedule.provider_id) === -1));
                }
            }

            resolve({
                types: this.types,
                genres: this.genres,
                roles: this.roles,
                persons: this.persons,
                broadcasts: this.broadcasts,
                channels: this.channels,
                schedule: this.schedule
            });
        });
    }

    parseTypes(types) {
        console.log('types', types.length);

        return new Promise(async (resolve, reject) => {
            const schemas = [];

            for (let i in types) {
//                console.log('type', parseInt(i) + 1, 'of', types.length);

                const schema = projection(types[i], {
                        provider_id: 'id',
                        name: 'name'
                    }),
                    found = schemas.findIndex(item => item.provider_id === schema.provider_id);

                if (found === -1) {
                    schemas.push(schema);
                }
            }

            resolve(schemas);
        });
    }

    parseGenres(genres) {
        console.log('genres', genres.length);

        return new Promise(async (resolve, reject) => {
            const schemas = [];

            let images;

            for (let i in genres) {
//                console.log('genre', parseInt(i) + 1, 'of', genres.length);

                const schema = projection(genres[i], {
                        provider_id: 'id',
                        slug: 'slug',
                        name: 'name'
                    }),
                    found = schemas.findIndex(item => item.provider_id === schema.provider_id || item.slug === schema.slug);

                if (found === -1) {
                    if (genres[i].images) {
                        images = await this.parseImages('genres', schema.slug, genres[i].images, 100).catch(err => {
                            return reject(err);
                        });
                    }

                    if (images && images.length) schema.image = images[0];

                    schemas.push(schema);
                }
            }

            resolve(schemas);
        });
    }

    parseChannels(channels) {
        console.log('channels', channels.length);

        return new Promise(async (resolve, reject) => {
            const schemas = {
                channels: [],
                genres: []
            };

            let images;

            for (let i in channels) {
//                console.log('channel', parseInt(i) + 1, 'of', channels.length);

                const schema = projection(channels[i], {
                        provider_id: 'id',
                        slug: 'slug',
                        name: 'name',
                        synopsis: 'synopsis',
                        description: 'description'
                    }),
                    found = schemas.channels.findIndex(item => item.provider_id === schema.provider_id || item.slug === schema.slug);

                if (channels[i].genres) {
                    schema.genres = [];

                    for (let genre of channels[i].genres) {
                        const schemaGenre = projection(genre, {
                                provider_id: 'id',
                                slug: 'slug',
                                name: 'name'
                            }),
                            foundGenre = schemas.genres.findIndex(item => item.provider_id === schemaGenre.provider_id || item.slug === schemaGenre.slug);

                        if (foundGenre === -1) {
                            if (genre.images) {
                                images = await this.parseImages('genres', schemaGenre.slug, genre.images, 100).catch(err => {
                                    return reject(err);
                                });
                            }

                            if (images && images.length) schemaGenre.image = images[0];

                            schemas.genres.push(schemaGenre);
                        }

                        schema.genres.push(schemaGenre.provider_id);
                    }
                }

                if (found === -1) {
                    if (channels[i].images) {
                        images = await this.parseImages('channels', schema.slug, channels[i].images, 100).catch(err => {
                            return reject(err);
                        });
                    }

                    if (images && images.length) schema.image = images[0];

                    schemas.channels.push(schema);
                }
            }

            resolve(schemas);
        });
    }
/*
    parseBroadcasts(broadcasts) {
        console.log('broadcasts', broadcasts.length);

        return new Promise(async (resolve, reject) => {
            const schemas = {
                types: [],
                genres: [],
                roles: [],
                persons: [],
                broadcasts: []
            };

            let images;

            for (let i in broadcasts) {
//                console.log('broadcast', parseInt(i) + 1, 'of', broadcasts.length);

                const schema = projection(broadcasts[i], {
                        provider_id: 'id',
                        name: 'name',
                        synopsis: 'synopsis',
                        description: 'description',
                        type: ['program_type', 'id']
                    }),
                    found = schemas.broadcasts.findIndex(item => item.provider_id === schema.provider_id);

                if (broadcasts[i].program_type && schemas.types.findIndex(item => item.provider_id === broadcasts[i].program_type.id) === -1) {
                    schemas.types.push(projection(broadcasts[i].program_type, {
                        provider_id: 'id',
                        name: 'name'
                    }));
                }

                if (broadcasts[i].genres) {
                    schema.genres = [];

                    for (let genre of broadcasts[i].genres) {
                        const schemaGenre = projection(genre, {
                                provider_id: 'id',
                                slug: 'slug',
                                name: 'name'
                            }),
                            foundGenre = schemas.genres.findIndex(item => item.provider_id === schemaGenre.provider_id || item.slug === schemaGenre.slug);

                        if (foundGenre === -1) {
                            if (genre.images) {
                                images = await this.parseImages('genres', schemaGenre.slug, genre.images, 100).catch(err => {
                                    return reject(err);
                                });
                            }

                            if (images && images.length) schemaGenre.image = images[0];

                            schemas.genres.push(schemaGenre);
                        }

                        schema.genres.push(schemaGenre.provider_id);
                    }
                }

                if (found === -1) {
                    if (broadcasts[i].images) {
                        images = await this.parseImages('broadcasts', schema.provider_id, broadcasts[i].images, 100).catch(err => {
                            return reject(err);
                        });
                    }

                    schema.members = broadcasts[i].cast_members.map((member, index) => {
                        return {
                            role: member.role,
                            person: member.person.id
                        };
                    });

                    if (images && images.length) schema.image = images[0];

                    schemas.broadcasts.push(schema);
                }

                const { roles, persons } = await this.parseMembers(broadcasts[i].cast_members).catch(err => {
                    return reject(err);
                });

                schemas.roles.push(...roles.filter((role, index) => schemas.roles.findIndex(item => item.slug === role.slug) === -1));
                schemas.persons.push(...persons.filter((person, index) => schemas.persons.findIndex(item => item.provider_id === person.provider_id) === -1));
            }

            resolve(schemas);
        });
    }
*/
    parseSchedule(schedule) {
        console.log('schedule', schedule.length);

        return new Promise(async (resolve, reject) => {
            const schemas = {
                types: [],
                genres: [],
                roles: [],
                persons: [],
                broadcasts: [],
                schedule: []
            };

            let images;

            for (let i in schedule) {
//                console.log('schedule', parseInt(i) + 1, 'of', schedule.length);

                const schemaSchedule = projection(schedule[i], {
                        provider_id: 'id',
                        starts: 'start_at',
                        ends: 'end_at',
                        channel: 'channel_id',
                        broadcast: 'program_id'
                    }),
                    schemaBroadcast = projection(schedule[i], {
                        provider_id: 'program_id',
                        name: 'name',
                        description: 'description',
                        type: ['program_type', 'id']
                    }),
                    foundSchedule = schemas.schedule.findIndex(item => item.provider_id === schemaSchedule.provider_id),
                    foundBroadcast = schemas.broadcasts.findIndex(item => item.provider_id === schemaBroadcast.provider_id);

                if (schedule[i].program_type && schemas.types.findIndex(item => item.provider_id === schedule[i].program_type.id) === -1) {
                    schemas.types.push(projection(schedule[i].program_type, {
                        provider_id: 'id',
                        name: 'name'
                    }));
                }

                if (schedule[i].genres) {
                    schemaBroadcast.genres = [];

                    for (let genre of schedule[i].genres) {
                        const schemaGenre = projection(genre, {
                                provider_id: 'id',
                                slug: 'slug',
                                name: 'name'
                            }),
                            foundGenre = schemas.genres.findIndex(item => item.provider_id === schemaGenre.provider_id || item.slug === schemaGenre.slug);

                        if (foundGenre === -1) {
                            if (genre.images) {
                                images = await this.parseImages('genres', schemaGenre.slug, genre.images, 100).catch(err => {
                                    return reject(err);
                                });
                            }

                            if (images && images.length) schemaGenre.image = images[0];

                            schemas.genres.push(schemaGenre);
                        }

                        schemaBroadcast.genres.push(schemaGenre.provider_id);
                    }
                }

                if (foundSchedule === -1) {
                    schemaSchedule.members = schedule[i].cast_members.map((member, index) => {
                        return {
                            role: member.role,
                            person: member.person.id
                        };
                    });

                    schemas.schedule.push(schemaSchedule);
                }

                if (foundBroadcast === -1) {
                    if (schedule[i].images) {
                        images = await this.parseImages('broadcasts', schemaBroadcast.provider_id, schedule[i].images, 100).catch(err => {
                            return reject(err);
                        });
                    }

                    if (images && images.length) schemaBroadcast.image = images[0];

                    schemas.broadcasts.push(schemaBroadcast);
                }

                const { roles, persons } = await this.parseMembers(schedule[i].cast_members).catch(err => {
                    return reject(err);
                });

                schemas.roles.push(...roles.filter((role, index) => schemas.roles.findIndex(item => item.slug === role.slug) === -1));
                schemas.persons.push(...persons.filter((person, index) => schemas.persons.findIndex(item => item.provider_id === person.provider_id) === -1));
            }

            resolve(schemas);
        });
    }

    parseMembers(members) {
//        console.log('members', members.length);

        return new Promise(async (resolve, reject) => {
            const schemas = {
                roles: [],
                persons: []
            };

            let images;

            for (let i in members) {
//                console.log('member', parseInt(i) + 1, 'of', members.length);

                const schemaPerson = projection(members[i].person, {
                        provider_id: 'id'
                    }),
                    schemaRole = projection(members[i], {
                        slug: 'role'
                    }),
                    foundPerson = schemas.persons.findIndex(item => item.provider_id === schemaPerson.provider_id),
                    foundRole = schemas.roles.findIndex(item => item.slug === members[i].role);

                if (foundPerson === -1) {
                    const full_name = members[i].person.full_name.split(' ');

                    schemaPerson.name = {
                        first: full_name[0],
                        last: full_name[1]
                    };

                    if (members[i].person.images) {
                        images = await this.parseImages('persons', schemaPerson.provider_id, members[i].person.images, 100).catch(err => {
                            return reject(err);
                        });
                    }

                    if (images && images.length) schemaPerson.image = images[0];

                    schemas.persons.push(schemaPerson);
                }

                if (foundRole === -1) {
                    schemas.roles.push(schemaRole);
                }
            }

            resolve(schemas);
        });
    }

    parseImages(resource, slug, images, delay = 1000) {
//        console.log('images', resource, slug, images.length);

        return new Promise(async (resolve, reject) => {
            const files = [];

            for (let i in images) {
//                console.log('image', parseInt(i) + 1, 'of', images.length);

                let file =  await download(images[i].url_template.replace(/^(https:)(.*?)$/gim, 'http:$2').replace(/\{(\S+?)\}/gim, (match, variable) => {
                    switch (variable) {
                        case 'width':
                            return images[i].original_width;
                        case 'height':
                            return images[i].original_height;
                        case 'crop':
                        default:
                            return '';
                    }
                }), path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/${resource}/${slug}/`), i).then(async result => {
                    return `${process.env.UPLOADS_URL}/${resource}/${slug}/${result}`;
                }).catch(err => {
                    return reject(err);
                });

                files.push(file);

                await sleep(delay);
            }

            resolve(files);
        });
    }

}

export default SPBTV;
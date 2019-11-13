import ApiService from './api-service';
import RestService from './rest-service';

const URL = '/api';

const user = new ApiService(URL, 'user');
const users = new RestService(URL, 'users');
const types = new RestService(URL, 'types');
const genres = new RestService(URL, 'genres');
const roles = new RestService(URL, 'roles');
const channels = new RestService(URL, 'channels');
const broadcasts = new RestService(URL, 'broadcasts');
const persons = new RestService(URL, 'persons');
const schedule = new RestService(URL, 'schedule');
const search = new ApiService(URL, 'search');

export { user, users, types, genres, roles, channels, broadcasts, persons, schedule, search };
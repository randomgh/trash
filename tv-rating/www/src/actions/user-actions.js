import { user as constants } from 'constants';
import { user as service } from 'services';

export default {
    register: (data = null) => {
        return {
            type: constants.REGISTRATION,
            payload: data ? service.post('register', data) : data
        };
    },

    profile: (data = null) => {
        return {
            type: constants.PROFILE,
            payload: data ? service.put('profile', data) : data
        };
    },

    invite: (data = null) => {
        return {
            type: constants.INVITATION,
            payload: data ? service.post('invite', data) : data
        };
    },

    authenticate: (data = null) => {
        return {
            type: constants.AUTHENTICATION,
            payload: data ? service.get('authenticate', data) : data
        };
    },

    debunk: (data = null) => {
        return {
            type: constants.DEBUNKING,
            payload: data ? service.get('debunk', data) : data
        };
    },

    recovery: (data = null) => {
        return {
            type: constants.RECOVERY,
            payload: data ? service.get('recovery', data) : data
        };
    },

    password: (data = null) => {
        return {
            type: constants.PASSWORD,
            payload: data ? service.put('password', data) : data
        };
    }
};
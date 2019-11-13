import { methods as constants } from 'constants';
import { methods as service } from 'services';

export default {
    getAll: data => {
        return {
            type: constants.GET_ALL,
            payload: service.getAll(data)
        };
    },

    getOne: data => {
        return {
            type: constants.GET_ONE,
            payload: service.getOne(data)
        };
    },

    create: data => {
        return {
            type: constants.CREATE,
            payload: service.create(data)
        };
    },

    update: data => {
        return {
            type: constants.UPDATE,
            payload: service.update(data)
        };
    },

    delete: data => {
        return {
            type: constants.DELETE,
            payload: service.delete(data)
        };
    }
};
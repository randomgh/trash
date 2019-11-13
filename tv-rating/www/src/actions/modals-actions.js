import { modals as constants } from 'constants';

export default {
    open: data => {
        return {
            type: constants.OPEN,
            payload: data
        };
    },

    close: id => {
        return {
            type: constants.CLOSE,
            payload: id
        };
    },

    clear: () => {
        return {
            type: constants.CLEAR
        };
    }
};
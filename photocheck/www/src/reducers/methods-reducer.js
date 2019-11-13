import { methods as constants } from 'constants';

export default (state = {
    errors: [],
    data:   [],
    meta:   {}
}, action) => {
    switch (action.type) {
        case constants.GET_ALL_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.GET_ALL_FULFILLED:
            return action.payload;
        case constants.GET_ALL_REJECTED:
            return action.payload;

        case constants.GET_ONE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.GET_ONE_FULFILLED:
            return action.payload;
        case constants.GET_ONE_REJECTED:
            return action.payload;

        case constants.CREATE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.CREATE_FULFILLED:
            return action.payload;
        case constants.CREATE_REJECTED:
            return action.payload;

        case constants.UPDATE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.UPDATE_FULFILLED:
            return action.payload;
        case constants.UPDATE_REJECTED:
            return action.payload;

        case constants.DELETE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.DELETE_FULFILLED:
            return action.payload;
        case constants.DELETE_REJECTED:
            return action.payload;

        default:
            return { ...state };
    }
};
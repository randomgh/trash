import { reports as constants } from 'constants';

let data;

export default (state = {
    errors: [],
    data:   {},
    meta:   {}
}, action) => {
    switch (action.type) {
        case constants.GET_ALL_PENDING:
            return {
                errors: [],
                data: {...state.data},
                meta: {
                    status: 102
                }
            };
        case constants.GET_ALL_FULFILLED:
            data = {...state.data};

            for (let report of action.payload.data) {
                data[report.method] = report;
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.GET_ALL_REJECTED:
            return {
                errors: action.payload.errors,
                data: {...state.data},
                meta: action.payload.meta
            };

        case constants.GET_ONE_PENDING:
            return {
                errors: [],
                data: {...state.data},
                meta: {
                    status: 102
                }
            };
        case constants.GET_ONE_FULFILLED:
            return {
                errors: [],
                data: {...state.data, [action.payload.data.method]: action.payload.data},
                meta: action.payload.meta
            };
        case constants.GET_ONE_REJECTED:
            return {
                errors: action.payload.errors,
                data: {...state.data},
                meta: action.payload.meta
            };

        case constants.CREATE_PENDING:
            return {
                errors: [],
                data: {...state.data},
                meta: {
                    status: 102
                }
            };
        case constants.CREATE_FULFILLED:
            return {
                errors: [],
                data: {...state.data, [action.payload.data.method]: action.payload.data},
                meta: action.payload.meta
            };
        case constants.CREATE_REJECTED:
            return {
                errors: action.payload.errors,
                data: {...state.data},
                meta: action.payload.meta
            };

        case constants.UPDATE_PENDING:
            return {
                errors: [],
                data: {...state.data},
                meta: {
                    status: 102
                }
            };
        case constants.UPDATE_FULFILLED:
            return {
                errors: [],
                data: {...state.data, [action.payload.data.method]: action.payload.data},
                meta: action.payload.meta
            };
        case constants.UPDATE_REJECTED:
            return {
                errors: action.payload.errors,
                data: {...state.data},
                meta: action.payload.meta
            };

        case constants.DELETE_PENDING:
            return {
                errors: [],
                data: {...state.data},
                meta: {
                    status: 102
                }
            };
        case constants.DELETE_FULFILLED:
            data = {...state.data};

            if (data[action.payload.data]) {
                delete data[action.payload.data];
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.DELETE_REJECTED:
            return {
                errors: action.payload.errors,
                data: {...state.data},
                meta: action.payload.meta
            };

        case constants.CLEAR:
            return {
                errors: [],
                data: {},
                meta: {}
            };

        default:
            return { ...state };
    }
};
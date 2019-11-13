import { types as constants } from 'constants';

let data,
    found;

export default (state = {
    errors: [],
    data: [],
    meta: {}
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
            data = [...state.data];

            for (let payloadItem of action.payload.data) {
                found = data.findIndex(stateItem => stateItem._id === payloadItem._id);

                if (found > -1) {
                    data[found] = {...data[found], ...payloadItem};
                } else {
                    data.push(payloadItem);
                }
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.GET_ALL_REJECTED:
            return {
                errors: action.payload.errors,
                data: [...state.data],
                meta: action.payload.meta
            };

        case constants.GET_ONE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.GET_ONE_FULFILLED:
            data = [...state.data];

            found = data.findIndex(stateItem => stateItem._id === action.payload.data._id);

            if (found > -1) {
                data[found] = {...data[found], ...action.payload.data};
            } else {
                data.push(action.payload.data);
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.GET_ONE_REJECTED:
            return {
                errors: action.payload.errors,
                data: [...state.data],
                meta: action.payload.meta
            };

        case constants.CREATE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.CREATE_FULFILLED:
            data = [...state.data];

            found = data.findIndex(stateItem => stateItem._id === action.payload.data._id);

            if (found > -1) {
                data[found] = {...data[found], ...action.payload.data};
            } else {
                data.push(action.payload.data);
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.CREATE_REJECTED:
            return {
                errors: action.payload.errors,
                data: [...state.data],
                meta: action.payload.meta
            };

        case constants.UPDATE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.UPDATE_FULFILLED:
            data = [...state.data];

            found = data.findIndex(stateItem => stateItem._id === action.payload.data._id);

            if (found > -1) {
                data[found] = {...data[found], ...action.payload.data};
            } else {
                data.push(action.payload.data);
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.UPDATE_REJECTED:
            return {
                errors: action.payload.errors,
                data: [...state.data],
                meta: action.payload.meta
            };

        case constants.DELETE_PENDING:
            return {
                errors: [],
                data: [...state.data],
                meta: {
                    status: 102
                }
            };
        case constants.DELETE_FULFILLED:
            data = [...state.data];

            found = data.findIndex(stateItem => stateItem._id === action.payload.data);

            if (found > -1) {
                data.splice(found, 1);
            }

            return {
                errors: [],
                data,
                meta: action.payload.meta
            };
        case constants.DELETE_REJECTED:
            return {
                errors: action.payload.errors,
                data: [...state.data],
                meta: action.payload.meta
            };

        default:
            return { ...state };
    }
};
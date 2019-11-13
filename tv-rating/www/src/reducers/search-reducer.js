import { search as constants } from 'constants';

export default (state = {}, action) => {
    switch (action.type) {
        case constants.SEARCH:
            return {};
        case constants.SEARCH_PENDING:
            return {
                meta: {
                    status: 102
                }
            };
        case constants.SEARCH_FULFILLED:
            return action.payload;
        case constants.SEARCH_REJECTED:
            return action.payload;

        default:
            return { ...state };
    }
};
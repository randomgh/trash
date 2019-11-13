import { modals as constants } from 'constants';

export default (state = [], action) => {
    switch (action.type) {
        case constants.OPEN:
            return [ ...state, action.payload ];
        case constants.CLOSE:
            return [ ...state.filter(modal => modal.id !== action.payload) ];
        case constants.CLEAR:
            return [];

        default:
            return [ ...state ];
    }
};
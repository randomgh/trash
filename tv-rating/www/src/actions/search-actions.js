import { search as constants } from 'constants';
import { search as service } from 'services';

export default {
    search: data => {
        return {
            type: constants.SEARCH,
            payload: service.get('', data)
        };
    }
};
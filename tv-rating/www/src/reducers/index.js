import { combineReducers } from 'redux';

import modals from './modals-reducer';
import user from './user-reducer';
import users from './users-reducer';
import types from './types-reducer';
import genres from './genres-reducer';
import roles from './roles-reducer';
import channels from './channels-reducer';
import broadcasts from './broadcasts-reducer';
import persons from './persons-reducer';
import schedule from './schedule-reducer';
import search from './search-reducer';

export default combineReducers({
    modals, user, users, types, genres, roles, channels, broadcasts, persons, schedule, search
});
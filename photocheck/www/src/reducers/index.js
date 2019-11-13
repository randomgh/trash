import { combineReducers } from 'redux';

import requests from './requests-reducer';
import files from './files-reducer';
import methods from './methods-reducer';
import reports from './reports-reducer';

export default combineReducers({ requests, files, methods, reports });
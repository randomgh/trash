import RestService from './rest-service';

const URL = '/api';

const requests = new RestService(URL, 'requests');
const files = new RestService(URL, 'files');
const methods = new RestService(URL, 'methods');
const reports = new RestService(URL, 'reports');

export { requests, files, methods, reports };
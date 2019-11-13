import Service from './service';

class ApiService extends Service {

    path = '';

    constructor(host, path) {
        super(host);

        this.path = path;
    }

    get url() {
        return `${this.host}/${this.path}`;
    }

    get(action, data = {}) {
        return this.request(`${this.url}/${action}`, ApiService.METHOD_GET, data);
    }

    post(action, data = {}) {
        return this.request(`${this.url}/${action}`, ApiService.METHOD_POST, data);
    }

    put(action, data = {}) {
        return this.request(`${this.url}/${action}`, ApiService.METHOD_PUT, data);
    }

    delete(action, data = {}) {
        return this.request(`${this.url}/${action}`, ApiService.METHOD_DELETE, data);
    }

}

export default ApiService;
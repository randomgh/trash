import Service from './service';

class RestService extends Service {

    static ACTION_GET_ONE = 'GET_ONE';
    static ACTION_GET_ALL = 'GET_ALL';
    static ACTION_CREATE = 'CREATE';
    static ACTION_UPDATE = 'UPDATE';
    static ACTION_DELETE = 'DELETE';

    resource = '';

    constructor(host, resource) {
        super(host);

        this.resource = resource;
    }

    get url() {
        return `${this.host}/${this.resource}`;
    }

    request(action = RestService.ACTION_GET_ALL, data = {}) {
        let method;

        switch (action) {
            case RestService.ACTION_GET_ALL:
            case RestService.ACTION_GET_ONE:
                method = Service.METHOD_GET;
                break;
            case RestService.ACTION_CREATE:
                method = Service.METHOD_POST;
                break;
            case RestService.ACTION_UPDATE:
                method = Service.METHOD_PUT;
                break;
            case RestService.ACTION_DELETE:
                method = Service.METHOD_DELETE;
                break;
        }

        return super.request(action === RestService.ACTION_GET_ALL ? this.url : `${this.url}/${data._id}`, method, data);
    }

    getAll(data) {
        return this.request(RestService.ACTION_GET_ALL, data);
    }

    getOne(data) {
        return this.request(RestService.ACTION_GET_ONE, data);
    }

    create(data) {
        return this.request(RestService.ACTION_CREATE, data);
    }

    update(data) {
        return this.request(RestService.ACTION_UPDATE, data);
    }

    delete(data) {
        return this.request(RestService.ACTION_DELETE, data);
    }

}

export default RestService;
import fetch from 'node-fetch';

class UrlParser {

    static METHOD_GET = 'get';
    static METHOD_POST = 'post';
    static METHOD_PUT = 'put';
    static METHOD_DELETE = 'delete';

    host = '';
    path = '';

    headers = {};

    query = [];

    constructor(host, path = '', headers = [], query = []) {
        this.host = host;
        this.path = path;
        this.headers = headers;
        this.query = query;
    }

    request(method = UrlParser.METHOD_GET) {
        return fetch(`${this.host}/${this.path}${this.query ? `?${this.query}` : ''}`, {
            method,
            headers: this.headers
        });
    }

    parse() {
        return this.request();
    }

}

export default UrlParser;
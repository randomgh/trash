class Service {

    static METHOD_GET    = 'get';
    static METHOD_POST   = 'post';
    static METHOD_PUT    = 'put';
    static METHOD_DELETE = 'delete';

    host = '';

    constructor(host) {
        this.host = host;
    }

    get url() {
        return this.host;
    }

    serialize(data, prefix) {
        const result = [];

        for (let i in data) {
            if (data.hasOwnProperty(i)) {
                const key = prefix ? `${prefix}[${i}]` : i,
                      value = data[i];

                result.push(
                    (value && typeof value === 'object' && value.constructor === Object) ?
                    this.serialize(value, key) :
                    encodeURIComponent(key) + "=" + encodeURIComponent(value)
                );
            }
        }

        return result.join("&");
    }

    request(url = null, method = Service.METHOD_GET, data = null) {
        let query = '',
            options = {
                method
            };

        if (data) {
            if ([Service.METHOD_POST, Service.METHOD_PUT].includes(method)) {
                if (Object.keys(data).some(i => data[i] instanceof File)) {
                    let body = new FormData();

                    for (let i in data) {
                        body.append(i, data[i]);
                    }

                    options.body = body;
                } else {
                    options.headers = {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    };

                    options.body = JSON.stringify(data);
                }
            } else {
                query = this.serialize(data);
            }
        }

        return fetch(`${url ? url : this.url}${query ? `?${query}` : query}`, options).then(result => {
            return result.json();
        }).catch(err => {
            let contentType = err.headers.get('Content-Type');

            if (contentType && contentType.includes('application/json')) {
                return err.json().then(error => {
                    throw error;
                });
            } else {
                return err.text().then(error => {
                    throw new Error(error);
                });
            }
        });
    }

}

export default Service;
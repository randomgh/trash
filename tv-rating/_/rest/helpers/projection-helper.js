const projection = (data, schema) => {
    const result = {};

    let v;
    for (let i in schema) {
        if (schema[i] && typeof schema[i] === 'object' && schema[i].constructor === Object) {
            v = projection(data, schema[i]);
        } else if (schema[i] && typeof schema[i] === 'object' && schema[i].constructor === Array) {
            v = schema[i].reduce((value, key) => value ? value[key]: null, data);
        } else {
            v = data[schema[i]];
        }

        result[i] = typeof v === 'undefined' || v === null || isNaN(v) ? v : +v;

        if (typeof result[i] === 'undefined' || result[i] === null || (result[i] && typeof result[i] === 'object' && result[i].constructor === Object && Object.keys(result[i]).length === 0)) {
            delete result[i];
        }
    }

    return result;
};

export default projection;
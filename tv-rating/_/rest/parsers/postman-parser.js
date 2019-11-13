import newman from 'newman';

class PostmanParser {

    collection = null;
    environment = {};

    constructor(collection, environment = {}) {
        this.collection = collection;
        this.environment = environment;
    }

    mergeEnv(environment) {
        const result = {...this.environment};

        let found;

        for (let i in environment) {
            found = result.values.findIndex((value, index) => value.key === i);
            if (found === -1) {
                result.values.push({
                    key: i,
                    value: environment[i],
                    description: '',
                    enabled: true
                });
            } else {
                result.values[found].value = environment[i];
            }
        }

        return result;
    }

    parse(folder, environment = {}, delay = 1000) {
        return new Promise((resolve, reject) => {
            newman.run({
                collection: this.collection,
                environment: this.mergeEnv(environment),
                folder: folder,
                delayRequest: delay
            }).on('done', (err, summary) => {
                if (err || summary.error) {
                    return reject(err || summary.error);
                }

                return resolve({
                    summary,
                    responses: summary.run.executions.map((execution, i) => execution.response.json())
                });
            });
        });
    }

    execute(data) {
        return new Promise((resolve, reject) => {
            const executions = [];

            for (let execution of data) {
                executions.push(this[execution.item.name](execution.response.json()));
            }

            Promise.all(executions).then(result => {
                return resolve(result);
            }).catch(err => {
                return reject(err);
            });
        });
    }

}

export default PostmanParser;
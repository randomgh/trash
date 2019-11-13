import fs from 'fs';
import http from 'http';

import { path as makePath } from '../helpers';

export default async (url, dir, file) => {
    makePath(dir);

    return new Promise((resolve, reject) => {
        let stream = fs.createWriteStream(`${dir}/${file}`);

        http.get(url, response => {
            response.on('data', chunk => {
                stream.write(chunk);
            });

            response.on('end', () => {
                stream.end();

                resolve(file);
            });
        });
    });
};
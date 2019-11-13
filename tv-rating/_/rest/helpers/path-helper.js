import fs from 'fs';
import path from 'path';

export default (dir) => {
    dir.split(path.sep).reduce((parent, child) => {
        const current = path.resolve(parent, child);

        if (!fs.existsSync(current)) {
            fs.mkdirSync(current);
        }

        return current;
    }, path.isAbsolute(dir) ? path.sep : '');
};
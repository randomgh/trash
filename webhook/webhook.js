import crypto from 'crypto';
import util from 'util';
import { exec } from 'child_process';

const createSignature = (secret, data, algo = 'sha1') => {
    return `${algo}=${crypto.createHmac(algo, secret).update(JSON.stringify(data)).digest('hex')}`;
};

const compareSignatures = (signature1, signature2) => {
    return crypto.timingSafeEqual(Buffer.from(signature1), Buffer.from(signature2));
};

export default function(options = {}) {
    const defaults = {
        contentTypeHeader: 'content-type',
        deliveryHeader: 'x-github-delivery',
        eventHeader: 'x-github-event',
        signatureHeader: 'x-hub-signature'
    };

    options = { ...defaults, ...options };

    return async (req, res, next) => {
        const { headers, body } = req,
              id = headers[options.deliveryHeader],
              event = headers[options.eventHeader],
              signature = headers[options.signatureHeader];

        if (!compareSignatures(signature, createSignature(options.secret, body))) {
            return res.status(401).send({
                error: 'Mismatched signatures'
            });
        }

        switch (event) {
            case 'ping':
                res.status(200).send('pong');
                break;
            case 'push':
                const banch = body.ref.split('/').pop();

                if (!['master', 'develop'].includes(banch)) {
                    res.status(400).send({
                        error: `Unknown branch ${banch}.`
                    });
                } else {
                    const out = await util.promisify(exec)(`cd /var/www/${options.project}/${banch}/ && git reset HEAD --hard && git pull`);

                    res.status(200).send({
                        out: out
                    });
                }
                break;
            default:
                res.status(404).send({
                    error: `Unknown event ${event}`
                });
        }
    }
};
import crypto from 'crypto';
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

    return (req, res, next) => {
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
                return res.status(200).send('pong');
            case 'push':
                const banch = body.ref.split('/').pop();

                if (!['master', 'develop'].includes(banch)) {
                    return res.status(400).send({
                        error: `Unknown branch ${banch}.`
                    });
                } else {
                    //`kill -15 $(cat ./webhook.pid) && ./reload.sh ${options.project} ${banch} > ./webhook.log 2>&1 & echo $! > ./webhook.pid &`
                    exec(`./reload.sh ${options.project} ${banch}`);

                    return res.status(200).send({
                        status: 'OK'
                    });
                }
            default:
                return res.status(404).send({
                    error: `Unknown event ${event}`
                });
        }
    }
};
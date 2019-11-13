import nodeMailer from 'nodemailer';
import dotenv from 'dotenv';

dotenv.config();

export default options => new Promise((resolve, reject) => {
    nodeMailer.createTransport({
        host: process.env.SMTP_HOST,
        port: parseInt(process.env.SMTP_PORT),
        secure: true,
        auth: {
            user: process.env.SMTP_USER,
            pass: process.env.SMTP_PASSWORD
        }
    }).sendMail({
        from: `"${process.env.SMTP_SENDER_NAME}" <${process.env.SMTP_SENDER_EMAIL}>`,
        ...options
    }, (error, info) => {
        if (error) {
            return reject(error);
        }

        return resolve(info);
    });
});
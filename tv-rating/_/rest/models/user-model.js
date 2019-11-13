import mongoose, { Schema } from 'mongoose';
import crypto from 'crypto';
import jwt from 'jsonwebtoken';
import generator from 'generate-password';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    email: { type: String, required: true, unique: true },
    salt: { type: String, required: true },
    hash: { type: String, required: true },
    name: {
        first: { type: String, required: false },
        last: { type: String, required: false }
    },
    image: { type: String, required: false }
}, {
    collection: 'users',
    toObject: { virtuals: true },
    toJSON: { virtuals: true },
    timestamps: true
});

schema.virtual('full_name').get(function() {
    return `${this.name.last} ${this.name.first}`;
});

schema.virtual('password').get(function() {
    return generator.generate({
        length: 10,
        numbers: true,
        symbols: false,
        strict: true
    });
});

schema.virtual('password').set(function(password) {
    this.salt = this.getSalt();
    this.hash = this.getHash(password);
});

schema.index({ email: 1 }, { unique: true });

schema.method('getSalt', function(bytes = 16) {
    return crypto.randomBytes(bytes).toString('hex');
});

schema.method('getHash', function(value) {
    return crypto.pbkdf2Sync(value, this.salt, 10000, 512, 'sha512').toString('hex');
});

schema.method('getToken', function(expires = parseInt(process.env.SESSION_TOKEN_ADE)) {
    return jwt.sign({
        id: this._id,
        email: this.email,
        exp: parseInt(new Date().setDate(new Date().getDate() + expires).getTime() / 1000, 10),
    }, process.env.SESSION_TOKEN_SECRET);
});

schema.method('validatePassword', function(password) {
    return this.getHash(password) === this.hash;
});

export default mongoose.model('User', schema);
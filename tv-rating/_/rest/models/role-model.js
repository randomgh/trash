import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    slug: { type: String, required: true, unique: true, index: true },
    name: { type: String }
}, {
    collection: 'roles',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Role', schema);
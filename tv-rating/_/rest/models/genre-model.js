import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    slug: { type: String, required: true, unique: true, index: true },
    name: { type: String, required: true },
    image: { type: String }
}, {
    collection: 'genres',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Genre', schema);
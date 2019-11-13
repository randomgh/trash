import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    name: { type: String, required: true }
}, {
    collection: 'types',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Type', schema);
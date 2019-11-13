import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    slug: { type: String, required: true, unique: true, index: true },
    name: { type: String, required: true },
    synopsis: { type: String },
    description: { type: String },
    image: { type: String },
    genres: [{ type: Schema.Types.ObjectId, ref: 'Genre' }]
}, {
    collection: 'channels',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Channel', schema);
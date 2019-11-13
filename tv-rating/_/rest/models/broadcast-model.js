import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    name: { type: String, required: true },
    synopsis: { type: String },
    description: { type: String },
    image: { type: String },
    type: { type: Schema.Types.ObjectId, ref: 'Type' },
    genres: [{ type: Schema.Types.ObjectId, ref: 'Genre' }]
}, {
    collection: 'broadcasts',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Broadcast', schema);
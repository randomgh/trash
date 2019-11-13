import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    slug:  { type: String, required: true, unique: true, index: true },
    name:  { type: String, required: true },
    index: { type: Number, default: 1 }
}, {
    collection: 'methods',
    toObject:   { virtuals: true },
    toJSON:     { virtuals: true }
});

export default mongoose.model('Method', schema);
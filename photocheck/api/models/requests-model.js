import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    name:  { type: String, required: true },
    files: [{ type: Schema.Types.ObjectId, ref: 'File' }],
}, {
    collection: 'requests',
    toObject:   { virtuals: true },
    toJSON:     { virtuals: true },
    timestamps: true
});

export default mongoose.model('Request', schema);
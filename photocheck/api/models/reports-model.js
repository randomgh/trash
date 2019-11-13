import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    file:   { type: Schema.Types.ObjectId, ref: 'File', required: true },
    method: { type: Schema.Types.ObjectId, ref: 'Method', required: true },
    result: { type: Object }
}, {
    collection: 'reports',
    toObject:   { virtuals: true },
    toJSON:     { virtuals: true },
    timestamps: true
});

export default mongoose.model('Report', schema);
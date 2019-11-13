import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    file_name:     { type: String, required: true },
    original_name: { type: String, required: true },
    mime_type:     { type: String, required: true },
    size:          { type: String, required: true }
}, {
    collection: 'files',
    toObject:   { virtuals: true },
    toJSON:     { virtuals: true },
    timestamps: true
});

export default mongoose.model('File', schema);
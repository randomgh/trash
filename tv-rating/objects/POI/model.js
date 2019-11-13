import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    latitude : { type: Number, required: true },
    longitude: { type: Number, required: true }
}, {
    collection: 'pois',
    toObject: { virtuals: true },
    toJSON: { virtuals: true },
    timestamps: true
});

export default mongoose.model('POI', schema);
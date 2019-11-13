import mongoose, { Schema } from 'mongoose';
import dotenv from 'dotenv';

dotenv.config();

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    starts: { type: Date, required: true },
    ends: { type: Date, required: true },
    channel: { type: Schema.Types.ObjectId, ref: 'Channel', required: true },
    broadcast: { type: Schema.Types.ObjectId, ref: 'Broadcast', required: true },
    members: [{
        role: { type: Schema.Types.ObjectId, ref: 'Role' },
        person: { type: Schema.Types.ObjectId, ref: 'Person' }
    }]
}, {
    collection: 'schedule',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

export default mongoose.model('Schedule', schema);
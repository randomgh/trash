import mongoose, { Schema } from 'mongoose';

const schema = new Schema({
    provider_id: { type: String, required: true, unique: true, index: true },
    name: {
        first: { type: String },
        middle: { type: String },
        last: { type: String }
    },
    image: { type: String }
}, {
    collection: 'persons',
    toObject: { virtuals: true },
    toJSON: { virtuals: true }
});

schema.virtual('full_name').get(function() {
    switch (true) {
        case !!this.name.last && !!this.name.first && !!this.name.middle:
            return `${this.name.last}, ${this.name.first} ${this.name.middle}`;
        case !!this.name.last && !!this.name.first:
            return `${this.name.first} ${this.name.last}`;
        default:
            return '';
    }
});

schema.virtual('full_name').set(function(full_name) {
    full_name = full_name.split(' ');

    switch (full_name.length) {
        case 0:
            this.name.first = full_name.join(' ');
            break;
        case 1:
            this.name.first = full_name[0];
            break;
        case 2:
            this.name.first = full_name[0];
            this.name.last = full_name[1];
            break;
        case 3:
            this.name.first = full_name[0];
            this.name.middle = full_name[1];
            this.name.last = full_name[2];
            break;
        default:
            this.name.first = full_name[0];
            this.name.middle = full_name.splice(1, full_name.length - 2).join(' ');
            this.name.last = full_name[full_name.length - 1];
    }
});

export default mongoose.model('Person', schema);
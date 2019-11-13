import POI from '../POI/model';
import User from '../User/model';

export default {
    Query: {
        poi: async (parent, { _id }, context, info) => {
            return await POI.findOne({ _id }).exec();
        },

        pois: async (parent, args, context, info) => {
            const pois = await POI.find({}).populate().exec();

            return pois.map(poi => ({
                _id: poi._id.toString(),
                latitude: poi.latitude,
                longitude: poi.longitude
            }));
        }
    },

    Mutation: {
        createPOI: (parent, { poi }, context, info) => {
            return new Promise(async (resolve, reject) => {
                const newPOI = await new POI({
                    latitude: poi.latitude,
                    longitude: poi.longitude
                });

                newPOI.save((err, res) => {
                    err ? reject(err) : resolve(res);
                });
            });
        },

        updatePOI: async (parent, { _id, poi }, context, info) => {
            return new Promise((resolve, reject) => {
                POI.findByIdAndUpdate(_id, { $set: { ...poi } }, { new: true }).exec(
                    (err, res) => {
                        err ? reject(err) : resolve(res);
                    }
                );
            });
        },

        deletePOI: async (parent, { _id }, context, info) => {
            return new Promise((resolve, reject) => {
                POI.findByIdAndDelete(_id).exec((err, res) => {
                    err ? reject(err) : resolve(res);
                });
            });
        }
    }
};
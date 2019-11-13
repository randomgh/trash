import User from '../User/model';

export default {
    Query: {
        user: async (parent, { _id }, context, info) => {
            return await User.findOne({ _id }).exec();
        },

        users: async (parent, args, context, info) => {
            const users = await User.find({}).populate().exec();

            return users.map(user => ({
                _id: user._id.toString(),
                email: user.email
            }));
        }
    },

    Mutation: {
        createUser: (parent, { user }, context, info) => {
            return new Promise(async (resolve, reject) => {
                const newUser = await new User({
                    email: user.email
                });

                newUser.save((err, res) => {
                    err ? reject(err) : resolve(res);
                });
            });
        },

        updateUser: async (parent, { _id, user }, context, info) => {
            return new Promise((resolve, reject) => {
                User.findByIdAndUpdate(_id, { $set: { ...user } }, { new: true }).exec((err, res) => {
                    err ? reject(err) : resolve(res);
                });
            });
        },

        deleteUser: async (parent, { _id }, context, info) => {
            return new Promise((resolve, reject) => {
                User.findByIdAndDelete(_id).exec((err, res) => {
                    err ? reject(err) : resolve(res);
                });
            });
        }
    }
};
import path from 'path';
import CleanWebpackPlugin from 'clean-webpack-plugin';
import dotenv from 'dotenv';

dotenv.config();

export default {
    output: {
        path: path.resolve(__dirname, '../../build/dev')
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: ['babel-loader']
            }
        ]
    },
    devServer: {
        historyApiFallback: true,
        proxy: {
            '/api': {
                target: process.env.API
            },
            '/uploads': {
                target: process.env.UPLOADS
            }
        }
    },
    devtool: 'cheap-module-source-map',
    plugins: [
        new CleanWebpackPlugin('build/dev', {
            root: path.resolve(__dirname , '../../')
        })
    ]
};
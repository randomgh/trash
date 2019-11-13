import path from 'path';
import CleanWebpackPlugin from 'clean-webpack-plugin';
import dotenv from 'dotenv';

dotenv.config();

export default {
    output: {
        path: path.resolve(__dirname, '../build')
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
        historyApiFallback: true
    },
    devtool: 'cheap-module-source-map',
    plugins: [
        new CleanWebpackPlugin('build', {
            root: path.resolve(__dirname , '../')
        })
    ]
};
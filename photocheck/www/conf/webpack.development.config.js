import path from 'path';
import CleanWebpackPlugin from 'clean-webpack-plugin';

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
                target: 'http://localhost:3000'
            },

            '/uploads': {
                target: 'http://localhost:3000'
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
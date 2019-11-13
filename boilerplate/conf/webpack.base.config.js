import path from 'path';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import WebpackMd5Hash from 'webpack-md5-hash';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';

export default {
    entry: {
        index: './src/index'
    },
    output: {
        filename: '[name].[hash].js',
        publicPath: '/'
    },
    resolve: {
        alias: {
            svg: path.resolve(__dirname, '../src/svg'),

            layouts: path.resolve(__dirname, '../src/layouts'),
            views: path.resolve(__dirname, '../src/views'),
            components: path.resolve(__dirname, '../src/components'),

            constants: path.resolve(__dirname, '../src/constants'),
            actions: path.resolve(__dirname, '../src/actions'),
            services: path.resolve(__dirname, '../src/services'),
            reducers: path.resolve(__dirname, '../src/reducers')
        },
        extensions: ['*', '.js', '.jsx']
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use:  ['style-loader', MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader']
            },
            {
                test: /\.less$/,
                use:  ['style-loader', MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'less-loader']
            },
            {
                test: /\.s[c|a]ss$/,
                use:  ['style-loader', MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader']
            },
            {
                test: /\.svg$/,
                use: ['babel-loader', {
                    loader: 'react-svg-loader',
                    options: {
                        jsx: true
                    }
                }]
            },
            {
                test: /\.(gif|png|jpe?g)$/i,
                use: ['file-loader', {
                    loader: 'image-webpack-loader',
                    options: {
                        bypassOnDebug: true
                    }
                }]
            },
            {
                test: /\.(woff(2)?|ttf|eot|otf)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts/'
                    }
                }]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].[contenthash].css',
            chunkFilename: "[id].css"
        }),
        new HtmlWebpackPlugin({
            inject: false,
            hash: true,
            template: './src/index.html',
            filename: 'index.html'
        }),
        new WebpackMd5Hash()
    ]
};
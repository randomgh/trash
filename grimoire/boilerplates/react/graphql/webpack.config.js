require('@babel/register');

module.exports = (env, argv) => require('webpack-merge')(require('./conf/webpack.base.config'), require(`./conf/webpack.${argv.mode}.config`));
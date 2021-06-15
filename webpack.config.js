let webpack = require('webpack');
let path = require('path');

module.exports = {
    entry: './resources/assets/js/app.js',

    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: "app.js",
        publicPath: "./public/js"
    },

    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.common.js' // 'vue/dist/vue.common.js' for webpack 1
        }
    }
}

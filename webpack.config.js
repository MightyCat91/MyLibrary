const VueLoaderPlugin = require('vue-loader/lib/plugin.js');
var path = require('path');

module.exports = {
    mode: 'development',
    entry: './resources/assets/js/app.js',
    output: {
        path: path.resolve(__dirname, './public/js/Custom'),
        filename: 'main.js',
        publicPath: './public/js/Custom'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }, {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ]
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ],
    resolve: {
        alias: {
            'vue$': '../../../node_modules/vue/dist/vue.esm.js'
        }
    }
};
const mix = require('laravel-mix');
const ChunkRenamePlugin = require('webpack-chunk-rename-plugin');
require('laravel-mix-merge-manifest');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/main.js', 'public/js/app.js')
    .extract([
        'vue',
        'vuex',
        'vue-router',
        'axios',
        'bootstrap',
        'bootstrap-vue',
        'laravel-vue-pagination',
        'admin-lte',
        'jquery',
    ])
    .mergeManifest();

mix.webpackConfig({
    plugins: [
        new ChunkRenamePlugin({
            initialChunksWithEntry: true,
            '/js': 'js/',
            '/js/vendor': 'js/vendor.js'
        }),
    ],
    output: {
        chunkFilename: 'js/chunks/[name].js'
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        }
    }
});

if (mix.inProduction()) {
    mix.version();
}

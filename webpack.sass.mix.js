const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.sass('resources/sass/app.scss', 'public/css')
    .mergeManifest();

if (mix.inProduction()) {
    mix.version();
}

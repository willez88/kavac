const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/_all.js', 'modules/purchase/js/app.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'modules/purchase/css/app.css');

if (mix.inProduction()) {
    mix.version();
}

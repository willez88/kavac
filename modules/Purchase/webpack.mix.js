const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'modules/purchase/js/purchase.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'modules/purchase/css/purchase.css');

if (mix.inProduction()) {
    mix.version();
}

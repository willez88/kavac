const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

var m = __dirname.split("/");
var moduleName = m[m.length-1].toLowerCase()

mix.js(__dirname + '/Resources/sale/js/app.js', `modules/sale/js`)
   .sass( __dirname + '/Resources/sale/sass/app.scss', `modules/sale/css`)
   .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

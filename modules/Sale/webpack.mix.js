const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

var m = __dirname.split("/");
var moduleName = m[m.length-1].toLowerCase()

mix.js(__dirname + '/Resources/asset/js/app.js', `modules/${moduleName}/js`)
   .sass( __dirname + '/Resources/asset/sass/app.scss', `modules/${moduleName}/css`)
   .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

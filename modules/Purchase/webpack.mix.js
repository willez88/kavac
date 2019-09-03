const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

var m = __dirname.split("/");
var moduleName = m[m.length-1].toLowerCase()

mix.js(__dirname + '/Resources/assets/js/app.js', `modules/${moduleName}/js`)
   .sass( __dirname + '/Resources/assets/sass/app.scss', `modules/${moduleName}/css`)
   .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

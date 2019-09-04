let mix = require('laravel-mix');
/*const fs = require('fs');
const path = require('path');*/

/* Allow multiple Laravel Mix applications*/
require('laravel-mix-merge-manifest');
mix.mergeManifest();

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

mix.js([
		'resources/js/app.js', 'resources/js/now-ui-kit/plugins/nouislider.min.js',
		'resources/js/now-ui-kit/now-ui-kit.js',
		'resources/js/now-ui-kit/plugins/bootstrap-switch.js',
		'resources/js/jquery-menu.js', 'resources/js/custom.js'
      //'resources/js/loading-message.js'
	], 'public/js')
   .js('resources/js/core-settings.js', 'public/js')
   .js(['resources/js/shared.js', 'resources/js/mixins.js'], 'public/js/shared-components.js')
   .js('resources/js/chart.js', 'public/js')
   .js('resources/js/ckeditor.js', 'public/js')
   .copy('resources/js/generic-classes.js', 'public/js/generic-classes.js')
   .copy('resources/js/common.js', 'public/js/common.js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/font-awesome/font-awesome.scss', 'public/css')
   .sass('resources/sass/ionicons/ionicons.scss', 'public/css')
   .sass('resources/sass/now-ui-kit/now-ui-kit.scss', 'public/css')
   .sass('resources/sass/custom/custom.scss', 'public/css')
   .combine([
   		'public/css/app.css', 'public/css/font-awesome.css', 'public/css/ionicons.css',
   		'public/css/now-ui-kit.css', 'public/css/custom.css'
   ], 'public/css/app.css')
   .sourceMaps();


/*
 |--------------------------------------------------------------------------
 | Mix Asset Modules Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
/*const moduleFolder = './modules';

const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p,f)).isDirectory());

let modules = dirs(moduleFolder);

modules.forEach(function(m) {
   let js = path.resolve(moduleFolder,m,'Resources/assets','js', '_all.js');
   mix.js(js, `public/modules/${m.toLowerCase()}/js/app.js`);
   let scss = path.resolve(moduleFolder,m,'Resources/assets','scss', 'app.scss');
   mix.sass(scss, `public/modules/${m}/css/app.css`);
});*/

/** Publica la versión de la compilación */
if (mix.inProduction()) {
   mix.version();
}

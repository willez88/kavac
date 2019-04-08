let mix = require('laravel-mix');

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
   .copy('resources/js/generic-classes.js', 'public/js/generic-classes.js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/font-awesome/font-awesome.scss', 'public/css')
   .sass('resources/sass/ionicons/ionicons.scss', 'public/css')
   .sass('resources/sass/now-ui-kit/now-ui-kit.scss', 'public/css')
   .sass('resources/sass/custom/custom.scss', 'public/css')
   .combine([
   		'public/css/app.css', 'public/css/font-awesome.css', 'public/css/ionicons.css', 
   		'public/css/now-ui-kit.css', 'public/css/custom.css'
   ], 'public/css/app.css').sourceMaps();

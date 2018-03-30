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
		'resources/assets/js/app.js', 'resources/assets/js/now-ui-kit/plugins/nouislider.min.js',
		'resources/assets/js/now-ui-kit/now-ui-kit.js',
		'resources/assets/js/now-ui-kit/plugins/bootstrap-switch.js',
		'resources/assets/js/custom.js', 'resources/assets/js/jquery-menu.js',
	], 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/font-awesome/font-awesome.scss', 'public/css')
   .sass('resources/assets/sass/ionicons/ionicons.scss', 'public/css')
   .sass('resources/assets/sass/now-ui-kit/now-ui-kit.scss', 'public/css')
   .sass('resources/assets/sass/custom/custom.scss', 'public/css')
   .combine([
   		'public/css/app.css', 'public/css/font-awesome.css', 'public/css/ionicons.css', 
   		'public/css/now-ui-kit.css', 'public/css/custom.css'
   	], 'public/css/app.css');

const mix = require('laravel-mix');
const webpack = require('webpack');
const fs = require('fs');
const path = require('path');

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

/** Procesa el archivo javascript principal app.js */
mix.js([
	'resources/js/app.js', 'resources/js/now-ui-kit/plugins/nouislider.min.js',
	'resources/js/now-ui-kit/now-ui-kit.js',
	'resources/js/now-ui-kit/plugins/bootstrap-switch.js',
	'resources/js/jquery-menu.js', 'resources/js/custom.js'
], 'public/js');

/** Procesa elementos compartidos de la aplicación */
mix.js(['resources/js/shared.js', 'resources/js/mixins.js'], 'public/js/shared-components.js');

/** Procesa el archivo que gestiona los gráficos de la aplicación */
mix.js('resources/js/chart.js', 'public/js');

/** Copia el archivo de clases genéricas a la carpeta public */
mix.copy('resources/js/generic-classes.js', 'public/js/generic-classes.js');

/** Copia el archivo de instrucciones comúnes a la carpeta public */
mix.copy('resources/js/common.js', 'public/js/common.js');

/** Procesa los estilos de la aplicación en el archivo app.css */
mix.sass('resources/sass/app.scss', 'public/css').options({
    processCssUrls: false
});
mix.sass('resources/sass/font-awesome/font-awesome.scss', 'public/css').options({
    processCssUrls: false
});
mix.sass('resources/sass/ionicons/ionicons.scss', 'public/css').options({
    processCssUrls: false
});
mix.sass('resources/sass/now-ui-kit/now-ui-kit.scss', 'public/css').options({
    processCssUrls: false
});
mix.sass('node_modules/@mdi/font/scss/materialdesignicons.scss', 'public/css').options({
    processCssUrls: false
});
mix.sass('resources/sass/custom/custom.scss', 'public/css').options({
    processCssUrls: false
});
mix.combine([
    'public/css/app.css', 'public/css/font-awesome.css', 'public/css/ionicons.css',
    'public/css/now-ui-kit.css', 'public/css/materialdesignicons.css', 'public/css/custom.css'
], 'public/css/app.css');


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
/*if (mix.inProduction()) {
    const moduleFolder = './modules';

    const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p,f)).isDirectory());

    let modules = dirs(moduleFolder);

    modules.forEach(function(m) {
       let js = path.resolve(moduleFolder,m,'Resources/assets','js', 'app.js');
       mix.js(js, `public/modules/${m.toLowerCase()}/js/app.js`);
       let scss = path.resolve(moduleFolder,m,'Resources/assets','scss', 'app.scss');
       mix.sass(scss, `public/modules/${m}/css/app.css`);
       mix.webpackConfig({
            output:{
                chunkFilename: `modules/${m}/components/${(mix.inProduction()) ? 'prod/[chunkhash]' : '[name]'}.js`,
            }
        });
    });
}*/

/*
 |--------------------------------------------------------------------------
 | Webpack Shell Plugin
 |--------------------------------------------------------------------------
 |
 | Permite la ejecución de comandos en consola
 |
 */
const WebpackShellPlugin = require('webpack-shell-plugin');

mix.webpackConfig({
    plugins: [
        new WebpackShellPlugin({
            onBuildStart:['php artisan lang:js --quiet'],
            onBuildEnd: []
        }),
        new webpack.IgnorePlugin({
            resourceRegExp: /^\.\/locale$/,
            contextRegExp: /moment$/
        }),
    ],
    resolve: {
        alias: {
            moment$: 'moment/moment.js'
        },
        modules: [
            path.resolve(__dirname),
            path.resolve('./node_modules/'),
            path.resolve('./resources/')
        ]
    },
    output:{
        chunkFilename: `js/components/${(mix.inProduction()) ? 'core/[chunkhash]' : '[name]'}.js`,
        publicPath: `${(process.env.APP_TESTING==='true')?process.env.APP_TESTING_URL:process.env.APP_URL}/`,
    },
    /*optimization: {
        splitChunks: {
          chunks: 'initial',
          name: ''
        }
      },*/
});


/*
 |--------------------------------------------------------------------------
 | Sección para entornos de producción
 |--------------------------------------------------------------------------
 |
 | Especifica las condiciones e instrucciones a ejecutar para entornos de
 | producción.
 |
 */
/** Publica la versión de la compilación */
if (mix.inProduction()) {
   mix.version();
}
else {
    mix.sourceMaps();
}
